// function ShowInventoryProducts(data, startIndex) {
//     let tableRows = '';
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             tableRows += `
//                 <tr>
//                     <td>${startIndex + key + 1}</td>
//                     <td>${item.tran_head_name}</td>
//                     <td>${item.groupe.tran_groupe_name}</td>
//                     <td>${item.category_id == null ? '': item.category.category_name} </td>
//                     <td>${item.manufacturer_id == null ? '': item.manufecturer.manufacturer_name}</td>
//                     <td>${item.form_id == null ? '': item.form.form_name}</td>
//                     <td>${item.quantity}</td>
//                     <td>${item.unit_id == null ? '': item.unit.unit_name}</td>
//                     <td>${item.cp}</td>
//                     <td>${item.mrp}</td>
//                     <td>${item.expiry_date}</td>
//                     ${role == 1 ? `<td>${item.company_id }</td>`: ''}
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

function ShowInventoryProducts(res) {
    new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_head_name','groupe.tran_groupe_name','category.category_name','manufecturer.manufacturer_name','form.form_name','quantity','unit.unit_name',{key:'cp', type: 'number'},{key:'mrp', type: 'number'},{key:'expiry_date', type: 'date'},'company_id'],
        actions: (row) => `
                <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                        
                <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                `,
    });
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'select', options: [15, 30, 50, 100, 500] },
        { label: 'Product Name', key: 'tran_head_name' },
        { label: 'Transaction Groupe', key: 'groupe.tran_groupe_name' },
        { label: 'Category Name', key: 'category.category_name' },
        { label: 'Manufacturer', key: 'manufecturer.manufacturer_name' },
        { label: 'Item Form Name	', key: 'form.form_name' },
        { label: 'QTY', key: 'quantity' },
        { label: 'Unite', key: 'unit.unit_name' },
        { label: 'CP', key: 'cp' },
        { label: 'MRP', key: 'mrp' },
        { label: 'Expiry', key: 'expiry_date', type:'date' },
        { label: 'Company Id', key: 'company_id' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Transaction Groupe
    GetTransactionGroupe(5, null, "Ok");


    // Load Data on Hard Reload
    ReloadData('inventory/setup/product', ShowInventoryProducts);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#productName");
    

    // Insert Ajax
    InsertAjax('inventory/setup/product', ShowInventoryProducts, 
        {
            category : { selector: '#category', attribute: 'data-id' },
            manufacturer : { selector: '#manufacturer', attribute: 'data-id' },
            form : { selector: '#form', attribute: 'data-id' },
            unit : { selector: '#unit', attribute: 'data-id' },
            store : { selector: '#store', attribute: 'data-id' },
            company: { selector: "#company", attribute: 'data-id' },
        },
        function() {
            $('#productName').focus();
            $('#category').removeAttr('data-id');
            $('#manufacturer').removeAttr('data-id');
            $('#form').removeAttr('data-id');
            $('#unit').removeAttr('data-id');
            $('#store').removeAttr('data-id');
            $('#company').removeAttr('data-id');
        }
    );


    //Edit Ajax
    EditAjax('inventory/setup/product', EditFormInputValue, EditModalOn);


    // Update Ajax
    UpdateAjax('inventory/setup/product', ShowInventoryProducts,
        {
            category : { selector: '#updateCategory', attribute: 'data-id' },
            manufacturer : { selector: '#updateManufacturer', attribute: 'data-id' },
            form : { selector: '#updateForm', attribute: 'data-id' },
            unit : { selector: '#updateUnit', attribute: 'data-id' },
            store : { selector: '#updateStore', attribute: 'data-id' },
        }
    );
    

    // Delete Ajax
    DeleteAjax('inventory/setup/product', ShowInventoryProducts);


    // Pagination Ajax
    // PaginationAjax(ShowInventoryProducts);


    // Search Ajax
    // SearchAjax('inventory/setup/product', ShowInventoryProducts, {  });


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.data.id);
        $('#updateProductName').val(res.data.tran_head_name);
        $('#updateProductName').focus();

        $('#updateGroupe').html('');
        $('#updateGroupe').append(`<option value="" >Select Product Groupe</option>`);
        $.each(res.groupes, function (key, groupe) {
            $('#updateGroupe').append(`<option value="${groupe.id}" ${res.data.groupe_id === groupe.id ? 'selected' : ''}>${groupe.tran_groupe_name}</option>`);
        });

        if(res.data.category_id){
            $('#updateCategory').val(res.data.category.category_name);
            $('#updateCategory').attr('data-id', res.data.category.id);
        }
        
        if(res.data.manufacturer_id){
            $('#updateManufacturer').val(res.data.manufecturer.manufacturer_name);
            $('#updateManufacturer').attr('data-id', res.data.manufecturer.id);
        }
        
        if(res.data.form_id){
            $('#updateForm').val(res.data.form.form_name);
            $('#updateForm').attr('data-id', res.data.form_id);
        }

        if(res.data.unit_id){
            $('#updateUnit').val(res.data.unit.unit_name);
            $('#updateUnit').attr('data-id', res.data.unit_id);
        }

        if(res.data.store_id){
            $('#updateStore').val(res.data.store.store_name);
            $('#updateStore').attr('data-id', res.data.store_id);
        }

        $('#updateQuantity').val(res.data.quantity);
        $('#updateCp').val(res.data.cp);
        $('#updateMrp').val(res.data.mrp);
        $('#updateExpiryDate').val(res.data.expired_date);
    }


    // Additional Edit Modal On
    function EditModalOn(){
        $('#EditForm')[0].reset();
        $('#updateCategory').removeAttr('data-id')
        $('#updateManufacturer').removeAttr('data-id')
        $('#updateForm').removeAttr('data-id')
        $('#updateUnit').removeAttr('data-id')
        $('#updateStore').removeAttr('data-id')
    }
});