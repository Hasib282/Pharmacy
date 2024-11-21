$(document).ready(function () {
    // Add Button Click Functionality
    $(document).on('click', '.add', function (e) {
        $('#with').focus();
    });



    /////////////// ------------------ Add Payroll Setup ajax part start ---------------- /////////////////////////////
    $(document).on('submit', '#AddForm', function (e) {
        e.preventDefault();
        let user = $('#user').attr('data-id');
        let formData = new FormData(this);
        formData.append('user', user === undefined ? '' : user);
        $.ajax({
            url: urls.insert,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#head').val('');
                    $('#amount').val('');
                    $('#head').focus();
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    getPayrollByUserId(user, '.payroll-grid tbody');
                    toastr.success('Payroll Added Successfully', 'Added!');
                }
            },
            error: function (err) {
                console.log(err)
                let error = err.responseJSON;
                $.each(error.errors, function (key, value) {
                    $('#' + key + "_error").text(value);
                });
            }
        });
    });



    ///////////// ------------------ Edit Payroll Setup ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id },
            success: function (res) {
                $('#id').val(res.payroll.id);

                $('#updateWith').focus();
                $('#updateWith').empty();
                $.each(res.tranwith, function (key, withs) {
                    $('#updateWith').append(`<option value="${withs.id}">${withs.tran_with_name}</option>`);
                });
                
                $('#updateUser').val(res.payroll.employee.user_name);
                $('#updateUser').attr('data-id', res.payroll.emp_id);
                $('#updateAmount').val(res.payroll.amount);
                

                $('#updateHead').empty();
                $.each(res.heads, function (key, head) {
                    $('#updateHead').append(`<option value="${head.id}" ${res.payroll.head_id === head.id ? 'selected' : ''}>${head.tran_head_name}</option>`);
                });


                var modal = document.getElementById(modalId);

                if (modal) {
                    modal.style.display = 'block';
                }
            },
            error: function (err) {
                console.log(err);
            }
        });
    });




    /////////////// ------------------ Update Payroll Setup ajax part start ---------------- /////////////////////////////
    $(document).on('submit', '#EditForm', function (e) {
        e.preventDefault();
        let user = $('#updateUser').attr('data-id');
        let formData = new FormData(this);
        formData.append('user', user === undefined ? '' : user);
        $.ajax({
            url: urls.update,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data:formData,
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#editModal').hide();
                    $('#EditForm')[0].reset();
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Payroll Setup Updated Successfully', 'Updated!');
                }
            },
            error: function (err) {
                let error = err.responseJSON;
                $.each(error.errors, function (key, value) {
                    $('#update_' + key + "_error").text(value);
                })
            }
        });
    });

    DeleteAjax('Payroll Middlewire Details Deleted', 'Deleted!');

    PaginationAjax({  });

    SearchAjax({  });

    SearchPaginationAjax({  });

    // Get Payroll Data By User Id
    function getPayrollByUserId(id, grid) {
        $.ajax({
            url: urls.getuser,
            method: 'GET',
            data: { id:id },
            success: function (res) {
                if(res.status === 'success'){
                    $(grid).html(res.data);
                }
                else{
                    $(grid).html('');
                }
            }
        });
    }
});