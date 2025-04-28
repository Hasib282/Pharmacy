function ShowTranWith(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['role.name','tran_with_name','tran_method'],
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
        { label: 'User Role', type:"select", key: 'user_role', method:"custom", options:[{val:4,text:"Client"}, {val:5,text:'Supplier'}] },
        { label: 'User Type', key: 'tran_with_name' },
        { label: 'Transaction Method', type:"select", key: 'tran_method', method:"custom", options:['Receive','Payment','Both'] },
        { label: 'Action', type: 'button' }
    ]);
    

    // Load Data on Hard Reload
    ReloadData('pharmacy/users/usertype', ShowTranWith);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#name");


    // Insert Ajax
    InsertAjax('pharmacy/users/usertype', {tranType: 6}, function() {
        $('#name').focus();
        $('#company').removeAttr('data-id');
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('pharmacy/users/usertype', {tranType: 6});
    

    // Delete Ajax
    DeleteAjax('pharmacy/users/usertype');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateName').val(item.tran_with_name);
        $('#updateRole').val(item.user_role);
        $('#updateTranMethod').val(item.tran_method);
        $('#updateName').focus();
    }; // End Method
});