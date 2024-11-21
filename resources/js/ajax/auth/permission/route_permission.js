$(document).ready(function () {
    $('#select-all').click(function() {
        $('.route').prop('checked', this.checked);
    });
    

    // Individual checkboxes click handler
    $('.route').click(function() {
        if ($('.route:checked').length === $('.route').length) {
            $('#select-all').prop('checked', true);
        } else {
            $('#select-all').prop('checked', false);
        }
    });


    ///////////// ------------------ Edit Route Permission ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#assign', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        $.ajax({
            url: urls.view,
            method: 'GET',
            data: { id },
            success: function (res) {
                $('#permissionid').text(`Permission Name: ${res.permission.name}`);
                $('#permission').val(id);
                
                $('#route-container').html('');
                $.each(res.routeDetails, function (key, route) {
                    $('#route-container').append(` <div class="c-4">
                                                            <label for="routes-${route['name']}">
                                                                <input type="checkbox" id="routes-${route['name']}" class="route" name="routes[]" value="${route['name']}" ${res.permissionroute.includes(route['name']) ? 'checked' : ''} } />
                                                                ${route['name']}
                                                            </label>
                                                        </div>`);
                });

                var modal = document.getElementById(modalId);
                modal.style.display = 'block';
            },
            error: function (err) {
                console.log(err);
            }
        });
    });



    /////////////// ------------------ Assign Route Permission ajax part start ---------------- /////////////////////////////
    $(document).on('submit', '#RoutePermissionForm', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: urls.assign,
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false, 
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#assignModal').hide();
                    $('#select-all').prop('checked', false);
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Route Permission Updated Successfully', 'Updated!');
                }
            },
            error: function (err) {
                let error = err.responseJSON;
                $.each(error.errors, function (key, value) {
                    $('#update_' + key + "_error").text(value);
                })
            }
        });
    });

    PaginationAjax({  });

    SearchAjax({  });

    SearchPaginationAjax({  });
});