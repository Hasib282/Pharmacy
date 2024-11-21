$(document).ready(function () {
    // Add Button Click Functionality
    $(document).on('click', '.add', function (e) {
        $("#designations").focus();
        $("#designations").val('');
        $('#department').removeAttr('data-id');
        $('#department').val('');
    });



    /////////////// ------------------ Add Designation Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#Insert', function (e) {
        e.preventDefault();
        let designations = $('#designations').val();
        let department = $('#department').attr('data-id');
        $.ajax({
            url: urls.insert,
            method: 'POST',
            data: { designations, department },
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#AddForm')[0].reset();
                    $('#designations').focus();
                    $('#department').removeAttr('data-id');
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Designation Added Successfully', 'Added!');
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



    ///////////// ------------------ Edit Designation Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id },
            success: function (res) {
                $('#id').val(id);
                $('#updateDesignations').val(res.designations.designation);
                $('#updateDepartment').attr('data-id',res.designations.dept_id);
                $('#updateDepartment').val(res.designations.department.dept_name);
                $('#updateDesignations').focus();
                var modal = document.getElementById(modalId);
                modal.style.display = 'block';
            },
            error: function (err) {
                console.log(err);
            }
        });
    });



    /////////////// ------------------ Update Designation Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#Update', function (e) {
        e.preventDefault();
        let id = $('#id').val();
        let designations = $('#updateDesignations').val();
        let department = $('#updateDepartment').attr('data-id');
        $.ajax({
            url: urls.update,
            method: 'PUT',
            data: { designations, department, id },
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#editModal').hide();
                    $('#EditForm')[0].reset();
                    $('#updateDepartment').removeAttr('data-id');
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Designation Updated Successfully', 'Updated!');
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


    DeleteAjax('Designation Details Deleted', 'Deleted!');

    PaginationAjax({  });

    SearchAjax({  });

    SearchPaginationAjax({  });
});