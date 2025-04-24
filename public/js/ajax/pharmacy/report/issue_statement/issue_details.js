// function ShowPharmacyIssueDetails(data, startIndex) {
//     let tableRows = '';
//     let totalQuantity = 0;
//     let totalCP = 0;
//     let totalMrp = 0;
//     let totalCostPrice = 0;
//     let totalMaximumRetailPrice = 0;
//     let totalDiscount = 0;
//     let totalProfit = 0;
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             tableRows += `
//                 <tr>
//                     <td>${startIndex + key + 1}</td>
//                     <td>${item.tran_id}</td>
//                     <td>${item.user.user_name}</td>
//                     <td>${item.head.tran_head_name}</td>
//                     <td style="text-align: right">${(item.quantity + item.quantity_return).toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td style="text-align: right">${item.cp.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td style="text-align: right">${item.mrp.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td style="text-align: right">${((item.quantity + item.quantity_return) * item.cp).toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td style="text-align: right">${((item.quantity + item.quantity_return) * item.mrp).toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td style="text-align: right">${item.discount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td style="text-align: right">${(((item.quantity + item.quantity_return) * item.mrp) - ((item.quantity + item.quantity_return) * item.cp) - item.discount).toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td>${item.batch_id}</td>
//                     <td>${new Date(item.tran_date).toLocaleDateString('en-CA')}<</td>
//                 </tr>
//             `;

//             totalQuantity += (item.quantity + item.quantity_return);
//             totalCP += item.cp;
//             totalMrp += item.mrp;
//             totalCostPrice += ((item.quantity + item.quantity_return) * item.cp);
//             totalMaximumRetailPrice += ((item.quantity + item.quantity_return) * item.mrp);
//             totalDiscount += item.discount;
//             totalProfit += (((item.quantity + item.quantity_return) * item.mrp) - ((item.quantity + item.quantity_return) * item.cp) - item.discount);
//         });

//         // Inject the generated rows into the table body
//         $('.load-data .show-table tbody').html(tableRows);
//         $('.load-data .show-table tfoot').html(`
//             <tr>
//                 <td colspan="4">Total:</td>
//                 <td style="text-align: right">${totalQuantity.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                 <td style="text-align: right">${totalCP.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                 <td style="text-align: right">${totalMrp.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                 <td style="text-align: right">${totalCostPrice.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                 <td style="text-align: right">${totalMaximumRetailPrice.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                 <td style="text-align: right">${totalDiscount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                 <td style="text-align: right">${totalProfit.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                 <td></td>
//                 <td></td>
//             </tr>`
//         );
//     }
//     else{
//         $('.load-data .show-table tbody').html('');
//         $('.load-data .show-table tfoot').html('<tr><td colspan="13" style="text-align:center;">No Data Found</td></tr>')
//     }
// }; // End Function

function ShowPharmacyIssueDetails(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_id','user.user_name','head.tran_head_name','quantity',{key:'cp', type: 'number'},{key:'mrp', type: 'number'},{key:'totCP', type: 'number'},{key:'totalMRP', type: 'number'},{key:'discount', type: 'number'},{key:'rofit', type: 'number'},'batch_id',{key:'tran_date', type: 'date'}],
    });
}


$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Tran Id', key: 'tran_id' },
        { label: 'User	', key: 'user.user_name' },
        { label: 'Product Name	', key: 'head.tran_head_name' },
        { label: 'Quantity', key: 'quantity' },
        { label: 'CP' },
        { label: 'MRP' },
        { label: 'Total CP' },
        { label: 'Total MRP' },
        { label: 'Discount' },
        { label: 'Profit' },
        { label: 'Batch Id', key: 'batch_id' },
        { label: 'Tran Date	', key: 'tran_date', type:'date' }
    ]);


    // Load Data on Hard Reload
    ReloadData('pharmacy/report/issue/details', ShowPharmacyIssueDetails);
    

    // Pagination Ajax
    // PaginationAjax(ShowPharmacyIssueDetails);


    // Search Ajax
    // SearchAjax('pharmacy/report/issue/details', ShowPharmacyIssueDetails, { type:'6', method:'Issue' });


    // Search By Month or Year
    // SearchByDateAjax('pharmacy/report/issue/details', ShowPharmacyIssueDetails, { type:'6', method:'Issue' })
});