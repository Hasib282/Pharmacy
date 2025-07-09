function ShowBedTransfer(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['booking_id','user_id', 'user.user_name', 'category.name', 'from_list.name', 'to_list.name', 'transfer_date', 'transfer_by' ],
       
        actions: (row) => {
            let buttons = '';
        
            if (userPermissions.includes(384) || role == 1) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }

            if (userPermissions.includes(385) || role == 1) {
                buttons += `
                <button data-id="${row.id}" id="delete_status" class="icon-wrapper" title="Toggle Delete"><i class="fa-solid fa-trash-arrow-up main-icon"></i><i class="fa-solid fa-arrows-rotate ring-icon"></i></button>
                `;
                
                if (role == 1 || role == 2) {
                    buttons += `
                        <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                    `;
                }
            }
        
            return buttons;
        }
    });
}




$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Booking Id', key: 'booking_id' },
        { label: 'Guest Id', key: 'user_id' },
        { label: 'Guest Name', key: 'user.user_name' },
        { label: 'Room Category', key: 'category.name' },
        { label: 'From Room', key: 'from_list.name' },
        { label: 'To Room', key: 'to_list.name' },
        { label: 'Transfer Date', key: 'transfer_date' },
        { label: 'Transfer By', key: 'transfer_by' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('hospital/bedtransfer', ShowBedTransfer);


    // Add Modal Open Functionality
    AddModalFunctionality("#guest", function () {
        $('#guest').removeAttr('data-id');
        $('#bed_category').removeAttr('data-id');
        $('#from_bed').removeAttr('data-id');
        $('#bed_list').removeAttr('data-id');
    });


    // Insert Ajax
    InsertAjax('hospital/bedtransfer', {guest_id: { selector: '#guest', attribute: 'data-id' }, booking_id: { selector: '#hotel-booking', attribute: 'data-id' },from_bed: { selector: '#from_bed', attribute: 'data-id' }, to_bed: { selector: '#bed_list', attribute: 'data-id' }, category_id: { selector: '#bed_category', attribute: 'data-id' }}, function () {
        $('#guest').removeAttr('data-id');
        $('#bed_category').removeAttr('data-id');
        $('#from_bed').removeAttr('data-id');
        $('#bed_list').removeAttr('data-id');
        $('#hotel-booking').removeAttr('data-id');
        $('#guest').focus();
    });


    // Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hospital/bedtransfer', {guest_id: { selector: '#updateGuest', attribute: 'data-id' }, booking_id: { selector: '#updateHotel-booking', attribute: 'data-id' },from_bed: { selector: '#updateFrom_bed', attribute: 'data-id' }, to_bed: { selector: '#updateBed_List', attribute: 'data-id' }, category_id: { selector: '#updateBed_Category', attribute: 'data-id' } }, function () {
        $('#updateGuest').removeAttr('data-id');
        $('#updateBed_Category').removeAttr('data-id');
        $('#updateFrom_bed').removeAttr('data-id');
        $('#updateBed_List').removeAttr('data-id');
        $('#updateHotel-booking').removeAttr('data-id');
        $('#updateGuest').focus();
    });


    // Delete Ajax
    DeleteAjax('hospital/bedtransfer');


    // Delete status Ajax
    DeleteStatusAjax('hospital/bedtransfer');


    // Additional Edit Functionality
    function EditFormInputValue(item) {
        $('#id').val(item.id);
        $('#update_name').val(item.name);
        
    }; // End Method
});