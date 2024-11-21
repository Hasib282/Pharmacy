$(document).ready(function () {
    // Add Button Click Functionality
    $(document).on('click', '.add', function (e) {
        $('#division').focus();
    });



    /////////////// ------------------ Add Location Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#Insert', function (e) {
        e.preventDefault();
        let division = $('#division').val();
        let district = $('#district').val();
        let upazila = $('#upazila').val();
        $.ajax({
            url: urls.insert,
            method: 'POST',
            data: { division, district, upazila },
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#AddForm')[0].reset();
                    $('#division').focus();
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Location Information Added Successfully', 'Added!');
                }
            },
            error: function (err) {
                console.log(err)
                let error = err.responseJSON;
                $.each(error.errors, function (key, value) {
                    $('#' + key + "_error").text(value);
                });
            }
        });
    });



    ///////////// ------------------ Edit Location Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id },
            success: function (res) {
                $('#id').val(id);
                // Create options dynamically
                $('#updateDivision').empty();
                $('#updateDivision').append(`<option value="Dhaka" ${res.location.division === 'Dhaka' ? 'selected' : ''}>Dhaka</option>
                                         <option value="Chittagong" ${res.location.division === 'Chittagong' ? 'selected' : ''}>Chittagong</option>
                                         <option value="Rajshahi" ${res.location.division === 'Rajshahi' ? 'selected' : ''}>Rajshahi</option>
                                         <option value="Khulna" ${res.location.division === 'Khulna' ? 'selected' : ''}>Khulna</option>
                                         <option value="Sylhet" ${res.location.division === 'Sylhet' ? 'selected' : ''}>Sylhet</option>
                                         <option value="Barisal" ${res.location.division === 'Barisal' ? 'selected' : ''}>Barisal</option>
                                         <option value="Rangpur" ${res.location.division === 'Rangpur' ? 'selected' : ''}>Rangpur</option>
                                         <option value="Mymensingh" ${res.location.division === 'Mymensingh' ? 'selected' : ''}>Mymensingh</option>`);
                $('#updateDistrict').val(res.location.district);
                $('#updateUpazila').val(res.location.upazila);
                $('#updateDivision').focus();
                var modal = document.getElementById(modalId);
                modal.style.display = 'block';
            },
            error: function (err) {
                console.log(err);
            }
        });
    });



    /////////////// ------------------ Update Locations Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#Update', function (e) {
        e.preventDefault();
        let id = $('#id').val();
        let division = $('#updateDivision').val();
        let district = $('#updateDistrict').val();
        let upazila = $('#updateUpazila').val();
        $.ajax({
            url: urls.update,
            method: 'PUT',
            data: { division, district, upazila, id },
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#editModal').hide();
                    $('#EditForm')[0].reset();
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Location Information Updated Successfully', 'Updated!');
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

    DeleteAjax('Location Details Deleted', 'Deleted!');

    PaginationAjax({  });

    SearchAjax({  });

    SearchPaginationAjax({  });
});