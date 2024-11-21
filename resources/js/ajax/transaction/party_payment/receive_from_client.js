$(document).ready(function () {
    //get last transaction id by transaction type
    $(document).on('click', '.add', function (e) {
        $('#date').focus();
        getTransactionWith('Receive', 4, '#within')
        $('.due-grid tbody').html('');
        $('.due-grid tfoot').html('');
    });



    ///////////// ------------------ Add Party Receive ajax part start ---------------- /////////////////////////////
    $(document).on('submit', '#AddForm', function (e) {
        e.preventDefault();
        let user = $('#user').attr('data-id');
        let withs = $('#user').attr('data-with');
        let formData = new FormData(this);
        formData.append('user', user === undefined ? '' : user);
        formData.append('withs', withs === undefined ? '' : withs);
        formData.append('groupe', 2);
        formData.append('head', 1);
        formData.append('type', 2);
        formData.append('method', "Receive");
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
                    $('#AddForm')[0].reset();
                    $('#location').removeAttr('data-id');
                    $('#user').removeAttr('data-id');
                    $('.load-data').load(location.href + ' .load-data');
                    $('.due-grid tbody').html('');
                    $('.due-grid tfoot').html('');
                    toastr.success('Party Payment Added Successfully', 'Added!');
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



    ///////////// ------------------ Edit Transaction Main ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        getTransactionWith('Receive', 4, '#within')
        $('.due-grid tbody').html('');
        $('.due-grid tfoot').html('');
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id },
            success: function (res) {
                $('#updateTranId').val(res.party.tran_id);

                getDueListByUserId(res.party.tran_user, '.due-grid tbody');
                $('#updateUser').attr('data-id',res.party.tran_user);
                $('#updateUser').val(res.party.user.user_name);
                $('#updateAmount').val(res.party.receive);
                $('#updateDiscount').val(res.party.discount);
                
                
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



    DeleteAjax('Party Payment Deleted', 'Deleted!');

    PaginationAjax({ type: 2, method: 'Receive' });

    SearchAjax({ type: 2, method: 'Receive' });
    
    SearchByDateAjax({ type: 2, method: 'Receive' });

    SearchPaginationAjax({ type: 2, method: 'Receive' });



    //get last transaction with by transaction type function
    function getTransactionWith(method, user, targetElement) {
        $.ajax({
            url: urls.with,
            method: 'GET',
            data: { type:null, method, user },
            success: function (res) {
                if (res.status === 'success') {
                    $(targetElement).html('');
                    $.each(res.tranwith, function (key, withs) {
                        $(targetElement).append(`<input type="checkbox" id="with[]" class="with-checkbox" name="with" value="${withs.id}" checked>`);
                    });
                }

            }
        });
    }



    // Get Due Payment list by User Id
    function getDueListByUserId(id, grid) {
        $.ajax({
            url: urls.due,
            method: 'GET',
            data: { id:id },
            success: function (res) {
                if(res.status === 'success'){
                    $(grid).html(res.data);
                    
                    let transactions = res.transaction.data;
                    // Calculate total amount
                    let totalAmount = transactions.reduce((sum, transaction) => sum + transaction.due, 0);
                    const formattedTotalAmount = totalAmount.toLocaleString('en-US');
                    $('.due-grid tfoot').html(`<tr>
                                                    <td colspan="4" style="text-align:right;"> Total Due: ${formattedTotalAmount} Tk.</td>
                                                </tr>`)
                }
                else{
                    $(grid).html('');
                }
                
            }
        });
    }



    // Search Party Payment Details
    function searchPartyPayment(url, data, targetElement) {
        $.ajax({
            url: url,
            method: 'GET',
            data: data,
            success: function (res) {
                if(res.status === 'success'){
                    console.log(res.data)
                    $(targetElement).html(res.data);
                    if(res.paginate){
                        $(targetElement).append('<div class="center search-paginate" id="paginate">' + res.paginate + '</div>');
                    }
                }
                else{
                    $(targetElement).html(`<span class="error">Result not Found </span>`);
                }
            }
        });
    }
});