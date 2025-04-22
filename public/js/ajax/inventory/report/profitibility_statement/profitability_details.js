function ShowInventoryProfitabilityDetails(data, startIndex) {
    let tableRows = '';
    let totalQty = 0;
    let totalCp = 0;
    let totalMrp = 0;
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
                    <td style="text-align: right">${item.quantity_actual.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.cp.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.mrp.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${(item.cp * item.quantity_actual).toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${(item.mrp * item.quantity_actual).toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.discount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${((item.mrp * item.quantity_actual)-(item.cp * item.quantity_actual)-item.discount).toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td>${item.batch_id}</td>
                    <td>${new Date(item.tran_date).toLocaleDateString('en-CA')}</td>
                </tr>
            `;

            totalQty += item.quantity_actual;
            totalCp += (item.cp * item.quantity_actual);
            totalMrp += (item.mrp * item.quantity_actual);
            totalDiscount += item.discount;
            totalProfit += (item.mrp * item.quantity_actual)-(item.cp * item.quantity_actual)-item.discount;
        });

        // Inject the generated rows into the table body
        $('.load-data .show-table tbody').html(tableRows);
        $('.load-data .show-table tfoot').html(`
            <tr>
                <td colspan="4">Total:</td>
                <td style="text-align: right">${totalQty.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                <td></td>
                <td></td>
                <td style="text-align: right">${totalCp.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                <td style="text-align: right">${totalMrp.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
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
        { label: ' Id', key: 'tran_id' },
        { label: 'User', key: 'user.user_name' },
        { label: 'Product Name', key: 'head.tran_head_name' },
        { label: 'Quantity	', key: 'quantity_actual' },
        { label: 'CP		', key: 'cp' },
        { label: 'MRP	', key: 'mrp' },
        { label: 'Total CP	', key: 'cp * item.quantity_actual' },
        { label: 'Total MRP	', key: 'mrp * item.quantity_actual' },
        { label: 'Discount', key: 'discount' },
        { label: 'Profit		', key: 'mrp * item.quantity_actual)' },
        { label: 'Batch Id	', key: 'batch_id' },
        { label: 'Date', key: 'tran_date' },
        { label: 'Action', type: 'button' }
    ]);

    
    // Load Data on Hard Reload
    ReloadData('inventory/report/profitability/statement', ShowInventoryProfitabilityDetails);
    

    // Pagination Ajax
    // PaginationAjax(ShowInventoryProfitabilityDetails);


    // Search Ajax
    // SearchAjax('inventory/report/profitability/statement', ShowInventoryProfitabilityDetails, { type:'5', method:'Issue' });


    // Search By Month or Year
    // SearchByDateAjax('inventory/report/profitability/statement', ShowInventoryProfitabilityDetails, { type:'5', method:'Issue' })
});