$(document).ready(function () {
    // Get Last Transaction Id By Transaction Method and Type
    $(document).on('click', '.add', function (e) {
        $('#store').focus();
    });


    ///////////// ------------------ Add Negative Adjustment ajax part start ---------------- /////////////////////////////
    $(document).on('submit', '#AddForm', function (e) {
        e.preventDefault();
        let store = $('#store').attr('data-id');
        let product = $('#product').attr('data-id');
        let groupe = $('#product').attr('data-groupe');
        let formData = new FormData(this);
        formData.append('product', product === undefined ? '' : product);
        formData.append('groupe', groupe === undefined ? '' : groupe);
        formData.append('store', store === undefined ? '' : store);
        formData.append('method', 'Negative');
        formData.append('type', '6');
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
                    toastr.success('Negative Adjustment Done Successfully', 'Added!');
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
        formData.append('type', "6");
        formData.append('method', "Negative");
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
                    toastr.success('Negative Adjustment Updated Successfully', 'Updated!');
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


    DeleteAjax('Negative Adjustment Deleted', 'Deleted!');

    PaginationAjax({ type: 6, method: 'Negative' });

    SearchAjax({ type: 6, method: 'Negative' });
    
    SearchByDateAjax({ type: 6, method: 'Negative' });

    SearchPaginationAjax({ type: 6, method: 'Negative' });
});