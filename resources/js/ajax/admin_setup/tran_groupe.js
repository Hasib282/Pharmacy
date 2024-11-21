$(document).ready(function () {
    // Add Button Click Functionality
    $(document).on('click', '.add', function (e) {
        $('#groupeName').focus();
    });



    /////////////// ------------------ Add Transaction Groupe ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#Insert', function (e) {
        e.preventDefault();
        let groupeName = $('#groupeName').val();
        let type = $('#type').val();
        let method = $('#method').val();
        $.ajax({
            url: urls.insert,
            method: 'POST',
            data: { groupeName, type, method },
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#AddForm')[0].reset();
                    $('#groupeName').focus();
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Transaction Groupe Added Successfully', 'Added!');
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



    ///////////// ------------------ Edit Transaction Groupe ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id },
            success: function (res) {
                $('#id').val(id);
                $('#updateGroupeName').val(res.groupes.tran_groupe_name);
                $('#updateType').html('');
                $('#updateType').append(`<option value="" >Select Transaction Type</option>`);
                $.each(res.types, function (key, type) {
                    $('#updateType').append(`<option value="${type.id}" ${res.groupes.tran_groupe_type == type.id ? 'selected' : ''}>${type.type_name}</option>`);
                });


                $('#updateMethod').empty();
                $('#updateMethod').append(`<option value="" >Select Transaction Method</option>
                                         <option value="Receive" ${res.groupes.tran_method === 'Receive' ? 'selected' : ''}>Receive</option>
                                         <option value="Payment" ${res.groupes.tran_method === 'Payment' ? 'selected' : ''}>Payment</option>
                                         <option value="Both" ${res.groupes.tran_method === 'Both' ? 'selected' : ''}>Both</option>`);
                

                $('#updateGroupeName').focus();
                var modal = document.getElementById(modalId);
                modal.style.display = 'block';
            },
            error: function (err) {
                console.log(err);
            }
        });
    });



    /////////////// ------------------ Update Transaction Groupe ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#Update', function (e) {
        e.preventDefault();
        let id = $('#id').val();
        let groupeName = $('#updateGroupeName').val();
        let type = $('#updateType').val();
        let method = $('#updateMethod').val();
        $.ajax({
            url: urls.update,
            method: 'PUT',
            data: { groupeName, type, method, id },
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#editModal').hide();
                    $('#EditForm')[0].reset();
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Transaction Groupe Updated Successfully', 'Updated!');
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

    DeleteAjax('Transaction Groupe Deleted', 'Deleted!');

    PaginationAjax({  });

    SearchAjax({ method: $('#methods').val(), type: $('#types').val() });

    SearchPaginationAjax({ method: $('#methods').val(), type: $('#types').val() });


    // Method, Types Option Change functionality
    $(document).on('change', '#methods, #types', function (e) {
        e.preventDefault();
        let search = $('#search').val();
        let method = $('#methods').val();
        let type = $('#types').val();
        LoadData(urls.search, { search, method, type })
    });
    
});