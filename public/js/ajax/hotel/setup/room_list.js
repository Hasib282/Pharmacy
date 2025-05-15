function ShowRoomList(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['category.name', 'name', 'floor.name', 'price', 'capacity'],
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
        { label: 'Room Catagory', key: 'category.name' },
        { label: 'Room Number', key: 'name' },
        { label: 'Floor', key: 'floor.name' },
        { label: 'Price', key: 'price' },
        { label: 'Capacity', key: 'capacity' },
        { label: 'Action', type: 'button' }

    ]);


    // Load Data on Hard Reload
    ReloadData('hotel/setup/roomlist', ShowRoomList);

    // Insert Ajax
    InsertAjax('hotel/setup/roomlist', {floor:{ selector: '#floor', attribute: 'data-id' },bed_category: { selector: '#bed_category', attribute: 'data-id' }}, function () {
        $('#room_number').focus();
        $('#room_catagory').focus();
        $('#floor').focus();
        $('#price').focus();
        $('#capacity').focus();


    });

    // Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hotel/setup/roomlist', {floor:{ selector: '#updateFloor', attribute: 'data-id' }, bed_category: { selector: '#updateBed_Category', attribute: 'data-id' }});



    // Delete Ajax
    DeleteAjax('hotel/setup/roomlist');



    // Additional Edit Functionality
    function EditFormInputValue(item) {
        $('#EditForm')[0].reset();
        $('#id').val('');
        $('#updateBed_List').val('');
        $('#updateBed_Category').val('');
        $('#updateBed_Category').removeAttr('data-id');
        $('#updateFloor').val('');
        $('#updateFloor').removeAttr('data-id');

        $('#id').val(item.id);
        $('#updateBed_List').val(item.name);
        $('#updateBed_Category').val(item.category.name);
        $('#updateBed_Category').attr('data-id',item.category.id);
        $('#updateFloor').val(item.floor.name);
        $('#updateFloor').attr('data-id',item.floor.id);
        $('#updatePrice').val(item.price);
        $('#updateCapacity').val(item.capacity);
        $('#updateBed_Category').focus();
    }; // End Method







});
