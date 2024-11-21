$(document).ready(function () {
    // Add Button Click Functionality
    $(document).on('click', '.add', function (e) {
        $("#name").focus();
    });



    /////////////// ------------------ Add Tran With Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#Insert', function (e) {
        e.preventDefault();
        let name = $('#name').val();
        let role = $('#role').val();
        let tranType = $('#tranType').val();
        let tranMethod = $('#tranMethod').val();
        $.ajax({
            url: urls.insert,
            method: 'POST',
            data: { name, role, tranType, tranMethod },
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#AddForm')[0].reset();
                    $('#name').focus();
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Tranwith Added Successfully', 'Added!');
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



    ///////////// ------------------ Edit Tran With Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id },
            success: function (res) {
                $('#id').val(id);
                $('#updateName').val(res.tranwith.tran_with_name);
                // Create options dynamically
                $('#updateRole').html('');
                $('#updateRole').append(`<option value="" >Select User Role</option>`);
                $.each(res.roles, function (key, role) {
                    $('#updateRole').append(`<option value="${role.id}" ${res.tranwith.user_role === role.id ? 'selected' : ''}>${role.name}</option>`);
                });

                $('#updateTranType').html('');
                $('#updateTranType').append(`<option value="" >Select Transaction Type</option>`);
                $.each(res.types, function (key, type) {
                    $('#updateTranType').append(`<option value="${type.id}" ${res.tranwith.tran_type === type.id ? 'selected' : ''}>${type.type_name}</option>`);
                });

                $('#updateTranMethod').html('');
                $('#updateTranMethod').append(`<option value="Receive" ${res.tranwith.tran_method === 'Receive' ? 'selected' : ''}>Receive</option>
                                         <option value="Payment" ${res.tranwith.tran_method === 'Payment' ? 'selected' : ''}>Payment</option>
                                         <option value="Both" ${res.tranwith.tran_method === 'Both' ? 'selected' : ''}>Both</option>`);
                
                
                $('#updateName').focus();
                var modal = document.getElementById(modalId);
                modal.style.display = 'block';
            },
            error: function (err) {
                console.log(err);
            }
        });
    });



    /////////////// ------------------ Update Tran With Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#Update', function (e) {
        e.preventDefault();
        let id = $('#id').val();
        let name = $('#updateName').val();
        let role = $('#updateRole').val();
        let tranType = $('#updateTranType').val();
        let tranMethod = $('#updateTranMethod').val();
        $.ajax({
            url: urls.update,
            method: 'PUT',
            data: { name, role, tranType, tranMethod, id },
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#editModal').hide();
                    $('#EditForm')[0].reset();
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Tranwith Updated Successfully', 'Updated!');
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

    SearchAjax({ method: $('#methods').val(), type: $('#types').val(), role: $("#roles").val() });

    SearchPaginationAjax({ method: $('#methods').val(), type: $('#types').val(), role: $("#roles").val() });

    // Method, Types and User Option Change functionality
    $(document).on('change', '#methods, #roles, #types', function (e) {
        e.preventDefault();
        let search = $('#search').val();
        let type = $("#types").val();
        let method = $('#methods').val();
        let role = $('#roles').val();
        LoadData(urls.search, { search, method, role, type })
    });
});