// function ShowPayrollMiddlewire(data, startIndex) {
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
//                     ${item.date != null ?
//                         `<td>${new Date(item.date).toLocaleString('en-US', { month: '2-digit' })}</td>
//                         <td>${new Date(item.date).getFullYear()}</td>`
//                         :
//                         `<td colspan="2"></td>`
//                     }
                    
//                     <td>
//                         <div style="display: flex;gap:5px;">
//                             <button class="open-modal" data-modal-id="editModal" id="edit"
//                                     data-id="${item.id}"><i class="fas fa-edit"></i></button>
                            
//                             <button data-id="${item.id}" id="delete"><i class="fas fa-trash"></i></button>
//                         </div>
//                     </td>
//                 </tr>
//             `;

//             lastEmpId = item.emp_id;
//         });

//         // Inject the generated rows into the table body
//         $('.load-data .show-table tbody').html(tableRows);
//         $('.load-data .show-table tfoot').html('')
//     }
//     else{
//         $('.load-data .show-table tbody').html('');
//         $('.load-data .show-table tfoot').html('<tr><td colspan="8" style="text-align:center;">No Data Found</td></tr>')
//     }
// }; // End Function

function ShowPayrollMiddlewire(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['emp_id','employee.user_name','head.tran_head_name','amount',{key:'date',type:'month'},{key:'date',type:'year'}],
        
        actions: (row) => {
            let buttons = '';
        
            if (userPermissions.includes(106) || role == 1) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }

           if (userPermissions.includes(107) || role == 1) {
                buttons += `
                <button data-id="${row.id}" id="delete_status" class="icon-wrapper" title="Toggle Delete"><i class="fa-solid fa-trash-arrow-up main-icon"></i><i class="fa-solid fa-arrows-rotate ring-icon"></i></button>
                `;
            }
            
            if (role == (1 || 2)) {
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
        { label: 'Employee Id', key: 'emp_id' },
        { label: 'Employee Name', key: 'employee.user_name' },
        { label: 'Payroll Category', type:"select", key: 'head_id', method:"fetch", link:'hr/payroll/setup/get', name:'tran_head_name' },
        { label: 'Amount' },
        { label: 'Month' },
        { label: 'Year' },
        { label: 'Action', type: 'button' }
    ]);


    // Get Transaction With / User Type 
    GetTransactionWith(3, null, 3, 'Ok');


    // Load Data on Hard Reload
    ReloadData('hr/payroll/middlewire', ShowPayrollMiddlewire);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#type", function () {
        $('#user').removeAttr('data-id');
        $('#user').val('');
        $('.payroll-grid tbody').html('');
    });


    // Insert Ajax
    InsertAjax('hr/payroll/middlewire', {user: { selector: '#user', attribute: 'data-id' }, with:{ selector: '#with' }}, function() {
        $('#head').focus();
        let user = $('#user').attr('data-id');
        getPayrollByUserId(user, '.payroll-grid tbody');
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hr/payroll/middlewire', {user: { selector: '#updateUser', attribute: 'data-id' }});
    

    // Delete Ajax
    DeleteAjax('hr/payroll/middlewire');
    

    // Delete status Ajax
    DeleteStatusAjax('hr/payroll/middlewire');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateType').val(item.employee.tran_user_type);
        $('#updateUser').val(item.employee.user_name);
        $('#updateUser').attr('data-id', item.emp_id);
        $('#updateAmount').val(item.amount);
        $('#updateHead').val(item.head_id);
        $('#updateDate').val(item.date)
        $('#updateWith').focus();
    }


    // Get Payroll Category
    GetSelectInputList('hr/payroll/setup/get', function (res) {
        CreateSelectOptions('#head', "Select Payroll Category", res.data, 'tran_head_name');
        CreateSelectOptions('#updateHead', "Select Payroll Category", res.data, 'tran_head_name');
    })
});