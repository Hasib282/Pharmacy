function ShowroomTransfer(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['user_id', 'user.user_name', 'from_list.name', 'to_list.name', 'transfer_date', 'transfer_by' ],
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
        { label: 'Guest Id', key: 'user_id' },
        { label: 'Guest Name', key: 'user.user_name' },
        { label: 'From Bed', key: 'from_list.name' },
        { label: 'To Bed', key: 'to_list.name' },
        { label: 'Transfer Date', key: 'transfer_date' },
        { label: 'Transfer By', key: 'transfer_by' },
        { label: 'Action', type: 'button' }

    ]);


    // Load Data on Hard Reload
    ReloadData('hotel/roomtransfer', ShowroomTransfer);


    // Add Modal Open Functionality
    AddModalFunctionality("#guest", function () {
        $('#guest').removeAttr('data-id');
        $('#bed_category').removeAttr('data-id');
        $('#from_bed').removeAttr('data-id');
        $('#bed_list').removeAttr('data-id');
    });


    // Insert Ajax
    InsertAjax('hotel/roomtransfer', {guest_id: { selector: '#guest', attribute: 'data-id' },from_bed: { selector: '#from_bed', attribute: 'data-id' }, to_bed: { selector: '#bed_list', attribute: 'data-id' }}, function () {
        $('#guest').removeAttr('data-id');
        $('#bed_category').removeAttr('data-id');
        $('#from_bed').removeAttr('data-id');
        $('#bed_list').removeAttr('data-id');
        $('#guest').focus();
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