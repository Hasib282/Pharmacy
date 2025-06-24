function ShowSalarySummary(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_user','user.user_name',{key:'bill_amount',type:'number',footerType:'sum'},{key:'tran_date',type:'date'}],
        actions: undefined,
    });

    UpdateUrl('/api/hr/report/salary/summary/print', {startDate: $('#startDate').val(), endDate: $('#endDate').val() });
}


$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Id', key: 'tran_user' },
        { label: 'Employee Name', key: 'user.user_name' },
        { label: 'Salary Amount' },
        { label: 'Process Date' }
    ]);
    
    // Load Data on Hard Reload
    ReloadData('hr/report/salary/summary', ShowSalarySummary);


    // Search By Date
    SearchByDateAjax('hr/report/salary/summary/search', ShowSalarySummary);
});