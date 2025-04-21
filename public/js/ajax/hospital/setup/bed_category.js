// function ShowBedCategory(data, startIndex) {
//     let tableRows = '';
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             tableRows += `
//                 <tr>
//                     <td>${startIndex + key + 1}</td>
//                     <td>${item.name}</td>
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

function ShowBedCategory(res) {
    new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['name'],
        actions: (row) => `
                <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                        
                <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                `,
    });
}



// Additional Edit Functionality
function EditFormInputValue(res){
    $('#id').val(res.data.id);
    $('#updateName').val(res.data.name);
    $('#updateName').focus();
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


    SingleInputDataCrudeAjax('hospital/setup/bedcategory', ShowBedCategory);
});



// $(document).ready(function () {
//     function Showbedcategory(){
//         $.ajax({
//             url: '/api/hospital/setup/bedcategory',
//             success: function(res){
//                 console.log(res)
//                 let view = "";
//                 $.each(res.data.data , function(key, item){
//                     view += `<tr>
//                                 <td>${key + 1} </td>
//                                 <td>${item.name} </td>
//                                 <td>
//                                    <div style="display: flex;gap:5px;">
                                
//                                         <button data-bs-toggle="modal" data-bs-target="#editModal" id="edit" data-id="${item.id}">Edit</button>
                                    
//                                         <button data-id="${item.id}" id="delete">Delete</button>
                                        
//                                     </div>
//                                 </td>
//                             </tr>`
//                 });
//                 $('.load-data table tbody').html(view);
                
//             }
//         });
//     }

//     Showbedcategory();
    




//     $(document).on('submit', '#AddForm', function (e) {
//         e.preventDefault();
//         let formData = new FormData(this);

//         $.ajax({
//             url: "/api/hospital/setup/bedcategory",
//             method: 'POST',
//             processData: false,
//             contentType: false,
//             data: formData,
//             beforeSend:function() {
//                 $(document).find('span.error').text('');  
//             },
//             success: function (res) {
//                 console.log(res);
                
//                 if (res.status) {
//                     // $('#addModal').modal('hide');
//                     $('#AddForm')[0].reset();
//                     $('#name').focus();
//                     Showbedcategory();
//                     // $('.table').load(location.href + ' .table');
//                 }
//             },

//             error: function (err) {
//                 console.log(err);

//                 // let error = err.responseJSON;
//                 $.each(err.responseJSON.errors, function (key, value) {
//                     $('#' + key + "_error").text(value);
//                 });
//             }
//         })


//     });


//     $(document).on('click', '#edit', function (e) {
//         let id = $(this).attr('data-id');
//         $.ajax({
//             url: '/api/hospital/setup/bedcategory/edit',
//             data: { id },
//             success: function (res) {
//                 console.log(res);
//                 $('#editModal').show();
//                 $('#id').val(res.data.id);
//                 $('#updateName').val(res.data.name);
//             },
//             error: function (err) {
//                 console.log(err);
//             }
//         });
        
//     });





//     // Update Ajuax
//     $(document).on('submit','#EditForm', function (e) {
//         e.preventDefault();
//         let formData = new FormData(this);

//         $.ajax({
//             url: "/api/hospital/setup/bedcategory",
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
//                     Showbedcategory();
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



//     $(document).on('click','#confirm', function (e) {
//         let id = $(this).attr('data-id');
//         $.ajax({
//             url: '/api/hospital/setup/bedcategory',
//             method: 'DELETE',
//             data: {id},
//             success: function (res) {
//                 Showbedcategory();
//                 $('#deleteModal').hide();
//             }
//         });
//     });



//     // $(document).on('submit', '#InsertForm', function (e) {
//     //     e.preventDefault();
//     //     let formData = new FormData(this);
//     //     $.ajax({
//     //         url: "/addstudent",
//     //         method: 'POST',
//     //         processData: false,
//     //         contentType: false,
//     //         cache: false,
//     //         data: formData,
//             // beforeSend:function() {
//             //     $(document).find('span.error').text('');  
//             // },
//     //         success: function (res) {
//     //             if (res.status == "success") {
//     //                 $('#AddBankForm')[0].reset();
//     //                 $('#location').removeAttr('data-id');
//     //                 $('#name').focus();
//     //                 $('.bank').load(location.href + ' .bank');
//     //                 $('#search').val('');
//     //                 toastr.success('Bank Details Added Successfully', 'Added!');
//     //             }
//     //         },
//     //         error: function (err) {
//     //             console.log(err)
//     //             let error = err.responseJSON;
//     //             $.each(error.errors, function (key, value) {
//     //                 $('#' + key + "_error").text(value);
//     //             });
//     //         }
//     //     });
//     // });
// });
