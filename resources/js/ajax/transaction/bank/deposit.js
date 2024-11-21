$(document).ready(function () {
    // Get Last Transaction Id By Transaction Method and Type
    $(document).on('click', '.add', function (e) {
        $('#date').focus();
    });



    /////////////// ------------------ Add Bank Deposit Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#Insert', function (e) {
        e.preventDefault();
        let method = 'Deposit';
        let type = '4';
        let bank = $('#bank').attr('data-id');
        let amount = $('#amount').val();
        let head = $('#head').attr('data-id');
        let groupe = $('#head').attr('data-groupe');
        $.ajax({
            url: urls.insert,
            method: 'POST',
            data: { type, method, bank, amount, head, groupe },
            beforeSend: function () {
                $(document).find('span.error').text('');
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#AddForm')[0].reset();
                    $('#head').removeAttr('data-id');
                    $('#head').removeAttr('data-groupe');
                    $('#bank').removeAttr('data-id');
                    $('.load-data').load(location.href + ' .load-data');
                    $('#bank').focus();
                    toastr.success('Bank Transaction Added Successfully', 'Added!');
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



    ///////////// ------------------ Edit Bank Deposit ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id },
            success: function (res) {
                var timestamps = new Date(res.transaction.tran_date);
                var formattedDate = timestamps.toLocaleDateString('en-US', { timeZone: 'UTC' });
                $('#updateDate').val(formattedDate);

                $('#id').val(res.transaction.tran_id);

                $('#updateHead').val(res.transaction.head.tran_head_name);
                $('#updateHead').attr('data-id', res.transaction.tran_head_id);
                $('#updateHead').attr('data-group', res.transaction.tran_groupe_id);
                
                $('#updateBank').attr('data-id',res.transaction.tran_bank);
                $('#updateBank').val(res.transaction.bank.name);

                $('#updateAmount').val(res.transaction.amount);
                
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



    /////////////// ------------------ Update Bank Deposit ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#Update', function (e) {
        e.preventDefault();
        let id = $('#id').val();
        let bank = $('#updateBank').attr('data-id');
        let head = $('#updateHead').attr('data-id');
        let groupe = $('#updateHead').attr('data-groupe');
        let amount = $('#updateAmount').val();
        let method = 'Deposit';
        $.ajax({
            url: urls.update,
            method: 'PUT',
            data: {id, bank, head, groupe, amount, method },
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#editModal').hide();
                    $('#search').val();
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Bank Deposit Updated Successfully', 'Updated!');
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

    DeleteAjax('Bank Transaction Deleted', 'Deleted!');

    PaginationAjax({ type: 4, method: 'Deposit' });

    SearchAjax({ type: 4, method: 'Deposit' });
    
    SearchByDateAjax({ type: 4, method: 'Deposit' });

    SearchPaginationAjax({ type: 4, method: 'Deposit' });
});