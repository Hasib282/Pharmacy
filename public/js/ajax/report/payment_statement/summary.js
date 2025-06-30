function ShowSummaryReports(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: [
            'user.user_name',
            {key:'total_payment', type: 'number', footerType:'sum'},
        ],
        rowsPerPage: res.data.length,
    });

    UpdateUrl('/api/report/payment/summary/print', {type: $("#typeOption").val(),startDate: $('#startDate').val(), endDate: $('#endDate').val() });
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Client/Supplier', key: 'user.user_name' },
        { label: 'Payment' },
    ]);


    // Load Data on Hard Reload
    ReloadData('report/payment/summary', ShowSummaryReports);


    // Search By Date
    SearchByDateAjax('report/payment/summary/search', ShowSummaryReports, {type: $("#typeOption").val()});


    // Search by Type
    SearchBySelect('report/payment/summary/search', ShowSummaryReports, "#typeOption", {type: $("#typeOption").val()});


    // Get Trantype
    GetSelectInputList('admin/mainheads/get', function (res) {
        CreateSelectOptions('#typeOption', "Select Tran Type", res.data, 'type_name');
    })
});