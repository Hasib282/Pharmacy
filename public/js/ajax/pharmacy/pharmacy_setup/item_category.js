function ShowPharmacyCategorys(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['category_name','company_id'],

        actions: (row) => {
            let buttons = '';
        
            if (userPermissions.includes(118)) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }
            
            if (userPermissions.include(119)) {
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
    $('#updateName').val(item.category_name);
    $('#updateName').focus();
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Item Category Name', key: 'category_name' },
        { label: 'Company Name', key: 'company_id' },
        { label: 'Action', type: 'button' }
    ]);

    
    SingleInputDataCrudeAjax('pharmacy/setup/category', ShowPharmacyCategorys);
});