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
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['user_id','user_name','withs.tran_with_name',{key:'dob', type: 'date'},'gender','user_email', 'user_phone','address',{key:'image', type: 'image'},{key:'status', type: 'status'}],
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
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Id', key: 'user_id' },
        { label: 'Name', key: 'user_name' },
        { label: 'Employee Type', key: 'withs.tran_with_name' },
        { label: 'DOB', key: 'dob', type:"date" },
        { label: 'Gender', type:"select", key: 'gender', method:"custom", options:['Male','Female','Others'] },
        { label: 'Email', key: 'user_email' },
        { label: 'Phone', key: 'user_phone' },
        { label: 'Address', key: 'address' },
        { label: 'Image' },
        { label: 'Status', status: [{key:1, label:'Active' }, { key:0, label:'Inactive'}] },
        { label: 'Action', type: 'button' }
    ]);


    // Get Transaction With / User Type 
    GetTransactionWith(3, '', 3, 'Ok');


    // Load Data on Hard Reload
    ReloadData('hr/employee/personal', ShowEmployeePersonalDetails);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#name");


    // Insert Ajax
    InsertAjax('hr/employee/personal', {location: { selector: '#location', attribute: 'data-id' }, company: { selector: '#company', attribute: 'data-id' }}, function() {
        $('#name').focus();
        $('#location').removeAttr('data-id');
        $('#previewImage').attr('src',`#`).hide();
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hr/employee/personal', {location: { selector: '#updateLocation', attribute: 'data-id' }});
    

    // Delete Ajax
    DeleteAjax('hr/employee/personal');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#employee_id').val(item.employee_id);
        $('#update_name').val(item.name);
        $('#update_name').focus();
        $('#update_fathers_name').val(item.fathers_name);
        $('#update_mothers_name').val(item.mothers_name);
        $('#update_dob').val(item.dob);

        // Create options dynamically
        $('#update_gender').empty();
        $('#update_gender').append(`<option value="Male" ${item.gender === 'Male' ? 'selected' : ''}>Male</option>
                                    <option value="Female" ${item.gender === 'Female' ? 'selected' : ''}>Female</option>
                                    <option value="Others" ${item.gender === 'Others' ? 'selected' : ''}>Others</option>`);

        $('#update_religion').empty();
        $('#update_religion').append(`<option value="Islam" ${item.religion === 'Islam' ? 'selected' : ''}>Islam</option>
                                    <option value="Hinduism" ${item.religion === 'Hinduism' ? 'selected' : ''}>Hinduism</option>
                                    <option value="Christianity" ${item.religion === 'Christianity' ? 'selected' : ''}>Christianity</option>
                                    <option value="Buddhism" ${item.religion === 'Buddhism' ? 'selected' : ''}>Buddhism</option>
                                    <option value="Judaism" ${item.religion === 'Judaism' ? 'selected' : ''}>Judaism</option>`);

        $('#update_marital_status').empty();
        $('#update_marital_status').append(`<option value="Married" ${item.marital_status === 'Married' ? 'selected' : ''}>Married</option>
                                            <option value="Unmarried" ${item.marital_status === 'Unmarried' ? 'selected' : ''}>Unmarried</option>`);

        $('#update_nationality').val(item.nationality);
        $('#update_nid_no').val(item.nid_no);
        $('#update_phn_no').val(item.phn_no);
        $('#update_blood_group').empty();
        $('#update_blood_group').append(`<option value="A+" ${item.blood_group === 'A+' ? 'selected' : ''}>A+</option>
                                    <option value="A-" ${item.blood_group === 'A-' ? 'selected' : ''}>A-</option>
                                    <option value="B+" ${item.blood_group === 'B+' ? 'selected' : ''}>B+</option>
                                    <option value="B-" ${item.blood_group === 'B-' ? 'selected' : ''}>B-</option>
                                    <option value="O+" ${item.blood_group === 'O+' ? 'selected' : ''}>O+</option>
                                    <option value="O-" ${item.blood_group === 'O-' ? 'selected' : ''}>O-</option>
                                    <option value="AB+" ${item.blood_group === 'AB+' ? 'selected' : ''}>AB+</option>
                                    <option value="AB-" ${item.blood_group === 'AB-' ? 'selected' : ''}>AB-</option>`);

        $('#update_email').val(item.email);

        // Create options dynamically
        $('#updateDivision').empty();
        $('#updateDivision').append(`<option value="Dhaka" ${item.location.division === 'Dhaka' ? 'selected' : ''}>Dhaka</option>
            <option value="Chittagong" ${item.location.division === 'Chittagong' ? 'selected' : ''}>Chittagong</option>
            <option value="Rajshahi" ${item.location.division === 'Rajshahi' ? 'selected' : ''}>Rajshahi</option>
            <option value="Khulna" ${item.location.division === 'Khulna' ? 'selected' : ''}>Khulna</option>
            <option value="Sylhet" ${item.location.division === 'Sylhet' ? 'selected' : ''}>Sylhet</option>
            <option value="Barisal" ${item.location.division === 'Barisal' ? 'selected' : ''}>Barisal</option>
            <option value="Rangpur" ${item.location.division === 'Rangpur' ? 'selected' : ''}>Rangpur</option>
            <option value="Mymensingh" ${item.location.division === 'Mymensingh' ? 'selected' : ''}>Mymensingh</option>`);

        $('#updateLocation').val(item.location.upazila);
        $('#updateLocation').attr('data-id',item.location_id);

        // Create options dynamically
        $('#update_type').empty();
        $.each(res.tranwith, function (key, withs) {
            $('#update_type').append(`<option value="${withs.id}" ${item.tran_user_type === withs.id ? 'selected' : ''}>${withs.tran_with_name}</option>`);
        });

        $('#update_address').val(item.address);
        $('#update_password').val(item.password);
        $('#updatePreviewImage').attr('src',`${apiUrl.replace('/api', '')}/storage/${item.image ? item.image : (item.gender == 'female' ? 'female.png' : 'male.png')}?${new Date().getTime()} `).show();
    }

    
    // Show Detals Ajax
    DetailsAjax('hr/employee/personal');


    // Get Store 
    GetSelectInputList('admin/stores/get', function (res) {
        CreateSelectOptions('#store', 'Select Store', res.data, 'store_name');
        CreateSelectOptions('#updateStore', 'Select Store', res.data, 'store_name');
    })
});