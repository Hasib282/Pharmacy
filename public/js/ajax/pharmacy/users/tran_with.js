function ShowTranWith(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_with_name','role.name','tran_method'],
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

        // Create options dynamically
        $('#updateRole').html('');
        $('#updateRole').append(`<option value="4" ${item.user_role == '4' ? 'selected' : ''}>Client</option>
                                    <option value="5" ${item.user_role == '5' ? 'selected' : ''}>Supplier</option>`);

        $('#updateTranMethod').html('');
        $('#updateTranMethod').append(`<option value="Receive" ${item.tran_method === 'Receive' ? 'selected' : ''}>Receive</option>
                                    <option value="Payment" ${item.tran_method === 'Payment' ? 'selected' : ''}>Payment</option>
                                    <option value="Both" ${item.tran_method === 'Both' ? 'selected' : ''}>Both</option>`);
        $('#updateName').focus();
    }; // End Method
});