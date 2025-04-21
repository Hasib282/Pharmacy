function ShowBedList(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.name} </td>
                    <td>${item.category.name}</td>
                    <td>${item.nursing.name}</td>
                    <td>
                        <div style="display: flex;gap:5px;">
                            
                            <button class="open-modal" data-modal-id="editModal" id="edit" data-id="${item.id}"><i class="fas fa-edit"></i></button>
                        
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
        $('.load-data .show-table tfoot').html('<tr><td colspan="8" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'select', options: [15, 30, 50, 100, 500] },
        
        { label: ' Name', key: 'name' },
        { label: 'Category Name', key: 'category.name' },
        { label: 'NursingName', key: 'nursing.name' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('hospital/setup/bedlist', ShowBedList);
    
    
    // Add Modal Open Functionality
    AddModalFunctionality("#bed_category", function () {
        $('#nursing_station').removeAttr('data-id');
        $('#bed_category').removeAttr('data-id');
    });


    // Insert Ajax
    InsertAjax('hospital/setup/bedlist', ShowBedList, {nursing_station: { selector: '#nursing_station', attribute: 'data-id' }, bed_category: { selector: '#bed_category', attribute: 'data-id' }}, function() {
        $('#bed_category').focus();
        $('#nursing_station').removeAttr('data-id');
        $('#bed_category').removeAttr('data-id');
    });


    //Edit Ajax
    EditAjax('hospital/setup/bedlist', EditFormInputValue);


    // Update Ajax
    UpdateAjax('hospital/setup/bedlist', ShowBedList, {nursing_station: { selector: '#updateNursing_Station', attribute: 'data-id' }, bed_category: { selector: '#updateBed_Category', attribute: 'data-id' }});
    

    // Delete Ajax
    DeleteAjax('hospital/setup/bedlist', ShowBedList);


    // Pagination Ajax
    // PaginationAjax(ShowBedList);


    // Search Ajax
    // SearchAjax('hospital/setup/bedlist', ShowBedList);


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.data.id);
        $('#updateName').val(res.data.name);
        $('#updateBed_Category').val(res.data.category.name);
        $('#updateBed_Category').attr('data-id',res.data.category);
        $('#updateNursing_Station').val(res.data.nursing.name);
        $('#updateNursing_Station').attr('data-id',res.data.nursing_station);
        $('#updateBed_Category').focus();
    }; // End Method
});




// $(document).ready(function () {
//     function Showbedlist(){
//         $.ajax({
//             url: '/api/hospital/setup/bedlist',
//             success: function(res){
//                 console.log(res)
//                 let view = "";
//                 $.each(res.data.data , function(key, item){
//                     view += `<tr>
//                                 <td>${key + 1} </td>
//                                 <td>${item.name} </td>
//                                 <td>${item.catagory}</td>
//                                 <td>${item.nursing_station}</td>
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

//     Showbedlist();
    

//     // $(document).on('click', '.add', function (e) {
//     //     console.log(e)
//     //     e.preventDefault();
//     //     $('#name').focus();
//     // });



//     $(document).on('submit', '#AddForm', function (e) {
//         e.preventDefault();
//         let formData = new FormData(this);

//         $.ajax({
//             url: "/api/hospital/setup/bedlist",
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
//                     Showbedlist();
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
//         $('#editModal').show();
//         $('#updateName').focus();
//         $.ajax({
//             url: '/api/hospital/setup/bedlist/edit',
//             data: { id },
        
//             success: function (res) {
//                 console.log(res);
//                 $('#id').val(res.data.id);
//                 // $('#updateStudentName').val(res.data.name);
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
//             url: "/api/hospital/setup/bedlist",
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
//                     Showbedlist();
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
//             url: '/api/hospital/setup/bedlist',
//             method: 'DELETE',
//             data: {id},
//             success: function (res) {
//                 $('#deleteModal').hide();
//                 Showbedlist();
//             }
//         });
//     });



//     $(document).on('submit', '#InsertForm', function (e) {
//         e.preventDefault();
//         let formData = new FormData(this);
//         $.ajax({
//             url: "/addstudent",
//             method: 'POST',
//             processData: false,
//             contentType: false,
//             cache: false,
//             data: formData,
//             beforeSend:function() {
//                 $(document).find('span.error').text('');  
//             },
//             success: function (res) {
//                 if (res.status == "success") {
//                     $('#AddBankForm')[0].reset();
//                     $('#location').removeAttr('data-id');
//                     $('#name').focus();
//                     $('.bank').load(location.href + ' .bank');
//                     $('#search').val('');
//                     toastr.success('Bank Details Added Successfully', 'Added!');
//                 }
//             },
//             error: function (err) {
//                 console.log(err)
//                 let error = err.responseJSON;
//                 $.each(error.errors, function (key, value) {
//                     $('#' + key + "_error").text(value);
//                 });
//             }
//         });
//     });


// });