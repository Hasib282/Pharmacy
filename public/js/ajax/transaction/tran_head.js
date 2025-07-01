function ShowTranHead(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['groupe.tran_groupe_name','tran_head_name','company_id'],
         actions: (row) => {
            let buttons = '';
 
            if (userPermissions.includes(19) || role == 1) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }
            
            buttons += `
                <button data-id="${row.id}" id="delete_status" class="icon-wrapper" title="Toggle Delete"><i class="fa-solid fa-trash-arrow-up main-icon"></i><i class="fa-solid fa-arrows-rotate ring-icon"></i></button>
            `;

            if (userPermissions.includes(20) || role == 1) {
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
        { label: 'Groupe Name', type:"select", key: 'groupe_id', method:"fetch", link:'admin/trangroupes/get', name:"tran_groupe_name", data:{type:1} },
        { label: 'Service/Product Name', key: 'tran_head_name' },
        { label: 'Company Id', key: 'company_id' },
        { label: 'Action', type: 'button' }
    ]);

    
    // Load Transaction Groupe
    GetTransactionGroupe(1, null, "Ok");

    
    // Load Data on Hard Reload
    ReloadData('transaction/setup/heads', ShowTranHead);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#groupe");


    // Insert Ajax
    InsertAjax('transaction/setup/heads', {company: { selector: "#company", attribute: 'data-id' },}, function() {
        $('#groupe').focus();
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('transaction/setup/heads');
    

    // Delete Ajax
    DeleteAjax('transaction/setup/heads');
    

    // Delete status Ajax
    DeleteStatusAjax('transaction/setup/heads');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateHeadName').val(item.tran_head_name);
        $('#updateGroupe').val(item.groupe_id);
        $('#updatePrice').val(item.mrp);
        $('#updateEditable').val(item.editable);
        $('#updateGroupe').focus();
    }; // End Method
});