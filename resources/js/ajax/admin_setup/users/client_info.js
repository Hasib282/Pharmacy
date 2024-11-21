$(document).ready(function () {
    // Add Button Click Functionality
    $(document).on('click', '.add', function (e) {
        $('#type').focus();
    });



    /////////////// ------------------ Show Client Details On Details Modal Ajax Part Start ---------------- /////////////////////////////
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



    /////////////// ------------------ Show Client Details List Toggle Functionality Ajax Part Start ---------------- /////////////////////////////
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
        else if(id == 2){
            if($('.contact').is(':visible')){
                $('.contact').hide()
            }
            else{
                $('.contact').show();
            }
        }
        else if(id == 3){
            if($('.address').is(':visible')){
                $('.address').hide()
            }
            else{
                $('.address').show();
            }
        }
        else if(id == 4){
            if($('.transaction').is(':visible')){
                $('.transaction').hide()
            }
            else{
                $('.transaction').show();
            }
        }
        else if(id == 5){
            if($('.others').is(':visible')){
                $('.others').hide()
            }
            else{
                $('.others').show();
            }
        }
    });



    /////////////// ------------------ Add Client Ajax Part Start ---------------- /////////////////////////////
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
                    toastr.success('Client Details Added Successfully', 'Added!');
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



    ///////////// ------------------ Edit Client Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id },
            success: function (res) {
                $('#id').val(res.client.id);

                $('#updateType').empty();
                $('#updateType').empty();
                $.each(res.tranwith, function (key, withs) {
                    $('#updateType').append(`<option value="${withs.id}" ${res.client.tran_user_type === withs.id ? 'selected' : ''}>${withs.tran_with_name}</option>`);
                });

                $('#updateType').focus();

                $('#updateName').val(res.client.user_name);
                $('#updatePhone').val(res.client.user_phone);
                $('#updateEmail').val(res.client.user_email);

                // Create options dynamically
                $('#updateDivision').empty();
                $('#updateDivision').append(`<option value="Dhaka" ${res.client.location.division === 'Dhaka' ? 'selected' : ''}>Dhaka</option>
                    <option value="Chittagong" ${res.client.location.division === 'Chittagong' ? 'selected' : ''}>Chittagong</option>
                    <option value="Rajshahi" ${res.client.location.division === 'Rajshahi' ? 'selected' : ''}>Rajshahi</option>
                    <option value="Khulna" ${res.client.location.division === 'Khulna' ? 'selected' : ''}>Khulna</option>
                    <option value="Sylhet" ${res.client.location.division === 'Sylhet' ? 'selected' : ''}>Sylhet</option>
                    <option value="Barisal" ${res.client.location.division === 'Barisal' ? 'selected' : ''}>Barisal</option>
                    <option value="Rangpur" ${res.client.location.division === 'Rangpur' ? 'selected' : ''}>Rangpur</option>
                    <option value="Mymensingh" ${res.client.location.division === 'Mymensingh' ? 'selected' : ''}>Mymensingh</option>`);

                // Create options dynamically based on the status value
                $('#updateGender').empty();
                $('#updateGender').append(`<option value="Male" ${res.client.gender === 'Male' ? 'selected' : ''}>Male</option>
                                         <option value="Female" ${res.client.gender === 'Female' ? 'selected' : ''}>Female</option>
                                         <option value="Others" ${res.client.gender === 'Others' ? 'selected' : ''}>Others</option>`);

                $('#updateLocation').val(res.client.location.upazila);
                $('#updateLocation').attr('data-id',res.client.loc_id);
                $('#updateAddress').val(res.client.address);

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



    /////////////// ------------------ Update Client Ajax Part Start ---------------- /////////////////////////////
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
                    toastr.success('Client Details Updated Successfully', 'Updated!');
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

    DeleteAjax('Client Details Deleted', 'Deleted!');

    PaginationAjax({  });

    SearchAjax({  });

    SearchPaginationAjax({  });
});