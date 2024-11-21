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
       LoadData(`/report/account/search/summarygroupe`, {search, startDate, endDate, searchOption, typeOption});
   });


   // Search By User Input
   $(document).on('keyup', '#search', function (e) {
       e.preventDefault();
       let startDate = $('#startDate').val();
       let endDate = $('#endDate').val();
       let search = $(this).val();
       let searchOption = $("#searchOption").val();
       let typeOption = $("#typeOption").val();
       LoadData(`/report/account/search/summarygroupe`, {search, startDate, endDate, searchOption, typeOption});
   });

});