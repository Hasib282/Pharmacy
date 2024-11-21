$(document).ready(function () {
    // Add Button Click Functionality
    $(document).on('click', '.add', function (e) {
        $('#type').focus();
    });



    /////////////// ------------------ Show Company Details On Details Modal Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#details', function (e) {
        let modal = $(this).attr('data-modal-id');
        let id = $(this).attr('data-id');
        $.ajax({
            url: urls.detail,
            method: 'GET',
            data: { id },
            success: function (res) {
                $("#"+ modal).show();
                $('.details').html(res.data)
            },
            error: function (err) {
                console.log(err)
            }
        });
    });



    /////////////// ------------------ Show Company Details List Toggle Functionality Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '.details li', function(e){
        let id = $(this).attr('data-id');
        if(id == 1){
            if($('.general').is(':visible')){
                $('.general').hide()
            }
            else{
                $('.general').show();
            }
        }
    });



    /////////////// ------------------ Add Company Ajax Part Start ---------------- /////////////////////////////
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
                if (res.status == "success") {
                    $('#AddForm')[0].reset();
                    $('#location').removeAttr('data-id');
                    $('#type').focus();
                    $('.load-data').load(location.href + ' .load-data');
                    $('#search').val('');
                    toastr.success('Company Details Added Successfully', 'Added!');
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



    ///////////// ------------------ Edit Company Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id:id },
            success: function (res) {
                $('#id').val(res.company.id);

                $('#updateType').empty();
                $('#updateType').empty();
                $.each(res.tranwith, function (key, withs) {
                    $('#updateType').append(`<option value="${withs.id}" ${res.company.tran_user_type === withs.id ? 'selected' : ''}>${withs.tran_with_name}</option>`);
                });

                $('#updateType').focus();

                $('#updateName').val(res.company.user_name);
                $('#updatePhone').val(res.company.user_phone);
                $('#updateEmail').val(res.company.user_email);

                // Create options dynamically
                $('#updateDivision').empty();
                $('#updateDivision').append(`<option value="Dhaka" ${res.company.location.division === 'Dhaka' ? 'selected' : ''}>Dhaka</option>
                    <option value="Chittagong" ${res.company.location.division === 'Chittagong' ? 'selected' : ''}>Chittagong</option>
                    <option value="Rajshahi" ${res.company.location.division === 'Rajshahi' ? 'selected' : ''}>Rajshahi</option>
                    <option value="Khulna" ${res.company.location.division === 'Khulna' ? 'selected' : ''}>Khulna</option>
                    <option value="Sylhet" ${res.company.location.division === 'Sylhet' ? 'selected' : ''}>Sylhet</option>
                    <option value="Barisal" ${res.company.location.division === 'Barisal' ? 'selected' : ''}>Barisal</option>
                    <option value="Rangpur" ${res.company.location.division === 'Rangpur' ? 'selected' : ''}>Rangpur</option>
                    <option value="Mymensingh" ${res.company.location.division === 'Mymensingh' ? 'selected' : ''}>Mymensingh</option>`);

                $('#updateLocation').val(res.company.location.upazila);
                $('#updateLocation').attr('data-id',res.company.loc_id);
                $('#updateAddress').val(res.company.address);

                var modal = document.getElementById(modalId);

                if (modal) {
                    modal.style.display = 'block';
                }
            },
            error: function (err) {
                console.log(err);
            }
        });
    });



    /////////////// ------------------ Update Company Ajax Part Start ---------------- /////////////////////////////
    $(document).on('submit', '#EditForm', function (e) {
        e.preventDefault();
        let locations = $('#updateLocation').attr('data-id');
        let formData = new FormData(this);
        formData.append('location', locations === undefined ? '' : locations);
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
                    toastr.success('Company Details Updated Successfully', 'Updated!');
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



    DeleteAjax('Company Details Deleted', 'Deleted!');

    PaginationAjax({  });

    SearchAjax({  });

    SearchPaginationAjax({  });
});