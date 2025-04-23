// function ShowPharmacyExpiryDetails(data, startIndex) {
//     let tableRows = '';
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             tableRows += `
//                 <tr>
//                     <td>${startIndex + key + 1}</td>
//                     <td>${item.head.tran_head_name}</td>
//                     <td>${new Date(item.expiry_date).toLocaleDateString('en-CA')}</td>
//                     <td>${item.tran_id}</td>
//                 </tr>
//             `;
//         });

//         // Inject the generated rows into the table body
//         $('.load-data .show-table tbody').html(tableRows);
//         $('.load-data .show-table tfoot').html(``);
//     }
//     else{
//         $('.load-data .show-table tbody').html('');
//         $('.load-data .show-table tfoot').html('<tr><td colspan="6" style="text-align:center;">No Data Found</td></tr>')
//     }
// }; // End Function

function ShowInventoryExpiryDetails(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['head.tran_head_name',{key:'expiry_date', type: 'date'},'tran_id'],
    });
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'select', options: [15, 30, 50, 100, 500] },
        { label: 'Product Name', key: 'head.tran_head_name' },
        { label: 'Expiry Date', key: 'expiry_date', type:'date' },
        { label: 'Batch Id', key: 'tran_id' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('pharmacy/report/expiry/statement', ShowPharmacyExpiryDetails);
    

    // Pagination Ajax
    // PaginationAjax(ShowPharmacyExpiryDetails);


    // Search Ajax
    // SearchAjax('pharmacy/report/expiry/statement', ShowPharmacyExpiryDetails);


    // Search By Month or Year
    // SearchByDateAjax('pharmacy/report/expiry/statement', ShowPharmacyExpiryDetails)
});