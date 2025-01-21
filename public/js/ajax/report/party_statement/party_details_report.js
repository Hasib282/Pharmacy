function ShowPartyDetailsReports(data, startIndex) {
    let groupedTransactions = {};
    $.each(data, function(key, item) {
        let tranId = item['tran_id'];
        let tranMethod = item['tran_method'];
        if (!groupedTransactions[tranId]) {
            groupedTransactions[tranId] = [];
        }
        groupedTransactions[tranId].push(item);
    });
    

    let tableRows = '';
    
    if(data.length > 0){
        $('.load-data .show-table tbody').html('');
        $.each(groupedTransactions, function(key, transaction) {
            let rows = `
                <tr>
                    <td>
                        <table style="margin-top:30px;">
                            <caption class="sub-caption" style="text-align:center;"> ${key} </caption>
                            <thead>
                                <tr>
                                    <th>Transaction Id</th>
                                    <th>Tran User</th>
                                    <th>Bill Amount</th>
                                    <th>Discount</th>
                                    <th>Net Amount</th>
                                    <th>Advance</th>
                                    <th>Party Discount</th>
                                    <th>Party Payment</th>
                                    <th>Net Col</th>
                                    <th>Balance / Due</th>
                                    <th>Batch ID</th>
                                    <th>Transaction Date</th>
                                </tr>
                            </thead>
                            <tbody>`;

                                $.each(transaction, function(keys, item) {
                                    rows += `<tr>
                                                <td>${item.tran_id}</td>
                                                <td>${item.tran_type === 4 ? item.bank.name : item.user.user_name}</td>
                                                <td>${item.bill_amount ? item.bill_amount : 0}</td>
                                                <td>${item.main_discount ? item.main_discount : 0}</td>
                                                <td>${item.net_amount ? item.net_amount : 0}</td>
                                                <td>${item.tran_method === "Receive" ? (item.main_receive ? item.main_receive : 0) : (item.main_payment ? item.main_payment : 0)}</td>
                                                <td>${item.due_discount ? item.due_discount : 0}</td>
                                                <td>${item.tran_method === "Receive" ? (item.due_receive ? item.due_receive : 0) : (item.due_payment ? item.due_payment : 0)}</td>
                                                <td>${item.due_receive + item.due_payment + item.due_discount}</td>
                                                <td>${item.bill_amount - item.main_discount - item.main_receive - item.main_payment - item.due_discount - item.due_receive - item.due_payment}</td>
                                                <td>${item.batch_id ? item.batch_id : item.tran_id}</td>
                                                <td>${new Date(item.tran_date + 'Z').toISOString().split('T')[0]}</td>
                                            </tr>`;
                                });

                rows +=    `</tbody>
                            </table>
                        </td>
                    </tr>`;

            tableRows += rows
        });

        $('.load-data .show-table tbody').append(tableRows);
        $('.load-data .show-table tfoot').html(``);
    }
    else{
        $('.load-data .show-table tbody').html('');
        $('.load-data .show-table tfoot').html('<tr><td colspan="11" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    CleanupEvents('SearchBySelect');
    
    // Load Data on Hard Reload
    ReloadData('report/party/details', ShowPartyDetailsReports);


    // Pagination Ajax
    PaginationAjax(ShowPartyDetailsReports);


    // Search Ajax
    SearchAjax('report/party/details', ShowPartyDetailsReports, {method: { selector: "#methodOption"}} );


    // Search By Date
    SearchByDateAjax('report/party/details', ShowPartyDetailsReports, {method: { selector: "#methodOption"}} );


    // Search By Methods, Roles, Types
    SearchBySelect('report/party/details', ShowPartyDetailsReports, '#methodOption', {method: { selector: "#methodOption"}} );
});