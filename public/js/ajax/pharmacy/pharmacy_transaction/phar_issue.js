function ShowPharmacyIssues(data, startIndex) {
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
                    <td style="text-align: right">${item.receive.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
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
            totalBillAmount += item.bill_amount;
            totalDiscount += item.discount;
            totalNetAmount += item.net_amount;
            totalAdvance += item.receive;
            totalDueCol += item.due_col;
            totalDueDiscount += item.due_disc;
            totalDue += item.due;
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
            </tr>`
        );
    }
    else{
        $('.load-data .show-table tbody').html('');
        $('.load-data .show-table tfoot').html('<tr><td colspan="11" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Load Transaction Groupe
    GetTransactionGroupe(6, "Receive");


    // Load Data on Hard Reload
    ReloadData('pharmacy/transaction/issue', ShowPharmacyIssues);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#product", function(){
        GetTransactionWith(6, 'Receive', '#within');
        localStorage.removeItem('transactionData');
        $('#store').val("Store 1")
        $('#store').attr("data-id", '1');
        $('#user').val('General Customer')
        $('#user').attr('data-id', 'CL000000001')
        $('#user').attr('data-with', 4);
        $('.transaction_grid tbody').html('');
    });


    // Insert Ajax
    // InsertAjax('pharmacy/transaction/issue', ShowPharmacyIssues, {}, function() {
    //     $('#division').focus();
    // });


    //Edit Ajax
    EditAjax('pharmacy/transaction/issue', EditFormInputValue, EditModalOn);


    // Update Ajax
    // UpdateAjax('pharmacy/transaction/issue', ShowPharmacyIssues);
    

    // Delete Ajax
    DeleteAjax('pharmacy/transaction/issue', ShowPharmacyIssues);


    // Pagination Ajax
    PaginationAjax(ShowPharmacyIssues);


    // Search Ajax
    SearchAjax('pharmacy/transaction/issue', ShowPharmacyIssues, { type: 6, method: 'Issue' });


    // Search By Ajax
    SearchByDateAjax('pharmacy/transaction/issue', ShowPharmacyIssues, { type: 6, method: 'Issue' });


    // Additional Edit Functionality
    function EditFormInputValue(res){
        getTransactionGrid(res.issue.tran_id);
        $('#id').val(res.issue.id);
        
        $('#updateTranId').val(res.issue.tran_id);
        var timestamps = new Date(res.issue.tran_date);
        var formattedDate = timestamps.toLocaleDateString('en-US', { timeZone: 'UTC' });
        $('#updateDate').val(formattedDate);
        $('#updateStore').val(res.issue.store.store_name);
        $('#updateStore').attr('data-id', res.issue.store_id);
        $('#updateUser').attr('data-id',res.issue.tran_user);
        $('#updateUser').attr('data-with',res.issue.tran_type_with);
        $('#updateUser').val(res.issue.user.user_name);
        $('#updateTotalDiscount').val(res.issue.discount);
        $('#updateAdvance').val(res.issue.receive);
        $('#updateName').val(res.issue.user_name);
        $('#updatePhone').val(res.issue.user_phone);
        $('#updateAddress').val(res.issue.user_address);
        $("#updateProduct").focus();
    }


    function EditModalOn() {
        $('#updateProduct').val('');
        $('#updateProduct').removeAttr('data-id');
        $('#updateProduct').removeAttr('data-groupe');
        $('#updateQuantity').val('1');
        $('#updateMrp').val('');
        $('#updateTotAmount').val('');
        $('#dId').val('');
        GetTransactionWith(6, 'Receive', '#updatewithin');
        localStorage.removeItem('transactionData');
        $('.transaction_grid tbody').html('');
    }


    // Insert Into Local Storage
    InsertLocalStorage(true);


    // Insert Pharmacy Issue ajax
    InsertTransaction('pharmacy/transaction/issue', ShowPharmacyIssues, 'Issue', '6', function() {
        $('#store').val("Store 1")
        $('#store').attr("data-id", '1');
        $('#user').val('General Customer')
        $('#user').attr('data-id', 'CL000000001')
        $('#user').attr('data-with', 4);
        $('.transaction_grid tbody').html('');
        $('#product').focus();
        localStorage.removeItem('transactionData');
    });


    // Update Pharmacy Issue ajax
    UpdateTransaction('pharmacy/transaction/issue', ShowPharmacyIssues, 'Issue', "6");
});