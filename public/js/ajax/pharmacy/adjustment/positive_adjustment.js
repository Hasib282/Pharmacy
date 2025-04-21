function ShowPharmacyPositiveAdjustments(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.tran_id}</td>
                    <td>${item.head.tran_head_name}</td>
                    <td>${item.store.store_name}</td>
                    <td>${item.quantity}</td>
                    <td>${new Date(item.tran_date).toISOString().split('T')[0]}</td>
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
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'select', options: [15, 30, 50, 100, 500] },
        { label: 'Company Id', key: 'company_id' },
        { label: 'Company Name', key: 'name' },
        { label: 'Permission', key: 'permission' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Transaction Groupe
    GetTransactionGroupe(6);


    // Load Data on Hard Reload
    ReloadData('pharmacy/adjustment/positive', ShowPharmacyPositiveAdjustments);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#store");

    
    // Insert Ajax
    InsertAjax('pharmacy/adjustment/positive', ShowPharmacyPositiveAdjustments, 
        {
            store: { selector: '#store', attribute: 'data-id' },
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
    EditAjax('pharmacy/adjustment/positive', EditFormInputValue);


    // Update Ajax
    UpdateAjax('pharmacy/adjustment/positive', ShowPharmacyPositiveAdjustments,
        {
            store: { selector: '#updateStore', attribute: 'data-id' },
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
    DeleteAjax('pharmacy/adjustment/positive', ShowPharmacyPositiveAdjustments);


    // Pagination Ajax
    // PaginationAjax(ShowPharmacyPositiveAdjustments);


    // Search Ajax
    // SearchAjax('pharmacy/adjustment/positive', ShowPharmacyPositiveAdjustments, { type: 6, method: 'Positive' });
    
    
    // Search By Date Ajax
    // SearchByDateAjax('pharmacy/adjustment/positive', ShowPharmacyPositiveAdjustments, { type: 6, method: 'Positive' });


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.data.id);
        $('#updateTranId').val(res.data.tran_id);
        $('#updateStore').attr('data-id', res.data.store_id);
        $('#updateStore').val(res.data.store.store_name);
        $('#updateProduct').attr('data-groupe', res.data.tran_groupe_id);
        $('#updateProduct').attr('data-id', res.data.tran_head_id);
        $('#updateProduct').val(res.data.head.tran_head_name);
        $('#updateQuantity').val(res.data.quantity);
        $('#updateCp').val(res.data.cp);
        $('#updateMrp').val(res.data.mrp);
    }
});