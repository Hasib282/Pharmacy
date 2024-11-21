$(document).ready(function () {
    // Search by Date Range
    $(document).on('change', '#startDate, #endDate', function(e){
        e.preventDefault();
        let startDate = $('#startDate').val();
        let endDate = $('#endDate').val();
        let type = $('#typeOption').val();
        LoadData(`/report/party/search/details`, {startDate:startDate, endDate:endDate,type:type})
    });
    
    
    // Search by Date Range
    $(document).on('change', '#typeOption', function(e){
        e.preventDefault();
        let startDate = $('#startDate').val();
        let endDate = $('#endDate').val();
        let type = $('#typeOption').val();
        LoadData(`/report/party/search/details`, {startDate:startDate, endDate:endDate,type:type})
    });


    /////////////// ------------------ Pagination ajax part start ---------------- /////////////////////////////
    $(document).on('click', '.paginate a', function (e) {
        e.preventDefault();
        let startDate = $('#startDate').val();
        let endDate = $('#endDate').val();
        let type = $('#typeOption').val();
        let page = $(this).attr('href').split('page=')[1];
        LoadData(`/report/party/pagination/details?page=${page}`, { startDate: startDate, endDate: endDate, type: type });
    });


    /////////////// ------------------ Search ajax part start ---------------- /////////////////////////////
    $(document).on('keyup', '#search', function (e) {
        e.preventDefault();
        let startDate = $('#startDate').val();
        let endDate = $('#endDate').val();
        let type = $('#typeOption').val();
        let search = $(this).val();
        LoadData(`/report/party/search/details`, {startDate:startDate, endDate:endDate, type:type, search:search})
    });



    /////////////// ------------------ Search Pagination ajax part start ---------------- /////////////////////////////
    $(document).on('click', '.search-paginate a', function (e) {
        e.preventDefault();
        $('.paginate').addClass('hidden');
        let startDate = $('#startDate').val();
        let endDate = $('#endDate').val();
        let type = $('#typeOption').val();
        let search = $(this).val();
        let page = $(this).attr('href').split('page=')[1];
        LoadData(`/report/party/search/details?page=${page}`, {startDate:startDate, endDate:endDate, type:type, search:search})
    });
});