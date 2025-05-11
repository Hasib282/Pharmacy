function ShowFloor(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['floor_name', 'no_of_rooms', 'starting_floor_no', 'action'],
        actions: (row) => `
                <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                        
                <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                `,
    });
}




$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Floor Name', key: 'floor_name' },
        { label: 'Number of Rooms', key: 'no_of_rooms' },
        { label: 'Starting Floor Number', key: 'starting_floor_no' },
        { label: 'Action/status', key: 'action' },
        { label: 'Action', type: 'button' }

    ]);


    // Load Data on Hard Reload
    ReloadData('hotel/setup/floor', ShowFloor);


    // Insert Ajax
    InsertAjax('hotel/setup/floor', function () {
        $('#floor_name').focus();
        $('#number_of_rooms'),
        $('#starting_floor'),
        $('#action')

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
        $('#update_floor_name').val(item.floor_name);
        $('#update_number_of_rooms').val(item.no_of_rooms);
        $('#update_floor').val(item.starting_floor_no);
        $('#update_action').val(item.action);
        $('#floor_name').focus();
    }; // End Method






});




