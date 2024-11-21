$(document).ready(function () {
    /////////////// ------------------ Search Ajax Part Start ---------------- /////////////////////////////
   // Search by Date Range
   $(document).on('change', '#startDate, #endDate, #typeOption', function(e){
       e.preventDefault();
       let startDate = $('#startDate').val();
       let endDate = $('#endDate').val();
       let search = $('#search').val();
       let searchOption = $("#searchOption").val();
       let typeOption = $("#typeOption").val();
       LoadData(`/report/account/search/summary`, {search, startDate, endDate, searchOption, typeOption});
   });


   // Search By User Input
   $(document).on('keyup', '#search', function (e) {
       e.preventDefault();
       let startDate = $('#startDate').val();
       let endDate = $('#endDate').val();
       let search = $(this).val();
       let searchOption = $("#searchOption").val();
       let typeOption = $("#typeOption").val();
       LoadData(`/report/account/search/summary`, {search, startDate, endDate, searchOption, typeOption});
   });
});




function ShowSummaryReports(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${key + 1}</td>
                    <td>${item.groupe.tran_groupe_name}</td>
                    <td>${item.head.tran_head_name}</td>
                    <td>${item.total_quantity}</td>
                    <td>${item.total_tot_amount}</td>
                </tr>
            `;
        });

        // Inject the generated rows into the table body
        $('.load-data .show-table tbody').html(tableRows);
        $('.load-data .show-table tfoot').html('')
    }
    else{
        $('.load-data .show-table tbody').html('');
        $('.load-data .show-table tfoot').html('<tr><td colspan="5" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Load Data on Hard Reload
    ReloadData('report/summary', ShowSummaryReports);


    // Pagination Ajax
    PaginationAjax(ShowSummaryReports);


    // Search Ajax
    SearchAjax('report/summary', ShowSummaryReports, {  });


    // Search By Date
    SearchByDateAjax('report/summary', ShowSummaryReports);
});