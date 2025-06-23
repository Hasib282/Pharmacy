function ShowPaymentMethod(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['name'],
        actions: (row) => {
            let buttons = '';
        
            if (userPermissions.includes(289)) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }
            
            if (userPermissions.includes(290)) {
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
        { label: 'Method Name', key: 'name' },
        { label: 'Action', type: 'button' }
    ]);


    SingleInputDataCrudeAjax('admin/payment_method', ShowPaymentMethod);
});