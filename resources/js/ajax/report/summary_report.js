$(document).ready(function () {
    // Search by Date Range
    $(document).on('change', '#startDate, #endDate', function(e){
        e.preventDefault();
        let startDate = $('#startDate').val();
        let endDate = $('#endDate').val();
        LoadData(`/summary/report/search`, { startDate, endDate })
    });
    
    
    // // Search by Date Range
    // $(document).on('change', '#typeOption', function(e){
    //     e.preventDefault();
    //     let startDate = $('#startDate').val();
    //     let endDate = $('#endDate').val();
    //     LoadData(`/summary/report/search`, {startDate:startDate, endDate:endDate})
    // });


    


    // /////////////// ------------------ Pagination ajax part start ---------------- /////////////////////////////
    // $(document).on('click', '.paginate a', function (e) {
    //     e.preventDefault();
    //     let startDate = $('#startDate').val();
    //     let endDate = $('#endDate').val();
    //     let type = $('#typeOption').val();
    //     let page = $(this).attr('href').split('page=')[1];
    //     LoadData(`/party/summary/report/pagination?page=${page}`, { startDate: startDate, endDate: endDate, type: type });
    // });


    // /////////////// ------------------ Search ajax part start ---------------- /////////////////////////////
    // $(document).on('keyup', '#search', function (e) {
    //     e.preventDefault();
    //     let startDate = $('#startDate').val();
    //     let endDate = $('#endDate').val();
    //     let type = $('#typeOption').val();
    //     let searchOption = $("#searchOption").val();
    //     let search = $(this).val();
    //     LoadData(`/party/summary/report/search`, {startDate:startDate, endDate:endDate, type:type, searchOption:searchOption, search:search})
    // });


    // /////////////// ------------------ Search Pagination ajax part start ---------------- /////////////////////////////
    // $(document).on('click', '.search-paginate a', function (e) {
    //     e.preventDefault();
    //     $('.paginate').addClass('hidden');
    //     let startDate = $('#startDate').val();
    //     let endDate = $('#endDate').val();
    //     let type = $('#typeOption').val();
    //     let searchOption = $("#searchOption").val();
    //     let search = $(this).val();
    //     let page = $(this).attr('href').split('page=')[1];
    //     LoadData(`/party/summary/report/search/pagination?page=${page}`, {startDate:startDate, endDate:endDate, type:type, searchOption:searchOption, search:search})
    // });

});