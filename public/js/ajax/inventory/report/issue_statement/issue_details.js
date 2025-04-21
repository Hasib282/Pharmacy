function ShowInventoryIssueDetails(data, startIndex) {
    let tableRows = '';
    let totalQuantity = 0;
    let totalCP = 0;
    let totalMrp = 0;
    let totalCostPrice = 0;
    let totalMaximumRetailPrice = 0;
    let totalDiscount = 0;
    let totalProfit = 0;
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.tran_id}</td>
                    <td>${item.user.user_name}</td>
                    <td>${item.head.tran_head_name}</td>
                    <td style="text-align: right">${(item.quantity + item.quantity_return).toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.cp.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.mrp.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${((item.quantity + item.quantity_return) * item.cp).toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${((item.quantity + item.quantity_return) * item.mrp).toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.discount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${(((item.quantity + item.quantity_return) * item.mrp) - ((item.quantity + item.quantity_return) * item.cp) - item.discount).toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td>${item.batch_id}</td>
                    <td>${new Date(item.tran_date).toLocaleDateString('en-CA')}</td>
                </tr>
            `;

            totalQuantity += (item.quantity + item.quantity_return);
            totalCP += item.cp;
            totalMrp += item.mrp;
            totalCostPrice += ((item.quantity + item.quantity_return) * item.cp);
            totalMaximumRetailPrice += ((item.quantity + item.quantity_return) * item.mrp);
            totalDiscount += item.discount;
            totalProfit += (((item.quantity + item.quantity_return) * item.mrp) - ((item.quantity + item.quantity_return) * item.cp) - item.discount);
        });

        // Inject the generated rows into the table body
        $('.load-data .show-table tbody').html(tableRows);
        $('.load-data .show-table tfoot').html(`
            <tr>
                <td colspan="4">Total:</td>
                <td style="text-align: right">${totalQuantity.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                <td style="text-align: right">${totalCP.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                <td style="text-align: right">${totalMrp.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                <td style="text-align: right">${totalCostPrice.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                <td style="text-align: right">${totalMaximumRetailPrice.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                <td style="text-align: right">${totalDiscount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                <td style="text-align: right">${totalProfit.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                <td></td>
                <td></td>
            </tr>`
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
        { label: ' User	', key: 'tran_id' },
        { label: ' Product Name	', key: 'head.tran_head_name' },
        { label: 'Quantity	', key: 'quantity' },
        { label: 'Cost Price', key: 'cp' },
        { label: ' MRP', key: 'mrp' },
        { label: 'Quantity	', key: 'quantity' },
        { label: 'Total Cost Price', key: 'quantity' },
        { label: ' Total MRP	', key: 'company_id' },
        { label: 'Discount		', key: 'name' },
        { label: 'Profit	', key: 'permission' },
        { label: ' Batch Id	', key: 'company_id' },
        { label: 'Transaction Date	', key: 'name' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('inventory/report/issue/details', ShowInventoryIssueDetails);
    

    // Pagination Ajax
    // PaginationAjax(ShowInventoryIssueDetails);


    // Search Ajax
    // SearchAjax('inventory/report/issue/details', ShowInventoryIssueDetails, { type:'5', method:'Issue' });


    // Search By Month or Year
    // SearchByDateAjax('inventory/report/issue/details', ShowInventoryIssueDetails, { type:'5', method:'Issue' })
});