// function ShowPharmacyPurchases(data, startIndex) {
//     let tableRows = '';
//     let totalBillAmount = 0;
//     let totalDiscount = 0;
//     let totalNetAmount = 0;
//     let totalAdvance = 0;
//     let totalDueCol = 0;
//     let totalDueDiscount = 0;
//     let totalDue = 0;
//     let params = GetQueryParams();
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             tableRows += `
//                 <tr>
//                     <td>${startIndex + key + 1}</td>
//                     <td>${item.tran_id}</td>
//                     <td>${item.user.user_name}</td>
//                     <td style="text-align: right">${item.bill_amount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td style="text-align: right">${item.discount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td style="text-align: right">${item.net_amount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td style="text-align: right">${item.payment.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td style="text-align: right">${item.due_col.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td style="text-align: right">${item.due_disc.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td style="text-align: right">${item.due.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td>
//                         <div style="display: flex;gap:5px;">
//                             ${params['status'] == 2 ? 
//                                 `<button class="open-modal" data-modal-id="verifyModal" id="verify"
//                                         data-id="${item.tran_id}"><i class="fa-solid fa-check"></i> Verify</button>`
//                                 :
//                                 ""
//                             }

//                             <a class="print-receipt" href="/api/get/invoice?id=${item.tran_id}&status=${params['status'] ? params['status'] : 1}"> <i class="fa-solid fa-receipt"></i></a>


                            
//                             <button class="open-modal" data-modal-id="editModal" id="edit"
//                                     data-id="${item.tran_id}"><i class="fas fa-edit"></i></button>
                            
//                             <button data-id="${item.tran_id}" id="delete"><i class="fas fa-trash"></i></button>
                            
//                         </div>
//                     </td>
//                 </tr>
//             `;

//             totalBillAmount += item.bill_amount;
//             totalDiscount += item.discount;
//             totalNetAmount += item.net_amount;
//             totalAdvance += item.payment;
//             totalDueCol += item.due_col;
//             totalDueDiscount += item.due_disc;
//             totalDue += item.due;
//         });

//         // Inject the generated rows into the table body
//         $('.load-data .show-table tbody').html(tableRows);
//         $('.load-data .show-table tfoot').html(`
//             <tr>
//                 <td colspan="3">Total:</td>
//                 <td style="text-align: right">${totalBillAmount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                 <td style="text-align: right">${totalDiscount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                 <td style="text-align: right">${totalNetAmount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                 <td style="text-align: right">${totalAdvance.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                 <td style="text-align: right">${totalDueCol.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                 <td style="text-align: right">${totalDueDiscount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                 <td style="text-align: right">${totalDue.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                 <td></td>
//             </tr>
//         `)
//     }
//     else{
//         $('.load-data .show-table tbody').html('');
//         $('.load-data .show-table tfoot').html('<tr><td colspan="11" style="text-align:center;">No Data Found</td></tr>')
//     }
// }; // End Function

function ShowPharmacyPurchases(res) {
    new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_id','user.user_name',{key:'bill_amount', type: 'number'},{key:'discount', type: 'number'},{key:'net_amount', type: 'number'},{key:'payment', type: 'number'},{key:'due_col', type: 'number'},{key:'due_discount', type: 'number'},{key:'due', type: 'number'}],
        actions: (row) => `
                <a class="print-receipt" href="/api/get/invoice?id=${row.tran_id}&status=1"> <i class="fa-solid fa-receipt"></i></a>

                <button data-modal-id="editModal" id="edit" data-id="${row.tran_id}"><i class="fas fa-edit"></i></button>
                        
                <button data-id="${row.tran_id}" id="delete"><i class="fas fa-trash"></i></button>
                `,
    });
}


$(document).ready(function () {
    $(document).off(`.${'SearchBySelect'}`);


    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'select', options: [15, 30, 50, 100, 500] },
        { label: 'Id', key: 'tran_id' },
        { label: 'User', key: 'user.user_name' },
        { label: 'Total	', key: 'bill_amount' },
        { label: '	Discount', key: 'discount' },
        { label: 'Net Total', key: 'net_amount' },
        { label: 'Advance', key: 'payment' },
        { label: 'Due Col', key: 'due_col' },
        { label: 'Due Discount', key: 'due_disc' },
        { label: 'Due', key: 'due' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Transaction Groupe
    GetTransactionGroupe(6, "Payment");
    

    // Load Data on Hard Reload
    ReloadData('pharmacy/transaction/purchase', ShowPharmacyPurchases);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#product", function(){
        GetTransactionWith(6, 'Payment', '#within');
        localStorage.removeItem('transactionData');
        $('.transaction_grid tbody').html('');
    });


    // Insert Ajax
    // InsertAjax('pharmacy/transaction/purchase', ShowPharmacyPurchases, {}, function() {
    //     $('#division').focus();
    // });


    //Edit Ajax
    EditAjax('pharmacy/transaction/purchase', EditFormInputValue, EditModalOn);


    // Update Ajax
    // UpdateAjax('pharmacy/transaction/purchase', ShowPharmacyPurchases);
    

    // Delete Ajax
    DeleteAjax('pharmacy/transaction/purchase', ShowPharmacyPurchases);


    // Pagination Ajax
    // PaginationAjax(ShowPharmacyPurchases);


    // Search Ajax
    // SearchAjax('pharmacy/transaction/purchase', ShowPharmacyPurchases, { type: 6, method: 'Purchase', status: { selector: "#status"} });


    // Search By Date
    // SearchByDateAjax('pharmacy/transaction/purchase', ShowPharmacyPurchases, { type: 6, method: 'Purchase', status: { selector: "#status"} });


    // Search By Methods, Roles, Types
    // SearchBySelect('pharmacy/transaction/purchase', ShowPharmacyPurchases, '#status', { type: 6, method: 'Purchase', status: { selector: "#status"} } );


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
        GetTransactionWith(6, 'Payment', '#updatewithin');
        localStorage.removeItem('transactionData');
        $('.transaction_grid tbody').html('');
    }


    // Insert Into Local Storage
    InsertLocalStorage();


    // Insert Pharmacy Purchase ajax
    InsertTransaction('pharmacy/transaction/purchase', ShowPharmacyPurchases, 'Purchase', '6', function() {
        $('#location').removeAttr('data-id');
        $('#user').removeAttr('data-id');
        $('#user').removeAttr('data-with');
        $('#store').removeAttr('data-id');
        $('#status').val('1');
        $('.transaction_grid tbody').html('');
        localStorage.removeItem('transactionData');
    });


    // Update Pharmacy Issue ajax
    UpdateTransaction('pharmacy/transaction/purchase', ShowPharmacyPurchases, 'Purchase', "6");


    /////////////// ------------------ Verify Pharmacy Purchase Ajax Part Start ---------------- /////////////////////////////
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
            url: `${apiUrl}/pharmacy/transaction/purchase/verify`,
            method: 'DELETE',
            data: { id },
            success: function (res) {
                if (res.status) {
                    ReloadData('pharmacy/transaction/purchase', ShowPharmacyPurchases);
                    $('#verifyModal').hide();
                    toastr.success('Transaction Main Data Deleted Successfully', 'Deleted!');
                }
            }
        });
    });
    
    /////////////// ------------------ Verify Pharmacy Purchase Ajax Part End ---------------- /////////////////////////////
});