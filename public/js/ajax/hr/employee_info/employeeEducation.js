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
                    <td><img src="${apiUrl.replace('/api', '')}/storage/${item.image ? item.image : (item.gender == 'female' ? 'female.png' : 'male.png')}?${new Date().getTime()}" alt="" height="50px" width="50px"></td>
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
    

    // Add Modal Open Functionality
    AddModalFunctionality("#with", function () {
        $('#user').removeAttr('data-id');
        formIndex = 1;
        $('#formContainer').html('');
    });


    // Insert Ajax
    InsertAjax('hr/employee/education', ShowEmployeeEducationDetails, {user: { selector: '#user', attribute: 'data-id' }}, function() {
        $('#with').focus();
        $('#user').removeAttr('data-id');
        formIndex = 1;
        $('#formContainer').html('');
    }, 'Multi POST');


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


    // Show Detals Ajax
    DetailsAjax('hr/employee/education');


    // Show Grid
    GridAjax('hr/employee/education');


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.employee.id);
        $('#empId').val(res.employee.emp_id);
        $('#update_degree').val(res.employee.degree);
        // Create options dynamically
        $('#update_group').empty();
        $('#update_group').append(`
            <option value="Science" ${res.employee.group === 'Science' ? 'selected' : ''}>Science</option>
            <option value="Commerce" ${res.employee.group === 'Commerce' ? 'selected' : ''}>Commerce</option>
            <option value="Arts" ${res.employee.group === 'Arts' ? 'selected' : ''}>Arts</option>
        `);

        $('#update_institution').val(res.employee.institution);

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


    // Event delegation for dynamically created result dropdowns
    $(document).on('change', '.result-dropdown', function() {
        var index = $(this).attr('id').replace('result_', '');
        var result = $(this).val();
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
    });


    let formIndex = 1;

    // Add new form on button click
    $('#addEducation').on('click', function() {
        let form = `<div class="rows add-form">  
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for="degree_${formIndex}">Degree Title <span class="required" title="Required">*</span></label>
                                <input type="text" name="degree[]" id="degree_${formIndex}" class="form-input">
                                <span class="error" id="degree_${formIndex}_error"></span>
                            </div>
                        </div>
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for="group_${formIndex}">Group</label>
                                <select name="group[]" id="group_${formIndex}" class="group-dropdown">
                                    <option value="">Select</option>
                                    <option value="Science">Science</option>
                                    <option value="Commerce">Commerce</option>
                                    <option value="Arts">Arts</option>
                                </select>
                                <span class="error" id="group_${formIndex}_error"></span>
                            </div>
                        </div>
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for="institution_${formIndex}">Institution Name <span class="required" title="Required">*</span></label>
                                <input type="text" name="institution[]" id="institution_${formIndex}" class="form-input">
                                <span class="error" id="institution_${formIndex}_error"></span>
                            </div>
                        </div>
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for="result_${formIndex}">Result <span class="required" title="Required">*</span></label>
                                <select name="result[]" id="result_${formIndex}" class="result-dropdown">
                                    <option value="">Select</option>
                                    <option value="First Division/Class">First Division/Class</option>
                                    <option value="Second Division/Class">Second Division/Class</option>
                                    <option value="Third Division/Class">Third Division/Class</option>
                                    <option value="Grade">Grade</option>
                                </select>
                                <span class="error" id="result_${formIndex}_error"></span>
                            </div>
                        </div>
                        <div class="c-6 hidden" id="scale-group_${formIndex}">
                            <div class="form-input-group">
                                <label for="scale_${formIndex}">Scale </label>
                                <input type="decimal" step="0.01" name="scale[]" id="scale_${formIndex}" class="form-input">
                                <span class="error" id="scale_${formIndex}_error"></span>
                            </div>
                        </div>
                        <div class="c-6 hidden" id="cgpa-group_${formIndex}">
                            <div class="form-input-group">
                                <label for="cgpa_${formIndex}">CGPA </label>
                                <input type="decimal" step="0.01" name="cgpa[]" id="cgpa_${formIndex}" class="form-input">
                                <span class="error" id="cgpa_${formIndex}_error"></span>
                            </div>
                        </div>
                        <div class="c-6 hidden" id="marks-group_${formIndex}">
                            <div class="form-input-group">
                                <label for="marks_${formIndex}">Marks </label>
                                <input type="number" name="marks[]" id="marks_${formIndex}" class="form-input">
                                <span class="error" id="marks_${formIndex}_error"></span>
                            </div>
                        </div>
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for="batch_${formIndex}">Batch <span class="required" title="Required">*</span></label>
                                <input type="integer" name="batch[]" id="batch_${formIndex}" class="form-input">
                                <span class="error" id="batch_${formIndex}_error"></span>
                            </div>
                        </div>
                    </div>`;
 
        $('#formContainer').append(form);
        formIndex++;
    });
});