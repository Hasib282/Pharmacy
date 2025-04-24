function ShowStores(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['store_name','division','location.upazila','address'],
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
        { label: 'Store Name', key: 'store_name' },
        { label: 'Division', key: 'division' },
        { label: 'Location', key: 'location.upazila' },
        { label: 'Address', key: 'address' },
        { label: 'Action', type: 'button' }
    ]);

    
    // Load Data on Hard Reload
    ReloadData('admin/stores', ShowStores);
    
    
    // Add Modal Open Functionality
    AddModalFunctionality("#store_name");


    // Insert Ajax
    InsertAjax('admin/stores', {location: { selector: '#location', attribute: 'data-id' }}, function() {
        $('#store_name').focus();
        $('#location').removeAttr('data-id');
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/stores', {location: { selector: '#updateLocation', attribute: 'data-id' }});
    

    // Delete Ajax
    DeleteAjax('admin/stores');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#update_store_name').val(item.store_name);

        // Create options dynamically
        $('#updateDivision').empty();
        $('#updateDivision').append(`<option value="Dhaka" ${item.division === 'Dhaka' ? 'selected' : ''}>Dhaka</option>
            <option value="Chittagong" ${item.division === 'Chittagong' ? 'selected' : ''}>Chittagong</option>
            <option value="Rajshahi" ${item.division === 'Rajshahi' ? 'selected' : ''}>Rajshahi</option>
            <option value="Khulna" ${item.division === 'Khulna' ? 'selected' : ''}>Khulna</option>
            <option value="Sylhet" ${item.division === 'Sylhet' ? 'selected' : ''}>Sylhet</option>
            <option value="Barishal" ${item.division === 'Barishal' ? 'selected' : ''}>Barishal</option>
            <option value="Rangpur" ${item.division === 'Rangpur' ? 'selected' : ''}>Rangpur</option>
            <option value="Mymensingh" ${item.division === 'Mymensingh' ? 'selected' : ''}>Mymensingh</option>`);

        $('#updateLocation').val(item.location.upazila);
        $('#updateLocation').attr('data-id',item.location_id);
        $('#updateAddress').val(item.address);
    }; // End Method
});