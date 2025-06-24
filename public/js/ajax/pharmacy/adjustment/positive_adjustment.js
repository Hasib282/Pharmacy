// function ShowPharmacyPositiveAdjustments(data, startIndex) {
//     let tableRows = '';
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             tableRows += `
//                 <tr>
//                     <td>${startIndex + key + 1}</td>
//                     <td>${item.tran_id}</td>
//                     <td>${item.head.tran_head_name}</td>
//                     <td>${item.store.store_name}</td>
//                     <td>${item.quantity}</td>
//                     <td>${new Date(item.tran_date).toISOString().split('T')[0]}</td>
//                     <td>
//                         <div style="display: flex;gap:5px;">

//                             <button class="open-modal" data-modal-id="editModal" id="edit"
//                                     data-id="${item.id}"><i class="fas fa-edit"></i></button>

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

function ShowPharmacyPositiveAdjustments(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_id','head.tran_head_name','store.store_name','quantity',{key:'tran_date', type: 'date'}],
       
        actions: (row) => {
            let buttons = '';
        
            if (userPermissions.includes(167)) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }
            
            if (userPermissions.includes(168)) {
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
        { label: ' Id', key: 'tran_id' },
        { label: 'Product Name', key: 'head.tran_head_name' },
        { label: 'Store Name', key: 'store.store_name' },
        { label: 'Quantity', key: 'quantity' },
        { label: 'Date', key:'tran_date', type:"date" },
        { label: 'Action', type: 'button' }
    ]);


    // Load Transaction Groupe
    GetTransactionGroupe(6);


    // Load Data on Hard Reload
    ReloadData('pharmacy/adjustment/positive', ShowPharmacyPositiveAdjustments);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#store");

    
    // Insert Ajax
    InsertAjax('pharmacy/adjustment/positive', 
        {
            product: { selector: '#product', attribute: 'data-id' },
            groupe: { selector: '#product', attribute: 'data-groupe' },
            company: { selector: '#company', attribute: 'data-id' },
            method: 'Positive',
            type: 6,
        }, 
        function() {
            $('#store').focus();
            $('#store').val('');
            $('#store').removeAttr('data-id');
            $('#product').val('');
            $('#product').removeAttr('data-id');
            $('#product').removeAttr('data-groupe');
            $('#quantity').val('1');
        }
    );


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('pharmacy/adjustment/positive',
        {
            product: { selector: '#updateProduct', attribute: 'data-id' },
            groupe: { selector: '#updateProduct', attribute: 'data-groupe' },
            method: 'Positive',
            type: 6,
        },
        function () {
            $('#updateProduct').val('');
            $('#updateProduct').removeAttr('data-id');
            $('#updateProduct').removeAttr('data-groupe');
            $('#updateQuantity').val('1');
        }
    );
    

    // Delete Ajax
    DeleteAjax('pharmacy/adjustment/positive');


    // Search By Date Ajax
    SearchByDateAjax('pharmacy/adjustment/positive/search', ShowPharmacyPositiveAdjustments, { type: 6, method: 'Positive' });


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateTranId').val(item.tran_id);
        $('#updateStore').val(item.store_id);
        $('#updateProduct').attr('data-groupe', item.tran_groupe_id);
        $('#updateProduct').attr('data-id', item.tran_head_id);
        $('#updateProduct').val(item.head.tran_head_name);
        $('#updateQuantity').val(item.quantity);
        $('#updateCp').val(item.cp);
        $('#updateMrp').val(item.mrp);
    }


    // Get Store 
    GetSelectInputList('admin/stores/get', function (res) {
        CreateSelectOptions('#store', 'Select Store', res.data, 'store_name');
        CreateSelectOptions('#updateStore', 'Select Store', res.data, 'store_name');
    })
});