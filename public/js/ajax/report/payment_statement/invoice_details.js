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
            {key:'tot_amount', type: 'number', footerType:'sum'},
            {key:'discount', type: 'number', footerType:'sum'},
            {key:'payment', type: 'calculate', expration:'tot_amount - discount', footerType:'sum'},
            {key:'payment', type: 'number', footerType:'sum'},
            {key:'due_col', type: 'number', footerType:'sum'},
            {key:'due_disc', type: 'number', footerType:'sum'},
            {key:'due', type: 'number', footerType:'sum'},
        ],
        rowsPerPage: res.data.length,
    });

    UpdateUrl('/api/report/payment/invoice_details/print', {type: $("#typeOption").val(),startDate: $('#startDate').val(), endDate: $('#endDate').val() });
}

$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:' },
        { label: 'Tran Id', key: 'tran_id' },
        { label: 'Date', key: 'tran_date', type:"date" },
        { label: 'Client/Supplier', key: 'user.user_name' },
        { label: 'Main Head', type:"select", key: 'tran_type', method:"fetch", link:'admin/mainheads/get', name:'type_name' },
        { label: 'Groupe', key: 'groupe.tran_groupe_name' },
        { label: 'Product/Service', key:'head.tran_head_name' },
        { label: 'Bill Amount' },
        { label: 'Discount' },
        { label: 'Net Amount' },
        { label: 'Advance Payment' },
        { label: 'Due Payment' },
        { label: 'Due Discount' },
        { label: 'Balance/Due' },
    ]);


    // Load Data on Hard Reload
    ReloadData('report/payment/invoice_details', ShowDetailsReports);


    // Search By Date
    SearchByDateAjax('report/payment/invoice_details/search', ShowDetailsReports, {type: $("#typeOption").val()});


    // Search by Type
    SearchBySelect('report/payment/invoice_details/search', ShowDetailsReports, "#typeOption", {type: $("#typeOption").val()});


    // Get Trantype
    GetSelectInputList('admin/mainheads/get', function (res) {
        CreateSelectOptions('#typeOption', "Select Tran Type", res.data, 'type_name');
    })
});