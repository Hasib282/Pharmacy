$(document).ready(function () {
    
    var formIndex = 2; // Initialize form index

    $('#addExperience').click(function() {
        var form = createForm(formIndex); // Create a new form
        $('#formContainer').append(form); // Append the form to the container
        formIndex++; // Increment form index
    });
    
    //Experience Form Field Empty and Insert Data in Add Form 
    $('#Insert').on('click', function() {
        // Check if forms have already been submitted
        if ($(this).data('submitted')) {
            // Forms already submitted, do nothing
            return;
        }
    
        // Mark the button as submitted
        $(this).data('submitted', true);
    
        // Start submitting forms sequentially
        submitForm($('.experience-form').first());
    });
    

    var isFirstFormInserted = false;

    // Function to submit forms sequentially
    function submitForm(form) {
        if (!form.length) {
            // No more forms to submit
            if (isFirstFormInserted) {
                // Remove all forms except the first one
                removeAllFormsExceptFirst();
            }
            return;
        }

        let user = $('#user').attr('data-id');
        let formData = new FormData(form[0]);
        formData.append('user', user === undefined ? '' : user);

        $.ajax({
            url: urls.insert,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            beforeSend: function() {
                form.find('span.error').text(''); // Clear errors
            },
            success: function(res) {
                console.log(res);
                if (res.status === "success") {
                    form[0].reset(); // Reset the current form
                    form.find('#name').focus(); // Set focus

                    // Clear errors and fields within the current form
                    form.find('.error').text('');
                    form.find('#user').removeAttr('data-id');
                    form.find('#search').val('');

                    //toastr.success('Experience Detail Added Successfully', 'Added!');
                    if (!isFirstFormInserted) {
                        isFirstFormInserted = true;
                    }
                }

                // Submit the next form recursively only if the first form was inserted successfully
                if (isFirstFormInserted) {
                    submitForm(form.next('.experience-form'));
                }
            },
            error: function(err) {
                console.log(err);
                let error = err.responseJSON;
                $.each(error.errors, function(key, value) {
                    form.find('#' + key + "_error").text(value); // Set error messages
                });
            }
        });
    }

    // Function to remove all forms except the first one
    function removeAllFormsExceptFirst() {
        $('.experience-form').not(':first').remove();
    }

    // Function to create a new form
    function createForm(index) {
        
        var form = $('<form>', {
            id: 'form' + index,
            class: 'experience-form'
        });
    

        // Add form fields
        form.append(`
        <div class="rows"> 
            <div class="c-6">
                <div class="form-input-group">
                    <label for = "company_name">Company Name<span class="red">*</span></label>
                    <input type="text" name="company_name" id="company_name" class="form-input">
                    <span class="error" id="company_name_error"></span>
                </div>
            </div>
            <div class="c-6">
                <div class="form-input-group">
                    <label for = "department">Department<span class="red">*</span></label>
                    <input type="text" name="department" id="department" class="form-input">
                    <span class="error" id="department_error"></span>
                </div>
            </div>
            <div class="c-6">
                <div class="form-input-group">
                    <label for = "designation">Designation<span class="red">*</span></label>
                    <input type="text" name="designation" id="designation" class="form-input">
                    <span class="error" id="designation_error"></span>
                </div>
            </div>
            <div class="c-6">
                <div class="form-input-group">
                    <label for = "company_location">Company Address<span class="red">*</span></label>
                    <input type="text" name="company_location" id="company_location"  class="form-input">
                    <span class="error" id="company_location_error"></span>
                </div>
            </div>
            <div class="c-6">
                <div class="form-input-group">
                    <label for="start_date">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-input">
                    <span class="error" id="start_date_error"></span>
                </div>
            </div>
            <div class="c-6">
                <div class="form-input-group">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-input">
                    <span class="error" id="end_date_error"></span>
                </div>
            </div>
            <!-- Forms will be dynamically added here -->
        </div>`);
        return form;
    }


    // Show Button part
    $(document).on('click', '.emp_experienceDetail', function (e) {
        let id = $(this).attr('data-id');
        let $detailsRow = $(`#detailsexperience${id}`);
        let $button = $(this); // Reference to the clicked button
    
        if ($detailsRow.is(':visible')) {
            // If the row is visible, hide it, change button text to "Show", and remove caret rotation
            $detailsRow.hide();
            $button.find('.fa-chevron-circle-right').removeClass('rotate');
        } else {
            // Fetch data and show it, then change button text to "Hide", and add caret rotation
            $.ajax({
                url: urls.grid,
                method: 'GET',
                data: { id },
                success: function (res) {
                    console.log(res);
                    $detailsRow.find('td').html(res.data);
                    $detailsRow.show();
                    $button.find('.fa-chevron-circle-right').addClass('rotate');
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }
    });
    
    
    

    //Show Employee Experience Details on details modal
    $(document).on('click', '#details', function (e) {
        let modal = $(this).attr('data-modal-id');
        let id = $(this).attr('data-id');
        $.ajax({
            url: urls.details,
            method: 'GET',
            data: { id },
            success: function (res) {
                $("#"+ modal).show();
                $('.employeeexperiencedetails').html(res.data)
            },
            error: function (err) {
                console.log(err)
            }
        });
    });


    // Show Employee Details List Toggle Functionality
    $(document).on('click', '.employeeexperiencedetails li', function(e){
        let id = $(this).attr('data-id');
        if(id == 1){
            if($('.personal').is(':visible')){
                $('.personal').hide()
            }
            else{
                $('.personal').show();
            }
        }
        else if(id == 2){
            if($('.experience').is(':visible')){
                $('.experience').hide()
            }
            else{
                $('.experience').show();
            }
        }
    });

    // Edit Button Click Event
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).attr('data-id');
        let formId = $(this).data('form-id'); // Get the form ID associated with the clicked edit button

        // Fetch form data for the corresponding form ID
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id }, // Send the form ID to the server
            success: function (res) {
                // Populate modal fields with fetched form data
                $('#id').val(res.employee.id);
                $('#empId').val(res.employee.emp_id);
                $('#update_company_name').val(res.employee.company_name);
                $('#update_department').val(res.employee.department);
                $('#update_designation').val(res.employee.designation);
                $('#update_company_location').val(res.employee.company_location);
                $('#update_start_date').val(res.employee.start_date);
                $('#update_end_date').val(res.employee.end_date);
                
                // Show the modal
                var modal = document.getElementById(modalId);
                modal.style.display = 'block';
            },
            error: function (err) {
                console.log(err);
            }
        });
    });

    // Submit Edited Employee Experience Form
    $(document).on('submit', '#EditExperienceForm', function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        // Make AJAX request to update form data
        $.ajax({
            url: urls.update,
            method: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.status == "success") {
                    $('#editModal').hide();
                    $('#EditForm')[0].reset();
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Experience Details Updated Successfully', 'Updated!');
                }
            },
            error: function (err) {
                console.log(err);
            }
        });
    });


    
    DeleteAjax('Employee Experience Details Deleted', 'Deleted!');

    PaginationAjax({  });

    SearchAjax({  });

    SearchPaginationAjax({  });
});
