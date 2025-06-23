function ShowStores(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['store_name','division','location.upazila','address'],


        actions: (row) => {
            let buttons = '';
        
            if (userPermissions.includes(11)) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }
            
            if (userPermissions.includes(12)) {
                buttons += `
                    <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                `;
            }
        
            return buttons;
        }
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
        $('#updateDivision').val(item.division);
        $('#updateLocation').val(item.location.upazila);
        $('#updateLocation').attr('data-id',item.location_id);
        $('#updateAddress').val(item.address);
    }; // End Method
});