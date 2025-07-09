function ShowTranHead(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['groupe.tran_groupe_name','tran_head_name','mrp','company_id'],
        
        actions: (row) => {
            let buttons = '';
        
            if (userPermissions.includes(313) || role == 1) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }

            if (userPermissions.includes(314) || role == 1) {
                buttons += `
                <button data-id="${row.id}" id="delete_status" class="icon-wrapper" title="Toggle Delete"><i class="fa-solid fa-trash-arrow-up main-icon"></i><i class="fa-solid fa-arrows-rotate ring-icon"></i></button>
                `;
                
                if (role == 1 || role == 2) {
                    buttons += `
                        <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                    `;
                }
            }
        
            return buttons;
        }
    });
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Transaction Groupe', type:"select", key: 'groupe_id', method:"fetch", link:'admin/trangroupes/get', name:"tran_groupe_name", data:{type:8} },
        { label: 'Transaction Head Name', key: 'tran_head_name' },
        { label: 'Price' },
        { label: 'Company Id', key: 'company_id' },
        { label: 'Action', type: 'button' }
    ]);


    // Get Transaction Groupe
    GetTransactionGroupe(8, null, "Ok");

    
    // Load Data on Hard Reload
    ReloadData('hotel/setup/services', ShowTranHead);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#groupe");


    // Insert Ajax
    InsertAjax('hotel/setup/services', {company: { selector: "#company", attribute: 'data-id' }}, function() {
        $('#groupe').focus();
        $('#company').removeAttr('data-id');
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hotel/setup/services');
    

    // Delete Ajax
    DeleteAjax('hotel/setup/services');
    

    // Delete  status Ajax
    DeleteStatusAjax('hotel/setup/services');


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