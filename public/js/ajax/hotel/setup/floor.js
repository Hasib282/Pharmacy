function ShowFloor(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['name', 'no_of_rooms', 'start_room_no'],
        
        actions: (row) => {
            let buttons = '';
        
            if (userPermissions.includes(297) || role == 1) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }
            
            buttons += `
                <button data-id="${row.id}" id="delete_status"><i class="fa-solid fa-trash-arrow-up"></i></button>
            `;

            if (userPermissions.includes(298) || role == 1) {
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
        { label: 'Floor Name', key: 'name' },
        { label: 'Number of Rooms', key: 'no_of_rooms' },
        { label: 'Starting Room Number', key: 'start_room_no' },
        { label: 'Action', type: 'button' }

    ]);


    // Load Data on Hard Reload
    ReloadData('hotel/setup/floor', ShowFloor);


    // Add Modal Open Functionality
    AddModalFunctionality("#name");


    // Insert Ajax
    InsertAjax('hotel/setup/floor', {}, function(){
        $('#name').focus();
    });


    // Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hotel/setup/floor');


    // Delete Ajax
    DeleteAjax('hotel/setup/floor');


    // Additional Edit Functionality
    function EditFormInputValue(item) {
        $('#id').val(item.id);
        $('#updateName').val(item.name);
        $('#update_number_of_rooms').val(item.no_of_rooms);
        $('#update_floor').val(item.start_room_no);
        $('#updateName').focus();
    }; // End Method






});




