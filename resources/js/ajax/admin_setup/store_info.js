$(document).ready(function () {
    // Add Button Click Functionality
    $(document).on('click', '.add', function (e) {
        $('#store_name').focus();
    });



    // Search by Division
    $(document).on('change', '#searchDivision', function(e){
        e.preventDefault();
        let search = $('#search').val();
        let division = $("#searchDivision").val();
        let searchOption = $('#searchOption').val();
        LoadData(urls.search, { search, division, searchOption });
    });



    ///////////// ------------------ Add Store Ajax Part Start ---------------- /////////////////////////////
    $(document).on('submit', '#AddForm', function (e) {
        e.preventDefault();
        let locations = $('#location').attr('data-id');
        let formData = new FormData(this);
        formData.append('location', locations === undefined ? '' : locations);
        $.ajax({
            url: urls.insert,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                console.log(res)
                if (res.status == "success") {
                    $('#AddForm')[0].reset();
                    $('#name').focus();
                    $('#location').removeAttr('data-id');
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Store Added Successfully', 'Added!');
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



    ///////////// ------------------ Edit Store Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id },
            success: function (res) {
                $('#id').val(res.store.id);
                $('#update_store_name').val(res.store.store_name);

                // Create options dynamically
                $('#updateDivision').empty();
                $('#updateDivision').append(`<option value="Dhaka" ${res.store.division === 'Dhaka' ? 'selected' : ''}>Dhaka</option>
                    <option value="Chittagong" ${res.store.division === 'Chittagong' ? 'selected' : ''}>Chittagong</option>
                    <option value="Rajshahi" ${res.store.division === 'Rajshahi' ? 'selected' : ''}>Rajshahi</option>
                    <option value="Khulna" ${res.store.division === 'Khulna' ? 'selected' : ''}>Khulna</option>
                    <option value="Sylhet" ${res.store.division === 'Sylhet' ? 'selected' : ''}>Sylhet</option>
                    <option value="Barisal" ${res.store.division === 'Barisal' ? 'selected' : ''}>Barisal</option>
                    <option value="Rangpur" ${res.store.division === 'Rangpur' ? 'selected' : ''}>Rangpur</option>
                    <option value="Mymensingh" ${res.store.division === 'Mymensingh' ? 'selected' : ''}>Mymensingh</option>`);

                $('#updateLocation').val(res.store.location.upazila);
                $('#updateLocation').attr('data-id',res.store.location_id);

                var modal = document.getElementById(modalId);
                modal.style.display = 'block';
            },
            error: function (err) {
                console.log(err);
            }
        });
    });



    /////////////// ------------------ Update Store Ajax Part Start ---------------- /////////////////////////////
    $(document).on('submit', '#EditForm', function (e) {
        e.preventDefault();
        let locations = $('#updateLocation').attr('data-id');
        let formData = new FormData(this);
        formData.append('location',locations);
        $.ajax({
            url: urls.update,
            method: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#editModal').hide();
                    $('#EditForm')[0].reset();
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Store Information Updated Successfully', 'Updated!');
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


    DeleteAjax('Store Details Deleted', 'Deleted!');

    PaginationAjax({  });

    SearchAjax({ division: $("#searchDivision").val() });

    SearchPaginationAjax({ division: $("#searchDivision").val() });
});