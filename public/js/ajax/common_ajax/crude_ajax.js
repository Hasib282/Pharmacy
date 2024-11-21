//////////////////// -------------------- Show Data on Hard Reload -------------------- ////////////////////
//////////////////// -------------------- Reload Content in Current Pagination Page After Successful Add/Update/Delete -------------------- ////////////////////
function ReloadData(link, RenderData){
    const queryParams = GetQueryParams();
    CheckIfLastPage(function(isLastPage) {
        if(isLastPage){
            queryParams['page'] = GetCurrentPageFromURL() - 1;
        }
        if (window.location.href.includes('/search')) {
            LoadBackendData(`${apiUrl}/${link}/search`, RenderData, queryParams);
        }
        else{
            LoadBackendData(`${apiUrl}/${link}`, RenderData, queryParams); 
        }
    });
}; // End Method





//////////////////// -------------------- Show Data Ajax Part Start -------------------- ////////////////////
function LoadBackendData(url, RenderData, queryParams) {
    $.ajax({
        url: url,
        type: 'GET',
        data: queryParams,
        success: function(response) {
            UpdateUrl(url, queryParams);

            if (response.redirect) {
                window.location.href = response.redirect;
                return;
            }
            
            let startIndex = (response.data.current_page - 1) * response.data.per_page;
            RenderData(response.data.data ? response.data.data : response.data, startIndex, response);
            response.data.path ? RenderPagination(response.data, response.data.path) : null;
        }
    });
}; // End Method





// Add Button Click Functionality
function AddModalFunctionality(focusVariable, AdditionalEvent){
    $(document).off('click', '.add').on('click', '.add', function (e) {
        e.preventDefault();
        $(focusVariable).focus();

        if(typeof AdditionalEvent === 'function'){
            AdditionalEvent();
        }
    });
}





/////////////// ------------------ Insert Ajax Part Start ---------------- /////////////////////////////
function InsertAjax(link, RenderData, AditionalData = {}, AdditionalEvent) {
    $(document).off('submit', '#AddForm').on('submit', '#AddForm', function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.each(AditionalData, function(key, value) {
            if (typeof value === 'object' && value.selector) {
                let selectedValue = value.attribute ? $(value.selector).attr(value.attribute) : $(value.selector).val();
                formData.append(key, selectedValue === undefined ? '' : selectedValue);
            } else {
                formData.append(key, value === undefined ? '' : value);
            }
        });

        requestMethod = 'POST';

        $.ajax({
            url: `${apiUrl}/${link}`,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            success: function (res) {
                if (res.status) {
                    $('#AddForm')[0].reset();
                    
                    if(typeof AdditionalEvent === 'function'){
                        AdditionalEvent();
                    }

                    ReloadData(link, RenderData);
                    toastr.success(res.message, 'Added!');
                }
            }
        });
    });
}; // End Method





///////////// ------------------ Edit Location Ajax Part Start ---------------- /////////////////////////////
function EditAjax(link, AdditionalEvent, AdditionalEvent2=undefined) {
    $(document).off('click', '#edit').on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        let status = $('#status').val();
        
        if(typeof AdditionalEvent2 === 'function'){
            AdditionalEvent2();
        }
        
        $.ajax({
            url: `${apiUrl}/${link}/edit`,
            method: 'GET',
            data: { id, status },
            success: function (res) {
                if(typeof AdditionalEvent === 'function'){
                    AdditionalEvent(res);
                }
                
                var modal = document.getElementById(modalId);
                modal.style.display = 'block';
            }
        });
    });
}





/////////////// ------------------ Update Ajax Part Start ---------------- /////////////////////////////
function UpdateAjax(link, RenderData, AditionalData = {}, AdditionalEvent) {
    $(document).off('submit', '#EditForm').on('submit', '#EditForm', function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.each(AditionalData, function(key, value) {
            if (typeof value === 'object' && value.selector) {
                let selectedValue = value.attribute ? $(value.selector).attr(value.attribute) : $(value.selector).val();
                formData.append(key, selectedValue === undefined ? '' : selectedValue);
            } else {
                formData.append(key, value === undefined ? '' : value);
            }
        });

        requestMethod = 'PUT';

        $.ajax({
            url: `${apiUrl}/${link}`,
            method: "POST",
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            success: function (res) {
                if (res.status) {
                    $('#editModal').hide();
                    $('#EditForm')[0].reset();

                    if(typeof AdditionalEvent === 'function'){
                        AdditionalEvent();
                    }
                    
                    ReloadData(link, RenderData);
                    toastr.success(res.message, 'Updated!');
                }
            }
        });
    });
}; // End Method





//////////////////// -------------------- Delete Ajax Part Start -------------------- ////////////////////
function DeleteAjax(link, RenderData) {
    $(document).off('click', '#confirm').on('click', '#confirm', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        let status = $('#status').val();
        $.ajax({
            url: `${apiUrl}/${link}`,
            method: 'DELETE',
            data:{ id, status },
            success: function (res) {
                if (res.status) {
                    ReloadData(link, RenderData);
                    $('#deleteModal').hide();
                    toastr.success(res.message, 'Deleted!');
                }
            }
        });
    });
}; // End Method





//////////////////// -------------------- Details Ajax Part Start -------------------- ////////////////////
function DetailsAjax(link) {
    $(document).off('click', '#details').on('click', '#details', function (e) {
        let id = $(this).attr('data-id');
        $.ajax({
            url: `${apiUrl}/${link}/details`,
            method: 'GET',
            data: { id },
            success: function (res) {
                if(res.status){
                    $("#detailsModal").show();
                    $('.details').html(res.data)
                }
            }
        });
    });
}; // End Method











$(document).ready(function () {
    //////////////////// -------------------- Delete Ajax Part Start -------------------- ////////////////////
    // Delete Button Functionality
    $(document).on('click', '#delete', function (e) {
        e.preventDefault();
        $('#deleteModal').show();
        let id = $(this).data('id');
        $('#confirm').attr('data-id',id);
        $('#cancel').focus();
    });  // End Delete Button Event



    // Cancel Button Functionality
    $(document).on('click', '#cancel', function (e) {
        e.preventDefault();
        $('#deleteModal').hide();
    }); // End Cancle Button Event
    //////////////////// -------------------- Delete Ajax Part End -------------------- ////////////////////





    
});