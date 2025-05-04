function ShowPharmacyProfitabilityDetails(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_id','user.user_name','head.tran_head_name',{key:'cp', type: 'number'},{key:'mrp', type: 'number'},'quantity_actual',{key:'totCP',expration:'quantity_actual*cp', type: 'calculate',footerType:'sum'},{key:'totalMRP',expration:'quantity_actual*mrp', type: 'calculate',footerType:'sum'},{key:'discount', type: 'number',footerType:'sum'},{key:'profit',expration:'(quantity_actual*mrp) - (quantity_actual*cp) - discount', type: 'calculate',footerType:'sum'},'batch_id',{key:'tran_date', type: 'date'}],
    });
}

$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Tran Id', key: 'tran_id' },
        { label: 'User	', key: 'user.user_name' },
        { label: 'Product Name	', key: 'head.tran_head_name' },
        { label: 'CP' },
        { label: 'MRP' },
        { label: 'Quantity'},
        { label: 'Total CP' },
        { label: 'Total MRP' },
        { label: 'Discount' },
        { label: 'Profit' },
        { label: 'Batch Id', key: 'batch_id' },
        { label: 'Tran Date	', key: 'tran_date', type:'date' }
    ]);


    // Load Data on Hard Reload
    ReloadData('pharmacy/report/profitability/statement', ShowPharmacyProfitabilityDetails);


    // Search By Month or Year
    SearchByDateAjax('pharmacy/report/profitability/statement/search', ShowPharmacyProfitabilityDetails, { method:'Issue' })
});