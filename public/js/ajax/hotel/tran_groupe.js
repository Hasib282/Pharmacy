function ShowTranGroupe(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_groupe_name','company_id'],
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
        { label: 'Transaction Groupe Name', key: 'tran_groupe_name' },
        { label: 'Company Id', key: 'company_id' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('hotel/setup/groupe', ShowTranGroupe);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#groupeName");


    // Insert Ajax
    InsertAjax('hotel/setup/groupe', {company: { selector: "#company", attribute: 'data-id' },type: 8, method: 'Both'}, function() {
        $('#groupeName').focus();
        $('#company').removeAttr('data-id');
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hotel/setup/groupe', {type: 8, method: 'Both'});
    

    // Delete Ajax
    DeleteAjax('hotel/setup/groupe');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateGroupeName').val(item.tran_groupe_name);
        $('#updateType').val(item.tran_groupe_type);
        $('#updateMethod').val(item.tran_method);
        $('#updateGroupeName').focus();
    }; // End Method
});