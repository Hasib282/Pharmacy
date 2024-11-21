$(document).ready(function () {
    /////////////// ----------------------- Payroll Process Part Ajax start here ------------------- //////////////////////////
    //Process Button Functionality
    $(document).on('click', '#PayrollProcess', function (e) {
        e.preventDefault();
        $('#confirmModal').show();
        $('#cancelProcessBtn').focus();
    });



    // Cancel Button Functionality
    $(document).on('click', '#cancelProcessBtn', function (e) {
        e.preventDefault();
        $('#confirmModal').hide();
    });



    // Confirm Button Functionality
    $(document).on('click', '#confirmProcessBtn', function (e) {
        e.preventDefault();
        $.ajax({
            url: urls.insert,
            method: 'POST',
            success: function (res) {
                if (res.status == "success") {
                    $('#confirmModal').hide();
                    toastr.success('Payroll Processed Successfully', 'Added!');
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

    /////////////// ----------------------- Payroll Process Part Ajax end here ------------------- //////////////////////////

    


    ///////////// ------------------ Payroll Details Part Ajax Start Here ---------------- /////////////////////////////
    $(document).on('click', '#details', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        let month = $('#month').attr('data-id'); 
        let year = $('#year').val();
        $.ajax({
            url: urls.payrollByDate,
            method: 'GET',
            data: { id, month, year },
            success: function (res) {
                if (res.status === 'success') {
                    $('.payroll-grid tbody').html(res.data);
                    $('#employee').val(res.payrolls[0].employee.user_name);
                    $('#employee').attr('data-id', res.payrolls[0].emp_id);

                    $('#head').empty();
                    $('#head').append('<option value="">Select Payroll Category</option>');
                    $.each(res.heads, function (key, head) {
                        $('#head').append(`<option value="${head.id}">${head.tran_head_name}</option>`);
                    });
                } 
                else {
                    $('.payroll-grid tbody').html('');
                }

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
    


    /////////////// ------------------ Edit Payroll ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#EditPayroll', function (e) {
        e.preventDefault();
        let user = $('#employee').attr('data-id');
        let head = $('#head').val();
        let amount = $('#amount').val();
        let date = $('#year').val()+'-'+$('#month').attr('data-id')+'-'+'07';
        $.ajax({
            url: urls.middlewire,
            method: 'POST',
            data: { user, head, amount, date },
            beforeSend:function() {
                $(document).find('span.error').text('');
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#head').val('');
                    $('#head').focus();
                    $('#amount').val('');
                    getPayrollByUserId(user);
                    toastr.success('Payroll Added Successfully', 'Added!');
                    $('.load-data').load(location.href + ' .load-data');
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

    SearchAjax({ month: $("#month").attr('data-id'), year: $("#year").val() });

    SearchPaginationAjax({ month: $("#month").attr('data-id'), year: $("#year").val() });

    // Search By Month and Year
    $(document).on('change', '#month, #year', function (e) {
        e.preventDefault();
        let search = $('#search').val();
        let month = $("#month").attr('data-id');
        let year = $('#year').val();
        LoadData(urls.search, { search, month, year })
    });



    // Get Payroll Data By User Id
    function getPayrollByUserId(id) {
        let month = $('#month').attr('data-id');
        let year = $('#year').val();
        $.ajax({
            url: urls.payrollByDate,
            method: 'GET',
            data: { id, month, year },
            success: function (res) {
                if(res.status === 'success'){
                    $('.payroll-grid tbody').html(res.data);
                }
                else{
                    $('.payroll-grid tbody').html('');
                }
            }
        });
    }

});