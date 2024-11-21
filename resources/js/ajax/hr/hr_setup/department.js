$(document).ready(function () {
    // Add Button Click Functionality
    $(document).on('click', '.add', function (e) {
        $('#deptName').focus();
    });



    /////////////// ------------------ Add Department Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#Insert', function (e) {
        e.preventDefault();
        let deptName = $('#deptName').val();
        $.ajax({
            url: urls.insert,
            method: 'POST',
            data: { deptName },
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#AddForm')[0].reset();
                    $('#deptName').focus();
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Department Added Successfully', 'Added!');
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



    ///////////// ------------------ Edit Department Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id },
            success: function (res) {
                $('#id').val(id);
                $('#updateDeptName').val(res.department.dept_name);
                $('#updateDeptName').focus();
                var modal = document.getElementById(modalId);
                modal.style.display = 'block';
            },
            error: function (err) {
                console.log(err);
            }
        });
    });



    /////////////// ------------------ Update Departments Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#Update', function (e) {
        e.preventDefault();
        let id = $('#id').val();
        let deptName = $('#updateDeptName').val();
        $.ajax({
            url: urls.update,
            method: 'PUT',
            data: { deptName, id },
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#editModal').hide();
                    $('#EditForm')[0].reset();
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Department Updated Successfully', 'Updated!');
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



    DeleteAjax('Department Details Deleted', 'Deleted!');

    PaginationAjax({  });

    SearchAjax({  });

    SearchPaginationAjax({  });

});