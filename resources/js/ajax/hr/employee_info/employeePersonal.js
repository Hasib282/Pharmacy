$(document).ready(function () {
    //////////////////// --------------------- Show Image When Select File ---------------- /////////////////////
    $(document).on('change','#image', function (e){
        let path = $(this).val();
        let extension = path.substring(path.lastIndexOf('.')+1).toLowerCase();
        
        if(extension == 'jpg' || extension == 'jpeg' || extension == 'png' || extension == 'gif'){
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImage').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(file);
            }
            else{
                $('#previewImage').attr('src', " ").hide();
            }
        }
        else{
            $('#previewImage').attr('src', " ").hide();
        }
    });



    $(document).on('change','#updateImage', function (e){
        console.log(e);
        let path = $(this).val();
        let extension = path.substring(path.lastIndexOf('.')+1).toLowerCase();
        
        if(extension == 'jpg' || extension == 'jpeg' || extension == 'png' || extension == 'gif'){
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#updatePreviewImage').attr('src', " ");
                    $('#updatePreviewImage').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(file);
            }
            else{
                $('#updatePreviewImage').attr('src', " ").hide();
            }
        }
        else{
            $('#updatePreviewImage').attr('src', " ").hide();
        }
    });



    ///////////// ------------------ Show Personal Details Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#details', function (e) {
        let modal = $(this).attr('data-modal-id');
        let id = $(this).attr('data-id');
        $.ajax({
            url: urls.detail,
            method: 'GET',
            data: {id:id},
            success: function (res) {
                $("#"+ modal).show();
                $('.employeepersonaldetails').html(res.data)
            },
            error: function (err) {
                console.log(err)
            }
        });
    });


    ///////////// ------------------ Insert Personal Details Ajax Part Start ---------------- /////////////////////////////
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
                    $('#previewImage').attr('src',`#`).hide();
                    toastr.success('Personal Detail Added Successfully', 'Added!');
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




    ///////////// ------------------ Edit Personal Details Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id },
            success: function (res) {
                $('#id').val(res.employee.id);
                $('#employee_id').val(res.employee.employee_id);
                $('#update_name').val(res.employee.name);
                $('#update_name').focus();
                $('#update_fathers_name').val(res.employee.fathers_name);
                $('#update_mothers_name').val(res.employee.mothers_name);
                $('#update_date_of_birth').val(res.employee.date_of_birth);

                // Create options dynamically
                $('#update_gender').empty();
                $('#update_gender').append(`<option value="Male" ${res.employee.gender === 'Male' ? 'selected' : ''}>Male</option>
                                            <option value="Female" ${res.employee.gender === 'Female' ? 'selected' : ''}>Female</option>
                                            <option value="Others" ${res.employee.gender === 'Others' ? 'selected' : ''}>Others</option>`);

                $('#update_religion').empty();
                $('#update_religion').append(`<option value="Islam" ${res.employee.religion === 'Islam' ? 'selected' : ''}>Islam</option>
                                            <option value="Hinduism" ${res.employee.religion === 'Hinduism' ? 'selected' : ''}>Hinduism</option>
                                            <option value="Christianity" ${res.employee.religion === 'Christianity' ? 'selected' : ''}>Christianity</option>
                                            <option value="Buddhism" ${res.employee.religion === 'Buddhism' ? 'selected' : ''}>Buddhism</option>
                                            <option value="Judaism" ${res.employee.religion === 'Judaism' ? 'selected' : ''}>Judaism</option>`);

                $('#update_marital_status').empty();
                $('#update_marital_status').append(`<option value="Married" ${res.employee.marital_status === 'Married' ? 'selected' : ''}>Married</option>
                                                    <option value="Unmarried" ${res.employee.marital_status === 'Unmarried' ? 'selected' : ''}>Unmarried</option>`);

                $('#update_nationality').val(res.employee.nationality);
                $('#update_nid_no').val(res.employee.nid_no);
                $('#update_phn_no').val(res.employee.phn_no);
                $('#update_blood_group').empty();
                $('#update_blood_group').append(`<option value="A+" ${res.employee.blood_group === 'A+' ? 'selected' : ''}>A+</option>
                                            <option value="A-" ${res.employee.blood_group === 'A-' ? 'selected' : ''}>A-</option>
                                            <option value="B+" ${res.employee.blood_group === 'B+' ? 'selected' : ''}>B+</option>
                                            <option value="B-" ${res.employee.blood_group === 'B-' ? 'selected' : ''}>B-</option>
                                            <option value="O+" ${res.employee.blood_group === 'O+' ? 'selected' : ''}>O+</option>
                                            <option value="O-" ${res.employee.blood_group === 'O-' ? 'selected' : ''}>O-</option>
                                            <option value="AB+" ${res.employee.blood_group === 'AB+' ? 'selected' : ''}>AB+</option>
                                            <option value="AB-" ${res.employee.blood_group === 'AB-' ? 'selected' : ''}>AB-</option>`);

                $('#update_email').val(res.employee.email);

                $('#updateLocation').val(res.employee.location.upazila);
                $('#updateLocation').attr('data-id',res.employee.location_id);

                // Create options dynamically
                $('#update_type').empty();
                $.each(res.tranwith, function (key, withs) {
                    $('#update_type').append(`<option value="${withs.id}" ${res.employee.tran_user_type === withs.id ? 'selected' : ''}>${withs.tran_with_name}</option>`);
                });

                $('#update_address').val(res.employee.address);
                $('#update_password').val(res.employee.password);
                $('#updatePreviewImage').attr('src',`/storage/profiles/${res.employee.image}?${new Date().getTime()} `).show();

                var modal = document.getElementById(modalId);
                modal.style.display = 'block';
            },
            error: function (err) {
                console.log(err);
            }
        });
    });



    /////////////// ------------------ Update Personal Details Ajax Part Start ---------------- /////////////////////////////
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
                    toastr.success('Personal Details Updated Successfully', 'Updated!');
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



    DeleteAjax('Employee Personal Details Deleted', 'Deleted!');

    PaginationAjax({  });

    SearchAjax({  });

    SearchPaginationAjax({  });
});