function ShowBankDeposits(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_id','bank.name',{key:'amount', type: 'number',footerType:'sum'}],
        actions: (row) => {
            let buttons = '';

            if (userPermissions.includes(51) || role == 1) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }
            
            if (userPermissions.includes(52) || role == 1) {
                buttons += `
                <button data-id="${row.id}" id="delete_status" class="icon-wrapper" title="Toggle Delete"><i class="fa-solid fa-trash-arrow-up main-icon"></i><i class="fa-solid fa-arrows-rotate ring-icon"></i></button>
                `;
            }
            
            if (role == 1 || role == 2) {
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
        { label: 'Tran Id', key: 'tran_id' },
        { label: 'Bank Name', key: 'bank.name' },
        { label: 'Amount' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Transaction Groupe
    GetTransactionGroupe(4, "Payment");


    // Load Data on Hard Reload
    ReloadData('transaction/bank/deposit', ShowBankDeposits);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#date", function () {
        $('#bank').removeAttr('data-id');
        $('#head').removeAttr('data-id');
        $('#head').removeAttr('data-groupe');
    });


    // Insert Ajax
    InsertAjax('transaction/bank/deposit', 
        {
            method:'Deposit', 
            type:'4', 
            bank: {selector: '#bank', attribute: 'data-id' },
            head: {selector: '#head', attribute: 'data-id' },
            groupe: {selector: '#head', attribute: 'data-groupe' },
        }, 
        function() {
            $('#head').removeAttr('data-id');
            $('#head').removeAttr('data-groupe');
            $('#bank').removeAttr('data-id');
            $('#bank').focus();
        }
    );


    // Edit Ajax
    EditAjax(EditFormInputValue);

    
    // Update Ajax
    UpdateAjax('transaction/bank/deposit',
        {
            method:'Deposit',
            bank: {selector: '#updateBank', attribute: 'data-id' },
            head: {selector: '#updateHead', attribute: 'data-id' },
            groupe: {selector: '#updateHead', attribute: 'data-groupe' },
            amount: {selector: '#updateAmount' },
        }
    );
    

    // Delete Ajax
    DeleteAjax('transaction/bank/deposit');
    

    // Delete statusAjax
    DeleteStatusAjax('transaction/bank/deposit');


    // Search By Date
    SearchByDateAjax('transaction/bank/deposit/search', ShowBankDeposits, {type: 4, method: 'Deposit'})


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#updateBank').removeAttr('data-id');
        $('#updateHead').removeAttr('data-id');
        $('#updateHead').removeAttr('data-groupe');
        console.log(item);
        
        var timestamps = new Date(item.tran_date);
        var formattedDate = timestamps.toLocaleDateString('en-US', { timeZone: 'Asia/Dhaka' });
        $('#updateDate').val(formattedDate);

        $('#id').val(item.id);

        $('#updateHead').val(item.head.tran_head_name);
        $('#updateHead').attr('data-id', item.tran_head_id);
        $('#updateHead').attr('data-group', item.tran_groupe_id);
        
        $('#updateBank').attr('data-id',item.tran_bank);
        $('#updateBank').val(item.bank.name);

        $('#updateAmount').val(item.amount);
        $('#updateDate').focus();
    }
});