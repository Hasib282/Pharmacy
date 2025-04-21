// function ShowEmployeePersonalDetails(data, startIndex) {
//     let tableRows = '';
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             tableRows += `
//                 <tr>
//                     <td>${startIndex + key + 1}</td>
//                     <td>${item.user_id}</td>
//                     <td>${item.user_name}</td>
//                     <td>${item.dob}</td>
//                     <td>${item.gender}</td>
//                     <td>${item.user_email}</td>
//                     <td>${item.user_phone}</td>
//                     <td>${item.address}</td>
//                     <td><img src="${apiUrl.replace('/api', '')}/storage/${item.image ? item.image : (item.gender == 'female' ? 'female.png' : 'male.png')}?${new Date().getTime()}" alt="" height="50px" width="50px"></td>
//                     <td>
//                         ${item.status == 1 ?
//                             `<button class="btn btn-success btn-sm toggle-status" data-id="{{$item.id}}" data-table="Inv_Client_Info" data-status="${item.status}" data-target=".client">Active</button>`
//                         :
//                             `<button class="btn btn-danger btn-sm toggle-status" data-id="{{$item.id}}" data-table="Inv_Client_Info" data-status="${item.status}" data-target=".client">Inactive</button>`
//                         }
//                     </td>
//                     <td>
//                         <div style="display: flex;gap:5px;">
//                             <button class="open-modal" data-modal-id="detailsModal" id="details"
//                                 data-id="${item.user_id}"><i class="fa-solid fa-circle-info"></i></button>
                            
//                             <button class="open-modal" data-modal-id="editModal" id="edit"
//                                 data-id="${item.user_id}"><i class="fas fa-edit"></i></button>
                            
//                             <button data-id="${item.id}" id="delete"><i class="fas fa-trash"></i></button>
                            
//                         </div>
//                     </td>
//                 </tr>
//             `;
//         });

//         // Inject the generated rows into the table body
//         $('.load-data .show-table tbody').html(tableRows);
//         $('.load-data .show-table tfoot').html('')
//     }
//     else{
//         $('.load-data .show-table tbody').html('');
//         $('.load-data .show-table tfoot').html('<tr><td colspan="11" style="text-align:center;">No Data Found</td></tr>')
//     }
// }; // End Function

