function ShowSpecialization(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['name'],
        actions: (row) => {
            let buttons = '';
        
            if (userPermissions.includes(348)) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }
            
            buttons += `
                <button data-id="${row.id}" id="delete_status"><i class="fa-solid fa-trash-arrow-up"></i></button>
            `;
            
            if (userPermissions.includes(349)) {
                buttons += `
                    <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                `;
            }
        
            return buttons;
        }
    });
}



// Additional Edit Functionality
function EditFormInputValue(item){
    $('#id').val(item.id);
    $('#updateName').val(item.name);
    $('#updateName').focus();
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Specialization Name', key: 'name' },
        { label: 'Action', type: 'button' }
    ]);


    SingleInputDataCrudeAjax('hospital/setup/specialization', ShowSpecialization);
});