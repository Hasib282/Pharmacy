function ShowEmployeeEducationDetails(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.user_id}</td>
                    <td>${item.user_name}</td>
                    <td>${item.dob}</td>
                    <td>${item.gender}</td>
                    <td>${item.user_email}</td>
                    <td>${item.user_phone}</td>
                    <td>${item.address}</td>
                    <td><img src="${apiUrl.replace('/api', '')}/storage/profiles/${item.image ? item.image : (item.gender == 'female' ? 'female.png' : 'male.png')}?${new Date().getTime()}" alt="" height="50px" width="50px"></td>
                    <td>
                        ${item.status == 1 ?
                        `<button class="btn btn-success btn-sm toggle-status" data-id="${item.id}"
                            data-table="Inv_Client_Info" data-status="${item.status}}" data-target=".client">Active</button>`
                        :
                        `<button class="btn btn-danger btn-sm toggle-status" data-id="${item.id}" data-table="Inv_Client_Info"
                            data-status="${item.status}" data-target=".client">Inactive</button>`
                        }
                    </td>
                    <td>
                        <div style="display: flex;gap:5px;">
                            <button class="btn-show" id="showGrid" data-id="${item.user_id}">Show <i class="fa fa-chevron-circle-right"></i></button>
                            <button class="open-modal" data-modal-id="detailsModal" id="details"
                                data-id="${item.user_id}"><i class="fa-solid fa-circle-info"></i></button>
                        </div>
                    </td>
                </tr>
                <tr id="grid${item.user_id}" style="display:none"></tr>
            `;
        });

        // Inject the generated rows into the table body
        $('.load-data .show-table tbody').html(tableRows);
        $('.load-data .show-table tfoot').html('')
    }
    else{
        $('.load-data .show-table tbody').html('');
        $('.load-data .show-table tfoot').html('<tr><td colspan="11" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Creating Select Options Dynamically
    $.ajax({
        url: `${apiUrl}/hr/employee/education`,
        method: "GET",
        success: function (res) {
            CreateSelectOptions('#with', 'Select Employee Type', res.tranwith, null, 'tran_with_name');
        },
    });


    // Load Data on Hard Reload
    ReloadData('hr/employee/education', ShowEmployeeEducationDetails);
    

    // // Add Modal Open Functionality
    // AddModalFunctionality("#division");


    // // Insert Ajax
    // InsertAjax('hr/employee/education', ShowEmployeeEducationDetails, {}, function() {
    //     $('#division').focus();
    // });


    //Edit Ajax
    EditAjax('hr/employee/education', EditFormInputValue);


    // Update Ajax
    UpdateAjax('hr/employee/education', ShowEmployeeEducationDetails);
    

    // Delete Ajax
    DeleteAjax('hr/employee/education', ShowEmployeeEducationDetails);


    // Pagination Ajax
    PaginationAjax(ShowEmployeeEducationDetails);


    // Search Ajax
    SearchAjax('hr/employee/education', ShowEmployeeEducationDetails, {  });


    // Additional Edit Functionality
    function EditFormInputValue(res){
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
        handleResultUpdate(res.employee.result);

        // Attach change event handler to update fields dynamically
        $('#update_result').on('change', function () {
            handleResultUpdate($(this).val());
        });
    }



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















    var formIndex = 2; // Initialize form index

    // Add new form on button click
    $('#addEducation').on('click', function() {
        var form = createForm(formIndex); // Create a new form
        $('#formContainer').append(form); // Append the form to the container
        formIndex++; // Increment form index
    });


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






    // Function to validate a single form
    function validateForm(index) {
        var isValid = true;

        // Get input fields by ID
        var levelOfEducation = $('#level_of_education_' + index);
        var degreeTitle = $('#degree_title_' + index);
        var institutionName = $('#institution_name_' + index);
        var result = $('#result_' + index);
        var passingYear = $('#passing_year_' + index);

        

        // Validate required fields
        if (levelOfEducation.val() === '') {
            $('#level_of_education_error_' + index).text('This field is required');
            isValid = false;
        }
        if (degreeTitle.val() === '') {
            $('#degree_title_error_' + index).text('This field is required');
            isValid = false;
        }
        if (institutionName.val() === '') {
            $('#institution_name_error_' + index).text('This field is required');
            isValid = false;
        }
        if (result.val() === '') {
            $('#result_error_' + index).text('This field is required');
            isValid = false;
        }

        if (result.val() === "Grade") {
            const scale = $(`#scale_${index}`).val();
            const cgpa = $(`#cgpa_${index}`).val();
            if (!scale) {
                $(`#scale_error_${index}`).text("Scale is required");
                isValid = false;
            }
            if (!cgpa) {
                $(`#cgpa_error_${index}`).text("CGPA is required");
                isValid = false;
            }
        } 
        else {
            const marks = $(`#marks_${index}`).val();
            if (!marks) {
                $(`#marks_error_${index}`).text("Marks are required");
                isValid = false;
            }
        }

        if (passingYear.val() === '') {
            $('#passing_year_error_' + index).text('This field is required');
            isValid = false;
        }

        return isValid;
    }



    // Handle form submission
    $('#Insert').on('click', function() {
        $('.error').text('');

        var withs = $('#with').val();
        var name = $('#user').attr('data-id');


        var isValid = true;
        var allFormsValid = true;

        if (withs === '') {
            $('#with_error').text('This field is required');
            isValid = false;
        }
        if (name === '' || name === undefined) {
            $('#user_error').text('This field is required');
            isValid = false;
        }

        if (isValid){
            // Loop through all forms
            for (var i = 1; i < formIndex; i++) {
                if (!validateForm(i)) {
                    allFormsValid = false;
                }
            }

            // If all forms are valid, submit one by one
            if (allFormsValid) {
                submitForm(1);
            }
        }
    });

    

    // Function to submit forms sequentially
    function submitForm(index) {
        let user = $('#user').attr('data-id') || '';
        let formElement = $(`#form${index}`);

        // Check if the form exists
        if (!formElement.length) {
            $('#user').removeAttr('data-id');
            $('#with').val('');
            $('#user').val('');
            $('.education-form').not(':first').remove();
            toastr.success('Employee Education Details Added Successfully', 'Added!');
            formIndex = 2;
            return;
        }

        let formData = new FormData(formElement.get(0));
        formData.append('user', user);
        formElement.find('.error').text('');
        $.ajax({
            url: `${apiUrl}/hr/employee/education`,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            success: function(res) {
                if (res.status) {
                    formElement[0].reset();
                    submitForm(index + 1);
                }
            },
        });
    }

    
    // Event delegation for dynamically created result dropdowns
    $(document).on('change', '.result-dropdown', function() {
        var form = $(this).closest('form');
        handleResultChange(form, $(this).val());
    });


    // Function to handle result change
    function handleResultChange(form, result) {
        var index = form.attr('id').replace('form', '');
        var scaleGroup = $('#scale-group_' + index);
        var cgpaGroup = $('#cgpa-group_' + index);
        var marksGroup = $('#marks-group_' + index);
        
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


    // Show Detals Ajax
    DetailsAjax('hr/employee/education');


    // Show Grid
    GridAjax('hr/employee/education');
});