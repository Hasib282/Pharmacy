function ShowSummaryReports(res) {
    

    UpdateUrl('/api/report/consolidated/summary/print', {type: $("#typeOption").val(),startDate: $('#startDate').val(), endDate: $('#endDate').val() });
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:' },
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
    // GetSelectInputList('admin/mainheads/get', function (res) {
    //     CreateSelectOptions('#typeOption', "Select Tran Type", res.data, 'type_name');
    // })
});