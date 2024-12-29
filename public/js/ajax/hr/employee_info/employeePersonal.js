function ShowEmployeePersonalDetails(data, startIndex) {
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
                            `<button class="btn btn-success btn-sm toggle-status" data-id="{{$item.id}}" data-table="Inv_Client_Info" data-status="${item.status}" data-target=".client">Active</button>`
                        :
                            `<button class="btn btn-danger btn-sm toggle-status" data-id="{{$item.id}}" data-table="Inv_Client_Info" data-status="${item.status}" data-target=".client">Inactive</button>`
                        }
                    </td>
                    <td>
                        <div style="display: flex;gap:5px;">
                            <button class="open-modal" data-modal-id="detailsModal" id="details"
                                data-id="${item.user_id}"><i class="fa-solid fa-circle-info"></i></button>
                            
                            <button class="open-modal" data-modal-id="editModal" id="edit"
                                data-id="${item.user_id}"><i class="fas fa-edit"></i></button>
                            
                            <button data-id="${item.id}" id="delete"><i class="fas fa-trash"></i></button>
                            
                        </div>
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
        url: `${apiUrl}/hr/employee/personal`,
        method: "GET",
        success: function (res) {
            CreateSelectOptions('#type', 'Select Employee Type', res.tranwith, null, 'tran_with_name');
        },
    });


    // Load Data on Hard Reload
    ReloadData('hr/employee/personal', ShowEmployeePersonalDetails);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#name");


    // Insert Ajax
    InsertAjax('hr/employee/personal', ShowEmployeePersonalDetails, {location: { selector: '#location', attribute: 'data-id' }, company: { selector: '#company', attribute: 'data-id' }}, function() {
        $('#name').focus();
        $('#location').removeAttr('data-id');
        $('#previewImage').attr('src',`#`).hide();
    });


    //Edit Ajax
    EditAjax('hr/employee/personal', EditFormInputValue);


    // Update Ajax
    UpdateAjax('hr/employee/personal', ShowEmployeePersonalDetails, {location: { selector: '#updateLocation', attribute: 'data-id' }});
    

    // Delete Ajax
    DeleteAjax('hr/employee/personal', ShowEmployeePersonalDetails);


    // Pagination Ajax
    PaginationAjax(ShowEmployeePersonalDetails);


    // Search Ajax
    SearchAjax('hr/employee/personal', ShowEmployeePersonalDetails, {  });


    // Additional Edit Functionality
    function EditFormInputValue(res){
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
        $('#updatePreviewImage').attr('src',`${apiUrl.replace('/api', '')}/storage/${res.employee.image ? res.employee.image : (res.employee.gender == 'female' ? 'female.png' : 'male.png')}?${new Date().getTime()} `).show();
    }








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



    // Show Detals Ajax
    DetailsAjax('hr/employee/personal');
});