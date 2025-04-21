//Show patient start
function ShowPatients(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.ptn_id}</td>
                    <td>${item.title}</td>
                    <td>${item.name}</td>
                    <td>${item.phone}</td>
                    <td>${item.email}</td>
                    <td>${item.gender}</td>
                    <td>${item.address}</td>
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
        $('.load-data .show-table tfoot').html('<tr><td colspan="9" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function

//Show patient end




$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'select', options: [15, 30, 50, 100, 500] },
        { label: 'Company Id', key: 'company_id' },
        { label: 'Company Name', key: 'name' },
        { label: 'Permission', key: 'permission' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('hospital/users/patients', ShowPatients);
    
    
    // Add Modal Open Functionality
    AddModalFunctionality("#title");


    // Insert Ajax
    // InsertAjax('hospital/users/patients', ShowPatients, {}, function() {
    //     $('#title').focus();
    // });


    //Edit Ajax
    EditAjax('hospital/users/patients', EditFormInputValue);


    // Update Ajax
    UpdateAjax('hospital/users/patients', ShowPatients);

    
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
    

    // Delete Ajax
    DeleteAjax('hospital/users/patients', ShowPatients);


    // Pagination Ajax
    // PaginationAjax(ShowPatients);


    // Search Ajax
    // SearchAjax('hospital/users/patients', ShowPatients);


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.data.id);
        $('#updateName').val(res.data.name);
        $('#updateTitle').val(res.data.title);
        $('#updatePhone').val(res.data.phone);
        $('#updateAddress').val(res.data.address);
        $('#updateEmail').val(res.data.email);

        $('#updateAge_years').val(res.data.age_years);
        $('#updateAge_months').val(res.data.age_months);
        $('#updateAge_days').val(res.data.age_days);
        
        $('#updateGender').val(res.data.gender);
        $('#updateNationality').val(res.data.nationality);
        $('#updateReligion').val(res.data.religion);
        

        $('#updateTitle').focus();
    }; // End Method
});