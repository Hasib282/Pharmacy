/////////////// ------------------ Delete Ajax Function Part Start ---------------- /////////////////////////////
function DeleteAjax(message, title) {
    $(document).on('click', '#confirm', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        $.ajax({
            url: urls.delete,
            method: 'DELETE',
            data:{ id },
            success: function (res) {
                if (res.status == "success") {
                    $('#search').val('');
                    $('#deleteModal').hide();

                    checkIfLastPage(function(isLastPage) {
                        console.log(isLastPage);
                        
                        reloadContent(message, title, isLastPage);
                    });
                }
            },
            statusCode: {
                403: function() {
                    toastr.error('You are not allowed to access this.', "Permission denied");
                },
            }, 
            error: function(response, textStatus, errorThrown) {
                toastr.error('An unexpected error occurred.', errorThrown);
            },
        });
    });
};


/////////////// ------------------ Pagination ajax part start ---------------- /////////////////////////////
function PaginationAjax(data){
    $(document).on('click', '.paginate a', function (e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        // let baseURL = $(this).attr('href').split('?')[0];
        currentPage = page;
        LoadData(`${urls.paginate}?page=${page}`, data);
    });
};


/////////////// ------------------ Search ajax part start ---------------- /////////////////////////////
// Search Input Ajax Function
function SearchAjax(data){
    $(document).on('keyup', '#search', function (e) {
        e.preventDefault();
        data.startDate = $('#startDate').val();
        data.endDate = $('#endDate').val();
        data.search = $(this).val();
        data.searchOption = $("#searchOption").val();
        LoadData(urls.search, data);
    });
};


/////////////// ------------------ Search By Date ajax part start ---------------- /////////////////////////////
function SearchByDateAjax(data){
    $(document).on('change', '#startDate, #endDate', function(e){
        e.preventDefault();
        data.startDate = $('#startDate').val();
        data.endDate = $('#endDate').val();
        data.search = $('#search').val();
        data.searchOption = $("#searchOption").val();
        LoadData(urls.search, data);
    });
};


/////////////// ------------------ Search Pagination ajax part start ---------------- /////////////////////////////
function SearchPaginationAjax(data){
    $(document).on('click', '.search-paginate a', function (e) {
        e.preventDefault();
        $('.paginate').addClass('hidden');
        data.startDate = $('#startDate').val();
        data.endDate = $('#endDate').val();
        data.search = $('#search').val();
        data.searchOption = $("#searchOption").val();
        let page = $(this).attr('href').split('page=')[1];
        currentPage = page;
        // let baseURL = $(this).attr('href').split('?')[0];
        LoadData(`${urls.search}?page=${page}`, data);
    });
};



/////////////// ------------------ Reload Content in Current Pagination Page After Successful Add/Update/Delete Ajax Part Start ---------------- /////////////////////////////

// Function to get the current page number from the URL
function getCurrentPageFromURL() {
    const params = new URLSearchParams(window.location.search);
    return params.get('page') ? parseInt(params.get('page')) : 1;
};


// Initialize current page from the URL
var currentPage = getCurrentPageFromURL();

// Function to reload the content while maintaining the current page
function reloadContent(message, title, resetToFirstPage = false) {
    if (resetToFirstPage) {
        currentPage -= 1;
    }

    let url = `${location.pathname}?page=${currentPage}`;
    $('.load-data').load(url + ' .load-data', function(res) {
        console.log(res);
        
        toastr.success(`${message} Successfully.`, title);
    });

    // let url;

    // // Check if the element with class 'search-paginate' exists
    // if ($('.search-paginate').length > 0) {
    //     // If '.search-paginate' exists, load the search query
    //     let startDate = $('#startDate').val();
    //     let endDate = $('#endDate').val();
    //     let search = $('#search').val();
    //     let searchOption = $("#searchOption").val();
        
    //     url = `${location.pathname}/search?page=${currentPage}&search=${search}&searchOption=${searchOption}&startDate=${startDate}&endDate=${endDate}`;
    // } else {
    //     // If '.search-paginate' does not exist, load the pagination query
    //     url = `${location.pathname}?page=${currentPage}`;
    // }

    // $.get(url, function(response) {
    //     if (response.status === 'success') {
    //         // Replace the content in '.load-data' with the rendered HTML from the server
    //         $('.load-data').html(response.data);

    //         // Show success message using toastr
    //         toastr.success(`${message} Successfully.`, title);
    //     } else {
    //         toastr.error('Failed to load content.');
    //     }
    // }).fail(function(xhr, status, error) {
    //     console.error("Error loading content:", xhr.status, xhr.statusText);
    //     toastr.error("Failed to load content.");
    // });
    // // Use the load method to load the data and handle success or errors
    // $('.load-data').load(url + ' .load-data', function(response, status, xhr) {
    //     if (status === "error") {
    //         console.error("Error loading content:", xhr.status, xhr.statusText);
    //         toastr.error("Failed to load content.");
    //     } else {
    //         toastr.success(`${message} Successfully.`, title);
    //     }
    // });
};


