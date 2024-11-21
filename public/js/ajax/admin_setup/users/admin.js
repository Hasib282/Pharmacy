function ShowAdmins(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.user_id}</td>
                    <td>${item.user_name}</td>
                    <td>${item.user_email}</td>
                    <td>${item.user_phone}</td>
                    <td>${item.loc_id ? item.location.upazila : ""}</td>
                    <td>${item.address ? item.address : "" }</td>
                    <td><img src="${apiUrl.replace('/api', '')}/storage/profiles/${item.image ? item.image : (item.gender == 'female' ? 'female.png' : 'male.png')}?${new Date().getTime()}" alt="" height="50px" width="50px"></td>
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
    ReloadData('admin/users/admins', ShowAdmins);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#name");


    // Insert Ajax
    InsertAjax('admin/users/admins', ShowAdmins, {location: { selector: '#location', attribute: 'data-id' }, company: { selector: '#company', attribute: 'data-id' }}, function() {
        $('#name').focus();
        $('#location').removeAttr('data-id');
    });


    // Edit Ajax
    EditAjax('admin/users/admins', EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/users/admins', ShowAdmins, {location: { selector: '#updateLocation', attribute: 'data-id' }});
    

    // Delete Ajax
    DeleteAjax('admin/users/admins', ShowAdmins);


    // Pagination Ajax
    PaginationAjax(ShowAdmins);


    // Search Ajax
    SearchAjax('admin/users/admins', ShowAdmins);


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.admin.id);
        $('#updateName').val(res.admin.user_name);
        $('#updatePhone').val(res.admin.user_phone);
        $('#updateEmail').val(res.admin.user_email);

        // Create options dynamically
        $('#updateDivision').empty();
        $('#updateDivision').append(`<option value="Dhaka" ${res.admin.location.division === 'Dhaka' ? 'selected' : ''}>Dhaka</option>
            <option value="Chittagong" ${res.admin.location.division === 'Chittagong' ? 'selected' : ''}>Chittagong</option>
            <option value="Rajshahi" ${res.admin.location.division === 'Rajshahi' ? 'selected' : ''}>Rajshahi</option>
            <option value="Khulna" ${res.admin.location.division === 'Khulna' ? 'selected' : ''}>Khulna</option>
            <option value="Sylhet" ${res.admin.location.division === 'Sylhet' ? 'selected' : ''}>Sylhet</option>
            <option value="Barisal" ${res.admin.location.division === 'Barisal' ? 'selected' : ''}>Barisal</option>
            <option value="Rangpur" ${res.admin.location.division === 'Rangpur' ? 'selected' : ''}>Rangpur</option>
            <option value="Mymensingh" ${res.admin.location.division === 'Mymensingh' ? 'selected' : ''}>Mymensingh</option>`);

        // Create options dynamically based on the status value
        $('#updateGender').empty();
        $('#updateGender').append(`<option value="Male" ${res.admin.gender === 'Male' ? 'selected' : ''}>Male</option>
                                    <option value="Female" ${res.admin.gender === 'Female' ? 'selected' : ''}>Female</option>
                                    <option value="Others" ${res.admin.gender === 'Others' ? 'selected' : ''}>Others</option>`);

        $('#updateLocation').val(res.admin.location.upazila);
        $('#updateLocation').attr('data-id',res.admin.loc_id);
        $('#updateAddress').val(res.admin.address);
        $('#updatePreviewImage').attr('src',`${apiUrl.replace('/api', '')}/storage/profiles/${res.admin.image}?${new Date().getTime()} `).show();
        $('#updateName').focus();
    }; // End Method


    // Show Detals Ajax
    DetailsAjax('admin/users/admins');
});