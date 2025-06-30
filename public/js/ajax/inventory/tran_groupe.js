function ShowTranGroupe(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_groupe_name','company_id'],
        actions: (row) => {
            let buttons = '';

            if (userPermissions.includes(212)) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }

            buttons += `
                <button data-id="${row.id}" id="delete_status"><i class="fa-solid fa-trash-arrow-up"></i></button>
            `;
            
            if (userPermissions.includes(213)) {
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
        { label: 'Item Groupe Name', key: 'tran_groupe_name' },
        { label: 'Company Id', key: 'company_id' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('inventory/setup/groupes', ShowTranGroupe);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#groupeName");


    // Insert Ajax
    InsertAjax('inventory/setup/groupes', {company: { selector: "#company", attribute: 'data-id' }, type: 5, method: 'Both'}, function() {
        $('#groupeName').focus();
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('inventory/setup/groupes', {type: 5, method: 'Both'});
    

    // Delete Ajax
    DeleteAjax('inventory/setup/groupes');
    

    // Delete status Ajax
    DeleteStatusAjax('inventory/setup/groupes');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateGroupeName').val(item.tran_groupe_name);
        $('#updateGroupeName').focus();
    }; // End Method
});