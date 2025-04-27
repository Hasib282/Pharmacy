function ShowPatients(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['ptn_id','name','email', 'phone','gender','address'],
        actions: (row) => `
                <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                        
                <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                `,
    });
}




$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Company Id', key: 'ptn_id' },
        { label: 'Name', key: 'name' },
        { label: 'Phone', key: 'phone' },
        { label: 'Email', key: 'email' },
        { label: 'Gender', key: 'gender'},
        { label: 'Address', key: 'address' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('hospital/users/patients', ShowPatients);
    
    
    // Add Modal Open Functionality
    AddModalFunctionality("#title");


    // Insert Ajax
    // InsertAjax('hospital/users/patients', {}, function() {
    //     $('#title').focus();
    // });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hospital/users/patients');

    
    // Delete Ajax
    DeleteAjax('hospital/users/patients', ShowPatients);


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateName').val(item.name);
        $('#updateTitle').val(item.title);
        $('#updatePhone').val(item.phone);
        $('#updateAddress').val(item.address);
        $('#updateEmail').val(item.email);

        $('#updateAge_years').val(item.age_years);
        $('#updateAge_months').val(item.age_months);
        $('#updateAge_days').val(item.age_days);
        
        $('#updateGender').val(item.gender);
        $('#updateNationality').val(item.nationality);
        $('#updateReligion').val(item.religion);
        
        $('#updateTitle').focus();
    }; // End Method
});


//Show patient start
// function ShowPatients(data, startIndex) {
//     let tableRows = '';
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             tableRows += `
//                 <tr>
//                     <td>${startIndex + key + 1}</td>
//                     <td>${item.ptn_id}</td>
//                     <td>${item.title}</td>
//                     <td>${item.name}</td>
//                     <td>${item.phone}</td>
//                     <td>${item.email}</td>
//                     <td>${item.gender}</td>
//                     <td>${item.address}</td>
//                     <td>
//                         <div style="display: flex;gap:5px;">
                            
//                             <button class="open-modal" data-modal-id="editModal" id="edit" data-id="${item.id}"><i class="fas fa-edit"></i></button>
                        
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
//         $('.load-data .show-table tfoot').html('<tr><td colspan="9" style="text-align:center;">No Data Found</td></tr>')
//     }
// }; // End Function

//      // Update Ajuax
//      $(document).on('submit','#EditForm', function (e) {
//          e.preventDefault();
// //         let formData = new FormData(this);

//         $.ajax({
//             url: "/api/hospital/setup/patients",
//             method: 'POST',
//             processData: false,
//             contentType: false,
//             cache: false,
//             data: formData,
//             beforeSend:function() {
//                 $(document).find('span.error').text('');  
//             },
//             success: function (res) {
//                 console.log(res);
                
//                 if (res.status) {
//                     $('#editModal').hide();
//                     $('#EditForm')[0].reset();
//                     ShowPatients();
//                     // $('.table').load(location.href + ' .table');
//                 }
//             },

//             error: function (err) {
//                 console.log(err);

//                 let error = err.responseJSON;
//                 $.each(error.errors, function (key, value) {
//                     $('#update_' + key + "_error").text(value);
//                 });
//             }
//         })


//     });