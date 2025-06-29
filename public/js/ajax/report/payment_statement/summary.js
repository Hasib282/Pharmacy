function ShowSummaryReports(res) {
    

    UpdateUrl('/api/report/payment/summary/print', {type: $("#typeOption").val(),startDate: $('#startDate').val(), endDate: $('#endDate').val() });
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:' },
        { label: 'Company Id', key: 'company_id' },
        { label: 'Company Name', key: 'name' },
        { label: 'Permission', key: 'permission' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('report/payment/summary', ShowSummaryReports);


    // Search By Date
    SearchByDateAjax('report/payment/summary/search', ShowSummaryReports, {type: $("#typeOption").val()});


    // Search by Type
    SearchBySelect('report/payment/summary/search', ShowSummaryReports, "#typeOption", {type: $("#typeOption").val()});


    // Get Trantype
    // GetSelectInputList('admin/mainheads/get', function (res) {
    //     CreateSelectOptions('#typeOption', "Select Tran Type", res.data, 'type_name');
    // })
});