function ShowInventoryPurchaseDetails(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_id','user.user_name','head.tran_head_name',{key:'cp', type: 'number'},{key:'quantity_actual',type:'number'},{key:'totCP', type: 'calculate',expration:'quantity_actual*cp',footerType:'sum'},{key:'discount', type: 'number',footerType:'sum'},{key:'tot_amount', type: 'number',footerType:'sum'},{key:'payment', type: 'number',footerType:'sum'},{key:'due_col', type: 'number',footerType:'sum'},{key:'due_disc', type: 'number',footerType:'sum'},{key:'due', type: 'number',footerType:'sum'},{key:'tran_date', type: 'date'}],
    });
}




$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Id', key: 'tran_id' },
        { label: 'User', key: 'user.user_name' },
        { label: 'Product Name', key: 'head.tran_head_name' },
        { label: 'CP' },
        { label: 'Quantity' },
        { label: 'Total CP' },
        { label: 'Discount' },
        { label: 'Total' },
        { label: 'Advance' },
        { label: 'Due Col' },
        { label: 'Due Discount' },
        { label: 'Due' },
        { label: 'Transaction Date', key: 'tran_date', type:'date' },
    ]);

    
    // Load Data on Hard Reload
    ReloadData('inventory/report/purchase/details', ShowInventoryPurchaseDetails);


    // Search By Month or Year
    SearchByDateAjax('inventory/report/purchase/details/search', ShowInventoryPurchaseDetails, { method:'Purchase' })
});