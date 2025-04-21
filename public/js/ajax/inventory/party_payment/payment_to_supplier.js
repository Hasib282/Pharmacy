function ShowPaymentToSuppliers(data, startIndex) {
    let tableRows = '';
    let totalBillAmount = 0;
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.tran_id}</td>
                    <td>${item.user.user_name}</td>
                    <td style="text-align: right">${item.bill_amount.toLocaleString('en-US', { minimumFractionDigits: 0 })} Tk.</td>
                    <td>
                        <div style="display: flex;gap:5px;">
                            <button class="open-modal" data-modal-id="editModal" id="edit"
                                    data-id="${item.tran_id}"><i class="fas fa-edit"></i></button>
                            
                            <button data-id="${item.tran_id}" id="delete"><i class="fas fa-trash"></i></button>
                            
                        </div>
                    </td>
                </tr>
            `;

            totalBillAmount += parseFloat(item.bill_amount) || 0;
        });

        // Inject the generated rows into the table body
        $('.load-data .show-table tbody').html(tableRows);


        $('.load-data .show-table tfoot').html(`
            <tr>
                <td style="text-align: right" colspan="3">Total:</td>
                <td style="text-align: right">${totalBillAmount.toLocaleString('en-US', { minimumFractionDigits: 0 })} Tk.</td>
                <td></td>
            </tr>
        `);
    }
    else{
        $('.load-data .show-table tbody').html('');
        $('.load-data .show-table tfoot').html('<tr><td colspan="11" style="text-align:center;">No Transaction Found</td></tr>')
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


    // Load Data on Hard Reload
    ReloadData('inventory/party/payment', ShowPaymentToSuppliers);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#date", function(){
        GetTransactionWith(5, 'Payment', '#within')
        $('.due-grid tbody').html('');
        $('.due-grid tfoot').html('');
    });


    // Insert Ajax
    InsertAjax('inventory/party/payment', ShowPaymentToSuppliers, 
        {
            user: { selector: '#user', attribute: 'data-id' },
            withs: { selector: '#user', attribute: 'data-with' },
            'groupe': 2,
            'head': 2,
            'type': 2,
            'method': 'Payment',
        }, 
        function() {
            $('#user').removeAttr('data-id');
            $('#user').removeAttr('data-with');
            $('.due-grid tbody').html('');
            $('.due-grid tfoot').html('');
        }
    );


    //Edit Ajax
    EditAjax('inventory/party/payment', EditFormInputValue, EditModalOn);


    // Update Ajax
    // UpdateAjax('inventory/party/payment', ShowPaymentToSuppliers);
    

    // Delete Ajax
    // DeleteAjax('inventory/party/payment', ShowPaymentToSuppliers);


    // Pagination Ajax
    // PaginationAjax(ShowPaymentToSuppliers);


    // Search Ajax
    // SearchAjax('inventory/party/payment', ShowPaymentToSuppliers);


    // Search By Date
    // SearchByDateAjax('inventory/party/payment', ShowPaymentToSuppliers);


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#updateTranId').val(res.data.tran_id);

        getDueListByUserId(res.data.tran_user, '.due-grid tbody');
        $('#updateUser').attr('data-id',res.data.tran_user);
        $('#updateUser').val(res.data.user.user_name);
        $('#updateAmount').val(res.data.payment);
        $('#updateDiscount').val(res.data.discount);
    }


    // Edit Modal Open Functionality
    function EditModalOn(){
        GetTransactionWith(5, 'Payment', '#within')
        $('.due-grid tbody').html('');
        $('.due-grid tfoot').html('');
    }
});