
function ShowSummaryReports(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: [
            'user.user_name',
            {key:'total_receive', type: 'number', footerType:'sum'},
        ],
    });

    UpdateUrl('/api/report/collection/summary/print', {method: $("#methodOption").val(),startDate: $('#startDate').val(), endDate: $('#endDate').val() });
}

$(document).ready(function () {
    // Render The Table Heads
        renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Client/Supplier', key: 'user.user_name' },
        { label: 'Receive' },
      
    ]);

    // Load Data on Hard Reload
    ReloadData('report/collection/summary', ShowSummaryReports);


    // Search By Date
    SearchByDateAjax('report/collection/summary/search', ShowSummaryReports, {type: $("#typeOption").val()});


    // Search by Type
    SearchBySelect('report/collection/summary/search', ShowSummaryReports, "#typeOption", {type: $("#typeOption").val()});


    // Get Trantype
    // GetSelectInputList('admin/mainheads/get', function (res) {
    //     CreateSelectOptions('#typeOption', "Select Tran Type", res.data, 'type_name');
    // })
});