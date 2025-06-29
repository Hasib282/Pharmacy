function ShowDetailsReports(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: [
            'tran_id',
            {key:'tran_date', type:'date'},
            'user.user_name',
            'type.type_name',
            'groupe.tran_groupe_name',
            'head.tran_head_name',
            {key:'payment', type: 'number', footerType:'sum'},
        ],
        rowsPerPage: res.data.length,
    });

    UpdateUrl('/api/report/payment/details/print', {type: $("#typeOption").val(),startDate: $('#startDate').val(), endDate: $('#endDate').val() });
}

$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:' },
        { label: 'Tran Id', key: 'tran_id' },
        { label: 'Date', key: 'tran_date', type:"date" },
        { label: 'Client/Supplier', key: 'user.user_name' },
        { label: 'Main Head', key: 'type.type_name' },
        { label: 'Groupe', key: 'groupe.tran_groupe_name' },
        { label: 'Product/Service', key:'head.tran_head_name' },
        { label: 'Payment' },
    ]);


    // Load Data on Hard Reload
    ReloadData('report/payment/details', ShowDetailsReports);


    // Search By Date
    SearchByDateAjax('report/payment/details/search', ShowDetailsReports, {type: $("#typeOption").val()});


    // Search by Type
    SearchBySelect('report/payment/details/search', ShowDetailsReports, "#typeOption", {type: $("#typeOption").val()});


    // Get Trantype
    // GetSelectInputList('admin/mainheads/get', function (res) {
    //     CreateSelectOptions('#typeOption', "Select Tran Type", res.data, 'type_name');
    // })
});