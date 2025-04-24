// function ShowPharmacyStockDetails(data, startIndex) {
//     let tableRows = '';
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             tableRows += `
//                 <tr>
//                     <td>${startIndex + key + 1}</td>
//                     <td>${item.tran_id}</td>
//                     <td>${item.head.tran_head_name}</td>
//                     <td>${item.head.category_id ? item.head.category.category_name : ''} </td>
//                     <td>${item.head.manufecturer_id ?item.head.manufecturer.manufacturer_name : ''}</td>
//                     <td>${item.head.form_id ? item.head.form.form_name : ''}</td>
//                     <td>${item.quantity}</td>
//                     <td>${item.unit_id == null ? '': item.unit.unit_name}</td>
//                     <td>${item.cp}</td>
//                     <td>${item.mrp}</td>
//                     <td>${new Date(item.expiry_date).toLocaleDateString('en-CA')}</td>
//                 </tr>
//             `;
//         });

//         // Inject the generated rows into the table body
//         $('.load-data .show-table tbody').html(tableRows);
//         $('.load-data .show-table tfoot').html(``);
//     }
//     else{
//         $('.load-data .show-table tbody').html('');
//         $('.load-data .show-table tfoot').html('<tr><td colspan="13" style="text-align:center;">No Data Found</td></tr>')
//     }
// }; // End Function

function ShowPharmacyStockDetails(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_id','user.user_name','head.tran_head_name','head.category.category_name','head.manufecturer.manufacturer_name','head.form.form_name','quantity','head.unit.unit_name',{key:'cp', type: 'number'},{key:'mrp', type: 'number'},{key:'expiry_date', type: 'date'}],
    });
}

$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Batch Id', key: 'tran_id' },
        { label: 'Product Name', key: 'head.tran_head_name' },
        { label: 'Category Name', key: 'head.categoy.category_id' },
        { label: 'Manufacturer', key: 'head.manufecturer.manufacturer_name' },
        { label: 'Item Form', key: 'head.form.form_name' },
        { label: 'QTY' },
        { label: 'Unit', key: 'head.unit.unit_name' },
        { label: 'CP' },
        { label: 'MRP' },
        { label: 'Expiry', key: 'expiry_date', type:'date' }
    ]);


    // Load Data on Hard Reload
    ReloadData('pharmacy/report/stock/details', ShowPharmacyStockDetails);
    

    // Pagination Ajax
    // PaginationAjax(ShowPharmacyStockDetails);


    // Search Ajax
    // SearchAjax('pharmacy/report/stock/details', ShowPharmacyStockDetails);


    // Search By Month or Year
    // SearchByDateAjax('pharmacy/report/stock/details', ShowPharmacyStockDetails);


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