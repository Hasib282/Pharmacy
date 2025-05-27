function ShowroomTransfer(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['user_id', 'from_bed', 'to_bed', 'transfer_date', 'transfer_by' ],
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
        { label: 'Guest ID', key: 'user_id' },
        { label: 'From Bed', key: 'from_bed' },
        { label: 'To Bed', key: 'to_bed' },
        { label: 'Transfer Date', key: 'transfer_date' },
        { label: 'Transfer By', key: 'transfer_by' },
        { label: 'Action', type: 'button' }

    ]);


    // Load Data on Hard Reload
    ReloadData('hotel/roomtransfer', ShowroomTransfer);


    // Insert Ajax
    InsertAjax('hotel/roomtransfer', {guest: { selector: '#guest', attribute: 'data-id' },from_bed: { selector: '#from_bed', attribute: 'data-id' }, to_bed: { selector: '#to_bed', attribute: 'data-id' }}, function () {
        $('#name').focus();
    });


    // Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hotel/roomtransfer');


    // Delete Ajax
    DeleteAjax('hotel/roomtransfer');


    // Additional Edit Functionality
    function EditFormInputValue(item) {
        $('#id').val(item.id);
        $('#update_name').val(item.name);
        
    }; // End Method
});