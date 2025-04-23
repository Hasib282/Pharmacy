// function ShowBankWithdraws(data, startIndex) {
//     let tableRows = '';
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             tableRows += `
//                 <tr>
//                     <td>${startIndex + key + 1}</td>
//                     <td>${item.tran_id}</td>
//                     <td>${item.bank.name}</td>
//                     <td style="text-align: right">${item.bill_amount} Tk.</td>
//                     <td>
//                         <div style="display: flex;gap:5px;">

//                             <button class="open-modal" data-modal-id="editModal" id="edit"
//                                     data-id="${item.tran_id}"><i class="fas fa-edit"></i></button>
                        
//                             <button data-id="${item.tran_id}" id="delete"><i class="fas fa-trash"></i></button>
                        
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
//         $('.load-data .show-table tfoot').html('<tr><td colspan="5" style="text-align:center;">No Data Found</td></tr>')
//     }
// }; // End Function

function ShowBankWithdraws(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_id','bank.name',{key:'bill_amount', type: 'number'}],
        actions: (row) => `
                <button data-modal-id="editModal" id="edit" data-id="${row.tran_id}"><i class="fas fa-edit"></i></button>
                        
                <button data-id="${row.tran_id}" id="delete"><i class="fas fa-trash"></i></button>
                `,
    });
}

$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'select', options: [15, 30, 50, 100, 500] },
        { label: 'Tran Id', key: 'tran_id' },
        { label: 'Bank Name', key: 'bank.name' },
        { label: 'Amount' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Transaction Groupe
    GetTransactionGroupe(4, "Receive");

    // Load Data on Hard Reload
    ReloadData('transaction/bank/withdraw', ShowBankWithdraws);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#date");


    // Insert Ajax
    InsertAjax('transaction/bank/withdraw', ShowBankWithdraws, 
        {
            method:'Withdraw', 
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


    //Edit Ajax
    EditAjax('transaction/bank/withdraw', EditFormInputValue);

    
    // Update Ajax
    UpdateAjax('transaction/bank/withdraw', ShowBankWithdraws,
        {
            method:'Withdraw',
            bank: {selector: '#updateBank', attribute: 'data-id' },
            head: {selector: '#updateHead', attribute: 'data-id' },
            groupe: {selector: '#updateHead', attribute: 'data-groupe' },
            amount: {selector: '#updateAmount' },
        }
    );
    

    // Delete Ajax
    DeleteAjax('transaction/bank/withdraw', ShowBankWithdraws);


    // Pagination Ajax
    // PaginationAjax(ShowBankWithdraws);


    // Search Ajax
    // SearchAjax('transaction/bank/withdraw', ShowBankWithdraws, {type: 4, method: 'Withdraw'});


    // Search By Date
    // SearchByDateAjax('transaction/bank/withdraw', ShowBankWithdraws, {type: 4, method: 'Withdraw'});


    // Additional Edit Functionality
    function EditFormInputValue(res){
        var timestamps = new Date(res.transaction.tran_date);
        var formattedDate = timestamps.toLocaleDateString('en-US', { timeZone: 'Asia/Dhaka' });
        $('#updateDate').val(formattedDate);

        $('#id').val(res.transaction.tran_id);

        $('#updateHead').val(res.transaction.head.tran_head_name);
        $('#updateHead').attr('data-id', res.transaction.tran_head_id);
        $('#updateHead').attr('data-group', res.transaction.tran_groupe_id);
        
        $('#updateBank').attr('data-id',res.transaction.tran_bank);
        $('#updateBank').val(res.transaction.bank.name);

        $('#updateAmount').val(res.transaction.amount);
        $('#updateDate').focus();
    }
});