function ShowEmployeeOrganizationDetails(data, startIndex) {
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
    // Get Transaction With / User Type 
    GetTransactionWith(3, '', '#with', 3, 'Ok');


    // Load Data on Hard Reload
    ReloadData('hr/employee/organization', ShowEmployeeOrganizationDetails);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#division");


    // Insert Ajax
    InsertAjax('hr/employee/organization', ShowEmployeeOrganizationDetails, 
        {
            user: { selector: '#user', attribute: 'data-id' },
            location: { selector: '#location', attribute: 'data-id' },
            department: { selector: '#department', attribute: 'data-id' },
            designation: { selector: '#designation', attribute: 'data-id' },
        }, 
        function() {
            $('#name').focus();
            $('#user').removeAttr('data-id');
            $('#location').removeAttr('data-id');
            $('#department').removeAttr('data-id');
            $('#designation').removeAttr('data-id');
            $('#previewImage').attr('src',`#`).hide();
        }
    );


    //Edit Ajax
    EditAjax('hr/employee/organization', EditFormInputValue);


    // Update Ajax
    UpdateAjax('hr/employee/organization', ShowEmployeeOrganizationDetails, 
        {
            location: { selector: '#updateLocation', attribute: 'data-id' },
            department: { selector: '#updateDepartment', attribute: 'data-id' },
            designation: { selector: '#updateDesignation', attribute: 'data-id' },
        }
    );
    

    // Delete Ajax
    DeleteAjax('hr/employee/organization', ShowEmployeeOrganizationDetails);


    // Pagination Ajax
    PaginationAjax(ShowEmployeeOrganizationDetails);


    // Search Ajax
    SearchAjax('hr/employee/organization', ShowEmployeeOrganizationDetails);


    // Show Detals Ajax
    DetailsAjax('hr/employee/organization');


    // Show Grid
    GridAjax('hr/employee/organization');


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.employee.id);
        $('#emp_id').val(res.employee.emp_id);
        $('#update_joining_date').val(res.employee.joining_date);
        $('#updateLocation').val(res.employee.location.upazila);
        $('#updateLocation').attr('data-id',res.employee.joining_location);
        $('#updateDepartment').val(res.employee.department.name);
        $('#updateDepartment').attr('data-id',res.employee.department.id);
        $('#updateDesignation').val(res.employee.designation.designation);
        $('#updateDesignation').attr('data-id',res.employee.designation.id);
    }
});