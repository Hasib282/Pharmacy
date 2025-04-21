// function ShowBanks(data, startIndex) {
//     let tableRows = '';
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             tableRows += `
//                 <tr>
//                     <td>${startIndex + key + 1}</td>
//                     <td>${item.user_id }</td>
//                     <td>${item.name }</td>
//                     <td>${item.email }</td>
//                     <td>${item.phone }</td>
//                     <td>${item.location.upazila }</td>
//                     <td>${item.address }</td>
//                     <td>
//                         <div style="display: flex;gap:5px;">
                            
//                             <button class="open-modal" data-modal-id="detailsModal" id="details"
//                                     data-id="${item.user_id}"><i class="fa-solid fa-circle-info"></i></button>
                                    
//                             <button class="open-modal" data-modal-id="editModal" id="edit"
//                                     data-id="${item.id}"><i class="fas fa-edit"></i></button>
                                    
//                             <button data-modal-id="deleteModal" data-id="${item.id}" id="delete"><i
//                                     class="fas fa-trash"></i></button>
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

function ShowBanks(res) {
    new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['user_id','name','email', 'phone','location.upazila','address'],
        actions: (row) => `
                <button class="open-modal" data-modal-id="detailsModal" id="details" data-id="${row.user_id}"><i class="fa-solid fa-circle-info"></i></button>
                
                <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                        
                <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                `,
    });
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'select', options: [15, 30, 50, 100, 500] },
        { label: 'Bank Id', key: 'user_id' },
        { label: 'Name', key: 'name' },
        { label: 'Email', key: 'email' },
        { label: 'Phone', key: 'phone' },
        { label: 'Location	', key: 'location.upazila' },
        { label: 'Address	', key: 'address' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('admin/banks', ShowBanks);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#name");


    // Insert Ajax
    InsertAjax('admin/banks', ShowBanks, {location: { selector: '#location', attribute: 'data-id' }}, function() {
        $('#name').focus();
        $('#location').removeAttr('data-id');
    });


    // Edit Ajax
    EditAjax('admin/banks', EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/banks', ShowBanks, {location: { selector: '#updateLocation', attribute: 'data-id' }});
    

    // Delete Ajax
    DeleteAjax('admin/banks', ShowBanks);


    // Pagination Ajax
    // PaginationAjax(ShowBanks);


    // Search Ajax
    // SearchAjax('admin/banks', ShowBanks);


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.data.id);
        $('#updateName').val(res.data.name);
        $('#updatePhone').val(res.data.phone);
        $('#updateEmail').val(res.data.email);

        // Create options dynamically
        $('#updateDivision').empty();
        $('#updateDivision').append(`<option value="Dhaka" ${res.data.location.division === 'Dhaka' ? 'selected' : ''}>Dhaka</option>
            <option value="Chittagong" ${res.data.location.division === 'Chittagong' ? 'selected' : ''}>Chittagong</option>
            <option value="Rajshahi" ${res.data.location.division === 'Rajshahi' ? 'selected' : ''}>Rajshahi</option>
            <option value="Khulna" ${res.data.location.division === 'Khulna' ? 'selected' : ''}>Khulna</option>
            <option value="Sylhet" ${res.data.location.division === 'Sylhet' ? 'selected' : ''}>Sylhet</option>
            <option value="Barishal" ${res.data.location.division === 'Barishal' ? 'selected' : ''}>Barishal</option>
            <option value="Rangpur" ${res.data.location.division === 'Rangpur' ? 'selected' : ''}>Rangpur</option>
            <option value="Mymensingh" ${res.data.location.division === 'Mymensingh' ? 'selected' : ''}>Mymensingh</option>`);

        $('#updateLocation').val(res.data.location.upazila);
        $('#updateLocation').attr('data-id',res.data.loc_id);
        $('#updateAddress').val(res.data.address);
        $('#updateName').focus();
    }; // End Method


    // Show Detals Ajax
    DetailsAjax('admin/banks');
});