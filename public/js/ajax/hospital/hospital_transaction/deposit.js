function ShowServices(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_id','patient.name',{key:'bill_amount', type: 'number',footerType:'sum'},{key:'discount', type: 'number',footerType:'sum'},{key:'net_amount', type: 'number',footerType:'sum'},{key:'receive', type: 'number',footerType:'sum'},{key:'due_col', type: 'number',footerType:'sum'},{key:'due_disc', type: 'number',footerType:'sum'},{key:'due', type: 'number',footerType:'sum'}],
        
        actions: (row) => {
            let buttons = '';

            buttons += `
                    <a class="print-receipt" href="/api/get/invoice?id=${row.tran_id}&status=1"> <i class="fa-solid fa-receipt"></i></a>
                `;
        
            if (userPermissions.includes(404) || role == 1) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }

            buttons += `
                <button data-id="${row.id}" id="delete_status"><i class="fa-solid fa-trash-arrow-up"></i></button>
            `;
            
            if (userPermissions.includes(405) || role == 1) {
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
        { label: 'Transaction Id', key: 'tran_id' },
        { label: 'User', key: 'patient.name' },
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
    ReloadData('hospital/transaction/services', ShowServices);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#date", function(){
        $('#date').focus();
        localStorage.removeItem('transactionData');
        $('.transaction_grid tbody').html('');
    });


    // Insert Into Local Storage
    InsertLocalStorage();


    // Insert Transaction Receive ajax
    InsertTransaction('hospital/transaction/services', 'Receive', '7', function() {
        $('#patient').removeAttr('data-id');
        $('#date').focus();
        $('.transaction_grid tbody').html('');
    });


    // Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Transaction Receive ajax
    UpdateTransaction('hospital/transaction/services', 'Receive', '7');
    

    // Delete Ajax
    DeleteAjax('hospital/transaction/services');
    

    // Delete status Ajax
    DeleteStatusAjax('hospital/transaction/services');


    // Pagination Ajax
    // PaginationAjax(ShowServices);


    // Search Ajax
    // SearchAjax('hospital/transaction/services', ShowServices, { type: 1, method: 'Receive' });


    // Search By Date
    // SearchByDateAjax('hospital/transaction/services', ShowServices, {type: 1, method: 'Receive'});


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