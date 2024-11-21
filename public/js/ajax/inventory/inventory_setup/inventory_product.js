function ShowInventoryProducts(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.tran_head_name}</td>
                    <td>${item.groupe.tran_groupe_name}</td>
                    <td>${item.category_id == null ? '': item.category.category_name} </td>
                    <td>${item.manufacturer_id == null ? '': item.manufecturer.manufacturer_name}</td>
                    <td>${item.form_id == null ? '': item.form.form_name}</td>
                    <td>${item.quantity}</td>
                    <td>${item.unit_id == null ? '': item.unit.unit_name}</td>
                    <td>${item.cp}</td>
                    <td>${item.mrp}</td>
                    <td>${item.expiry_date}</td>
                    <td>${item.store_id == null ? '': item.store.store_name}</td>
                    <td>
                        <div style="display: flex;gap:5px;">
                            <button class="open-modal" data-modal-id="editModal" id="edit"
                                    data-id="${item.id}"><i class="fas fa-edit"></i></button>
                            <button data-id="${item.id}" id="delete"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            `;
        });

        // Inject the generated rows into the table body
        $('.load-data .show-table tbody').html(tableRows);
        $('.load-data .show-table tfoot').html('')
    }
    else{
        $('.load-data .show-table tbody').html('');
        $('.load-data .show-table tfoot').html('<tr><td colspan="8" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Creating Select Options Dynamically
    $.ajax({
        url: `${apiUrl}/inventory/setup/product`,
        method: "GET",
        success: function (res) {
            CreateSelectOptions('#groupe', 'Select Transaction Groupe', res.groupes, null, 'tran_groupe_name')
        },
    });


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
        },
        function() {
            $('#productName').focus();
            $('#category').removeAttr('data-id');
            $('#manufacturer').removeAttr('data-id');
            $('#form').removeAttr('data-id');
            $('#unit').removeAttr('data-id');
            $('#store').removeAttr('data-id');
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
    PaginationAjax(ShowInventoryProducts);


    // Search Ajax
    SearchAjax('inventory/setup/product', ShowInventoryProducts, {  });


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.heads.id);
        $('#updateProductName').val(res.heads.tran_head_name);
        $('#updateProductName').focus();

        $('#updateGroupe').html('');
        $('#updateGroupe').append(`<option value="" >Select Product Groupe</option>`);
        $.each(res.groupes, function (key, groupe) {
            $('#updateGroupe').append(`<option value="${groupe.id}" ${res.heads.groupe_id === groupe.id ? 'selected' : ''}>${groupe.tran_groupe_name}</option>`);
        });

        if(res.heads.category_id){
            $('#updateCategory').val(res.heads.category.category_name);
            $('#updateCategory').attr('data-id', res.heads.category.id);
        }
        
        if(res.heads.manufacturer_id){
            $('#updateManufacturer').val(res.heads.manufecturer.manufacturer_name);
            $('#updateManufacturer').attr('data-id', res.heads.manufecturer.id);
        }
        
        if(res.heads.form_id){
            $('#updateForm').val(res.heads.form.form_name);
            $('#updateForm').attr('data-id', res.heads.form_id);
        }

        if(res.heads.unit_id){
            $('#updateUnit').val(res.heads.unit.unit_name);
            $('#updateUnit').attr('data-id', res.heads.unit_id);
        }

        if(res.heads.store_id){
            $('#updateStore').val(res.heads.store.store_name);
            $('#updateStore').attr('data-id', res.heads.store_id);
        }

        $('#updateQuantity').val(res.heads.quantity);
        $('#updateCp').val(res.heads.cp);
        $('#updateMrp').val(res.heads.mrp);
        $('#updateExpiryDate').val(res.heads.expired_date);
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