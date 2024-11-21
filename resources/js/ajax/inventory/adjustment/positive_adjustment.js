$(document).ready(function () {
    // Get Last Transaction Id By Transaction Method and Type
    $(document).on('click', '.add', function (e) {
        $('#store').focus();
    });
    

    ///////////// ------------------ Add Positive Adjustment ajax part start ---------------- /////////////////////////////
    $(document).on('submit', '#AddForm', function (e) {
        e.preventDefault();
        let store = $('#store').attr('data-id');
        let product = $('#product').attr('data-id');
        let groupe = $('#product').attr('data-groupe');
        let formData = new FormData(this);
        formData.append('product', product === undefined ? '' : product);
        formData.append('groupe', groupe === undefined ? '' : groupe);
        formData.append('store', store === undefined ? '' : store);
        formData.append('method', 'Positive');
        formData.append('type', '5');
        $.ajax({
            url: urls.insert,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            beforeSend: function () {
                $(document).find('span.error').text('');
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#store').val('');
                    $('#store').removeAttr('data-id');
                    $('#product').val('');
                    $('#product').removeAttr('data-id');
                    $('#product').removeAttr('data-groupe');
                    $('#quantity').val('1');
                    $("#head").focus();
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Positive Adjustment Done Successfully', 'Added!');
                }
            },
            error: function (err) {
                let error = err.responseJSON;
                $.each(error.errors, function (key, value) {
                    $('#' + key + "_error").text(value);
                });
            }
        });
    });




    ///////////// ------------------ Edit Transaction Details ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function (e) {
        e.preventDefault();
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id },
            success: function (res) {
                $('#id').val(res.adjust.id);
                $('#updateTranId').val(res.adjust.tran_id);
                $('#updateStore').attr('data-id', res.adjust.store_id);
                $('#updateStore').val(res.adjust.store.store_name);
                $('#updateProduct').attr('data-groupe', res.adjust.tran_groupe_id);
                $('#updateProduct').attr('data-id', res.adjust.tran_head_id);
                $('#updateProduct').val(res.adjust.head.tran_head_name);
                $('#updateQuantity').val(res.adjust.quantity);

                var modal = document.getElementById(modalId);

                if (modal) {
                    modal.style.display = 'block';
                }
            },
            error: function (err) {
                console.log(err)
            }
        });
    });




    /////////////// ------------------ Update Transaction Details ajax part start ---------------- /////////////////////////////
    $(document).on('submit', '#EditForm', function (e) {
        e.preventDefault();
        let store = $('#updateStore').attr('data-id');
        let groupe = $('#updateProduct').attr('data-groupe');
        let product = $('#updateProduct').attr('data-id');
        let formData = new FormData(this);
        formData.append('store', store === undefined ? '' : store);
        formData.append('product', product === undefined ? '' : product);
        formData.append('groupe', groupe === undefined ? '' : groupe);
        formData.append('type', "5");
        formData.append('method', "Positive");
        $.ajax({
            url: urls.update,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#updateProduct').val('');
                    $('#updateProduct').removeAttr('data-id');
                    $('#updateProduct').removeAttr('data-groupe');
                    $('#updateQuantity').val('1');
                    $('.load-data').load(location.href + ' .load-data');
                    $('#editModal').hide();
                    toastr.success('Positive Adjustment Updated Successfully', 'Updated!');
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




    /////////////// ------------------ Delete Transaction Details ajax part start ---------------- /////////////////////////////
    // Delete Button Functionality
    $(document).on('click', '#delete', function (e) {
        e.preventDefault();
        $('#deleteModal').show();
        let id = $(this).attr('data-id');
        $('#confirm').attr('data-id',id);
        $('#cancel').focus();
    });

    // Cancel Button Functionality
    $(document).on('click', '#cancel', function (e) {
        e.preventDefault();
        $('#deleteModal').hide();
    });

    // Confirm Button Functionality
    $(document).on('click', '#confirm', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        $.ajax({
            url: urls.delete,
            method: 'DELETE',
            data: { id },
            success: function (res) {
                if (res.status == "success") {
                    $('.load-data').load(location.href + ' .load-data');
                    $('#search').val('');
                    $('#deleteModal').hide();
                    toastr.success('Adjustment Deleted Successfully', 'Deleted!');
                }
            }
        });
    });

    DeleteAjax('Positive Adjustment Deleted', 'Deleted!');

    PaginationAjax({ type: 5, method: 'Positive' });

    SearchAjax({ type: 5, method: 'Positive' });
    
    SearchByDateAjax({ type: 5, method: 'Positive' });

    SearchPaginationAjax({ type: 5, method: 'Positive' });
});