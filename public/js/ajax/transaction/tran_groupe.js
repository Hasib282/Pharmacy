function ShowTranGroupe(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_groupe_name','tran_method','company_id'],
         actions: (row) => {
            let buttons = '';

            if (userPermissions.includes(15)) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }
            
            buttons += `
                <button data-id="${row.id}" id="delete_status"><i class="fa-solid fa-trash-arrow-up"></i></button>
            `;

            if (userPermissions.includes(16)) {
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
        { label: 'Groupe Name', key: 'tran_groupe_name' },
        { label: 'Method', type:"select", key: 'tran_method', method:"custom", options:['Receive','Payment','Both'] },
        { label: 'Company Id', key: 'company_id' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('transaction/setup/groupes', ShowTranGroupe);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#groupeName");


    // Insert Ajax
    InsertAjax('transaction/setup/groupes', {company: { selector: "#company", attribute: 'data-id' },type: 1}, function() {
        $('#groupeName').focus();
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('transaction/setup/groupes', {type: 1});
    

    // Delete Ajax
    DeleteAjax('transaction/setup/groupes');
    

    // Deleteb status Ajax
    DeleteStatusAjax('transaction/setup/groupes');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateGroupeName').val(item.tran_groupe_name);
        $('#updateMethod').val(item.tran_method);
        $('#updateGroupeName').focus();
    }; // End Method
});