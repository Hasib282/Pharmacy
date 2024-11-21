$(document).ready(function () {
    // Add Button Click Functionality
    $(document).on('click', '.add', function (e) {
        $('#name').focus();
    });



    /////////////// ------------------ Show Bank Details On Details Modal Ajax Part Start ---------------- /////////////////////////////
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



    /////////////// ------------------ Show Bank Details List Toggle Functionality Ajax Part Start ---------------- /////////////////////////////
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
            if($('.transaction').is(':visible')){
                $('.transaction').hide()
            }
            else{
                $('.transaction').show();
            }
        }
    });



    /////////////// ------------------ Add Bank Ajax Part Start ---------------- /////////////////////////////
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
                    $('#name').focus();
                    $('.load-data').load(location.href + ' .load-data');
                    $('#search').val('');
                    toastr.success('Bank Details Added Successfully', 'Added!');
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



    ///////////// ------------------ Edit Bank Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id },
            success: function (res) {
                $('#id').val(res.bank.id);

                $('#updateName').focus();

                $('#updateName').val(res.bank.name);
                $('#updatePhone').val(res.bank.phone);
                $('#updateEmail').val(res.bank.email);

                // Create options dynamically
                $('#updateDivision').empty();
                $('#updateDivision').append(`<option value="Dhaka" ${res.bank.location.division === 'Dhaka' ? 'selected' : ''}>Dhaka</option>
                    <option value="Chittagong" ${res.bank.location.division === 'Chittagong' ? 'selected' : ''}>Chittagong</option>
                    <option value="Rajshahi" ${res.bank.location.division === 'Rajshahi' ? 'selected' : ''}>Rajshahi</option>
                    <option value="Khulna" ${res.bank.location.division === 'Khulna' ? 'selected' : ''}>Khulna</option>
                    <option value="Sylhet" ${res.bank.location.division === 'Sylhet' ? 'selected' : ''}>Sylhet</option>
                    <option value="Barisal" ${res.bank.location.division === 'Barisal' ? 'selected' : ''}>Barisal</option>
                    <option value="Rangpur" ${res.bank.location.division === 'Rangpur' ? 'selected' : ''}>Rangpur</option>
                    <option value="Mymensingh" ${res.bank.location.division === 'Mymensingh' ? 'selected' : ''}>Mymensingh</option>`);

                $('#updateLocation').val(res.bank.location.upazila);
                $('#updateLocation').attr('data-id',res.bank.loc_id);
                $('#updateAddress').val(res.bank.address);

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



    /////////////// ------------------ Update Bank Ajax Part Start ---------------- /////////////////////////////
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
                    toastr.success('Bank Details Updated Successfully', 'Updated!');
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



    DeleteAjax('Bank Details Deleted', 'Deleted!');

    PaginationAjax({  });

    SearchAjax({  });

    SearchPaginationAjax({  });
});