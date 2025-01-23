function ShowEmployeeExperienceDetails(data, startIndex) {
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
                                data-table="Inv_Client_Info" data-status="${item.status}" data-target=".client">Active</button>`
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
        url: `${apiUrl}/hr/employee/experience`,
        method: "GET",
        success: function (res) {
            CreateSelectOptions('#with', 'Select Employee Type', res.tranwith, null, 'tran_with_name');
        },
    });

    // Load Data on Hard Reload
    ReloadData('hr/employee/experience', ShowEmployeeExperienceDetails);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#with", function () {
        $('#user').removeAttr('data-id');
        formIndex = 1;
        $('#formContainer').html('');
    });


    // Insert Ajax
    InsertAjax('hr/employee/experience', ShowEmployeeExperienceDetails, {user: { selector: '#user', attribute: 'data-id' }}, function() {
        $('#with').focus();
        $('#user').removeAttr('data-id');
        formIndex = 1;
        $('#formContainer').html('');
    }, 'Multi POST');


    //Edit Ajax
    EditAjax('hr/employee/experience', EditFormInputValue);


    // Update Ajax
    UpdateAjax('hr/employee/experience', ShowEmployeeExperienceDetails);
    

    // Delete Ajax
    DeleteAjax('hr/employee/experience', ShowEmployeeExperienceDetails);


    // Pagination Ajax
    PaginationAjax(ShowEmployeeExperienceDetails);


    // Search Ajax
    SearchAjax('hr/employee/experience', ShowEmployeeExperienceDetails);
    
    
    // Show Detals Ajax
    DetailsAjax('hr/employee/experience');


    // Show Grid
    GridAjax('hr/employee/experience');


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.employee.id);
        $('#empId').val(res.employee.emp_id);
        $('#update_company_name').val(res.employee.company_name);
        $('#update_department').val(res.employee.department);
        $('#update_designation').val(res.employee.designation);
        $('#update_company_location').val(res.employee.company_location);
        $('#update_start_date').val(res.employee.start_date);
        $('#update_end_date').val(res.employee.end_date);
    }


    var formIndex = 1;

    $('#addExperience').click(function() {
        var form = `<div class="rows add-form"> 
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for = "company_name_${formIndex}">Company Name<span class="red">*</span></label>
                                <input type="text" name="company_name[]" id="company_name_${formIndex}" class="form-input">
                                <span class="error" id="company_name_${formIndex}_error"></span>
                            </div>
                        </div>
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for = "department_${formIndex}">Department<span class="red">*</span></label>
                                <input type="text" name="department[]" id="department_${formIndex}" class="form-input">
                                <span class="error" id="department_${formIndex}_error"></span>
                            </div>
                        </div>
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for = "designation_${formIndex}">Designation<span class="red">*</span></label>
                                <input type="text" name="designation[]" id="designation_${formIndex}" class="form-input">
                                <span class="error" id="designation_${formIndex}_error"></span>
                            </div>
                        </div>
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for = "company_location_${formIndex}">Company Address<span class="red">*</span></label>
                                <input type="text" name="company_location[]" id="company_location_${formIndex}"  class="form-input">
                                <span class="error" id="company_location_${formIndex}_error"></span>
                            </div>
                        </div>
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for="start_date_${formIndex}">Start Date</label>
                                <input type="date" name="start_date[]" id="start_date_${formIndex}" class="form-input">
                                <span class="error" id="start_date_${formIndex}_error"></span>
                            </div>
                        </div>
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for="end_date_${formIndex}">End Date</label>
                                <input type="date" name="end_date[]" id="end_date_${formIndex}" class="form-input">
                                <span class="error" id="end_date_${formIndex}_error"></span>
                            </div>
                        </div>
                    </div>`;
        
        $('#formContainer').append(form);
        formIndex++;
    });
});
