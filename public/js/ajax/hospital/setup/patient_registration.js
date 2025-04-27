function ShowPatientRegistration(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['reg_id','ptn_id','bed_list','doctor', 'sr_id','admission_by','added_at'],
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
        { label: 'Registration Id', key: 'reg_id' },
        { label: 'Patient Id', key: 'ptn_id' },
        { label: 'Bed list', key: 'bed_list' },
        { label: 'Doctor', key: 'doctor' },
        { label: 'SR', key: 'sr_id' },
        { label: 'Admission By', key: 'addmission_by' },
        { label: 'Added At', key: 'added_at' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('hospital/ptnregistration', ShowPatientRegistration);
    
    
    // Add Modal Open Functionality
    AddModalFunctionality("#title", function () {
        $('#bed_category').removeAttr('data-id');
        $('#bed_list').removeAttr('data-id');
        $('#doctor').removeAttr('data-id');
        $('#sr').removeAttr('data-id');
    });


    // Insert Ajax
    InsertAjax('hospital/ptnregistration', {bed_category: { selector: '#bed_category', attribute: 'data-id' }, bed_list: { selector: '#bed_list', attribute: 'data-id' }, doctor: { selector: '#doctor', attribute: 'data-id' }, sr: { selector: '#sr', attribute: 'data-id' }}, function() {
        $('#title').focus();
        $('#bed_category').removeAttr('data-id');
        $('#bed_list').removeAttr('data-id');
        $('#doctor').removeAttr('data-id');
        $('#sr').removeAttr('data-id');
        $('.togglePatientid').hide();
        $('#togglePhone').show();
    });


    // Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hospital/ptnregistration');
    

    // Delete Ajax
    DeleteAjax('hospital/ptnregistration');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateName').val(item.name);
        $('#updateFloor').val(item.floor);
        $('#updateName').focus();
    }; // End Method



    //  radio button controll on new and old patient
    $(document).on('change', '#newPatient', function () {
        if ($(this).is(':checked')) {
            $('.togglePatientid').hide();
        }
    })

    $(document).on('change', '#oldPatient', function () {
        if ($(this).is(':checked')) {
            $('.togglePatientid').show();
        }
    })
});





// //show data

// function ShowData() {
//     $.ajax({
//         url: '/api/hospital/ptnregistration',
//         method: 'GET',
//         success: function (res) {
//             let view = ``;
//             $.each(res.data.data, function (key, item) {
//                 view += `
//                 <tr>
//                     <td>${key + 1}</td>
//                     <td>${item.ptn_id}</td>
//                     <td>${item.reg_id}</td>
//                     <td>${item.bed_list}</td>
//                     <td>${item.doctor}</td>
//                     <td>${item.sr_id}</td>
//                     <td>${item.addmission_by}</td>
//                     <td>${item.added_at}</td>
                  
                    
                   
//                     <td>
//                         <div style="display: flex;gap:5px;">
//                             <button class="open-modal" data-modal-id="editModal" id="edit"
//                                     data-id="${item.id}"><i class="fas fa-edit"></i></button>
//                             <button data-id="${item.id}" id="delete"><i class="fas fa-trash"></i></button>
//                         </div>
//                     </td>
//                 </tr>
//             `
//                 $('.load-data table tbody').html(view);


//             });
//         }

//     });
// }


// $(document).ready(function () {
//     ShowData();

//     //radio button controll on new and old patient

//     $(document).on('change', '#newPatient', function () {
//         if ($(this).is(':checked')) {
//             $('#togglePatientid').hide();
//         }
//     })
//     $(document).on('change', '#oldPatient', function () {
//         if ($(this).is(':checked')) {
//             $('#togglePatientid').show();
//         }
//     })
 


//     //insert data 
//     $(document).on('submit', '#AddForm', function (e) {
//         e.preventDefault();
//         let fromData = new FormData(this);
//         $.ajax({
//             url: '/api/hospital/ptnregistration',
//             method: 'POST',
//             processData: false,
//             contentType: false,
//             data: fromData,
//             success: function (res) {
//                 console.log(res);
//                 if (res.status == true) {
//                     // $('#addModal').hide()
//                     $('#AddForm')[0].reset();
//                     ShowData();
//                 }

//             }
//         })
//     })
//     //insert data completed

//     //edit data

//     $(document).on('click', '#edit', function (e) {
//         let id = $(this).attr('data-id');
//         $.ajax({
//             url: '/api/hospital/ptnregistration/edit',
//             data: { id },
//             success: function (res) {
//                 console.log(res);
//                 $('#id').val(res.data.id);
//                 $('#ptn_id').val(res.data.ptn_id);
//                 $('#reg_id').val(res.data.reg_id);
//                 $('#bed_list').val(res.data.bed_list);
//                 $('#doctor').val(res.data.doctor);
//                 $('#sr_id').val(res.data.sr_id);
//                 $('#addmission_by').val(res.data.addmission_by);



//             }
//         });
//     })

//     //edit data completed


//     //update data


//     $(document).on('submit', '#EditForm', function (e) {
//         e.preventDefault();
//         let fromdata = new FormData(this);

//         $.ajax({
//             url: '/api/hospital/ptnregistration',
//             method: 'POST',
//             data: fromdata,
//             processData: false,
//             contentType: false,
//             success: function (res) {
//                 console.log(res);
//                 if (res.status == true) {

//                     // $('#AddForm')[0].reset();
//                     $('#editModal').hide();
//                     ShowData();
//                 }

//             }

//         })
//     })


//     //update data completed

//     //delete data
//     $(document).on('click', '#confirm', function () {
//         let id = $(this).attr('data-id');
//         $.ajax({
//             url: '/api/hospital/ptnregistration',
//             method: 'DELETE',
//             data: { id },
//             success: function (res) {
//                 if (res.status == true) {
//                     $('#deleteModal').hide();
//                     ShowData();
//                 }
//             }

//         })
//     })





// })




// function ShowPatientRegistration(data, startIndex) {
//     let tableRows = '';
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             tableRows += `
//                 <tr>
//                     <td>${startIndex + key + 1}</td>
//                     <td>${item.reg_id}</td>
//                     <td>${item.ptn_id}</td>
//                     <td>${item.bed_list}</td>
//                     <td>${item.doctor}</td>
//                     <td>${item.sr_id}</td>
//                     <td>${item.addmission_by}</td>
//                     <td>${item.added_at}</td>
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
//         $('.load-data .show-table tfoot').html('<tr><td colspan="8" style="text-align:center;">No Data Found</td></tr>')
//     }
// }; // End Function


