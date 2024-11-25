function ShowPaymentToSuppliers(data, startIndex) {
    let tableRows = '';
    let totalBillAmount = 0;
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.tran_id}</td>
                    <td>${item.user.user_name}</td>
                    <td style="text-align: right">${item.bill_amount.toLocaleString('en-US', { minimumFractionDigits: 0 })} Tk.</td>
                    <td>
                        <div style="display: flex;gap:5px;">
                            <button class="open-modal" data-modal-id="editModal" id="edit"
                                    data-id="${item.tran_id}"><i class="fas fa-edit"></i></button>
                            
                            <button data-id="${item.tran_id}" id="delete"><i class="fas fa-trash"></i></button>
                            
                        </div>
                    </td>
                </tr>
            `;

            totalBillAmount += parseFloat(item.bill_amount) || 0;
        });

        // Inject the generated rows into the table body
        $('.load-data .show-table tbody').html(tableRows);


        $('.load-data .show-table tfoot').html(`
            <tr>
                <td style="text-align: right" colspan="3">Total:</td>
                <td style="text-align: right">${totalBillAmount.toLocaleString('en-US', { minimumFractionDigits: 0 })} Tk.</td>
                <td></td>
            </tr>
        `);
    }
    else{
        $('.load-data .show-table tbody').html('');
        $('.load-data .show-table tfoot').html('<tr><td colspan="11" style="text-align:center;">No Transaction Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Load Data on Hard Reload
    ReloadData('transaction/party/payment', ShowPaymentToSuppliers);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#date", function(){
        GetTransactionWith(null, 'Payment', '#within', 5)
        $('.due-grid tbody').html('');
        $('.due-grid tfoot').html('');
    });


    // Insert Ajax
    InsertAjax('transaction/party/payment', ShowPaymentToSuppliers, 
        {
            user: { selector: '#user', attribute: 'data-id' },
            withs: { selector: '#user', attribute: 'data-with' },
            company: { selector: '#company', attribute: 'data-id' },
            'groupe': 2,
            'head': 2,
            'type': 2,
            'method': 'Payment',
        }, 
        function() {
            $('#user').removeAttr('data-id');
            $('#user').removeAttr('data-with');
            $('.due-grid tbody').html('');
            $('.due-grid tfoot').html('');
        }
    );


    //Edit Ajax
    EditAjax('transaction/party/payment', EditFormInputValue, EditModalOn);


    // Update Ajax
    // UpdateAjax('transaction/party/payment', ShowPaymentToSuppliers);
    

    // Delete Ajax
    // DeleteAjax('transaction/party/payment', ShowPaymentToSuppliers);


    // Pagination Ajax
    PaginationAjax(ShowPaymentToSuppliers);


    // Search Ajax
    SearchAjax('transaction/party/payment', ShowPaymentToSuppliers, { type: 2, method: 'Payment' });


    // Search By Date
    SearchByDateAjax('transaction/party/payment', ShowPaymentToSuppliers, {type: 2, method: 'Payment'});


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#updateTranId').val(res.party.tran_id);

        getDueListByUserId(res.party.tran_user, '.due-grid tbody');
        $('#updateUser').attr('data-id',res.party.tran_user);
        $('#updateUser').val(res.party.user.user_name);
        $('#updateAmount').val(res.party.payment);
        $('#updateDiscount').val(res.party.discount);
    }


    // Edit Modal Open Functionality
    function EditModalOn(){
        GetTransactionWith(null, 'Payment', '#within', 5)
        $('.due-grid tbody').html('');
        $('.due-grid tfoot').html('');
    }
});