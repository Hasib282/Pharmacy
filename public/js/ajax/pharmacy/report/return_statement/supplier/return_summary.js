function ShowPharmacySupplierReturnSummarys(data, startIndex) {
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
                    <td style="text-align: right">${item.bill_amount ? item.bill_amount.toLocaleString('en-US', { minimumFractionDigits: 0 }) : 0 }</td>
                    <td style="text-align: right">${item.discount ? item.discount.toLocaleString('en-US', { minimumFractionDigits: 0 }) : 0 }</td>
                    <td style="text-align: right">${item.net_amount ? item.net_amount.toLocaleString('en-US', { minimumFractionDigits: 0 }) : 0 }</td>
                    <td style="text-align: right">${item.receive ? item.receive.toLocaleString('en-US', { minimumFractionDigits: 0 }) : 0 }</td>
                    <td style="text-align: right">${item.due_col ? item.due_col.toLocaleString('en-US', { minimumFractionDigits: 0 }) : 0 }</td>
                    <td style="text-align: right">${item.due_disc ? item.due_disc.toLocaleString('en-US', { minimumFractionDigits: 0 }) : 0 }</td>
                    <td style="text-align: right">${item.due ? item.due.toLocaleString('en-US', { minimumFractionDigits: 0 }) : 0 }</td>
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
            <tr>
                <td colspan="3">Total:</td>
                <td style="text-align: right">${totalBillAmount ? totalBillAmount.toLocaleString('en-US', { minimumFractionDigits: 0 }) : 0}</td>
                <td style="text-align: right">${totalDiscount ? totalDiscount.toLocaleString('en-US', { minimumFractionDigits: 0 }) : 0}</td>
                <td style="text-align: right">${totalNetAmount ? totalNetAmount.toLocaleString('en-US', { minimumFractionDigits: 0 }) : 0}</td>
                <td style="text-align: right">${totalAdvance ? totalAdvance.toLocaleString('en-US', { minimumFractionDigits: 0 }) : 0}</td>
                <td style="text-align: right">${totalDueCol ? totalDueCol.toLocaleString('en-US', { minimumFractionDigits: 0 }) : 0}</td>
                <td style="text-align: right">${totalDueDiscount ? totalDueDiscount.toLocaleString('en-US', { minimumFractionDigits: 0 }) : 0}</td>
                <td style="text-align: right">${totalDue ? totalDue.toLocaleString('en-US', { minimumFractionDigits: 0 }) : 0}</td>
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
    ReloadData('pharmacy/report/return/supplier/summary', ShowPharmacySupplierReturnSummarys);
    

    // Pagination Ajax
    // PaginationAjax(ShowPharmacySupplierReturnSummarys);


    // Search Ajax
    // SearchAjax('pharmacy/report/return/supplier/summary', ShowPharmacySupplierReturnSummarys, { type:'6', method:'Supplier Return' });


    // Search By Month or Year
    // SearchByDateAjax('pharmacy/report/return/supplier/summary', ShowPharmacySupplierReturnSummarys, { type:'6', method:'Supplier Return' })
});