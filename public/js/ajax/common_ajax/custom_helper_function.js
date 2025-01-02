//////////////////// -------------------- Format Numbers Into comma-separated value -------------------- ////////////////////
function formatNumber(value, locale = 'en-US', minimumFractionDigits = 0, maximumFractionDigits = 0) {
    const formatter = new Intl.NumberFormat(locale, {
        minimumFractionDigits: minimumFractionDigits,
        maximumFractionDigits: maximumFractionDigits,
    });
    return formatter.format(value);
}


//////////////////// -------------------- Get the Query Parameters From the Current URL -------------------- ////////////////////
function GetQueryParams() {
    let urlParams = new URLSearchParams(window.location.search);
    let queryParams = Object.fromEntries(urlParams.entries());
    return queryParams;
}; // End Function





//////////////////// -------------------- Get the Page Number From the Current URL -------------------- ////////////////////
function GetCurrentPageFromURL() {
    const params = new URLSearchParams(window.location.search);
    return params.get('page') ? parseInt(params.get('page')) : 1;
}; // End Function





//////////////////// -------------------- Check If The Current Page is The Last Page -------------------- ////////////////////
function CheckIfLastPage(callback) {
    let baseURL =  location.href.replace(/^(http[s]?:\/\/[^/]+)/, apiUrl);
    $.ajax({
        url: baseURL,
        method: 'GET',
        success: function (response) {
            if(response.data && response.data.current_page && response.data.last_page){
                callback(response.data.current_page > response.data.last_page);
            }
            else {
                callback(false);
            }
        },
        error: function () {
            callback(false);
        }
    });
}; // End Function





//////////////////// -------------------- Update URL With Query Parameters -------------------- ////////////////////
function UpdateUrl(url, queryParams) {
    let baseURL = url.replace(/^(http[s]?:\/\/[^/]+)(\/api)/, window.location.origin);
    let separator = baseURL.includes('?') ? '&' : '?';
    let newUrl = (!$.isEmptyObject(queryParams) && queryParams != undefined ) ? `${baseURL}${separator}${$.param(queryParams)}` : baseURL;
    history.pushState(null, '', newUrl);
}; // End Function





//////////////////// -------------------- Create Select Options Dynamically -------------------- ////////////////////
// For Creating Select Options Dynamically
function CreateSelectOptions(id, defaultText, data, selectedValue = null, fieldName) {
    let selectElement = $(id);
    selectElement.empty();
    selectElement.append(`<option value="">${defaultText}</option>`);
    data.forEach(function(item) {
        selectElement.append(`<option value="${item.id}" ${ selectedValue == item.id ? 'selected' : '' } >${item[fieldName]}</option>`);
    });
}; // End Method



