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
                    <td><img src="${apiUrl.replace('/api', '')}/storage/${item.image ? item.image : (item.gender == 'female' ? 'female.png' : 'male.png')}?${new Date().getTime()}" alt="" height="50px" width="50px"></td>
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
        $('.load-data .show-table tfoot').html('<tr><td colspan="11" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'select', options: [15, 30, 50, 100, 500] },
        { label: 'Admin Id', key: 'user_id' },
        { label: 'Name', key: 'user_name' },
        { label: 'Email', key: 'user_email' },
        { label: 'Phone', key: 'user_phone' },
        { label: 'Image'},
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('admin/users/admins', ShowAdmins);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#name");


    // Insert Ajax
    InsertAjax('admin/users/admins', ShowAdmins, {company: { selector: '#company', attribute: 'data-id' }, store: { selector: '#store', attribute: 'data-id' }}, function() {
        $('#name').focus();
        $('#location').removeAttr('data-id');
    });


    // Edit Ajax
    EditAjax('admin/users/admins', EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/users/admins', ShowAdmins);
    

    // Delete Ajax
    DeleteAjax('admin/users/admins', ShowAdmins);


    // Pagination Ajax
    // PaginationAjax(ShowAdmins);


    // Search Ajax
    // SearchAjax('admin/users/admins', ShowAdmins);


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.data.id);
        $('#updateName').val(res.data.user_name);
        $('#updatePhone').val(res.data.user_phone);
        $('#updateEmail').val(res.data.user_email);

        $('#updatePreviewImage').attr('src',`${apiUrl.replace('/api', '')}/storage/${res.data.image ? res.data.image : 'male.png'}?${new Date().getTime()} `).show();
        $('#updateName').focus();
    }; // End Method


    // Show Detals Ajax
    DetailsAjax('admin/users/admins');
});