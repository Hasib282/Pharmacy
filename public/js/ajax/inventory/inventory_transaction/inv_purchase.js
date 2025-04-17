function ShowInventoryPurchases(data, startIndex) {
    let tableRows = '';
    let totalBillAmount = 0;
    let totalDiscount = 0;
    let totalNetAmount = 0;
    let totalAdvance = 0;
    let totalDueCol = 0;
    let totalDueDiscount = 0;
    let totalDue = 0;
    let params = GetQueryParams();
    
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
                            ${params['status'] == 2 ? 
                                `<button class="open-modal" data-modal-id="verifyModal" id="verify"
                                        data-id="${item.tran_id}"><i class="fa-solid fa-check"></i> Verify</button>`
                                :
                                ""
                            }
                            <a class="print-receipt" href="/api/get/invoice?id=${item.tran_id}&status=${params['status'] ? params['status'] : 1}"> <i class="fa-solid fa-receipt"></i></a>
                            
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
            totalAdvance += item.payment;
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
            </tr>
        `)
    }
    else{
        $('.load-data .show-table tbody').html('');
        $('.load-data .show-table tfoot').html('<tr><td colspan="11" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    $(document).off(`.${'SearchBySelect'}`);


    // Load Transaction Groupe
    GetTransactionGroupe(5, "Payment");


    // Load Data on Hard Reload
    ReloadData('inventory/transaction/purchase', ShowInventoryPurchases);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#product", function(){
        GetTransactionWith(5, 'Payment', '#within');
        localStorage.removeItem('transactionData');
        $('.transaction_grid tbody').html('');
    });


    // Insert Ajax
    // InsertAjax('inventory/transaction/purchase', ShowInventoryPurchases, {}, function() {
    //     $('#division').focus();
    // });


    //Edit Ajax
    EditAjax('inventory/transaction/purchase', EditFormInputValue, EditModalOn);


    // Update Ajax
    // UpdateAjax('inventory/transaction/purchase', ShowInventoryPurchases);
    

    // Delete Ajax
    DeleteAjax('inventory/transaction/purchase', ShowInventoryPurchases);


    // Pagination Ajax
    PaginationAjax(ShowInventoryPurchases);


    // Search Ajax
    SearchAjax('inventory/transaction/purchase', ShowInventoryPurchases, { type: 5, method: 'Purchase', status: { selector: "#status"} });


    // Search By Date
    SearchByDateAjax('inventory/transaction/purchase', ShowInventoryPurchases, { type: 5, method: 'Purchase', status: { selector: "#status"} });


    // Search By Methods, Roles, Types
    SearchBySelect('inventory/transaction/purchase', ShowInventoryPurchases, '#status', { type: 5, method: 'Purchase', status: { selector: "#status"} } );


    // Additional Edit Functionality
    function EditFormInputValue(res){
        getTransactionGrid(res.data.tran_id);

        $('#id').val(res.data.id);
        
        $('#updateTranId').val(res.data.tran_id);

        var timestamps = new Date(res.data.tran_date);
        var formattedDate = timestamps.toLocaleDateString('en-US', { timeZone: 'UTC' });
        $('#updateDate').val(formattedDate);

        $('#updateStore').val(res.data.store.store_name);
        $('#updateStore').attr('data-id', res.data.store_id);
        
        $('#updateUser').attr('data-id',res.data.tran_user);
        $('#updateUser').attr('data-with',res.data.tran_type_with);
        $('#updateUser').val(res.data.user.user_name);

        $('#updateTotalDiscount').val(res.data.discount);

        $('#updateAdvance').val(res.data.payment);

        
        $("#updateProduct").focus();
    }


    function EditModalOn() {
        $('#updateProduct').val('');
        $('#updateProduct').removeAttr('data-id');
        $('#updateProduct').removeAttr('data-groupe');
        $('#updateUnit').val('');
        $('#updateUnit').removeAttr('data-id');
        $('#updateQuantity').val('1');
        $('#updateCp').val('');
        $('#updateMrp').val('');
        let currentDate = new Date().toISOString().split('T')[0];
        $('#updateExpiry').val(currentDate);
        $('#updateTotAmount').val('');
        $('#dId').val('');
        GetTransactionWith(5, 'Payment', '#updatewithin');
        localStorage.removeItem('transactionData');
        $('.transaction_grid tbody').html('');
    }

    
    // Insert Into Local Storage
    InsertLocalStorage();


    // Insert Inventory Purchase ajax
    InsertTransaction('inventory/transaction/purchase', ShowInventoryPurchases, 'Purchase', '5', function() {
        $('#location').removeAttr('data-id');
        $('#user').removeAttr('data-id');
        $('#user').removeAttr('data-with');
        $('#store').removeAttr('data-id');
        $('#status').val('1');
        $('.transaction_grid tbody').html('');
        localStorage.removeItem('transactionData');
    });


    // Update Inventory Purchase ajax
    UpdateTransaction('inventory/transaction/purchase', ShowInventoryPurchases, 'Purchase', "5");


    /////////////// ------------------ Verify Inventory Purchase Ajax Part Start ---------------- /////////////////////////////
    // Verify Button Functionality
    $(document).off('click', '#verify').on('click', '#verify', function (e) {
        e.preventDefault();
        $('#verifyModal').show();
        let id = $(this).attr('data-id');
        $('#yes').attr('data-id',"");
        $('#yes').attr('data-id',id);
        $('#no').focus();
    });

    // Cancel Button Functionality
    $(document).off('click', '#no').on('click', '#no', function (e) {
        e.preventDefault();
        $('#verifyModal').hide();
    });

    // Confirm Button Functionality
    $(document).off('click', '#yes').on('click', '#yes', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        $.ajax({
            url: `${apiUrl}/inventory/transaction/purchase/verify`,
            method: 'DELETE',
            data: { id },
            success: function (res) {
                if (res.status) {
                    ReloadData('inventory/transaction/purchase', ShowInventoryPurchases);
                    $('#verifyModal').hide();
                    toastr.success('Transaction Main Data Deleted Successfully', 'Deleted!');
                }
            }
        });
    });
    
    /////////////// ------------------ Verify Inventory Purchase Ajax Part End ---------------- /////////////////////////////
















    

















    








    


    /////////////// ------------------ Update Inventory Purchase ajax part start ---------------- /////////////////////////////
    $(document).off('click', '#UpdateMain').on('click', '#UpdateMain', function (e) {
        e.preventDefault();
        let products = localStorage.getItem('transactionData');
        if (!products) {
            $('#update_message_error').html('No product added' || '');
            return;
        }

        products = JSON.parse(products);

        let tranid = $('#updateTranId').val();
        let id = $('#id').val();
        let method = 'Purchase';
        let amountRP = $('#updateAmountRP').val();
        let totalDiscount = $('#updateTotalDiscount').val();
        let netAmount = $('#updateNetAmount').val();
        let advance = $('#updateAdvance').val();
        let balance = $('#updateBalance').val();
        let status = $('#status').val();
        $.ajax({
            url: `${apiUrl}/inventory/transaction/purchase`,
            method: 'PUT',
            data: { products:JSON.stringify(products), status, id, tranid, method, amountRP, totalDiscount, netAmount, advance, balance },
            success: function (res) {
                if (res.status) {
                    ReloadData('inventory/transaction/purchase', ShowInventoryPurchases);
                    $('#editModal').hide();
                    // $('#status').val('1');
                    localStorage.removeItem('transactionData');
                    toastr.success(res.message, 'Updated!');
                }
            }
        });
    });
});