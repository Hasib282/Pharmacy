$(document).ready(function () {
    $(document).on('click', '.add', function (e) {
        $('#productName').focus();
    });

    
    /////////////// ------------------ Add Inventory Product ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#Insert', function (e) {
        e.preventDefault();
        let productName = $('#productName').val();
        let groupe = $('#groupe').val();
        let category = $('#category').attr('data-id');
        let manufacturer = $('#manufacturer').attr('data-id');
        let form = $('#form').attr('data-id');
        let unit = $('#unit').attr('data-id');
        let store = $('#store').attr('data-id');
        let expirydate  = $('#expirydate').val();
        $.ajax({
            url: urls.insert,
            method: 'POST',
            data: { productName, groupe, category, manufacturer, form, unit, store, expirydate  },
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#AddForm')[0].reset();
                    $('#productName').focus();
                    $('#search').val('');
                    $('#category').removeAttr('data-id')
                    $('#manufacturer').removeAttr('data-id')
                    $('#form').removeAttr('data-id')
                    $('#unit').removeAttr('data-id')
                    $('#store').removeAttr('data-id')
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Inventory Product Added Successfully', 'Added!');
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



    ///////////// ------------------ Edit Inventory Product ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        $('#EditForm')[0].reset();
        $('#updateCategory').removeAttr('data-id')
        $('#updateManufacturer').removeAttr('data-id')
        $('#updateForm').removeAttr('data-id')
        $('#updateUnit').removeAttr('data-id')
        $('#updateStore').removeAttr('data-id')
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id },
            success: function (res) {
                $('#id').val(id);
                $('#updateProductName').val(res.heads.tran_head_name);
                $('#updateProductName').focus();

                $('#updateGroupe').html('');
                $('#updateGroupe').append(`<option value="" >Select Product Groupe</option>`);
                $.each(res.groupes, function (key, groupe) {
                    $('#updateGroupe').append(`<option value="${groupe.id}" ${res.heads.groupe_id === groupe.id ? 'selected' : ''}>${groupe.tran_groupe_name}</option>`);
                });

                if(res.heads.category_id){
                    $('#updateCategory').val(res.heads.category.category_name);
                    $('#updateCategory').attr('data-id', res.heads.category.id);
                }
                
                if(res.heads.manufacturer_id){
                    $('#updateManufacturer').val(res.heads.manufecturer.manufacturer_name);
                    $('#updateManufacturer').attr('data-id', res.heads.manufecturer.id);
                }
                
                if(res.heads.form_id){
                    $('#updateForm').val(res.heads.form.form_name);
                    $('#updateForm').attr('data-id', res.heads.form_id);
                }

                if(res.heads.unit_id){
                    $('#updateUnit').val(res.heads.unit.unit_name);
                    $('#updateUnit').attr('data-id', res.heads.unit_id);
                }

                if(res.heads.store_id){
                    $('#updateStore').val(res.heads.store.store_name);
                    $('#updateStore').attr('data-id', res.heads.store_id);
                }

                $('#updateQuantity').val(res.heads.quantity);
                $('#updateCp').val(res.heads.cp);
                $('#updateMrp').val(res.heads.mrp);
                $('#updateExpiryDate').val(res.heads.expired_date);

                var modal = document.getElementById(modalId);
                modal.style.display = 'block';
            },
            error: function (err) {
                console.log(err);
            }
        });
    });



    /////////////// ------------------ Update Inventory Product ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#Update', function (e) {
        e.preventDefault();
        let id = $('#id').val();
        let groupe = $('#updateGroupe').val();
        let productName = $('#updateProductName').val();
        let category = $('#updateCategory').attr('data-id');
        let manufacturer = $('#updateManufacturer').attr('data-id');
        let form = $('#updateForm').attr('data-id');
        let unit = $('#updateUnit').attr('data-id');
        let store = $('#updateStore').attr('data-id');
        let quantity = $('#updateQuantity').val();
        let cp = $('#updateCp').val();
        let mrp = $('#updateMrp').val();
        let expiryDate = $('#updateExpiryDate').val();

        $.ajax({
            url: urls.update,
            method: 'PUT',
            data: { id, productName, groupe, category, manufacturer, form, unit, store, quantity, cp, mrp, expiryDate },
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#editModal').hide();
                    $('#EditForm')[0].reset();
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Inventory Product Updated Successfully', 'Updated!');
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



    DeleteAjax('Inventory Product Details Deleted', 'Deleted!');

    PaginationAjax({  });

    SearchAjax({  });

    SearchPaginationAjax({  });

});