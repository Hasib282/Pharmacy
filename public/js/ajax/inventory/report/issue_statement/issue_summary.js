function ShowInventoryIssueSummarys(data, startIndex) {
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
                    <td style="text-align: right">${(item.receive ?? 0).toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.due_col.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.due_disc.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.due.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td>${new Date(item.tran_date).toLocaleDateString('en-CA')}</td>
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
            <td colspan="3">Total:</td>
            <td style="text-align: right">${totalBillAmount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
            <td style="text-align: right">${totalDiscount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
            <td style="text-align: right">${totalNetAmount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
            <td style="text-align: right">${totalAdvance.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
            <td style="text-align: right">${totalDueCol.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
            <td style="text-align: right">${totalDueDiscount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
            <td style="text-align: right">${totalDue.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
            <td></td>`
        );
    }
    else{
        $('.load-data .show-table tbody').html('');
        $('.load-data .show-table tfoot').html('<tr><td colspan="13" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Render The Table Heads
   renderTableHead([
    { label: 'SL:', type: 'select', options: [15, 30, 50, 100, 500] },
    { label: 'Id	', key: 'tran_id' },
    { label: 'User	', key: 'user.user_name' },
    { label: 'Total ', key: 'bill_amount' },
    { label: 'Discount ', key: 'discount' },
    { label: 'Net Total', key: 'net_amount' },
    { label: 'Advance Payment', key: 'receive' },
    { label: 'Due Col', key: 'due_col' },
    { label: 'Discount Col', key: 'due_disc' },
    { label: 'Due', key: 'due' },
    { label: 'Date', key: 'tran_date' },
    { label: 'Action', type: 'button' }
]);


    // Load Data on Hard Reload
    ReloadData('inventory/report/issue/summary', ShowInventoryIssueSummarys);
    

    // Pagination Ajax
    // PaginationAjax(ShowInventoryIssueSummarys);


    // Search Ajax
    // SearchAjax('inventory/report/issue/summary', ShowInventoryIssueSummarys, { type:'5', method:'Issue' });


    // Search By Month or Year
    // SearchByDateAjax('inventory/report/issue/summary', ShowInventoryIssueSummarys, { type:'5', method:'Issue' })
});