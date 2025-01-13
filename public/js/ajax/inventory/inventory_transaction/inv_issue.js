function ShowInventoryIssues(data, startIndex) {
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
    // Creating Select Options Dynamically
    $.ajax({
        url: `${apiUrl}/inventory/transaction/issue`,
        method: "GET",
        success: function (res) {
            let groupein = "";
            let updategroupein = "";

            // Groupin chedckbox
            $.each(res.groupes, function(key, groupe) {
                groupein += `<input type="checkbox" id="groupe[]" name="groupe" class="groupe-checkbox"
                value="${groupe.id}" checked>`
            });
            $('#groupein').html(groupein);

            // Update Groupin chedckbox
            $.each(res.groupes, function(key, groupe) {
                updategroupein += `<input type="checkbox" id="groupe[]" name="groupe" class="updategroupe-checkbox"
                    value="${groupe.id}" checked>`
            });
            $('#updategroupein').html(updategroupein);
        },
    });


    // Load Data on Hard Reload
    ReloadData('inventory/transaction/issue', ShowInventoryIssues);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#product", function(){
        GetTransactionWith(5, 'Receive', '#within');
        $('#store').val("Store 1")
        $('#store').attr("data-id", '1');
        $('#user').val('General Customer')
        $('#user').attr('data-id', 'C000000101')
        $('#user').attr('data-with', 4);
        localStorage.removeItem('transactionData');
        $('.transaction_grid tbody').html('');
    });


    // Insert Ajax
    // InsertAjax('inventory/transaction/issue', ShowInventoryIssues, {}, function() {
    //     $('#division').focus();
    // });


    //Edit Ajax
    EditAjax('inventory/transaction/issue', EditFormInputValue, EditModalOn);


    // Update Ajax
    // UpdateAjax('inventory/transaction/issue', ShowInventoryIssues);
    

    // Delete Ajax
    DeleteAjax('inventory/transaction/issue', ShowInventoryIssues);


    // Pagination Ajax
    PaginationAjax(ShowInventoryIssues);


    // Search Ajax
    SearchAjax('inventory/transaction/issue', ShowInventoryIssues, { type: 5, method: 'Issue' });


    // Search By Ajax
    SearchByDateAjax('inventory/transaction/issue', ShowInventoryIssues, { type: 5, method: 'Issue' });


    // Additional Edit Functionality
    function EditFormInputValue(res){
        getTransactionGrid(res.inventory.tran_id);
        $('#id').val(res.inventory.id);
        
        $('#updateTranId').val(res.inventory.tran_id);
        var timestamps = new Date(res.inventory.tran_date);
        var formattedDate = timestamps.toLocaleDateString('en-US', { timeZone: 'UTC' });
        $('#updateDate').val(formattedDate);
        $('#updateStore').val(res.inventory.store.store_name);
        $('#updateStore').attr('data-id', res.inventory.store_id);
        $('#updateUser').attr('data-id',res.inventory.tran_user);
        $('#updateUser').attr('data-with',res.inventory.tran_type_with);
        $('#updateUser').val(res.inventory.user.user_name);
        $('#updateTotalDiscount').val(res.inventory.discount);
        $('#updateAdvance').val(res.inventory.receive);
        $('#updateName').val(res.inventory.user_name);
        $('#updatePhone').val(res.inventory.user_phone);
        $('#updateAddress').val(res.inventory.user_address);
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
        GetTransactionWith(5, 'Receive', '#updatewithin');
        localStorage.removeItem('transactionData');
        $('.transaction_grid tbody').html('');
    }

    // Insert Into Local Storage
    InsertLocalStorage(true);


    // Insert Inventory Issue ajax
    InsertTransaction('inventory/transaction/issue', ShowInventoryIssues, 'Issue', '5', function() {
        $('#store').val("Store 1")
        $('#store').attr("data-id", '1');
        $('#user').val('General Customer')
        $('#user').attr('data-id', 'C000000101')
        $('#user').attr('data-with', 4);
        $('.transaction_grid tbody').html('');
        $('#product').focus();
        localStorage.removeItem('transactionData');
    });


    // Update Inventory Issue ajax
    UpdateTransaction('inventory/transaction/issue', ShowInventoryIssues, 'Issue', "5");
});