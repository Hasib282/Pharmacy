function ShowPharmacyClientReturnDetails(data, startIndex) {
    let tableRows = '';
    let totalQuantity = 0;
    let totalMrp = 0;
    let totalCostPrice = 0;
    let totalDiscount = 0;
    let totalTotalAmount = 0;
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.tran_id}</td>
                    <td>${item.user.user_name}</td>
                    <td>${item.head.tran_head_name}</td>
                    <td style="text-align: right">${item.quantity.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.mrp.toLocaleString('en-US', { minimumFractionDigits: 0 }) }</td>
                    <td style="text-align: right">${(item.mrp * item.quantity).toLocaleString('en-US', { minimumFractionDigits: 0 }) }</td>
                    <td style="text-align: right">${item.discount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.tot_amount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td>${new Date(item.tran_date).toLocaleDateString('en-CA')}</td>
                </tr>
            `;

            totalQuantity += item.quantity;
            totalMrp += item.mrp;
            totalCostPrice += (item.mrp * item.quantity);
            totalDiscount += item.discount;
            totalTotalAmount += item.tot_amount;
        });

        // Inject the generated rows into the table body
        $('.load-data .show-table tbody').html(tableRows);
        $('.load-data .show-table tfoot').html(`
            <tr>
                <td colspan="4">Total:</td>
                <td style="text-align: right">${totalQuantity.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                <td style="text-align: right">${totalMrp.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                <td style="text-align: right">${totalCostPrice.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                <td style="text-align: right">${totalDiscount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                <td style="text-align: right">${totalTotalAmount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
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
        { label: 'Company Id', key: 'company_id' },
        { label: 'Company Name', key: 'name' },
        { label: 'Permission', key: 'permission' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('pharmacy/report/return/client/details', ShowPharmacyClientReturnDetails);
    

    // Pagination Ajax
    // PaginationAjax(ShowPharmacyClientReturnDetails);


    // Search Ajax
    // SearchAjax('pharmacy/report/return/client/details', ShowPharmacyClientReturnDetails, { type:'6', method:'Client Return' });


    // Search By Month or Year
    // SearchByDateAjax('pharmacy/report/return/client/details', ShowPharmacyClientReturnDetails, { type:'6', method:'Client Return' })
});