// Function to check if the current page is the last page
function checkIfLastPage(callback) {
    $.ajax({
        url: `${location.href}`,
        method: 'GET',
        success: function (data) {
            container = $(data).find('.load-data');
            if (container.find('table.show-table tbody tr').length === 0 && currentPage > 1) {
                callback(true);
            } else {
                callback(false);
            }
        },
        error: function () {
            callback(false);
        }
    });
};

/////////////// ------------------ Reload Content in Current Pagination Page After Successful Add/Update/Delete Ajax Part End ---------------- /////////////////////////////






// Load Data Common Function For Search and Pagination
function LoadData(url, data) {
    let queryString = $.param(data);  // Convert data object to query string format

    if (queryString) {
        url = url.includes('?') ? `${url}&${queryString}` : `${url}?${queryString}`;
    }
    
    $.ajax({
        url: url,
        method: 'GET',
        data: data,
        success: function (res) {
            if(res.status === 'success'){
                // setupAjaxHeaders();
                // history.pushState(null, '', url);
                $('.load-data').html(res.data);
                if(res.paginate){
                    $('.load-data').append('<div class="center search-paginate" id="paginate">' + res.paginate + '</div>');
                }
            }
            else{
                $('.load-data').html(`<span class="error">Result not Found </span>`);
            }
        },
        statusCode: {
            403: function() {
                toastr.error('You are not allowed to access this.', "Permission denied");
            },
        }, 
        error: function(response, textStatus, errorThrown) {
            toastr.error('An unexpected error occurred.', errorThrown);
        },
    });
}


// function logout(){
//     $('#logoutButton').click(function() {
//         const token = localStorage.getItem('token'); // Retrieve the token

//         $.ajax({
//             url: '/api/logout',
//             type: 'POST',
//             headers: {
//                 'Authorization': 'Bearer ' + token
//             },
//             success: function(response) {
//                 sessionStorage.setItem('redirectMessage', response.message);
                
//                 // Clear the stored token
//                 localStorage.removeItem('token');
                
//                 // Redirect to login page or show a logout confirmation message
//                 window.location.href = '/login';
//             },
//             error: function(error) {
//                 console.log('Logout failed', error);
//             }
//         });
//     });
// }


function SidebarListClick(id, url) {
    $(document).on('click', id, function(e){
        e.preventDefault();
        // Update the URL without reloading the page
        history.pushState(null, '', url);

        $.ajax({
            url: url,
            method: 'GET',
            beforeSend: function() {
                $('.main-content').html('<p>Loading...</p>');
            },
            success: function(res) {
                // console.log(res);
                // setupAjaxHeaders();
                // $('body').html('');
                $('.main-content').html('');
                $('.main-content').html(res);
                
                // $('.main-content').html(res.data);

                // Optional: Display a success message using toastr or similar
                // toastr.success(`${pageTitle} Loaded Successfully`);
            },
            error: function() {
                // Handle any errors
                $('.main-container').html('<p>Failed to load content.</p>');
                toastr.error('Error loading content');
            }
        });
    });
};


$(document).on('click', '#logout', function (e) {
    e.preventDefault();
    const token = localStorage.getItem('token');

    $.ajax({
        url: '/api/logout',
        type: 'POST',
        success: function(response) {
            localStorage.removeItem('token');
            // setupAjaxHeaders();
            window.location.href = '/login';
        },
        error: function(error) {
            console.log('Logout failed', error);
        }
    });
});

function LoadSidebar() {
    $.ajax({
        url: '/api/sidebar',
        type: 'GET',
        success: function(response) {
            if (response.redirect) {
                window.location.href = response.redirect;
            }

            $('.main-container').prepend(response.data);
            SidebarAjax();
            // setupAjaxHeaders();
        },
        error: function(error) {
            console.log('Failed to load dashboard data:', error);

            if (error.responseJSON.redirect) {
                sessionStorage.setItem('redirectMessage', error.responseJSON.message);
                window.location.href = error.responseJSON.redirect;
            }
            if (error.responseJSON.message == "Unauthenticated.") {
                sessionStorage.setItem('redirectMessage', 'You need to login First');
                // window.location.href = '/login';
            }
        }
    });
};





// Call this function after dynamically reloading content
function AjaxHeaderSetup(){
    var token = localStorage.getItem('token');
    if (token) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json',
            }
        });
        console.log('success');
        
    } 
    else {
        // If the token is not available, redirect to login or handle accordingly
        console.log('unauthorised')
        // window.location.href = '/login';
    }
};


