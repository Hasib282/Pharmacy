function ShowFloor(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['floor_name','no_of_rooms','starting_floor_on','action'],
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
        { label: 'Starting Floor Number', key: 'starting_floor_on' },
        { label: 'Action/status', key: 'action' },
        { label: 'Action', type: 'button' }
        
    ]);


    // Load Data on Hard Reload
    ReloadData('hotel/setup/floor', ShowFloor);


 
    // Delete Ajax
    DeleteAjax('hotel/floor');

   
   
   

    
});




