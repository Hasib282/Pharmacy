$(document).ready(function () {
    // Add Button Click Functionality
    $(document).on('click', '.add', function (e) {
        $('#mainhead').focus();
    });



    /////////////// ------------------ Add Permission ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#Insert', function (e) {
        e.preventDefault();
        let mainhead = $('#mainhead').val();
        let name = $('#name').val();
        $.ajax({
            url: urls.insert,
            method: 'POST',
            data: { name, mainhead },
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#AddForm')[0].reset();
                    $('#mainhead').focus();
                    $('#search').val('');
                    $("#searchHead").val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Permission Added Successfully', 'Added!');
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



    ///////////// ------------------ Edit Permissions ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id },
            success: function (res) {
                $('#id').val(id);
                $('#updateMainhead').html('');
                $('#updateMainhead').append(`<option value="" >Select Main Head</option>`);
                $.each(res.permissionMainhead, function (key, mainhead) {
                    $('#updateMainhead').append(`<option value="${mainhead.id}" ${res.permission.permission_mainhead === mainhead.id ? 'selected' : ''}>${mainhead.name}</option>`);
                });

                $('#updateName').val(res.permission.name);
                $('#updateName').focus();
                var modal = document.getElementById(modalId);
                modal.style.display = 'block';
            },
            error: function (err) {
                console.log(err);
            }
        });
    });



    /////////////// ------------------ Update Permissions ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#Update', function (e) {
        e.preventDefault();
        let id = $('#id').val();
        let name = $('#updateName').val();
        let mainhead = $('#updateMainhead').val();
        $.ajax({
            url: urls.update,
            method: 'PUT',
            data: { name, mainhead, id },
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#editModal').hide();
                    $('#EditForm')[0].reset();
                    $('#search').val('');
                    $("#searchHead").val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Permission Updated Successfully', 'Updated!');
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


    DeleteAjax('Permission Head Deleted', 'Deleted!');

    PaginationAjax({  });

    SearchAjax({ searchHead: $('#searchHead').val() });

    SearchPaginationAjax({ searchHead: $('#searchHead').val() });
});