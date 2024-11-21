$(document).ready(function () {
    SearchAjax({ month: $("#month").val(), year: $("#year").val() });

    // Search By Month and Year
    $(document).on('change', '#month, #year', function (e) {
        e.preventDefault();
        let search = $('#search').val();
        let month = $("#month").val();
        let year = $('#year').val();
        LoadData(urls.search, {search, month, year})
    });
});