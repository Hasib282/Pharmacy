// function ShowPharmacyPurchaseDetails(data, startIndex) {
//     let tableRows = '';
//     let totalQuantity = 0;
//     let totalCostPrice = 0;
//     let totalDiscount = 0;
//     let totalTotalAmount = 0;
//     let totalPayment = 0;
//     let totalDue = 0;
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             tableRows += `
//                 <tr>
//                     <td>${startIndex + key + 1}</td>
//                     <td>${item.tran_id}</td>
//                     <td>${item.user.user_name}</td>
//                     <td>${item.head.tran_head_name}</td>
//                     <td style="text-align: right">${(item.quantity + item.quantity_issue + item.quantity_return).toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td style="text-align: right">${item.cp.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td style="text-align: right">${((item.quantity + item.quantity_issue + item.quantity_return) * item.cp).toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td style="text-align: right">${item.discount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td style="text-align: right">${(item.tot_amount - item.discount).toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td style="text-align: right">${item.payment.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td style="text-align: right">${item.due.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td>${new Date(item.tran_date).toLocaleDateString('en-CA')}</td>
//                 </tr>
//             `;

//             totalQuantity += (item.quantity + item.quantity_issue + item.quantity_return);
//             totalCostPrice += ((item.quantity + item.quantity_issue + item.quantity_return) * item.cp);
//             totalDiscount += item.discount;
//             totalTotalAmount += item.tot_amount - item.discount;
//             totalPayment += item.payment;
//             totalDue += item.due;
//         });

//         // Inject the generated rows into the table body
//         $('.load-data .show-table tbody').html(tableRows);
//         $('.load-data .show-table tfoot').html(`
//             <tr>
//                 <td colspan="4">Total:</td>
//                 <td style="text-align: right">${totalQuantity.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                 <td style="text-align: right"></td>
//                 <td style="text-align: right">${totalCostPrice.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                 <td style="text-align: right">${totalDiscount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                 <td style="text-align: right">${totalTotalAmount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                 <td style="text-align: right">${totalPayment.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                 <td style="text-align: right">${totalDue.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                 <td></td>
//             </tr>`
//         );
//     }
//     else{
//         $('.load-data .show-table tbody').html('');
//         $('.load-data .show-table tfoot').html('<tr><td colspan="13" style="text-align:center;">No Data Found</td></tr>')
//     }
// }; // End Function

function ShowPharmacyPurchaseDetails(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_id','user.user_name','head.tran_head_name','quantity_actual',{key:'cp', type: 'number'},{key:'totCP', type: 'number'},{key:'discount', type: 'number'},{key:'tot_amount', type: 'number'},{key:'payment', type: 'number'},{key:'due', type: 'number'},{key:'tran_date', type: 'date'}],
    });
}

$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'select', options: [15, 30, 50, 100, 500] },
        { label: 'Id', key: 'tran_id' },
        { label: 'User', key: 'user.user_name' },
        { label: 'Product Name', key: 'head.tran_head_name' },
        { label: 'Quantity', key: 'quantity' },
        { label: 'CP' },
        { label: 'Total CP' },
        { label: 'Discount' },
        { label: 'Total' },
        { label: 'Advance' },
        { label: 'Due' },
        { label: 'Transaction Date', key: 'tran_date' },
    ]);

    
    // Load Data on Hard Reload
    ReloadData('pharmacy/report/purchase/details', ShowPharmacyPurchaseDetails);
    

    // Pagination Ajax
    // PaginationAjax(ShowPharmacyPurchaseDetails);


    // Search Ajax
    // SearchAjax('pharmacy/report/purchase/details', ShowPharmacyPurchaseDetails, { type:'6', method:'Purchase' });


    // Search By Month or Year
    // SearchByDateAjax('pharmacy/report/purchase/details', ShowPharmacyPurchaseDetails, { type:'6', method:'Purchase' })
});