function ShowServices(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_id','user.user_name',{key:'bill_amount', type: 'number'},{key:'discount', type: 'number'},{key:'net_amount', type: 'number'},{key:'payment', type: 'number'},{key:'due_col', type: 'number'},{key:'due_discount', type: 'number'},{key:'due', type: 'number'}],
        actions: (row) => `
                <a class="print-receipt" href="/api/get/invoice?id=${row.tran_id}&status=1"> <i class="fa-solid fa-receipt"></i></a>

                <button data-modal-id="editModal" id="edit" data-id="${row.tran_id}"><i class="fas fa-edit"></i></button>
                        
                <button data-id="${row.tran_id}" id="delete"><i class="fas fa-trash"></i></button>
                `,
    });
}

$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Transaction Id', key: 'tran_id' },
        { label: 'User', key: 'user.user_name' },
        { label: 'Total' },
        { label: 'Discount' },
        { label: 'Net Total' },
        { label: 'Advance' },
        { label: 'Due Col' },
        { label: 'Due Discount' },
        { label: 'Due' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Transaction Groupe
    GetTransactionGroupe(7);


    // Load Data on Hard Reload
    ReloadData('hospital/transaction/services', ShowTransactionReceives);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#date", function(){
        GetTransactionWith('1', 'Receive', '#within');
        localStorage.removeItem('transactionData');
        $('.transaction_grid tbody').html('');
    });


    // Insert Into Local Storage
    InsertLocalStorage();


    // Insert Transaction Receive ajax
    InsertTransaction('hospital/transaction/services', ShowTransactionReceives, 'Receive', '1', function() {
        $('#location').removeAttr('data-id');
        $('#user').removeAttr('data-id');
        $('#user').removeAttr('data-with');
        $('#date').focus();
        $('.transaction_grid tbody').html('');
        localStorage.removeItem('transactionData');
    });


    //Edit Ajax
    EditAjax('hospital/transaction/services', EditFormInputValue, EditModalOn);


    // Update Transaction Receive ajax
    UpdateTransaction('hospital/transaction/services', ShowTransactionReceives, 'Receive', '1');
    

    // Delete Ajax
    DeleteAjax('hospital/transaction/services', ShowTransactionReceives);


    // Pagination Ajax
    // PaginationAjax(ShowTransactionReceives);


    // Search Ajax
    // SearchAjax('hospital/transaction/services', ShowTransactionReceives, { type: 1, method: 'Receive' });


    // Search By Date
    // SearchByDateAjax('hospital/transaction/services', ShowTransactionReceives, {type: 1, method: 'Receive'});


    // Additional Edit Functionality
    function EditFormInputValue(res){
        getTransactionGrid(res.data.tran_id);

        $('#id').val(res.data.id);
        
        $('#updateTranId').val(res.data.tran_id);

        var timestamps = new Date(res.data.tran_date);
        var formattedDate = timestamps.toLocaleDateString('en-US', { timeZone: 'UTC' });
        $('#updateDate').val(formattedDate);
        
        $('#updateUser').attr('data-id',res.data.tran_user);
        $('#updateUser').attr('data-with',res.data.tran_type_with);
        $('#updateUser').val(res.data.user.user_name);


        $('#updateTotalDiscount').val(res.data.discount);

        $('#updateAdvance').val(res.data.receive);

        
        $("#updateHead").focus();
    }

    

    // Edit Modal Open Functionality
    function EditModalOn(){
        $('#updateHead').val('');
        $('#updateHead').removeAttr('data-id');
        $('#updateHead').removeAttr('data-groupe');
        $('#updateQuantity').val('1');
        $('#updateAmount').val('');
        $('#updateTotAmount').val('');
        $('#dId').val('');
        GetTransactionWith('1', 'Receive', '#within');
        localStorage.removeItem('transactionData');
        $('.transaction_grid tbody').html('');
    }



    // // Additional Edit Functionality
    // function EditFormInputValue(res){
    //     getTransactionGrid(res.data.tran_id);

    //     $('#id').val(res.data.id);
        
    //     $('#updateTranId').val(res.data.tran_id);

    //     var timestamps = new Date(res.data.tran_date);
    //     var formattedDate = timestamps.toLocaleDateString('en-US', { timeZone: 'UTC' });
    //     $('#updateDate').val(formattedDate);

    //     $('#updateStore').val(res.data.store.store_name);
    //     $('#updateStore').attr('data-id', res.data.store_id);
        
    //     $('#updateUser').attr('data-id',res.data.tran_user);
    //     $('#updateUser').attr('data-with',res.data.tran_type_with);
    //     $('#updateUser').val(res.data.user.user_name);

    //     $('#updateTotalDiscount').val(res.data.discount);

    //     $('#updateAdvance').val(res.data.payment);

        
    //     $("#updateProduct").focus();
    // }


    // function EditModalOn() {
    //     $('#updateProduct').val('');
    //     $('#updateProduct').removeAttr('data-id');
    //     $('#updateProduct').removeAttr('data-groupe');
    //     $('#updateUnit').val('');
    //     $('#updateUnit').removeAttr('data-id');
    //     $('#updateQuantity').val('1');
    //     $('#updateCp').val('');
    //     $('#updateMrp').val('');
    //     let currentDate = new Date().toISOString().split('T')[0];
    //     $('#updateExpiry').val(currentDate);
    //     $('#updateTotAmount').val('');
    //     $('#dId').val('');
    //     GetTransactionWith(6, 'Payment', '#updatewithin');
    //     localStorage.removeItem('transactionData');
    //     $('.transaction_grid tbody').html('');
    // }


    // Insert Into Local Storage
    // InsertLocalStorage();


    // // Insert Pharmacy Purchase ajax
    // InsertTransaction('pharmacy/transaction/purchase', ShowPharmacyPurchases, 'Purchase', '6', function() {
    //     $('#location').removeAttr('data-id');
    //     $('#user').removeAttr('data-id');
    //     $('#user').removeAttr('data-with');
    //     $('#store').removeAttr('data-id');
    //     $('#status').val('1');
    //     $('.transaction_grid tbody').html('');
    //     localStorage.removeItem('transactionData');
    // });


    // // Update Pharmacy Issue ajax
    // UpdateTransaction('pharmacy/transaction/purchase', ShowPharmacyPurchases, 'Purchase', "6");
});