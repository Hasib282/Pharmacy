function ShowBedstatus(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['category.name','name', 'no_of_rooms', 'start_room_no'],
        actions: (row) => `
                <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                        
                <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                `,
    });
};


$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Bed Catagory', key: '' },
        { label: 'Room Number', key: '' },
        { label: 'Guest Name', key: '' },
        { label: 'Status', key: '' },
        { label: 'Action', type: 'button' }

    ]);

       // Load Data on Hard Reload
       ReloadData('hotel/bedstatus', ShowBedstatus);

});


