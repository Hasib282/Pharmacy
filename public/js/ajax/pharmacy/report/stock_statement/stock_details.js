function ShowPharmacyStockDetails(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_id','head.tran_head_name','head.category.category_name','head.manufecturer.manufacturer_name','head.form.form_name',{key:'quantity',type:'number'},'head.unit.unit_name',{key:'cp', type: 'number'},{key:'mrp', type: 'number'},{key:'expiry_date', type: 'date'}],
    });
}

$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Batch Id', key: 'tran_id' },
        { label: 'Product Name', key: 'head.tran_head_name' },
        { label: 'Category Name', key: 'head.category.category_name' },
        { label: 'Manufacturer', key: 'head.manufecturer.manufacturer_name' },
        { label: 'Item Form', key: 'head.form.form_name' },
        { label: 'QTY' },
        { label: 'Unit' },
        { label: 'CP' },
        { label: 'MRP' },
        { label: 'Expiry', key: 'expiry_date', type:'date' }
    ]);


    // Load Data on Hard Reload
    ReloadData('pharmacy/report/stock/details', ShowPharmacyStockDetails);
});