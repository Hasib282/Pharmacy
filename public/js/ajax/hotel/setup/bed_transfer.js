function ShowRoomCatagory(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['name'],
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
        { label: 'Guest ID', key: 'guest_id' },
        { label: 'From Bed', key: 'from_bed' },
        { label: 'To Bed', key: 'to_bed' },
        { label: 'Transfer Date', key: 'transfer_date' },
        { label: 'Transfer By', key: 'transfer_by' },
        { label: 'Action', type: 'button' }

    ]);


    // Load Data on Hard Reload
    ReloadData('hotel/setup/bedtransfer', ShowBedTransfer);


    // Insert Ajax
    InsertAjax('hotel/setup/bedtransfer', function () {
        $('#name').focus();
    });


    // Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hotel/setup/bedtransfer');


    // Delete Ajax
    DeleteAjax('hotel/setup/bedtransfer');


    // Additional Edit Functionality
    function EditFormInputValue(item) {
        $('#id').val(item.id);
        $('#update_name').val(item.name);
        
    }; // End Method
});