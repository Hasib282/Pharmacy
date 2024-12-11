function ShowInventoryExpiryDetails(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.head.tran_head_name}</td>
                    <td>${new Date(item.expiry_date).toLocaleDateString('en-CA')}</td>
                    <td>${item.tran_id}</td>
                </tr>
            `;
        });

        // Inject the generated rows into the table body
        $('.load-data .show-table tbody').html(tableRows);
        $('.load-data .show-table tfoot').html(``);
    }
    else{
        $('.load-data .show-table tbody').html('');
        $('.load-data .show-table tfoot').html('<tr><td colspan="6" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Load Data on Hard Reload
    ReloadData('inventory/report/expiry/statement', ShowInventoryExpiryDetails);
    

    // Pagination Ajax
    PaginationAjax(ShowInventoryExpiryDetails);


    // Search Ajax
    SearchAjax('inventory/report/expiry/statement', ShowInventoryExpiryDetails);


    // Search By Month or Year
    SearchByDateAjax('inventory/report/expiry/statement', ShowInventoryExpiryDetails)
});