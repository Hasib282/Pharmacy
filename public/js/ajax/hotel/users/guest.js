function ShowGuests(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['user_id','title','user_name','user_email', 'user_phone','address'],
       
        actions: (row) => {
            let buttons = '';
        
            if (userPermissions.includes(329)) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }
            
            if (userPermissions.include(330)) {
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
        { label: 'Guest Id', key: 'user_id' },
        { label: 'Title', key: 'title' },
        { label: 'Name', key: 'user_name' },
        { label: 'Email', key: 'user_email' },
        { label: 'Phone', key: 'user_phone' },
        { label: 'Address', key: 'address' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('hotel/users/guests', ShowGuests);
    
    
    // Add Modal Open Functionality
    AddModalFunctionality("#title");


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hotel/users/guests');

    
    // Delete Ajax
    DeleteAjax('hotel/users/guests', ShowGuests);


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateName').val(item.user_name);
        $('#updateTitle').val(item.title);
        $('#updatePhone').val(item.user_phone);
        $('#updateAddress').val(item.address);
        $('#updateEmail').val(item.user_email);
        
        $('#updateGender').val(item.gender);
        $('#updateNationality').val(item.nationality);
        $('#updateReligion').val(item.religion);
        
        $('#updateTitle').focus();
    }; // End Method
});