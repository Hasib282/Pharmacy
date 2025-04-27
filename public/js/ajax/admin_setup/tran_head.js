function ShowTranHead(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['groupe.tran_groupe_name','tran_head_name','mrp','company_id'],
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
        { label: 'Transaction Groupe', type:"select", key: 'groupe_id', method:"fetch", link:'admin/trangroupes/get', name:"tran_groupe_name" },
        { label: 'Transaction Head Name', key: 'tran_head_name' },
        { label: 'Price' },
        { label: 'Company Id', key: 'company_id' },
        { label: 'Action', type: 'button' }
    ]);


    // Get Transaction Groupe
    GetTransactionGroupe(null, null, "Ok");

    
    // Load Data on Hard Reload
    ReloadData('admin/tranheads', ShowTranHead);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#groupe");


    // Insert Ajax
    InsertAjax('admin/tranheads', {company: { selector: "#company", attribute: 'data-id' }}, function() {
        $('#groupe').focus();
        $('#company').removeAttr('data-id');
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/tranheads');
    

    // Delete Ajax
    DeleteAjax('admin/tranheads');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateHeadName').val(item.tran_head_name);
        $('#updateGroupe').val(item.groupe_id);
        $('#updatePrice').val(item.mrp);
        $('#updateGroupe').focus();
    }; // End Method
});