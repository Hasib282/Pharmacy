function ShowSuppliers(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['user_id','user_name','withs.tran_with_name','user_email', 'user_phone','location.upazila','address',{key:'image', type: 'image'}],
        
        actions: (row) => {
            let buttons = '';

            buttons += `
                    <button class="open-modal" data-modal-id="detailsModal" id="details" data-id="${row.user_id}"><i class="fa-solid fa-circle-info"></i></button>
                `;
        
            if (userPermissions.includes(228)) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }
            
            if (userPermissions.includes(229)) {
                buttons += `
                    <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                `;
            }
        
            return buttons;
        }
    });
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Id', key: 'user_id' },
        { label: 'Name', key: 'user_name' },
        { label: 'Client Type', type:"select", key: 'tran_user_type', method:"fetch", link:"admin/tranwith/get", data:{type:5,user:5}, name:"tran_with_name" },
        { label: 'Email', key: 'user_email' },
        { label: 'Phone', key: 'user_phone' },
        { label: 'Location', key: 'location.upazila' },
        { label: 'Address', key: 'address' },
        { label: 'Image' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('inventory/users/suppliers', ShowSuppliers);


    // Creating Select Options Dynamically
    GetTransactionWith(5, null, 5, 'Ok');
    

    // Add Modal Open Functionality
    AddModalFunctionality("#type");


    // Insert Ajax
    InsertAjax('inventory/users/suppliers', {location: { selector: '#location', attribute: 'data-id' }, company: { selector: '#company', attribute: 'data-id' }}, function() {
        $('#type').focus();
        $('#location').removeAttr('data-id');
    });


    // Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('inventory/users/suppliers', {location: { selector: '#updateLocation', attribute: 'data-id' }});
    

    // Delete Ajax
    DeleteAjax('inventory/users/suppliers');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#EditForm')[0].reset();
        $('#updateLocation').removeAttr('data-id');

        $('#id').val(item.id);
        $('#updateType').val(item.tran_user_type);
        $('#updateName').val(item.user_name);
        $('#updatePhone').val(item.user_phone);
        $('#updateEmail').val(item.user_email);
        $('#updateDivision').val(item.location.division);
        $('#updateGender').val(item.gender);
        $('#updateLocation').val(item.location.upazila);
        $('#updateLocation').attr('data-id',item.loc_id);
        $('#updateAddress').val(item.address);
        $('#updatePreviewImage').attr('src',`${apiUrl.replace('/api', '')}/storage/${item.image ? item.image : (item.gender == 'female' ? 'female.png' : 'male.png')}?${new Date().getTime()} `).show();
        $('#updateType').focus();
    }; // End Method


    // Show Detals Ajax
    DetailsAjax('transaction/users/suppliers');
});