// function ShowEmployeeOrganizationDetails(data, startIndex) {
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
//                             `<button class="btn btn-success btn-sm toggle-status" data-id="${item.id}"
//                                 data-table="Inv_Client_Info" data-status="${item.status}" data-target=".client">Active</button>`
//                             :
//                             `<button class="btn btn-danger btn-sm toggle-status" data-id="${item.id}" data-table="Inv_Client_Info"
//                                 data-status="${item.status}" data-target=".client">Inactive</button>`
//                         }
//                     </td>
//                     <td>
//                         <div style="display: flex;gap:5px;">
//                             <button class="btn-show" id="showGrid" data-id="${item.user_id}">Show <i class="fa fa-chevron-circle-right"></i></button>
//                             <button class="open-modal" data-modal-id="detailsModal" id="details"
//                                 data-id="${item.user_id}"><i class="fa-solid fa-circle-info"></i></button>
//                         </div>
//                     </td>
//                 </tr>
//                 <tr id = "grid${item.user_id}" style = "display:none"></tr>
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

function ShowEmployeeOrganizationDetails(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['user_id','user_name','withs.tran_with_name',{key:'dob', type: 'date'},'gender','user_email', 'user_phone','address',{key:'image', type: 'image'},{key:'status', type: 'status'}],
        actions: (row) => `
                <button class="btn-show" id="showGrid" data-id="${row.user_id}">Show <i class="fa fa-chevron-circle-right"></i></button>
                
                <button class="open-modal" data-modal-id="detailsModal" id="details" data-id="${row.user_id}"><i class="fa-solid fa-circle-info"></i></button>
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
    GetTransactionWith(3, '', '#with', 3, 'Ok');


    // Load Data on Hard Reload
    ReloadData('hr/employee/organization', ShowEmployeeOrganizationDetails);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#division");


    // Insert Ajax
    InsertAjax('hr/employee/organization', 
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
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hr/employee/organization', 
        {
            location: { selector: '#updateLocation', attribute: 'data-id' },
            department: { selector: '#updateDepartment', attribute: 'data-id' },
            designation: { selector: '#updateDesignation', attribute: 'data-id' },
        }
    );
    

    // Delete Ajax
    DeleteAjax('hr/employee/organization');


    // Show Detals Ajax
    DetailsAjax('hr/employee/organization');


    // Show Grid
    GridAjax('hr/employee/organization');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#emp_id').val(item.emp_id);
        $('#update_joining_date').val(item.joining_date);
        $('#updateLocation').val(item.location.upazila);
        $('#updateLocation').attr('data-id',item.joining_location);
        $('#updateDepartment').val(item.department.name);
        $('#updateDepartment').attr('data-id',item.department.id);
        $('#updateDesignation').val(item.designation.designation);
        $('#updateDesignation').attr('data-id',item.designation.id);
    }
});