function ShowRoomList(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['room_number', 'room_catagory', 'floor', 'price', 'capacity'],
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
        { label: 'Room Number', key: 'room_number' },
        { label: 'Room Catagory', key: 'room_catagory' },
        { label: 'Floor', key: 'floor' },
        { label: 'Price', key: 'price' },
        { label: 'Capacity', key: 'capacity' },
        { label: 'Action', type: 'button' }

    ]);


    // Load Data on Hard Reload
    ReloadData('hotel/setup/room_list', ShowRoomList);

    // Insert Ajax
    InsertAjax('hotel/setup/room_list', function () {
        $('#room_number').focus();
        $('#room_catagory').focus();
        $('#floor').focus();
        $('#price').focus();
        $('#capacity').focus();


    });

    // Edit Ajax
    EditAjax(EditFormInputValue);



    // Delete Ajax
    DeleteAjax('hotel/setup/room_list');






});
