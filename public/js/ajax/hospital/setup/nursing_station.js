function ShowNursingStation(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.name}</td>
                    <td>${item.floor}</td>
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
        { label: 'Name', key: 'name' },
        { label: 'Floor', key: 'floor' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('hospital/setup/nursingstation', ShowNursingStation);
    
    
    // Add Modal Open Functionality
    AddModalFunctionality("#name");


    // Insert Ajax
    InsertAjax('hospital/setup/nursingstation', ShowNursingStation, {}, function() {
        $('#name').focus();
    });


    //Edit Ajax
    EditAjax('hospital/setup/nursingstation', EditFormInputValue);


    // Update Ajax
    UpdateAjax('hospital/setup/nursingstation', ShowNursingStation);
    

    // Delete Ajax
    DeleteAjax('hospital/setup/nursingstation', ShowNursingStation);


    // Pagination Ajax
    // PaginationAjax(ShowNursingStation);


    // Search Ajax
    // SearchAjax('hospital/setup/nursingstation', ShowNursingStation);


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.data.id);
        $('#updateName').val(res.data.name);
        $('#updateFloor').val(res.data.floor);
        $('#updateName').focus();
    }; // End Method
});



// function ShowData(){
//     $.ajax({
//         url: '/api/hospital/setup/nursingstation',
//         method:'GET',
//         success: function(res){
//             let view =``;
//             $.each(res.data.data, function(key,item){
//                 view+=`
//                 <tr>
//                     <td>${ key + 1}</td>
//                     <td>${item.name}</td>
//                     <td>${item.floor}</td>
                    
                   
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

// //show data


// $(document).ready(function(){
//     ShowData();
    
//     //insert data 
//     $(document).on('submit','#AddForm',function(e){
//         e.preventDefault();
//         let fromData = new FormData(this);
//         $.ajax({
//             url:'/api/hospital/setup/nursingstation',
//             method:'POST',
//             processData:false,
//             contentType:false,
//             data:fromData,
//             success:function(res){
//                     console.log(res);
//                     if(res.status == true){
//                         $('#AddForm').modal('hide')
//                         $('#AddForm')[0].reset();
//                         ShowData();
//                     }
                    
//             }
//         })
//     })


//  //update data 
//  $(document).on('submit','#EditForm',function(e){
//     e.preventDefault();
//     let fromdata = new FormData(this);

//     $.ajax({
//         url:'/api/hospital/setup/nursingstation', 
//         method:'POST',
//         data : fromdata,
//         processData:false,
//         contentType:false, 
//         success:function(res){
//             console.log(res);
//             if(res.status == true){
//                 $('#editModal').hide();
//                 $('#EditForm')[0].reset();
//                 ShowData();
//             }
//         } 
//     })
//  })






//     //edit data 
//     $(document).on('click', '#edit', function (e) {
//         let id = $(this).attr('data-id');
//         $.ajax({
//             url: '/api/hospital/setup/nursingstation/edit',
//             data: { id },
//             success: function (res) {
//                 console.log(res);
//                 $('#id').val(res.data.id);
//                     $('#updateName').val(res.data.name);
//                     $('#updateFloor').val(res.data.floor);
                


            

//             }
//         });
        
//     });


   



//     //delete data
//     DeleteAjax('hospital/setup/nursingstation', ShowData);
// })