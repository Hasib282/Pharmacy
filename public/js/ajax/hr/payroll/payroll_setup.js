// function ShowPayrollSetup(data, startIndex) {
//     let tableRows = '';
//     let lastEmpId = null;
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             tableRows += `
//                 <tr>
//                     <td>${startIndex + key + 1}</td>
//                     ${item.emp_id != lastEmpId ?
//                         `<td>${item.emp_id}</td>
//                         <td>${item.employee.user_name}</td>`
//                         :
//                         `<td colspan="2"></td>`
//                     }
                    
//                     <td>${item.head.tran_head_name}</td>
//                     <td>${item.amount}</td>
//                     <td>
//                         <div style="display: flex;gap:5px;">
//                             <button class="open-modal" data-modal-id="editModal" id="edit"
//                                     data-id="${item.id}"><i class="fas fa-edit"></i></button>
                                    
//                             <button data-id="${item.id}" id="delete"><i class="fas fa-trash"></i></button>
//                         </div>
//                     </td>
//                 </tr>
//             `;

//             lastEmpId = item.emp_id
//         });

//         // Inject the generated rows into the table body
//         $('.load-data .show-table tbody').html(tableRows);
//         $('.load-data .show-table tfoot').html('')
//     }
//     else{
//         $('.load-data .show-table tbody').html('');
//         $('.load-data .show-table tfoot').html('<tr><td colspan="6" style="text-align:center;">No Data Found</td></tr>')
//     }
// }; // End Function

function ShowPayrollSetup(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['emp_id','employee.user_name','head.tran_head_name','amount'],
        actions: (row) => `
                <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                        
                <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                `,
    });
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Employee Id', key: 'emp_id' },
        { label: 'Employee Name', key: 'employee.user_name' },
        { label: 'Payroll Category', key: 'head.tran_head_name' },
        { label: 'Amount' },
        { label: 'Action', type: 'button' }
    ]);


    // Get Transaction With / User Type 
    GetTransactionWith(3, '', '#with', 3, 'Ok');
    
    // Creating Select Options Dynamically
    $.ajax({
        url: `${apiUrl}/hr/payroll/setup`,
        method: "GET",
        success: function (res) {
            CreateSelectOptions('#head', 'Select Payroll Category', res.heads, null, 'tran_head_name')
        },
    });


    // Load Data on Hard Reload
    ReloadData('hr/payroll/setup', ShowPayrollSetup);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#with", function () {
        $('#with').val('');
        $('#user').removeAttr('data-id');
        $('#user').val('');
        $('.payroll-grid tbody').html('');
    });


    // Insert Ajax
    InsertAjax('hr/payroll/setup', ShowPayrollSetup, {user: { selector: '#user', attribute: 'data-id' }, with:{ selector: '#with' }}, function() {
        $('#head').focus();
        let user = $('#user').attr('data-id');
        getPayrollByUserId(user, '.payroll-grid tbody');
    });


    //Edit Ajax
    EditAjax('hr/payroll/setup', EditFormInputValue);


    // Update Ajax
    UpdateAjax('hr/payroll/setup', ShowPayrollSetup, {user: { selector: '#updateUser', attribute: 'data-id' }});
    

    // Delete Ajax
    DeleteAjax('hr/payroll/setup', ShowPayrollSetup);


    // Pagination Ajax
    // PaginationAjax(ShowPayrollSetup);


    // Search Ajax
    // SearchAjax('hr/payroll/setup', ShowPayrollSetup, {  });


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.payroll.id);

        CreateSelectOptions('#updateWith', 'Select Employee Type', res.tranwith, res.payroll.employee.tran_user_type, 'tran_with_name');
        // $('#updateWith').empty();
        // $.each(res.tranwith, function (key, withs) {
        //     $('#updateWith').append(`<option value="${withs.id}">${withs.tran_with_name}</option>`);
        // });
        
        $('#updateUser').val(res.payroll.employee.user_name);
        $('#updateUser').attr('data-id', res.payroll.emp_id);
        $('#updateAmount').val(res.payroll.amount);
        
        CreateSelectOptions('#updateHead', 'Select Payroll Category', res.heads, res.payroll.head_id, 'tran_head_name');
        // $('#updateHead').empty();
        // $.each(res.heads, function (key, head) {
        //     $('#updateHead').append(`<option value="${head.id}" ${res.payroll.head_id === head.id ? 'selected' : ''}>${head.tran_head_name}</option>`);
        // });
        $('#updateWith').focus();
    }

});