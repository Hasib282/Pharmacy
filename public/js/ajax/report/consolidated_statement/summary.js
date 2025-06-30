function ShowSummaryReports(res) {
    if ($('#data-table thead #opening-row').length === 0) {
        $('#data-table thead').append(`<tr id="opening-row">
                                        <th colspan="2">Opening Balance</th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align: right; width:10%;" id="opening">${formatNumber(res.opening)}</th>
                                    </tr>`);
    }
    else{
        $('#opening').html(formatNumber(res.opening))
    }
    
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: [
            'user.user_name',
            {key:'total_receive', type: 'number', footerType:'sum'},
            {key:'total_payment', type: 'number', footerType:'sum'},
            {key:'balance',expration:'total_receive - total_payment', type: 'calculate', footerType:'sum'},
        ],
        balance: res.opening,
        rowsPerPage: res.data.length,
    });

    UpdateUrl('/api/report/consolidated/summary/print', {type: $("#typeOption").val(),startDate: $('#startDate').val(), endDate: $('#endDate').val() });
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Client/Supplier', key: 'user.user_name' },
        { label: 'Receive' },
        { label: 'Payment' },
        { label: 'Balance' },
    ]);


    // Load Data on Hard Reload
    ReloadData('report/consolidated/summary', ShowSummaryReports);


    // Search By Date
    SearchByDateAjax('report/consolidated/summary/search', ShowSummaryReports, {type: $("#typeOption").val()});


    // Search by Type
    SearchBySelect('report/consolidated/summary/search', ShowSummaryReports, "#typeOption", {type: $("#typeOption").val()});


    // Get Trantype
    GetSelectInputList('admin/mainheads/get', function (res) {
        CreateSelectOptions('#typeOption', "Select Tran Type", res.data, 'type_name');
    })
});