function ShowSummaryGroupeReports(data, startIndex) {
    let opening = formatNumber(data.opening.total_receive - data.opening.total_payment);
    $('#opening').text(opening)

    let tableRows = '';
    let grandReceive = 0;
    let grandPayment = 0;

    if(!$.isEmptyObject(data)){
        $.each(data, function(title, datas) {
            if(title != "opening" && title != "status"){
                if (Array.isArray(datas) && datas.length > 0) {
                    let totalReceive = 0;
                    let totalPayment = 0;
                    
                    tableRows += `
                    <tr>
                        <td colspan="3">
                            <table class="show-table" style="margin:20px 0;">
                                <thead>
                                    <caption class="sub-caption">${title} Transaction</caption>
                                    <tr>
                                        <th style="width: 5%;">SL:</th>
                                        <th style="text-align: center; width:20%;">Groupe</th>
                                        <th style="text-align: center; width:12%;">Receive</th>
                                        <th style="text-align: center; width:12%;">Payment</th>
                                    </tr>
                                </thead>
                                <tbody>`;

                                    $.each(datas, function(key, item) {
                                        let lastGroupeId = null;
                                        totalReceive += item.total_receive;
                                        totalPayment += item.total_payment;

                                        

                                        tableRows += `
                                        <tr>
                                            <td>${key +1}</td>
                                            ${item.tran_groupe_id != lastGroupeId ? `<td>${item.groupe.tran_groupe_name}</td>` : `<td></td>`}
                                            <td style="text-align: right">${formatNumber(item.total_receive)}</td>
                                            <td style="text-align: right">${formatNumber(item.total_payment)}</td>
                                        </tr>`;

                                        lastGroupeId = item.tran_groupe_id;
                                    });
                                    grandReceive += totalReceive;
                                    grandPayment += totalPayment;


                                tableRows += `
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" style="text-align: right">Sub Total:</td>
                                        <td style="text-align: right;">${formatNumber(totalReceive)}</td>
                                        <td style="text-align: right;">${formatNumber(totalPayment)}</td>
                                    </tr>     
                                </tfoot> 
                            </table>
                        </td>
                    </tr>`;
                }
            }
        });

        $('#grandReceive').text(formatNumber(grandReceive));
        $('#grandPayment').text(formatNumber(grandPayment));
        $('#closing').text(formatNumber(opening - (grandReceive - grandPayment)));

        // Inject the generated rows into the table body
        $('.load-data .show-table tbody').html(tableRows);
        // $('.load-data .show-table tfoot').html('')
    }
    else{
        $('.load-data .show-table tbody').html('');
        // $('.load-data .show-table tfoot').html('<tr><td colspan="5" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    $(document).off(`.${'SearchBySelect'}`);
    
    // Creating Select Options Dynamically
    $.ajax({
        url: `${apiUrl}/report/account/summarygroupe`,
        method: "GET",
        success: function (res) {
            let queryParams = GetQueryParams();
            CreateSelectOptions('#typeOption', 'All', res.type, queryParams['type'], 'type_name')
        },
    });


    // Load Data on Hard Reload
    ReloadData('report/account/summarygroupe', ShowSummaryGroupeReports);


    // Pagination Ajax
    PaginationAjax(ShowSummaryGroupeReports);


    // Search Ajax
    SearchAjax('report/account/summarygroupe', ShowSummaryGroupeReports, {type: { selector: "#typeOption"}});


    // Search By Date
    SearchByDateAjax('report/account/summarygroupe', ShowSummaryGroupeReports, {type: { selector: "#typeOption"}});


    // Search by Type
    SearchBySelect('report/account/summarygroupe', ShowSummaryGroupeReports, "#typeOption", {type: { selector: "#typeOption"}});
});