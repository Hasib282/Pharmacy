function ShowTranHead(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_head_name','groupe.tran_groupe_name','company_id'],
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
        { label: 'Transaction Head Name', key: 'tran_head_name' },
        { label: 'Transaction Groupe', type:"select", key: 'groupe_id', method:"fetch", link:'admin/trangroupes/get', name:"tran_groupe_name" },
        { label: 'Company Id', key: 'company_id' },
        { label: 'Action', type: 'button' }
    ]);


    // Get Transaction Groupe
    GetTransactionGroupe(null, null, "Ok");

    
    // Load Data on Hard Reload
    ReloadData('hospital/setup/services', ShowTranHead);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#headName");


    // Insert Ajax
    InsertAjax('hospital/setup/services', {company: { selector: "#company", attribute: 'data-id' }}, function() {
        $('#headName').focus();
        $('#company').removeAttr('data-id');
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hospital/setup/services');
    

    // Delete Ajax
    DeleteAjax('hospital/setup/services');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateHeadName').val(item.tran_head_name);
        $('#updateGroupe').val(item.groupe_id);
        $('#updateHeadName').focus();
    }; // End Method
});