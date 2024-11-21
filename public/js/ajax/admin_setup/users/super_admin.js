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
    ReloadData('admin/users/superadmins', ShowAdmins);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#name");


    // Insert Ajax
    InsertAjax('admin/users/superadmins', ShowAdmins, {location: { selector: '#location', attribute: 'data-id' }}, function() {
        $('#name').focus();
        $('#location').removeAttr('data-id');
    });


    // Edit Ajax
    EditAjax('admin/users/superadmins', EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/users/superadmins', ShowAdmins, {location: { selector: '#updateLocation', attribute: 'data-id' }});
    

    // Delete Ajax
    DeleteAjax('admin/users/superadmins', ShowAdmins);


    // Pagination Ajax
    PaginationAjax(ShowAdmins);


    // Search Ajax
    SearchAjax('admin/users/superadmins', ShowAdmins);


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.superadmin.id);
        $('#updateName').val(res.superadmin.user_name);
        $('#updatePhone').val(res.superadmin.user_phone);
        $('#updateEmail').val(res.superadmin.user_email);

        // Create options dynamically
        $('#updateDivision').empty();
        $('#updateDivision').append(`<option value="Dhaka" ${res.superadmin.location.division === 'Dhaka' ? 'selected' : ''}>Dhaka</option>
            <option value="Chittagong" ${res.superadmin.location.division === 'Chittagong' ? 'selected' : ''}>Chittagong</option>
            <option value="Rajshahi" ${res.superadmin.location.division === 'Rajshahi' ? 'selected' : ''}>Rajshahi</option>
            <option value="Khulna" ${res.superadmin.location.division === 'Khulna' ? 'selected' : ''}>Khulna</option>
            <option value="Sylhet" ${res.superadmin.location.division === 'Sylhet' ? 'selected' : ''}>Sylhet</option>
            <option value="Barisal" ${res.superadmin.location.division === 'Barisal' ? 'selected' : ''}>Barisal</option>
            <option value="Rangpur" ${res.superadmin.location.division === 'Rangpur' ? 'selected' : ''}>Rangpur</option>
            <option value="Mymensingh" ${res.superadmin.location.division === 'Mymensingh' ? 'selected' : ''}>Mymensingh</option>`);

        // Create options dynamically based on the status value
        $('#updateGender').empty();
        $('#updateGender').append(`<option value="Male" ${res.superadmin.gender === 'Male' ? 'selected' : ''}>Male</option>
                                    <option value="Female" ${res.superadmin.gender === 'Female' ? 'selected' : ''}>Female</option>
                                    <option value="Others" ${res.superadmin.gender === 'Others' ? 'selected' : ''}>Others</option>`);

        $('#updateLocation').val(res.superadmin.location.upazila);
        $('#updateLocation').attr('data-id',res.superadmin.loc_id);
        $('#updateAddress').val(res.superadmin.address);
        $('#updatePreviewImage').attr('src',`${apiUrl.replace('/api', '')}/storage/profiles/${res.superadmin.image}?${new Date().getTime()} `).show();
        $('#updateName').focus();

    }; // End Method


    // Show Detals Ajax
    DetailsAjax('admin/users/superadmins');
});