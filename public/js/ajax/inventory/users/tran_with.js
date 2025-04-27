// function ShowTranWith(data, startIndex) {
//     let tableRows = '';
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             tableRows += `
//                 <tr>
//                     <td>${startIndex + key + 1}</td>
//                     <td>${item.tran_with_name}</td>
//                     <td>${item.role.name}</td>
//                     <td>${item.tran_method}</td>
//                     <td>
//                         <div style="display: flex;gap:5px;">
                            
//                             <button class="open-modal" data-modal-id="editModal" id="edit" data-id="${item.id}"><i class="fas fa-edit"></i></button>
                            
//                             <button data-id="${item.id}" id="delete"><i class="fas fa-trash"></i></button>
                            
//                         </div>
//                     </td>
//                 </tr>
//             `;
//         });

//         // Inject the generated rows into the table body
//         $('.load-data .show-table tbody').html(tableRows);
//         $('.load-data .show-table tfoot').html('')
//     }
//     else{
//         $('.load-data .show-table tbody').html('');
//         $('.load-data .show-table tfoot').html('<tr><td colspan="8" style="text-align:center;">No Data Found</td></tr>')
//     }
// }; // End Function

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
    ReloadData('inventory/users/usertype', ShowTranWith);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#name");


    // Insert Ajax
    InsertAjax('inventory/users/usertype', {tranType: 5}, function() {
        $('#name').focus();
        $('#company').removeAttr('data-id');
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('inventory/users/usertype', {tranType: 5});
    

    // Delete Ajax
    DeleteAjax('inventory/users/usertype');


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