$(document).ready(function () {  

    var formIndex = 2; // Initialize form index

    // Add new form on button click
    $('#addEducation').on('click', function() {
        var form = createForm(formIndex); // Create a new form
        $('#formContainer').append(form); // Append the form to the container
        formIndex++; // Increment form index
    });

    // Handle form submission
    $('#Insert').on('click', function() {
        if ($(this).data('submitted')) {
            return; // Do nothing if already submitted
        }
        $(this).data('submitted', true);
        submitForm($('.education-form').first());
    });

    // Event delegation for dynamically created result dropdowns
    $(document).on('change', '.result-dropdown', function() {
        var form = $(this).closest('form');
        handleResultChange(form, $(this).val());
    });
    

    var isFirstFormInserted = false;

    // Function to submit forms sequentially
    function submitForm(form) {
        if (!form.length) {
            if (isFirstFormInserted) {
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
                if (res.status === "success") {
                    form[0].reset(); // Reset the current form
                    form.find('#name').focus(); // Set focus
                    form.find('.error').text(''); // Clear errors
                    form.find('#user').removeAttr('data-id');
                    form.find('#search').val('');

                    if (!isFirstFormInserted) {
                        isFirstFormInserted = true;
                    }
                }
                if (isFirstFormInserted) {
                    submitForm(form.next('.education-form'));
                }
            },
            error: function(err) {
                let error = err.responseJSON;
                $.each(error.errors, function(key, value) {
                    form.find('#' + key + "_error").text(value); // Set error messages
                });
            }
        });
    }

    function removeAllFormsExceptFirst() {
        $('.education-form').not(':first').remove();
    }

    function createForm(index) {
        var form = $('<form>', {
            id: 'form' + index,
            class: 'education-form'
        });

        form.append(`
        <div class="rows">  
            <div class="c-6">
                <div class="form-input-group">
                    <label for="level_of_education_${index}">Level of Education<span class="red">*</span></label>
                    <input type="text" name="level_of_education" id="level_of_education_${index}" class="form-input">
                    <span class="error" id="level_of_education_error_${index}"></span>
                </div>
            </div>
            <div class="c-6">
                <div class="form-input-group">
                    <label for="degree_title_${index}">Degree Title<span class="red">*</span></label>
                    <input type="text" name="degree_title" id="degree_title_${index}" class="form-input">
                    <span class="error" id="degree_title_error_${index}"></span>
                </div>
            </div>
            <div class="c-6">
                <div class="form-input-group">
                    <label for="group_${index}">Group</label>
                    <select name="group" id="group_${index}" class="group-dropdown">
                        <option value="">Select</option>
                        <option value="Science">Science</option>
                        <option value="Commerce">Commerce</option>
                        <option value="Arts">Arts</option>
                    </select>
                    <span class="error" id="group_error_${index}"></span>
                </div>
            </div>
            <div class="c-6">
                <div class="form-input-group">
                    <label for="institution_name_${index}">Institution Name<span class="red">*</span></label>
                    <input type="text" name="institution_name" id="institution_name_${index}" class="form-input">
                    <span class="error" id="institution_name_error_${index}"></span>
                </div>
            </div>
            <div class="c-6">
                <div class="form-input-group">
                    <label for="result_${index}">Result<span class="red">*</span></label>
                    <select name="result" id="result_${index}" class="result-dropdown">
                        <option value="">Select</option>
                        <option value="First Division/Class">First Division/Class</option>
                        <option value="Second Division/Class">Second Division/Class</option>
                        <option value="Third Division/Class">Third Division/Class</option>
                        <option value="Grade">Grade</option>
                    </select>
                    <span class="error" id="result_error_${index}"></span>
                </div>
            </div>
           <div class="c-6 hidden" id="scale-group_${index}">
                <div class="form-input-group">
                    <label for="scale_${index}">Scale<span class="red">*</span></label>
                    <input type="decimal" step="0.01" name="scale" id="scale_${index}" class="form-input">
                    <span class="error" id="scale_error_${index}"></span>
                </div>
            </div>
            <div class="c-6 hidden" id="cgpa-group_${index}">
                <div class="form-input-group">
                    <label for="cgpa_${index}">CGPA<span class="red">*</span></label>
                    <input type="decimal" step="0.01" name="cgpa" id="cgpa_${index}" class="form-input">
                    <span class="error" id="cgpa_error_${index}"></span>
                </div>
            </div>
            <div class="c-6 hidden" id="marks-group_${index}">
                <div class="form-input-group">
                    <label for="marks_${index}">Marks<span class="red">*</span></label>
                    <input type="number" name="marks" id="marks_${index}" class="form-input">
                    <span class="error" id="marks_error_${index}"></span>
                </div>
            </div>
            <div class="c-6">
                <div class="form-input-group">
                    <label for="batch_${index}">Batch</label>
                    <input type="integer" name="batch" id="batch_${index}" class="form-input">
                    <span class="error" id="batch_error_${index}"></span>
                </div>
            </div>
            <div class="c-6">
                <div class="form-input-group">
                    <label for="passing_year_${index}">Passing Year<span class="red">*</span></label>
                    <input type="integer" name="passing_year" id="passing_year_${index}" class="form-input">
                    <span class="error" id="passing_year_error_${index}"></span>
                </div>
            </div>
        </div>`);
        return form;
    }


    // Function to handle result change
    function handleResultChange(form, result) {
        var index = form.attr('id').replace('form', '');
        var scaleGroup = $('#scale-group_' + index);
        var cgpaGroup = $('#cgpa-group_' + index);
        var marksGroup = $('#marks-group_' + index);
        
        console.log(index);
        if (result === 'Grade') {
            scaleGroup.removeClass('hidden');
            cgpaGroup.removeClass('hidden');
            marksGroup.addClass('hidden');
        } else if (result === 'First Division/Class' || result === 'Second Division/Class' || result === 'Third Division/Class') {
            scaleGroup.addClass('hidden');
            cgpaGroup.addClass('hidden');
            marksGroup.removeClass('hidden');
        } else {
            scaleGroup.addClass('hidden');
            cgpaGroup.addClass('hidden');
            marksGroup.addClass('hidden');
        }
    }

    // Show Button part
    $(document).on('click', '.emp_educationDetail', function (e) {
        let id = $(this).attr('data-id');
        let $detailsRow = $(`#detailseducation${id}`);
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
    
    

    
    //Show Employee Education Details on details modal
    $(document).on('click', '#details', function (e) {
        let modal = $(this).attr('data-modal-id');
        let id = $(this).attr('data-id');
        $.ajax({
            url: urls.detail,
            method: 'GET',
            data: { id },
            success: function (res) {
                $("#"+ modal).show();
                $('.employeeeducationdetails').html(res.data)
            },
            error: function (err) {
                console.log(err)
            }
        });
    });


    // Show Employee Details List Toggle Functionality
    $(document).on('click', '.employeeeducationdetails li', function(e){
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
            if($('.education').is(':visible')){
                $('.education').hide()
            }
            else{
                $('.education').show();
            }
        }
    });



    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).attr('data-id');
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id },
            success: function (res) {
                $('#id').val(res.employee.id);
                $('#empId').val(res.employee.emp_id);
                $('#update_level_of_education').val(res.employee.level_of_education);
                $('#update_degree_title').val(res.employee.degree_title);
                // Create options dynamically
                $('#update_group').empty();
                $('#update_group').append(`
                    <option value="Science" ${res.employee.group === 'Science' ? 'selected' : ''}>Science</option>
                    <option value="Commerce" ${res.employee.group === 'Commerce' ? 'selected' : ''}>Commerce</option>
                    <option value="Arts" ${res.employee.group === 'Arts' ? 'selected' : ''}>Arts</option>
                `);

                $('#update_institution_name').val(res.employee.institution_name);
    
                // Create options dynamically
                $('#update_result').empty();
                $('#update_result').append(`
                    <option value="First Division/Class" ${res.employee.result === 'First Division/Class' ? 'selected' : ''}>First Division/Class</option>
                    <option value="Second Division/Class" ${res.employee.result === 'Second Division/Class' ? 'selected' : ''}>Second Division/Class</option>
                    <option value="Third Division/Class" ${res.employee.result === 'Third Division/Class' ? 'selected' : ''}>Third Division/Class</option>
                    <option value="Grade" ${res.employee.result === 'Grade' ? 'selected' : ''}>Grade</option>
                `);
    
                $('#update_marks').val(res.employee.marks);
                $('#update_scale').val(res.employee.scale);
                $('#update_cgpa').val(res.employee.cgpa);
                $('#update_batch').val(res.employee.batch);
                $('#update_passing_year').val(res.employee.passing_year);
                
                // Show or hide fields based on result
                handleResultUpdate($('#update_result').val());
    
                // Attach change event handler to update fields dynamically
                $('#update_result').on('change', function () {
                    handleResultUpdate($(this).val());
                });
    
                // Show the modal
                var modal = document.getElementById(modalId);
                modal.style.display = 'block';
            },
            error: function (err) {
                console.log(err);
            }
        });
    });
    
    function handleResultUpdate(result) {
        var scaleGroup = $('#update_scale-group');
        var cgpaGroup = $('#update_cgpa-group');
        var marksGroup = $('#update_marks-group');
    
        if (result === 'Grade') {
            scaleGroup.removeClass('hidden');
            cgpaGroup.removeClass('hidden');
            marksGroup.addClass('hidden');
            $('#update_marks').val('');
        } else if (result === 'First Division/Class' || result === 'Second Division/Class' || result === 'Third Division/Class') {
            scaleGroup.addClass('hidden');
            cgpaGroup.addClass('hidden');
            marksGroup.removeClass('hidden');
            $('#update_scale').val('');
            $('#update_cgpa').val('');
        } else {
            scaleGroup.addClass('hidden');
            cgpaGroup.addClass('hidden');
            marksGroup.addClass('hidden');
        }
    }
    

    // Submit Edited Employee Education Form
    $(document).on('submit', '#EditForm', function (e) {
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
                    toastr.success('Education Details Updated Successfully', 'Updated!');
                }
            },
            error: function (err) {
                console.log(err);
            }
        });
    });


    DeleteAjax('Employee Education Details Deleted', 'Deleted!');

    PaginationAjax({  });

    SearchAjax({  });

    SearchPaginationAjax({  });
});

document.getElementById('addEducation').addEventListener('click', function() {
    var container = document.getElementById('dynamicContainer');
    var newFields = document.createElement('div');
    newFields.innerHTML = `@include('education_fields')`;
    container.appendChild(newFields);
});