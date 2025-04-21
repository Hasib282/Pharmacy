function ShowInventoryStockDetails(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.tran_id}</td>
                    <td>${item.head.tran_head_name}</td>
                    <td>${item.head.category_id ? item.head.category.category_name : ''} </td>
                    <td>${item.head.manufecturer_id ?item.head.manufecturer.manufacturer_name : ''}</td>
                    <td>${item.head.form_id ? item.head.form.form_name : ''}</td>
                    <td>${item.quantity}</td>
                    <td>${item.unit_id == null ? '': item.unit.unit_name}</td>
                    <td>${item.cp}</td>
                    <td>${item.mrp}</td>
                    <td>${new Date(item.expiry_date).toLocaleDateString('en-CA')}</td>
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
    ReloadData('inventory/report/stock/details', ShowInventoryStockDetails);
    

    // Pagination Ajax
    // PaginationAjax(ShowInventoryStockDetails);


    // Search Ajax
    // SearchAjax('inventory/report/stock/details', ShowInventoryStockDetails);


    // Search By Month or Year
    // SearchByDateAjax('inventory/report/stock/details', ShowInventoryStockDetails);


    // on select option search value will be remove
    $(document).on('change', '#searchOption', function (e) {
        $('#search').val('');
        let searchOption = $('#searchOption').val();
        if(searchOption == 5){
            $('#search').attr('type', "date")
            let currentDate = new Date().toISOString().split('T')[0];
            $('#search').val(currentDate);
        }
        else{
            $('#search').attr('type', "text")
        }
    });
});