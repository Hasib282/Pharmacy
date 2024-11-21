// Get Transaction With
function GetTransactionWith(type, method, targetElement, user = null, AdditionalEvent=null) {
    $.ajax({
        url: `${apiUrl}/admin/tranwith/get`,
        method: 'GET',
        data: { type, method, user },
        success: function (res) {
            if (res.status) {
                if(AdditionalEvent == 'Ok'){
                    CreateSelectOptions('#type', 'Select User Type', res.tranwith, null, 'tran_with_name')
                }
                else{
                    $(targetElement).html('');
                    $.each(res.tranwith, function (key, withs) {
                        $(targetElement).append(`<input type="checkbox" id="with[]" class="with-checkbox" name="with" value="${withs.id}" checked>`);
                    });
                }
            }
        }
    });
}





// Get Inserted Transacetion Grid By Transaction Id Function
// function getTransactionGrid(tranId) {
//     let status = $('#status').length ? $('#status').val() : 1;
//     $.ajax({
//         url: `${apiUrl}/transaction/get/transactiongrid`,
//         method: 'GET',
//         data: { tranId, status },
//         success: function (res) {
//             if(res.status){
//                 let transactions = res.transaction;

//                 // Retrieve existing productGrids from local storage
//                 let productGrids = JSON.parse(localStorage.getItem('transactionData')) || [];

//                 transactions.forEach(transaction => {
//                     let productGrid = {
//                         product: transaction.tran_head_id,
//                         name: transaction.head.tran_head_name,
//                         groupe: transaction.tran_groupe_id,
//                         quantity: transaction.quantity_actual,
//                         amount: transaction.amount,
//                         unit: transaction.unit_id,
//                         cp: transaction.cp,
//                         mrp: transaction.mrp,
//                         totAmount: transaction.total_amount,
//                         expiry: transaction.expiry_date
//                     };
                    
//                     // Add the new productGrids to the list
//                     productGrids.push(productGrid);
//                 });
//                 // Save updated productGrids back to local storage
//                 localStorage.setItem('transactionData', JSON.stringify(productGrids));

//                 DisplayEditTransactionGrid();
//             }
//         }
//     });
// };






// Get Due Payment list by User Id
function getDueListByUserId(id, grid) {
    let tableRows = '';
    $.ajax({
        url: `${apiUrl}/transaction/party/get/due`,
        method: 'GET',
        data: { id:id },
        success: function (res) {
            if(res.status){
                $.each(res.data, function(key, item) {
                    tableRows += `
                    <tr>
                        <td>${key + 1}</td>
                        <td>${item.tran_id}</td>
                        <td style="text-align: right">${item.bill_amount.toLocaleString('en-US', { minimumFractionDigits: 0 })} Tk.</td>
                        <td style="text-align: right">${item.due.toLocaleString('en-US', { minimumFractionDigits: 0 })} Tk.</td>
                    </tr>`
                });

                $(grid).html(tableRows);



                let transactions = res.data ?? [];

                // Calculate total amount or show a message if no transactions
                let totalAmount = transactions.length > 0 ? transactions.reduce((sum, transaction) => sum + transaction.due, 0) : null;

                $('.due-grid tfoot').html(`
                    <tr>
                        <td colspan="4" style="text-align:${totalAmount !== null ? 'right' : 'center'};">
                            ${totalAmount !== null ? `Total Due: ${totalAmount.toLocaleString('en-US', { minimumFractionDigits: 0 })} Tk.` : 'No transactions due'}
                        </td>
                    </tr>`
                );
            }
        }
    });
}