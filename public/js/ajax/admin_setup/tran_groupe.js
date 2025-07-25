function ShowTranGroupe(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_groupe_name','type.type_name','tran_method','company_id'],
        actions: (row) => `
                <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>

                <button data-id="${row.id}" id="delete_status" class="icon-wrapper" title="Toggle Delete"><i class="fa-solid fa-trash-arrow-up main-icon"></i><i class="fa-solid fa-arrows-rotate ring-icon"></i></button>
                        
                <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                `,
    });
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Transaction Groupe Name', key: 'tran_groupe_name' },
        { label: 'Transaction Groupe Type', type:"select", key: 'tran_groupe_type', method:"fetch", link:'admin/mainheads/get', name:'type_name' },
        { label: 'Transaction Method', type:"select", key: 'tran_method', method:"custom", options:['Receive','Payment','Both'] },
        { label: 'Company Id', key: 'company_id' },
        { label: 'Action', type: 'button' }
    ]);

    
    // Load Data on Hard Reload
    ReloadData('admin/trangroupes', ShowTranGroupe);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#groupeName");


    // Insert Ajax
    InsertAjax('admin/trangroupes', {company: { selector: "#company", attribute: 'data-id' }}, function() {
        $('#groupeName').focus();
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/trangroupes');
    

    // Delete Ajax
    DeleteAjax('admin/trangroupes');
    

    // Delete status Ajax
    DeleteStatusAjax('admin/trangroupes');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateGroupeName').val(item.tran_groupe_name);
        $('#updateType').val(item.tran_groupe_type);
        $('#updateMethod').val(item.tran_method);
        $('#updateGroupeName').focus();
    }; // End Method



    // Get Trantype
    GetSelectInputList('admin/mainheads/get', function (res) {
        CreateSelectOptions('#type', "Select Tran Type", res.data, 'type_name');
        CreateSelectOptions('#updateType', "Select Tran Type", res.data, 'type_name');
    })
});