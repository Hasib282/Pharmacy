function ShowDoctors(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['title','name','degree','email', 'phone','chamber','specialization'],
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
        { label: 'Company Name', key: 'title' },
        { label: 'Name', key: 'name' },
        { label: 'Degree', key: 'degree' },
        { label: 'Email', key: 'email' },
        { label: 'Phone', key: 'phone' },
        { label: 'Chamber', key: 'chamber' },
        { label: 'Spacializatio', key: 'spacialization' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('hospital/users/doctors', ShowDoctors);
    
    
    // Add Modal Open Functionality
    AddModalFunctionality("#title");


    // Insert Ajax
    InsertAjax('hospital/users/doctors', {specialization: { selector: '#specialization', attribute: 'data-id' }, marketing_head: { selector: '#marketing_head', attribute: 'data-id' }}, function() {
        $('#title').focus();
        $('#specialization').removeAttr('data-id');
        $('#marketing_head').removeAttr('data-id');
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hospital/users/doctors', {specialization: { selector: '#updateSpecialization', attribute: 'data-id' }, marketing_head: { selector: '#updateMarketing_Head', attribute: 'data-id' }});
    

    // Delete Ajax
    DeleteAjax('hospital/users/doctors');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateName').val(item.name);
        $('#updateFloor').val(item.floor);
        $('#updateTitle').focus();
    }; // End Method
});


// function ShowData(){
//     $.ajax({
//         url: '/api/hospital/users/doctors',
//         method:'GET',
//         success: function(res){
//             console.log(res);
//             let view =``;
//             $.each(res.data.data, function(key,item){
//                 view+=`
//                 <tr>
//                     <td>${ key + 1}</td>
//                     <td>${item.title}</td>
//                     <td>${item.name}</td>
//                     <td>${item.degree}</td>
//                     <td>${item.email}</td>
//                     <td>${item.phone}</td>
//                     <td>${item.chamber}</td>
                    
                    
                   
//                     <td>
//                         <div style="display: flex;gap:5px;">
//                             <button class="open-modal" data-modal-id="editModal" id="edit"
//                                     data-id="${item.id}"><i class="fas fa-edit"></i></button>
//                             <button data-id="${item.id}" id="delete"><i class="fas fa-trash"></i></button>
//                         </div>
//                     </td>
//                 </tr>
//             `
//             $('.load-data table tbody').html(view);
            
            
//             });
//         }

//     });
// }



// $(document).ready(function(){
//     ShowData();
    
//     //insert data 
//     $(document).on('submit','#AddForm',function(e){
//         e.preventDefault();
//         let fromData = new FormData(this);
//         $.ajax({
//             url:'/api/hospital/users/doctors',
//             method:'POST',
//             processData:false,
//             contentType:false,
//             data:fromData,
//             success:function(res){
//                     console.log(res);
//                     if(res.status == true){
//                         // $('#addModal').hide()
//                         $('#AddForm')[0].reset();
//                         ShowData();
//                     }
                    
//             }
//         })
//     })

//     //edit data

//     $(document).on('click','#edit',function(e){
//         let id = $(this).attr('data-id');
//         $.ajax({
//             url: '/api/hospital/users/doctors/edit',
//             data: { id },
//             success: function (res) {
//                     console.log(res);
//                     $('#id').val(res.data.id);
//                     $('#updatetitle').val(res.data.title);
//                     $('#updatename').val(res.data.name);
//                     $('#updatedegree').val(res.data.degree);
//                     $('#updateemail').val(res.data.email);
//                     $('#updatephone').val(res.data.phone);
//                     $('#updatechamber').val(res.data.chamber);
//                     $('#updatemarketing_head').val(res.data.marketing_head);
            

//             }
//         });
//     })


//     //update date
//     $(document).on('submit','#EditForm',function(e){
//         e.preventDefault();
//         let fromdata = new FormData(this);

//         $.ajax({
//             url :'/api/hospital/users/doctors',
//             method:'POST',
//             data: fromdata,
//             processData:false,
//             contentType:false,
//             success:function(res){
//                 console.log(res);
//                 if(res.status == true){
                    
//                     $('#AddForm')[0].reset();
//                     $('#editModal').hide();
//                     ShowData();
//                 }
                
//         }

//         })
//     })

//     //delete
//     $(document).on('click','#confirm',function(){
//         let id = $(this).attr('data-id');
//         $.ajax({
//             url:'/api/hospital/users/doctors',
//             method:'DELETE',
//             data : {id},
//             success: function(res){
//                 if(res.status == true){
//                     $('#deleteModal').hide();
//                     ShowData();
//                 }
//             }

//         })
//     })


 
// })






// function ShowDoctors(data, startIndex) {
//     let tableRows = '';
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             tableRows += `
//                 <tr>
//                     <td>${startIndex + key + 1}</td>
//                     <td>${item.title}</td>
//                     <td>${item.name}</td>
//                     <td>${item.degree}</td>
//                     <td>${item.email}</td>
//                     <td>${item.phone}</td>
//                     <td>${item.chamber}</td>
//                     <td>${item.spacialization}</td>
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

