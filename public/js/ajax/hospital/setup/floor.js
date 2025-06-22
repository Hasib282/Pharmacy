function ShowFloor(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['name'],
        
         actions: (row) => {
            let buttons = '';
        
            if (userPermissions.includes(352)) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }
            
            if (userPermissions.include(353)) {
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
        { label: 'Floor Name', key: 'name' },
        { label: 'Action', type: 'button' }

    ]);


    // Load Data on Hard Reload
    ReloadData('hospital/setup/floor', ShowFloor);


    // Add Modal Open Functionality
    AddModalFunctionality("#name");


    // Insert Ajax
    InsertAjax('hospital/setup/floor', {}, function(){
        $('#name').focus();
    });


    // Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hospital/setup/floor');


    // Delete Ajax
    DeleteAjax('hospital/setup/floor');


    // Additional Edit Functionality
    function EditFormInputValue(item) {
        $('#id').val(item.id);
        $('#updateName').val(item.name);
        $('#updateName').focus();
    }; // End Method
});