function ShowEmployeePersonalDetails(res) {
    new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['user_id','user_name','withs.tranwith','dob','gender','user_email', 'user_phone','address','image','status'],
        actions: (row) => `
                <button class="open-modal" data-modal-id="detailsModal" id="details" data-id="${row.user_id}"><i class="fa-solid fa-circle-info"></i></button>
                            
                <button class="open-modal" data-modal-id="editModal" id="edit" data-id="${row.user_id}"><i class="fas fa-edit"></i></button>
                            
                <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                `,
    });
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'select', options: [15, 30, 50, 100, 500] },
        { label: 'Company Id', key: 'company_id' },
        { label: 'Company Name', key: 'name' },
        { label: 'Permission', key: 'permission' },
        { label: 'Action', type: 'button' }
    ]);


    // Get Transaction With / User Type 
    GetTransactionWith(3, '', '#type', 3, 'Ok');


    // Load Data on Hard Reload
    ReloadData('hr/employee/personal', ShowEmployeePersonalDetails);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#name");


    // Insert Ajax
    InsertAjax('hr/employee/personal', ShowEmployeePersonalDetails, {location: { selector: '#location', attribute: 'data-id' }, company: { selector: '#company', attribute: 'data-id' }, store: { selector: '#store', attribute: 'data-id' }}, function() {
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
    // PaginationAjax(ShowEmployeePersonalDetails);


    // Search Ajax
    // SearchAjax('hr/employee/personal', ShowEmployeePersonalDetails, {  });


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.data.id);
        $('#employee_id').val(res.data.employee_id);
        $('#update_name').val(res.data.name);
        $('#update_name').focus();
        $('#update_fathers_name').val(res.data.fathers_name);
        $('#update_mothers_name').val(res.data.mothers_name);
        $('#update_dob').val(res.data.dob);

        // Create options dynamically
        $('#update_gender').empty();
        $('#update_gender').append(`<option value="Male" ${res.data.gender === 'Male' ? 'selected' : ''}>Male</option>
                                    <option value="Female" ${res.data.gender === 'Female' ? 'selected' : ''}>Female</option>
                                    <option value="Others" ${res.data.gender === 'Others' ? 'selected' : ''}>Others</option>`);

        $('#update_religion').empty();
        $('#update_religion').append(`<option value="Islam" ${res.data.religion === 'Islam' ? 'selected' : ''}>Islam</option>
                                    <option value="Hinduism" ${res.data.religion === 'Hinduism' ? 'selected' : ''}>Hinduism</option>
                                    <option value="Christianity" ${res.data.religion === 'Christianity' ? 'selected' : ''}>Christianity</option>
                                    <option value="Buddhism" ${res.data.religion === 'Buddhism' ? 'selected' : ''}>Buddhism</option>
                                    <option value="Judaism" ${res.data.religion === 'Judaism' ? 'selected' : ''}>Judaism</option>`);

        $('#update_marital_status').empty();
        $('#update_marital_status').append(`<option value="Married" ${res.data.marital_status === 'Married' ? 'selected' : ''}>Married</option>
                                            <option value="Unmarried" ${res.data.marital_status === 'Unmarried' ? 'selected' : ''}>Unmarried</option>`);

        $('#update_nationality').val(res.data.nationality);
        $('#update_nid_no').val(res.data.nid_no);
        $('#update_phn_no').val(res.data.phn_no);
        $('#update_blood_group').empty();
        $('#update_blood_group').append(`<option value="A+" ${res.data.blood_group === 'A+' ? 'selected' : ''}>A+</option>
                                    <option value="A-" ${res.data.blood_group === 'A-' ? 'selected' : ''}>A-</option>
                                    <option value="B+" ${res.data.blood_group === 'B+' ? 'selected' : ''}>B+</option>
                                    <option value="B-" ${res.data.blood_group === 'B-' ? 'selected' : ''}>B-</option>
                                    <option value="O+" ${res.data.blood_group === 'O+' ? 'selected' : ''}>O+</option>
                                    <option value="O-" ${res.data.blood_group === 'O-' ? 'selected' : ''}>O-</option>
                                    <option value="AB+" ${res.data.blood_group === 'AB+' ? 'selected' : ''}>AB+</option>
                                    <option value="AB-" ${res.data.blood_group === 'AB-' ? 'selected' : ''}>AB-</option>`);

        $('#update_email').val(res.data.email);

        // Create options dynamically
        $('#updateDivision').empty();
        $('#updateDivision').append(`<option value="Dhaka" ${res.data.location.division === 'Dhaka' ? 'selected' : ''}>Dhaka</option>
            <option value="Chittagong" ${res.data.location.division === 'Chittagong' ? 'selected' : ''}>Chittagong</option>
            <option value="Rajshahi" ${res.data.location.division === 'Rajshahi' ? 'selected' : ''}>Rajshahi</option>
            <option value="Khulna" ${res.data.location.division === 'Khulna' ? 'selected' : ''}>Khulna</option>
            <option value="Sylhet" ${res.data.location.division === 'Sylhet' ? 'selected' : ''}>Sylhet</option>
            <option value="Barisal" ${res.data.location.division === 'Barisal' ? 'selected' : ''}>Barisal</option>
            <option value="Rangpur" ${res.data.location.division === 'Rangpur' ? 'selected' : ''}>Rangpur</option>
            <option value="Mymensingh" ${res.data.location.division === 'Mymensingh' ? 'selected' : ''}>Mymensingh</option>`);

        $('#updateLocation').val(res.data.location.upazila);
        $('#updateLocation').attr('data-id',res.data.location_id);

        // Create options dynamically
        $('#update_type').empty();
        $.each(res.tranwith, function (key, withs) {
            $('#update_type').append(`<option value="${withs.id}" ${res.data.tran_user_type === withs.id ? 'selected' : ''}>${withs.tran_with_name}</option>`);
        });

        $('#update_address').val(res.data.address);
        $('#update_password').val(res.data.password);
        $('#updatePreviewImage').attr('src',`${apiUrl.replace('/api', '')}/storage/${res.data.image ? res.data.image : (res.data.gender == 'female' ? 'female.png' : 'male.png')}?${new Date().getTime()} `).show();
    }

    
    // Show Detals Ajax
    DetailsAjax('hr/employee/personal');
});