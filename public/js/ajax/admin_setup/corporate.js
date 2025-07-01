function ShowCorporate(res) {
    
    
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['name','discount'],
        actions: (row) => {
            let buttons = '';
        
            if (userPermissions.includes(293) || role == 1) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }

            buttons += `
                <button data-id="${row.id}" id="delete_status"><i class="fa-solid fa-trash-arrow-up"></i></button>
            `;
            
            if (userPermissions.includes(294) || role == 1) {
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
        { label: 'Corporate Name', key: 'name' },
        { label: 'Discount Rate' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('admin/corporate', ShowCorporate);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#name");


    // Insert Ajax
    InsertAjax('admin/corporate', {}, function() {
        $('#name').focus();
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/corporate');
    

    // Delete Ajax
    DeleteAjax('admin/corporate');


    // Delete stutus Ajax
    DeleteStatusAjax('admin/corporate');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateName').val(item.name);
        $('#updatePrice').val(item.discount);
        $('#updateName').focus();
    }
});