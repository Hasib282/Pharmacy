function ShowNursingStation(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['name','floor.name'],
        
         actions: (row) => {
            let buttons = '';
        
            if (userPermissions.includes(356) || role == 1) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }

            if (userPermissions.includes(357) || role == 1) {
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
        { label: 'Nursing Station Name', key: 'name' },
        { label: 'Floor', key: 'floor.name' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('hospital/setup/nursingstation', ShowNursingStation);
    
    
    // Add Modal Open Functionality
    AddModalFunctionality("#name");


    // Insert Ajax
    InsertAjax('hospital/setup/nursingstation', {floor:{ selector: '#floor', attribute: 'data-id' }}, function() {
        $('#name').focus();
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hospital/setup/nursingstation', {floor:{ selector: '#updateFloor', attribute: 'data-id' }});
    

    // Delete Ajax
    DeleteAjax('hospital/setup/nursingstation');
    

    // Delete status Ajax
    DeleteStatusAjax('hospital/setup/nursingstation');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateName').val(item.name);
        $('#updateFloor').val(item.floor.name);
        $('#updateFloor').attr('data-id',item.floor.id);
        $('#updateName').focus();
    }; // End Method
});