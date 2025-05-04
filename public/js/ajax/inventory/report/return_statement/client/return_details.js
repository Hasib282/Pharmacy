function ShowInventoryClientReturnDetails(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_id','user.user_name','head.tran_head_name',{key:'mrp', type: 'number'},{key:'quantity_actual',type:'number'},{key:'mrp',expration:'mrp * quantity_actual', type: 'calculate',footerType:'sum'},{key:'discount', type: 'number',footerType:'sum'},{key:'tot_amount', type: 'number',footerType:'sum'},{key:'receive', type: 'number',footerType:'sum'},{key:'due', type: 'number',footerType:'sum'},{key:'tran_date', type: 'date'}],
    });
}

$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Id', key: 'tran_id' },
        { label: 'User', key: 'user.user_name' },
        { label: 'Product Name', key: 'head.tran_head_name' },
        { label: 'Mrp' },
        { label: 'Qty'},
        { label: 'Total Mrp' },
        { label: 'Discount' },
        { label: 'Total' },
        { label: 'Advance' },
        { label: 'Due' },
        { label: 'Transaction Date', key: 'tran_date', type:'date'},
    ]);


    // Load Data on Hard Reload
    ReloadData('inventory/report/return/client/details', ShowInventoryClientReturnDetails);
    

    // Search By Month or Year
    SearchByDateAjax('inventory/report/return/client/details/search', ShowInventoryClientReturnDetails, { method:'Client Return' })
});