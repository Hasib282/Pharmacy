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
                            <button class="btn-show open-modal emp_organizationDetail" data-modal-id="emp_organizationDetail"
                                data-id="${item.user_id}">Show <i class="fa fa-chevron-circle-right"></i></button>
                            <button class="open-modal" data-modal-id="detailsModal" id="details"
                                data-id="${item.user_id}"><i class="fa-solid fa-circle-info"></i></button>
                        </div>
                    </td>
                </tr>
                <tr id = "detailsorganization${item.user_id}" style = "display:none">
                    <td colspan = "11">

                    </td>
                </tr>
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
        url: `${apiUrl}/hr/employee/organization`,
        method: "GET",
        success: function (res) {
            CreateSelectOptions('#with', 'Select Employee Type', res.tranwith, null, 'tran_with_name');
        },
    });


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
    SearchAjax('hr/employee/organization', ShowEmployeeOrganizationDetails, {  });


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.employee.id);
        $('#emp_id').val(res.employee.emp_id);
        $('#update_joining_date').val(res.employee.joining_date);
        $('#updateLocation').val(res.employee.location.upazila);
        $('#updateLocation').attr('data-id',res.employee.joining_location);
        $('#updateDepartment').val(res.employee.department.dept_name);
        $('#updateDepartment').attr('data-id',res.employee.department);
        $('#updateDesignation').val(res.employee.designation.designation);
        $('#updateDesignation').attr('data-id',res.employee.designation);
    }







    ///////////// ------------------ Show Organization Details Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#details', function (e) {
        let modal = $(this).attr('data-modal-id');
        let id = $(this).attr('data-id');
        $.ajax({
            url: '/hr/employee/organization/details',
            method: 'GET',
            data: { id },
            success: function (res) {
                $("#"+ modal).show();
                $('.employeeorganizationdetails').html(res.data)
            }
        });
    });

    // Show Employee Details List Toggle Functionality
    $(document).on('click', '.employeeorganizationdetails li', function(e){
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
            if($('.organization').is(':visible')){
                $('.organization').hide()
            }
            else{
                $('.organization').show();
            }
        }
    });




    ///////////// ------------------ Show Organization Grid Ajax Part Start ---------------- /////////////////////////////
    // Show Button functionality
    $(document).on('click', '.emp_organizationDetail', function (e) {
        let id = $(this).attr('data-id');
        let $detailsRow = $(`#detailsorganization${id}`);
        let $button = $(this); // Reference to the clicked button

        if ($detailsRow.is(':visible')) {
            // If the row is visible, hide it, change button text to "Show", and remove caret rotation
            $detailsRow.hide();
            $button.find('.fa-chevron-circle-right').removeClass('rotate');
        } else {
            // Fetch data and show it, then change button text to "Hide", and add caret rotation
            $.ajax({
                url: '/hr/employee/organization/grid',
                method: 'GET',
                data: { id },
                success: function (res) {
                    $detailsRow.find('td').html(res.data);
                    $detailsRow.show();
                    $button.find('.fa-chevron-circle-right').addClass('rotate');
                }
            });
        }
    });
});