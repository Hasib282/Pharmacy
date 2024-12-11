function ShowEmployeeTrainingDetails(data, startIndex) {
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
                                data-table="Inv_Client_Info" data-status="${item.status}" data-target=".client">Active</button>`
                            :
                            `<button class="btn btn-danger btn-sm toggle-status" data-id="${item.id}" data-table="Inv_Client_Info"
                                data-status="${item.status}" data-target=".client">Inactive</button>`
                        }
                    </td>
                    <td>
                        <div style="display: flex;gap:5px;">
                            <button class="btn-show" id="showGrid" data-id="${item.user_id}">Show <i class="fa fa-chevron-circle-right"></i></button>
                            <button class="open-modal" data-modal-id="detailsModal" id="details" data-id="${item.user_id}"><i class="fa-solid fa-circle-info"></i></button>
                        </div>
                    </td>
                </tr>
                <tr id = "grid${item.user_id}" style = "display:none"></tr>
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
        url: `${apiUrl}/hr/employee/training`,
        method: "GET",
        success: function (res) {
            CreateSelectOptions('#with', 'Select Employee Type', res.tranwith, null, 'tran_with_name');
        },
    });


    // Load Data on Hard Reload
    ReloadData('hr/employee/training', ShowEmployeeTrainingDetails);
    

    // // Add Modal Open Functionality
    // AddModalFunctionality("#division");


    // // Insert Ajax
    // InsertAjax('hr/employee/training', ShowEmployeeTrainingDetails, {}, function() {
    //     $('#division').focus();
    // });


    //Edit Ajax
    EditAjax('hr/employee/training', EditFormInputValue);


    // Update Ajax
    UpdateAjax('hr/employee/training', ShowEmployeeTrainingDetails);
    

    // Delete Ajax
    DeleteAjax('hr/employee/training', ShowEmployeeTrainingDetails);


    // Pagination Ajax
    PaginationAjax(ShowEmployeeTrainingDetails);


    // Search Ajax
    SearchAjax('hr/employee/training', ShowEmployeeTrainingDetails, {  });


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.employee.id);
        $('#empId').val(res.employee.emp_id);
        $('#update_training_title').val(res.employee.training_title);
        $('#update_country').val(res.employee.country);
        $('#update_topic').val(res.employee.topic);
        $('#update_institution_name').val(res.employee.institution_name);
        $('#update_start_date').val(res.employee.start_date);
        $('#update_end_date').val(res.employee.end_date);
        $('#update_training_year').val(res.employee.training_year);
    }






    










    var formIndex = 2; // Initialize form index

    $('#addTraining').click(function() {
        var form = createForm(formIndex); // Create a new form
        $('#formContainer').append(form); // Append the form to the container
        formIndex++; // Increment form index
    });

    // Function to create a new form
    function createForm(index) {
        var form = $('<form>', {
            id: 'form' + index,
            class: 'training-form'
        });
    
        // Add form fields
        form.append(`
            <div class="rows">
                <div class="c-6">
                    <div class="form-input-group">
                        <label for = "training_title_${index}">Training Title<span class="red">*</span></label>
                        <input type="text" name="training_title" id="training_title_${index}" class="form-input">
                        <span class="error" id="training_title_error_${index}"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for = "country_${index}">Country</label>
                        <input type="text" name="country" id="country_${index}" class="form-input">
                        <span class="error" id="country_error_${index}"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for = "topic_${index}">Topic<span class="red">*</span></label>
                        <input type="text" name="topic" id="topic_${index}" class="form-input">
                        <span class="error" id="topic_error_${index}"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for = "institution_name_${index}">Institution Name<span class="red">*</span></label>
                        <input type="text" name="institution_name" id="institution_name_${index}" class="form-input">
                        <span class="error" id="institution_name_error_${index}"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="start_date_${index}">Start Date</label>
                        <input type="date" name="start_date" id="start_date_${index}" class="form-input">
                        <span class="error" id="start_date_error_${index}"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="end_date_${index}">End Date</label>
                        <input type="date" name="end_date" id="end_date_${index}" class="form-input">
                        <span class="error" id="end_date_error_${index}"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for = "training_year_${index}">Training Year<span class="red">*</span></label>
                        <input type="integer" name="training_year" id="training_year_${index}" class="form-input">
                        <span class="error" id="training_year_error_${index}"></span>
                    </div>
                </div>
            </div>`);
        return form;
    }



    // Function to validate a single form
    function validateForm(index) {
        var isValid = true;

        // Get input fields by ID
        var title = $('#training_title_' + index);
        // var country = $('#country_' + index);
        var topic = $('#topic_' + index);
        var institution = $('#institution_name_' + index);
        var startdate = $('#start_date_' + index);
        var enddate = $('#end_date_' + index);
        var trainingyear = $('#training_year_' + index);

        

        // Validate required fields
        if (title.val() === '') {
            $('#training_title_error_' + index).text('This field is required');
            isValid = false;
        }
        // if (country.val() === '') {
        //     $('#country_error_' + index).text('This field is required');
        //     isValid = false;
        // }
        if (topic.val() === '') {
            $('#topic_error_' + index).text('This field is required');
            isValid = false;
        }
        if (institution.val() === '') {
            $('#institution_name_error_' + index).text('This field is required');
            isValid = false;
        }

        if (startdate.val() === '') {
            $('#start_date_error_' + index).text('This field is required');
            isValid = false;
        }
        
        if (enddate.val() === '') {
            $('#end_date_error_' + index).text('This field is required');
            isValid = false;
        }
        
        if (trainingyear.val() === '') {
            $('#training_year_error_' + index).text('This field is required');
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
            $('.training-form').not(':first').remove();
            toastr.success('Employee Training Details Added Successfully', 'Added!');
            formIndex = 2;
            return;
        }

        let formData = new FormData(formElement.get(0));
        formData.append('user', user);
        formElement.find('.error').text('');
        $.ajax({
            url: `${apiUrl}/hr/employee/training`,
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

    // Show Detals Ajax
    DetailsAjax('hr/employee/training');


    // Show Grid
    GridAjax('hr/employee/training');
});