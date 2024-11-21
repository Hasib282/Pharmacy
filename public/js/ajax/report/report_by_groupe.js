function ShowReportByGroupes(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.tran_id}</td>
                    <td>${item.user ? item.user.user_name : item.bank.name}</td>
                    <td>${item.bill_amount}</td>
                    <td>${item.discount}</td>
                    <td>${item.net_amount}</td>
                    <td>${item.receive}</td>
                    <td>${item.payment}</td>
                    <td>${item.net_amount - item.receive- item.payment}</td>
                    <td>${new Date(item.tran_date).toISOString().split('T')[0]}</td>
                    <td>
                        <button class="open-modal" data-modal-id="printDetails" id="invoice"
                        data-id="${item.tran_id}"><i class="fas fa-print"></i></button>
                    </td>
                </tr>
            `;
        });

        // Inject the generated rows into the table body
        $('.load-data .show-table tbody').html(tableRows);
        $('.load-data .show-table tfoot').html('')
    }
    else{
        $('.load-data .show-table tbody').html('');
        $('.load-data .show-table tfoot').html('<tr><td colspan="11" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Load Data on Hard Reload
    ReloadData('report/groupe', ShowReportByGroupes);


    // Pagination Ajax
    PaginationAjax(ShowReportByGroupes);


    // Search Ajax
    SearchAjax('report/groupe', ShowReportByGroupes, {  });


    // Search By Date
    SearchByDateAjax('report/groupe', ShowReportByGroupes);
});