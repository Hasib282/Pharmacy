//////////////////// -------------------- Update The Search Parameters Value Ajax Part Start -------------------- ////////////////////
function UpdateSearchParameters(data) {
    let updatedData = Object.assign({}, data); 
    $.each(updatedData, function(key, value) {
        if (typeof value === 'object' && value.selector) {
            let selectedValue = value.attribute ? $(value.selector).attr(value.attribute) : $(value.selector).val();
            updatedData[key] = selectedValue === undefined ? '' : selectedValue;
        } else {
            updatedData[key] = value;
        }
    });

    $('#startDate').length ? updatedData.startDate = $('#startDate').val() : '';
    $('#endDate').length ? updatedData.endDate = $('#endDate').val() : '';
    $('#search').length ? updatedData.search = $('#search').val() : '';
    $('#searchOption').length ? updatedData.searchOption = $("#searchOption").val() : '';

    return updatedData;
} // End Method





//////////////////// -------------------- Update The Search Parameters Value Ajax Part Start -------------------- ////////////////////
function LoadSearchData(url, RenderData, data) {
    let updatedData = UpdateSearchParameters(data);
    // let newUrl = `${window.location.origin}/${url}/search?${$.param(updatedData)}`;
    // history.pushState(null, '', newUrl);
    // if($('#print').length){
    //     let parsedUrl = new URL(newUrl);
    //     let pathname = parsedUrl.pathname;
    //     pathname = pathname.replace(/\/search$/, '/print');
    //     newUrl = `${parsedUrl.origin}/api${pathname}${parsedUrl.search}`;
    //     $('#print').attr('href', newUrl)
    // }
    LoadBackendData(`${apiUrl}/${url}/search`, RenderData, updatedData);
} // End Method





//////////////////// -------------------- Search Ajax Part Start -------------------- ////////////////////
function SearchAjax(url, RenderData, data={}){
    $(document).off('keyup', '#search').on('keyup', '#search', function (e) {
        e.preventDefault();
        LoadSearchData(url, RenderData, data);
    });
}; // End Method





//////////////////// -------------------- Search By Date Ajax Part Start -------------------- ////////////////////
function SearchByDateAjax(url, RenderData, data={}){
    $(document).off('change', '#startDate, #endDate').on('change', '#startDate, #endDate', function(e){
        e.preventDefault();
        LoadSearchData(url, RenderData, data);
    });
}; // End Method





//////////////////// -------------------- Search By Select Input Change Ajax Part Start -------------------- ////////////////////
function SearchBySelect(url, RenderData, id, data={}){
    $(document).off('change', id).on('change', id, function(e){
        e.preventDefault();
        LoadSearchData(url, RenderData, data);
    });
}; // End Method





//////////////////// -------------------- Pagination Ajax Part Start -------------------- ////////////////////
function PaginationAjax(RenderData){
    $(document).off('click', 'a.page-link').on('click', 'a.page-link', function(e) {
        e.preventDefault();
        let queryParams = GetQueryParams();
        delete queryParams.page;
        
        var url = $(this).attr('href');
        LoadPagination(url, RenderData, queryParams);
    });
}; // End Method





//////////////////// ------------------ Load Pagintaion Ajax Part Start ---------------- ////////////////////
function LoadPagination(url, RenderData, queryParams) {
    $.ajax({
        url: url,
        type: 'GET',
        data: queryParams,
        success: function(response) {
            delete queryParams.page;
            UpdateUrl(url, queryParams);

            if(response.data.length == 0){
                $('.load-data .show-table tbody').html(`<span class="error">Result not Found </span>`);
                $('#paginate').html("");
            }
            else{
                let startIndex = (response.data.current_page - 1) * response.data.per_page;
                RenderData(response.data.data, startIndex);
                RenderPagination(response.data, response.data.path);
            }
        }
    });
} // End Method





$(document).ready(function () {
    // If option chages search value will be remove
    $(document).on('change', '#searchOption', function (e) {
        $('#search').val('');
    });
});