function sendAjaxRequest(url, method, data, success, beforeSend, error, processData, contentType) {
    $.ajax({
        url: url,
        
        method: method,
        
        data: data,
        
        beforeSend: beforeSend || function(response, settings) {
            $(document).find('span.error').text('');
            console.log('before send response',response)
            console.log('before send settings',settings)
        },
        
        success: success || function(data, textStatus, jqXHR){
            console.log('Success:', data);
            console.log('Success:', textStatus);
            console.log('Success:', jqXHR);
        },
        
        error: error || function(response, textStatus, errorThrown) {
            if (response.responseJSON && response.responseJSON.errors) {
                $.each(response.responseJSON.errors, function (key, value) {
                    $('#' + key + "_error").text(value);
                });
            } 
            else {
                console.log("Error: ", response);
                console.log("Text Status: ", textStatus);
                console.log("Error Thrown: ", errorThrown);
                toastr.error('An unexpected error occurred.', "Error");
            }
        },
        
        statusCode: {
            403: function() {
                toastr.error('You are not allowed to access this.', "Permission denied");
            },
        }, 
        
        processData: processData || true,
        
        contentType: contentType || 'application/x-www-form-urlencoded',
        
        // dataType: dataType || undefined,
        
        // timeout: timeout || undefined,
        
        // cache: cache || true,
        
        // headers: headers || undefined,
        
        // complete: complete || undefined,    
        
        // dataFilter: undefined,
        
        // crossDomain: crossDomain || false,
    });
};

$(document).ready(function () {
    AjaxHeaderSetup();
    LoadSidebar();
    // // Common function for handling success response
    // function handleSuccess(res, message, targetElement, resetForm = true) {
    //     if (res.status === "success") {
    //         $(targetElement).html(res.data);
    //         if (res.paginate) {
    //             $(targetElement).append('<div class="center search-paginate" id="paginate">' + res.paginate + '</div>');
    //         }
    //         if (resetForm) {
    //             $('#AddForm')[0].reset();
    //             $('#head').removeAttr('data-id');
    //             $('#head').removeAttr('data-groupe');
    //             $('#bank').removeAttr('data-id');
    //         }
    //         toastr.success(message, 'Success');
    //     } 
    //     else {
    //         $(targetElement).html(`<span class="error">Result not Found</span>`);
    //     }
    // }

    /////////////// ------------------ Delete Ajax Part Start ---------------- /////////////////////////////
    // Delete Button Functionality
    $(document).on('click', '#delete', function (e) {
        e.preventDefault();
        $('#deleteModal').show();
        let id = $(this).data('id');
        $('#confirm').attr('data-id',id);
        $('#cancel').focus();
    });

    // Cancel Button Functionality
    $(document).on('click', '#cancel', function (e) {
        e.preventDefault();
        $('#deleteModal').hide();
    });

    /////////////// ------------------ Delete Ajax Part End ---------------- /////////////////////////////


    // On select option search value will be remove
    $(document).on('change', '#searchOption', function (e) {
        $('#search').val('');
    });


    // // Add functionality
    // $(document).on('click', '#Insert', function (e) {
    //     e.preventDefault();
    //     let data = {
    //         type: '4',
    //         method: 'Deposit',
    //         bank: $('#bank').attr('data-id'),
    //         amount: $('#amount').val(),
    //         head: $('#head').attr('data-id'),
    //         groupe: $('#head').attr('data-groupe')
    //     };
    //     sendAjaxRequest(urls.insert, 'POST', data, function (res) {
    //         handleSuccess(res, '.deposit');
    //     }, handleError);
    // });

    // // Edit functionality
    // $(document).on('click', '#edit', function () {
    //     let id = $(this).data('id');
    //     sendAjaxRequest(urls.edit, 'GET', { id: id }, function (res) {
    //         var timestamps = new Date(res.transaction.tran_date);
    //         var formattedDate = timestamps.toLocaleDateString('en-US', { timeZone: 'UTC' });
    //         $('#updateDate').val(formattedDate);
    //         $('#id').val(res.transaction.tran_id);
    //         $('#updateHead').val(res.transaction.head.tran_head_name).attr('data-id', res.transaction.tran_head_id).attr('data-group', res.transaction.tran_groupe_id);
    //         $('#updateBank').attr('data-id', res.transaction.tran_bank).val(res.transaction.bank.name);
    //         $('#updateAmount').val(res.transaction.amount);
    //         document.getElementById($(this).data('modal-id')).style.display = 'block';
    //     }, handleError);
    // });

    // // Update functionality
    // $(document).on('click', '#Update', function (e) {
    //     e.preventDefault();
    //     let data = {
    //         id: $('#id').val(),
    //         bank: $('#updateBank').attr('data-id'),
    //         head: $('#updateHead').attr('data-id'),
    //         groupe: $('#updateHead').attr('data-groupe'),
    //         amount: $('#updateAmount').val(),
    //         method: 'Deposit'
    //     };
    //     sendAjaxRequest(urls.update, 'PUT', data, function (res) {
    //         handleSuccess(res, '.deposit', false);
    //         $('#editModal').hide();
    //     }, handleError);
    // });

    
});