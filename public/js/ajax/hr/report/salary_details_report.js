// function ShowSalaryDetails(data, startIndex) {
//     let tableRows = '';
//     let lastUserId = null;
//     let totalAmount = 0;
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             tableRows += `
//                 <tr>
//                     <td>${startIndex + key + 1}</td>
//                     ${(item.tran_user !== lastUserId) ? 
//                         `<td>${item.tran_user}</td>
//                         <td>${item.user.user_name}</td>` 
//                         : 
//                         `<td colspan="2"></td>`
//                     }
        
//                     <td>${item.head.tran_head_name}</td>
//                     <td style="text-align:right;">${item.amount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td>${new Date(item.tran_date).toISOString().split('T')[0]}</td>
//                 </tr>
//             `;

            
//             lastUserId = item.tran_user;
//             totalAmount += item.amount;
//         });

//         // Inject the generated rows into the table body
//         $('.load-data .show-table tbody').html(tableRows);



    
//         $('.load-data .show-table tfoot').html(`
//                 <tr>
//                     <td colspan="4">Total:</td>
//                     <td style="text-align: right">${totalAmount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td></td>
//                 </tr>
//         `);
//     }
//     else{
//         $('.load-data .show-table tbody').html('');
//         $('.load-data .show-table tfoot').html('<tr><td colspan="6" style="text-align:center;">No Transaction Found</td></tr>')
//     }
// }; // End Function

function ShowSalaryDetails(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_user','user.user_name','head.tran_head_name','amount','tran_date'],
    });
}

$(document).ready(function () {
    $(document).off(`.${'SearchBySelect'}`);


    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: ' Id', key: 'tran_user' },
        { label: ' Employee Name', key: 'user.user_name' },
        { label: ' Payroll Category', key: 'head.tran_head_name' },
        { label: ' Amount' },
        { label: ' Date' }
    ]);

    
    // Load Data on Hard Reload
    ReloadData('hr/report/salary/details', ShowSalaryDetails);
    

    // Pagination Ajax
    // PaginationAjax(ShowSalaryDetails, { month: { selector: '#month'}, year: { selector: '#year'}});


    // Search Ajax
    // SearchAjax('hr/report/salary/details', ShowSalaryDetails, { month: { selector: '#month'}, year: { selector: '#year'}});


    // Search By Month or Year
    // SearchBySelect('hr/report/salary/details', ShowSalaryDetails, '#month, #year', { month: { selector: '#month'}, year: { selector: '#year'}})
});