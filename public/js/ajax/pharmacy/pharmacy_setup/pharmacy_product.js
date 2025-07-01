function ShowPharmacyProducts(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['groupe.tran_groupe_name','tran_head_name','category.category_name','manufecturer.manufacturer_name','form.form_name','quantity','unit.unit_name',{key:'cp', type: 'number'},{key:'mrp', type: 'number'},{key:'expiry_date', type: 'date'},'company_id'],
        
         actions: (row) => {
            let buttons = '';
        
            if (userPermissions.includes(134) || role == 1) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }
            
            buttons += `
                <button data-id="${row.id}" id="delete_status" class="icon-wrapper" title="Toggle Delete"><i class="fa-solid fa-trash-arrow-up main-icon"></i><i class="fa-solid fa-arrows-rotate ring-icon"></i></button>
            `;

            if (userPermissions.includes(135) || role == 1) {
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
        { label: 'Groupe Name', type:"select", key: 'groupe_id', method:"fetch", link:'admin/trangroupes/get', name:"tran_groupe_name", data:{type:6} },
        { label: 'Product Name', key: 'tran_head_name' },
        { label: 'Category Name', key: 'category.category_name' },
        { label: 'Manufacturer', key: 'manufecturer.manufacturer_name' },
        { label: 'Item Form Name	', key: 'form.form_name' },
        { label: 'QTY', key: 'quantity' },
        { label: 'Unite', key: 'unit.unit_name' },
        { label: 'CP' },
        { label: 'MRP' },
        { label: 'Expiry', key: 'expiry_date', type:'date' },
        { label: 'Company Id', key: 'company_id' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Transaction Groupe
    GetTransactionGroupe(6, null, "Ok");


    // Load Data on Hard Reload
    ReloadData('pharmacy/setup/product', ShowPharmacyProducts);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#productName");
    

    // Insert Ajax
    InsertAjax('pharmacy/setup/product', 
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
        }
    );


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('pharmacy/setup/product',
        {
            category : { selector: '#updateCategory', attribute: 'data-id' },
            manufacturer : { selector: '#updateManufacturer', attribute: 'data-id' },
            form : { selector: '#updateForm', attribute: 'data-id' },
            unit : { selector: '#updateUnit', attribute: 'data-id' },
            store : { selector: '#updateStore', attribute: 'data-id' },
        }
    );
    

    // Delete status  Ajax
    DeleteAjax('pharmacy/setup/product');
    

    // Delete Ajax
    DeleteStatusAjax('pharmacy/setup/product');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#EditForm')[0].reset();
        $('#updateCategory').removeAttr('data-id')
        $('#updateManufacturer').removeAttr('data-id')
        $('#updateForm').removeAttr('data-id')
        $('#updateUnit').removeAttr('data-id')
        $('#updateStore').removeAttr('data-id')

        $('#id').val(item.id);
        $('#updateProductName').val(item.tran_head_name);
        $('#updateProductName').focus();
        $('#updateGroupe').val(item.groupe_id);

        if(item.category_id){
            $('#updateCategory').val(item.category.category_name);
            $('#updateCategory').attr('data-id', item.category.id);
        }
        
        if(item.manufacturer_id){
            $('#updateManufacturer').val(item.manufecturer.manufacturer_name);
            $('#updateManufacturer').attr('data-id', item.manufecturer.id);
        }
        
        if(item.form_id){
            $('#updateForm').val(item.form.form_name);
            $('#updateForm').attr('data-id', item.form_id);
        }

        if(item.unit_id){
            $('#updateUnit').val(item.unit.unit_name);
            $('#updateUnit').attr('data-id', item.unit_id);
        }

        if(item.store_id){
            $('#updateStore').val(item.store.store_name);
            $('#updateStore').attr('data-id', item.store_id);
        }

        $('#updateQuantity').val(item.quantity);
        $('#updateCp').val(item.cp);
        $('#updateMrp').val(item.mrp);
        $('#updateExpiryDate').val(item.expired_date);
    }
});