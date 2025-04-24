function ShowTranWith(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_with_name','role.name','tran_method','type.type_name'],
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
        { label: 'User Type', key: 'tran_with_name' },
        { label: 'User Role', type:"select", key: 'user_role', method:"fetch", link:'admin/users/roles/get', name:"name" },
        { label: 'Transaction Method', type:"select", key: 'tran_method', method:"custom", options:['Receive','Payment','Both'] },
        { label: 'Transaction Type', type:"select", key: 'tran_type', method:"fetch", link:'admin/mainheads/get', name:"tran_groupe_name" },
        { label: 'Action', type: 'button' }
    ]);
    
    // Load Data on Hard Reload
    ReloadData('admin/tranwith', ShowTranWith);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#name");


    // Insert Ajax
    InsertAjax('admin/tranwith', { company: { selector: "#company", attribute: 'data-id' }}, function() {
        $('#name').focus();
        $('#company').removeAttr('data-id');
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/tranwith');
    

    // Delete Ajax
    DeleteAjax('admin/tranwith');


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.data.id);
        $('#updateName').val(res.data.tran_with_name);
        $('#updateRole').val(res.data.user_role);
        $('#updateTranType').val(res.data.tran_type);
        $('#updateTranMethod').html('');
        $('#updateTranMethod').append(`<option value="Receive" ${res.data.tran_method === 'Receive' ? 'selected' : ''}>Receive</option>
                                    <option value="Payment" ${res.data.tran_method === 'Payment' ? 'selected' : ''}>Payment</option>
                                    <option value="Both" ${res.data.tran_method === 'Both' ? 'selected' : ''}>Both</option>`);
        $('#updateName').focus();
    }; // End Method



    // Get Trantype
    GetSelectInputList('admin/mainheads/get', function (res) {
        CreateSelectOptions('#tranType', 'Select Tran Type', res.data, null, 'name');
        CreateSelectOptions('#updateTranType', 'Select Tran Type', res.data, null, 'name');
    })
    
    // Get Roles
    GetSelectInputList('admin/users/roles/get', function (res) {
        CreateSelectOptions('#role', 'Select Role', res.data, null, 'name');
        CreateSelectOptions('#updateRole', 'Select Role', res.data, null, 'name');
    })
});