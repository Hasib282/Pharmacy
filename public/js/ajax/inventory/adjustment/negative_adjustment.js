function ShowInventoryNegativeAdjustments(data, startIndex) {
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
    // Creating Select Options Dynamically
    $.ajax({
        url: `${apiUrl}/inventory/adjustment/negative`,
        method: "GET",
        success: function (res) {
            let groupein = "";
            let updategroupein = "";

            // Groupin chedckbox
            $.each(res.groupes, function(key, groupe) {
                groupein += `<input type="checkbox" id="groupe[]" name="groupe" class="groupe-checkbox"
                value="${groupe.id}" checked>`
            });
            $('#groupein').html(groupein);

            // Update Groupin chedckbox
            $.each(res.groupes, function(key, groupe) {
                updategroupein += `<input type="checkbox" id="groupe[]" name="groupe" class="updategroupe-checkbox"
                    value="${groupe.id}" checked>`
            });
            $('#updategroupein').html(updategroupein);
        },
    });


    // Load Data on Hard Reload
    ReloadData('inventory/adjustment/negative', ShowInventoryNegativeAdjustments);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#store");

    
    // Insert Ajax
    InsertAjax('inventory/adjustment/negative', ShowInventoryNegativeAdjustments, 
        {
            store: { selector: '#store', attribute: 'data-id' },
            product: { selector: '#product', attribute: 'data-id' },
            groupe: { selector: '#product', attribute: 'data-groupe' },
            company: { selector: '#company', attribute: 'data-id' },
            method: 'Negative',
            type: 5,
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
    EditAjax('inventory/adjustment/negative', EditFormInputValue);


    // Update Ajax
    UpdateAjax('inventory/adjustment/negative', ShowInventoryNegativeAdjustments,
        {
            store: { selector: '#updateStore', attribute: 'data-id' },
            product: { selector: '#updateProduct', attribute: 'data-id' },
            groupe: { selector: '#updateProduct', attribute: 'data-groupe' },
            method: 'Negative',
            type: 5,
        },
        function () {
            $('#updateProduct').val('');
            $('#updateProduct').removeAttr('data-id');
            $('#updateProduct').removeAttr('data-groupe');
            $('#updateQuantity').val('1');
        }
    );
    

    // Delete Ajax
    DeleteAjax('inventory/adjustment/negative', ShowInventoryNegativeAdjustments);


    // Pagination Ajax
    PaginationAjax(ShowInventoryNegativeAdjustments);


    // Search Ajax
    SearchAjax('inventory/adjustment/negative', ShowInventoryNegativeAdjustments, { type: 5, method: 'Negative' });
    
    
    // Search By Date Ajax
    SearchByDateAjax('inventory/adjustment/negative', ShowInventoryNegativeAdjustments, { type: 5, method: 'Negative' });


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.adjust.id);
        $('#updateTranId').val(res.adjust.tran_id);
        $('#updateStore').attr('data-id', res.adjust.store_id);
        $('#updateStore').val(res.adjust.store.store_name);
        $('#updateProduct').attr('data-groupe', res.adjust.tran_groupe_id);
        $('#updateProduct').attr('data-id', res.adjust.tran_head_id);
        $('#updateProduct').val(res.adjust.head.tran_head_name);
        $('#updateQuantity').val(res.adjust.quantity);
        $('#updateCp').val(res.adjust.cp);
        $('#updateMrp').val(res.adjust.mrp);
    }
});