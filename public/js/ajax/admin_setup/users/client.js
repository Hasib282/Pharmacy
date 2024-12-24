function ShowClients(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.user_id}</td>
                    <td>${item.user_name}</td>
                    <td>${item.withs.tran_with_name}</td>
                    <td>${item.user_email}</td>
                    <td>${item.user_phone}</td>
                    <td>${item.loc_id ? item.location.upazila : ""}</td>
                    <td>${item.address ? item.address : "" }</td>
                    <td><img src="${apiUrl.replace('/api', '')}/storage/${item.image ? item.image : (item.gender == 'female' ? 'female.png' : 'male.png')}?${new Date().getTime()}" alt="" height="50px" width="50px"></td>
                    <td>
                        <div style="display: flex;gap:5px;">
                            
                            <button class="open-modal" data-modal-id="detailsModal" id="details" data-id="${item.user_id}"><i class="fa-solid fa-circle-info"></i></button>

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
        $('.load-data .show-table tfoot').html('<tr><td colspan="11" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Load Data on Hard Reload
    ReloadData('admin/users/clients', ShowClients);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#type");


    // Insert Ajax
    InsertAjax('admin/users/clients', ShowClients, {location: { selector: '#location', attribute: 'data-id' }, company: { selector: '#company', attribute: 'data-id' }}, function() {
        $('#type').focus();
        $('#location').removeAttr('data-id');
    });


    // Edit Ajax
    EditAjax('admin/users/clients', EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/users/clients', ShowClients, {location: { selector: '#updateLocation', attribute: 'data-id' }});
    

    // Delete Ajax
    DeleteAjax('admin/users/clients', ShowClients);


    // Pagination Ajax
    PaginationAjax(ShowClients);


    // Search Ajax
    SearchAjax('admin/users/clients', ShowClients);


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.client.id);

        CreateSelectOptions('#updateType', 'Select Company Type', res.tranwith, res.client.tran_user_type, 'tran_with_name');

        $('#updateName').val(res.client.user_name);
        $('#updatePhone').val(res.client.user_phone);
        $('#updateEmail').val(res.client.user_email);

        // Create options dynamically
        $('#updateDivision').empty();
        $('#updateDivision').append(`<option value="Dhaka" ${res.client.location.division === 'Dhaka' ? 'selected' : ''}>Dhaka</option>
            <option value="Chittagong" ${res.client.location.division === 'Chittagong' ? 'selected' : ''}>Chittagong</option>
            <option value="Rajshahi" ${res.client.location.division === 'Rajshahi' ? 'selected' : ''}>Rajshahi</option>
            <option value="Khulna" ${res.client.location.division === 'Khulna' ? 'selected' : ''}>Khulna</option>
            <option value="Sylhet" ${res.client.location.division === 'Sylhet' ? 'selected' : ''}>Sylhet</option>
            <option value="Barisal" ${res.client.location.division === 'Barisal' ? 'selected' : ''}>Barisal</option>
            <option value="Rangpur" ${res.client.location.division === 'Rangpur' ? 'selected' : ''}>Rangpur</option>
            <option value="Mymensingh" ${res.client.location.division === 'Mymensingh' ? 'selected' : ''}>Mymensingh</option>`);

        // Create options dynamically based on the status value
        $('#updateGender').empty();
        $('#updateGender').append(`<option value="Male" ${res.client.gender === 'Male' ? 'selected' : ''}>Male</option>
                                    <option value="Female" ${res.client.gender === 'Female' ? 'selected' : ''}>Female</option>
                                    <option value="Others" ${res.client.gender === 'Others' ? 'selected' : ''}>Others</option>`);

        $('#updateLocation').val(res.client.location.upazila);
        $('#updateLocation').attr('data-id',res.client.loc_id);
        $('#updateAddress').val(res.client.address);
        $('#updatePreviewImage').attr('src',`${apiUrl.replace('/api', '')}/storage/${res.client.image ? res.client.image : (res.client.gender == 'female' ? 'female.png' : 'male.png')}?${new Date().getTime()} `).show();
        $('#updateType').focus();
    }; // End Method


    // Show Detals Ajax
    DetailsAjax('admin/users/clients');


    // Creating Select Options Dynamically
    GetTransactionWith(null, null, null, 4, 'Ok');
});