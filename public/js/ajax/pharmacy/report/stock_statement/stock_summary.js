function ShowPharmacyStockSummarys(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.tran_head_name}</td>
                    <td>${item.groupe.tran_groupe_name}</td>
                    <td>${item.category_id == null ? '': item.category.category_name} </td>
                    <td>${item.manufacturer_id == null ? '': item.manufecturer.manufacturer_name}</td>
                    <td>${item.form_id == null ? '': item.form.form_name}</td>
                    <td>${item.quantity}</td>
                    <td>${item.unit_id == null ? '': item.unit.unit_name}</td>
                    <td>${item.cp}</td>
                    <td>${item.mrp}</td>
                </tr>
            `;
        });

        // Inject the generated rows into the table body
        $('.load-data .show-table tbody').html(tableRows);
        $('.load-data .show-table tfoot').html(``);
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
    ReloadData('pharmacy/report/stock/summary', ShowPharmacyStockSummarys);
    

    // Pagination Ajax
    // PaginationAjax(ShowPharmacyStockSummarys);


    // Search Ajax
    // SearchAjax('pharmacy/report/stock/summary', ShowPharmacyStockSummarys);


    // Search By Month or Year
    // SearchByDateAjax('pharmacy/report/stock/summary', ShowPharmacyStockSummarys)
});