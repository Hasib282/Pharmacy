// function ShowPharmacyStockSummarys(data, startIndex) {
//     let tableRows = '';
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             tableRows += `
//                 <tr>
//                     <td>${startIndex + key + 1}</td>
//                     <td>${item.tran_head_name}</td>
//                     <td>${item.groupe.tran_groupe_name}</td>
//                     <td>${item.category_id == null ? '': item.category.category_name} </td>
//                     <td>${item.manufacturer_id == null ? '': item.manufecturer.manufacturer_name}</td>
//                     <td>${item.form_id == null ? '': item.form.form_name}</td>
//                     <td>${item.quantity}</td>
//                     <td>${item.unit_id == null ? '': item.unit.unit_name}</td>
//                     <td>${item.cp}</td>
//                     <td>${item.mrp}</td>
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

function ShowPharmacyStockSummarys(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_head_name','groupe.tran_groupe_name','category.category_name','manufecturer.manufacturer_name','form.form_name',{key:'quantity',type:'number'},'unit.unit_name',{key:'cp', type: 'number'},{key:'mrp', type: 'number'}],
    });
}

$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Product Name', key: 'tran_head_name' },
        { label: 'Transaction Groupe', key: 'groupe.tran_groupe_name' },
        { label: 'Category Name', key: 'category.category_name' },
        { label: 'Manufacturer', key: 'manufecturer.manufacturer_name' },
        { label: 'Item Form Name', key: 'form.form_name' },
        { label: 'QTY' },
        { label: 'Unit' },
        { label: 'CP' },
        { label: 'MRP' },
    ]);


    // Load Data on Hard Reload
    ReloadData('pharmacy/report/stock/summary', ShowPharmacyStockSummarys);
});