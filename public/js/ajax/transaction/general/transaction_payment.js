///////////////////////////////////////////////  Updated Format Start From Here /////////////////////////////////  
function ShowTransactionPayments(data, startIndex) {
    let tableRows = '';
    let totalBillAmount = 0;
    let totalDiscount = 0;
    let totalNetAmount = 0;
    let totalAdvance = 0;
    let totalDueCol = 0;
    let totalDueDiscount = 0;
    let totalDue = 0;
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.tran_id}</td>
                    <td>${item.user.user_name}</td>
                    <td style="text-align: right">${item.bill_amount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.discount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.net_amount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.payment.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.due_col.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.due_disc.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.due.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td>
                        <div style="display: flex;gap:5px;">
                        
                            <a class="print-receipt" href="/api/get/invoice?id=${item.tran_id}&status=1"> <i class="fa-solid fa-receipt"></i></a>
                                    
                            <button class="open-modal" data-modal-id="editModal" id="edit"
                                    data-id="${item.tran_id}"><i class="fas fa-edit"></i></button>
                                    
                            <button data-id="${item.tran_id}" id="delete"><i class="fas fa-trash"></i></button>
                            
                        </div>
                    </td>
                </tr>
            `;

            totalBillAmount += parseFloat(item.bill_amount) || 0;
            totalDiscount += parseFloat(item.discount) || 0;
            totalNetAmount += parseFloat(item.net_amount) || 0;
            totalAdvance += parseFloat(item.payment) || 0;
            totalDueCol += parseFloat(item.due_col) || 0;
            totalDueDiscount += parseFloat(item.due_disc) || 0;
            totalDue += parseFloat(item.due) || 0;
        });

        // Inject the generated rows into the table body
        $('.load-data .show-table tbody').html(tableRows);

    
        $('.load-data .show-table tfoot').html(`
                <tr>
                    <td colspan="3">Total:</td>
                    <td style="text-align: right">${totalBillAmount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${totalDiscount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${totalNetAmount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${totalAdvance.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${totalDueCol.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${totalDueDiscount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${totalDue.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
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
    // Load Transaction Groupe
    GetTransactionGroupe(1, "Payment");


    // Load Data on Hard Reload
    ReloadData('transaction/payment', ShowTransactionPayments);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#date", function(){
        GetTransactionWith('1', 'Payment', '#within');
        localStorage.removeItem('transactionData');
        $('.transaction_grid tbody').html('');
    });


    // Insert Into Local Storage
    InsertLocalStorage();
    

    // Insert Transaction Payment ajax
    InsertTransaction('transaction/payment', ShowTransactionPayments, 'Payment', '1', function() {
        $('#location').removeAttr('data-id');
        $('#user').removeAttr('data-id');
        $('#user').removeAttr('data-with');
        $('#date').focus();
        $('.transaction_grid tbody').html('');
        localStorage.removeItem('transactionData');
    });


    //Edit Ajax
    EditAjax('transaction/payment', EditFormInputValue, EditModalOn);


    // Update Transaction Payment ajax
    UpdateTransaction('transaction/payment', ShowTransactionPayments, 'Payment', '1');
    

    // Delete Ajax
    DeleteAjax('transaction/payment', ShowTransactionPayments);


    // Pagination Ajax
    PaginationAjax(ShowTransactionPayments);


    // Search Ajax
    SearchAjax('transaction/payment', ShowTransactionPayments, { type: 1, method: 'Payment' });


    // Search By Date
    SearchByDateAjax('transaction/payment', ShowTransactionPayments, {type: 1, method: 'Payment'});


    // Additional Edit Functionality
    function EditFormInputValue(res){
        getTransactionGrid(res.data.tran_id);
        $('#id').val(res.data.id);
        
        $('#updateTranId').val(res.data.tran_id);

        var timestamps = new Date(res.data.tran_date);
        var formattedDate = timestamps.toLocaleDateString('en-US', { timeZone: 'UTC' });
        $('#updateDate').val(formattedDate);
        
        $('#updateUser').attr('data-id',res.data.tran_user);
        $('#updateUser').attr('data-with',res.data.tran_type_with);
        $('#updateUser').val(res.data.user.user_name);

        $('#updateTotalDiscount').val(res.data.discount);

        $('#updateAdvance').val(res.data.payment);
        
        $("#updateHead").focus();
    }

    

    // Edit Modal Open Functionality
    function EditModalOn(){
        $('#updateHead').val('');
        $('#updateHead').removeAttr('data-id');
        $('#updateHead').removeAttr('data-groupe');
        $('#updateQuantity').val('1');
        $('#updateAmount').val('');
        $('#updateTotAmount').val('');
        $('#dId').val('');
        GetTransactionWith('1', 'Payment', '#within');
        localStorage.removeItem('transactionData');
        $('.transaction_grid tbody').html('');
    }
});