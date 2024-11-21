$(document).ready(function () {
    $(document).on('click', '.add', function (e) {
        $('#name').focus();
    });

    /////////////// ------------------ Add Manufacturer Ajax Part Start ---------------- /////////////////////////////
    $(document).on('submit', '#AddForm', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        
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
                console.log(res)
                if (res.status == "success") {
                    $('#AddForm')[0].reset();
                    $('#name').focus();
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Manufacturer Added Successfully', 'Added!');
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


    /////////////// ------------------ Edit Manufacturer Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id },
            success: function (res) {
                $('#id').val(res.manufacturer.id);
                $('#updateName').val(res.manufacturer.manufacturer_name);
                var modal = document.getElementById(modalId);
                modal.style.display = 'block';
            },
            error: function (err) {
                console.log(err);
            }
        });
    });



    /////////////// ------------------ Update Manufacturer Category Ajax Part Start ---------------- /////////////////////////////
    $(document).on('submit', '#EditForm', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: urls.update,
            method: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#editModal').hide();
                    $('#EditForm')[0].reset();
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Manufacturer Updated Successfully', 'Updated!');
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



    DeleteAjax('Inventory Manufacturer Deleted', 'Deleted!');

    PaginationAjax({  });

    SearchAjax({  });

    SearchPaginationAjax({  });
});