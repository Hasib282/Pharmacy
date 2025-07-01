function ShowRoomCatagory(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['name'],
        actions: (row) => {
            let buttons = '';
        
            if (userPermissions.includes(301) || role == 1) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }

            buttons += `
                <button data-id="${row.id}" id="delete_status"><i class="fa-solid fa-trash-arrow-up"></i></button>
            `;
            
            if (userPermissions.includes(302) || role == 1) {
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
        { label: 'Name', key: 'name' },
        { label: 'Action', type: 'button' }

    ]);


    // Load Data on Hard Reload
    ReloadData('hotel/setup/roomcatagory', ShowRoomCatagory);


    // Insert Ajax
    InsertAjax('hotel/setup/roomcatagory', function () {
        $('#name').focus();
    });


    // Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hotel/setup/roomcatagory');


    // Delete Ajax
    DeleteAjax('hotel/setup/roomcatagory');


    // Delete status Ajax
    DeleteStatusAjax('hotel/setup/roomcatagory');


    // Additional Edit Functionality
    function EditFormInputValue(item) {
        $('#id').val(item.id);
        $('#update_name').val(item.name);
        
    }; // End Method
});