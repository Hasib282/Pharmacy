function ShowRefunds(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_id','user.user_name',{key:'bill_amount', type: 'number',footerType:'sum'},{key:'discount', type: 'number',footerType:'sum'},{key:'net_amount', type: 'number',footerType:'sum'},{key:'receive', type: 'number',footerType:'sum'},{key:'due_col', type: 'number',footerType:'sum'},{key:'due_disc', type: 'number',footerType:'sum'},{key:'due', type: 'number',footerType:'sum'}, 'booking_id'],
        actions: (row) => `
                <a class="print-receipt" href="/api/get/invoice?id=${row.tran_id}&status=1"> <i class="fa-solid fa-receipt"></i></a>

                <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                        
                <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
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
        { label: 'Booking Id', key:'booking_id' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('hotel/transaction/refunds', ShowRefunds);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#date");


    // Insert Ajax
    InsertAjax('hotel/transaction/deposits', {guest_id: { selector: '#guest', attribute: 'data-id' }, booking_id: { selector: '#hotel-booking', attribute: 'data-id' },head_id: { selector: '#head', attribute: 'data-id' }, groupe_id: { selector: '#groupe', attribute: 'data-groupe' }, type: 8, method: "Refund"}, function () {
        $('#guest').removeAttr('data-id');
        $('#hotel-booking').removeAttr('data-id');
        $('#date').focus();
    });


    // Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Transaction Receive ajax
    // UpdateTransaction('hotel/transaction/refunds', 'Receive', '8');
    

    // Delete Ajax
    DeleteAjax('hotel/transaction/refunds');


    // Pagination Ajax
    // PaginationAjax(ShowRefunds);


    // Search Ajax
    // SearchAjax('hotel/transaction/refunds', ShowRefunds, { type: 1, method: 'Receive' });


    // Search By Date
    SearchByDateAjax('hotel/transaction/refunds/search', ShowRefunds, {type: 8, method: 'Refund'});


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#updateHead').val('');
        $('#updateHead').removeAttr('data-id');
        $('#updateHead').removeAttr('data-groupe');
        $('#updatePatient').val();
        $('#updatePatient').removeAttr('data-id');
        $('#updateQty').val('1');
        $('#updateAmount').val('');
        $('#updateTotAmount').val('');
        localStorage.removeItem('transactionData');
        $('.transaction_grid tbody').html('');

        getTransactionGrid(item.tran_id);

        $('#id').val(item.id);
        
        $('#updateTranId').val(item.tran_id);

        var timestamps = new Date(item.tran_date);
        var formattedDate = timestamps.toLocaleDateString('en-US', { timeZone: 'UTC' });
        $('#updateDate').val(formattedDate);
        
        $('#updatePatient').attr('data-id',item.ptn_id);
        $('#updatePatient').val(item.patient.name);


        $('#updateTotalDiscount').val(item.discount);

        $('#updateAdvance').val(item.receive);

        
        $("#updateHead").focus();
    }
});