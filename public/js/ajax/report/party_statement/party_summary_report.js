function ShowPartySummaryReports(data, startIndex) {
    let tableRows = '';
    let totalBillAmount = 0;
    let totalDiscount = 0;
    let totalNetAmount = 0;
    let totalReceive = 0;
    let totalPayment = 0;
    let totalDueCol = 0;
    let totalDueDiscount = 0;
    let totalDue = 0;
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.tran_type == 4 ? "" : item.withs.tran_with_name}</td>
                    <td>${item.tran_type == 4 ? item.bank.name : item.user.user_name}</td>
                    <td style="text-align: right;">${item.total_bill_amount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right;">${item.total_discount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right;">${item.total_net_amount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right;">${item.total_receive ? item.total_receive.toLocaleString('en-US', { minimumFractionDigits: 0 }) : 0}</td>
                    <td style="text-align: right;">${item.total_payment ? item.total_payment.toLocaleString('en-US', { minimumFractionDigits: 0 }) : 0}</td>
                    <td style="text-align: right;">${item.total_due_col.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right;">${item.total_due_disc.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right;">${item.total_due.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                </tr>
            `;


            totalBillAmount += item.total_bill_amount;
            totalDiscount += item.total_discount;
            totalNetAmount += item.total_net_amount;
            totalReceive += item.total_receive;
            totalPayment += item.total_payment;
            totalDueCol += item.total_due_col;
            totalDueDiscount += item.total_due_disc;
            totalDue += item.total_due;
        });

        // Inject the generated rows into the table body
        $('.load-data .show-table tbody').html(tableRows);

        
        $('.load-data .show-table tfoot').html(`
            <tr>
                <td colspan="3">Total:</td>
                <td style="text-align: right;">${totalBillAmount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                <td style="text-align: right;">${totalDiscount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                <td style="text-align: right;">${totalNetAmount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                <td style="text-align: right;">${totalReceive.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                <td style="text-align: right;">${totalPayment.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                <td style="text-align: right;">${totalDueCol.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                <td style="text-align: right;">${totalDueDiscount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                <td style="text-align: right;">${totalDue.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
            </tr>
        `);
    }
    else{
        $('.load-data .show-table tbody').html('');
        $('.load-data .show-table tfoot').html('<tr><td colspan="11" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    CleanupEvents('SearchBySelect');
    
    // Load Data on Hard Reload
    ReloadData('report/party/summary', ShowPartySummaryReports);


    // Pagination Ajax
    PaginationAjax(ShowPartySummaryReports);


    // Search Ajax
    SearchAjax('report/party/summary', ShowPartySummaryReports, {method: { selector: "#methodOption"}} );


    // Search By Date
    SearchByDateAjax('report/party/summary', ShowPartySummaryReports, {method: { selector: "#methodOption"}} );


    // Search By Methods, Roles, Types
    SearchBySelect('report/party/summary', ShowPartySummaryReports, '#methodOption', {method: { selector: "#methodOption"}} );
});