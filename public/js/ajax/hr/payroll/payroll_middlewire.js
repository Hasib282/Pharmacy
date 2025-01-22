function ShowPayrollMiddlewire(data, startIndex) {
    let tableRows = '';
    let lastEmpId = null;
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>

                    
                    ${item.emp_id != lastEmpId ?
                        `<td>${item.emp_id}</td>
                        <td>${item.employee.user_name}</td>`
                        :
                        `<td colspan="2"></td>`
                    }

                    <td>${item.head.tran_head_name}</td>
                    <td>${item.amount}</td>
                    ${item.date != null ?
                        `<td>${new Date(item.date).toLocaleString('en-US', { month: '2-digit' })}</td>
                        <td>${new Date(item.date).getFullYear()}</td>`
                        :
                        `<td colspan="2"></td>`
                    }
                    
                    <td>
                        <div style="display: flex;gap:5px;">
                            <button class="open-modal" data-modal-id="editModal" id="edit"
                                    data-id="${item.id}"><i class="fas fa-edit"></i></button>
                            
                            <button data-id="${item.id}" id="delete"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            `;

            lastEmpId = item.emp_id;
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
    $(document).off(`.${'SearchBySelect'}`);
    
    // Creating Select Options Dynamically
    $.ajax({
        url: `${apiUrl}/hr/payroll/middlewire`,
        method: "GET",
        success: function (res) {
            CreateSelectOptions('#with', 'Select Employee Type', res.tranwith, null, 'tran_with_name')
            CreateSelectOptions('#head', 'Select Payroll Category', res.heads, null, 'tran_head_name')
        },
    });

    // Load Data on Hard Reload
    ReloadData('hr/payroll/middlewire', ShowPayrollMiddlewire);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#with", function () {
        $('#with').val('');
        $('#user').removeAttr('data-id');
        $('#user').val('');
        $('.payroll-grid tbody').html('');
    });


    // Insert Ajax
    InsertAjax('hr/payroll/middlewire', ShowPayrollMiddlewire, {user: { selector: '#user', attribute: 'data-id' }, with:{ selector: '#with' }}, function() {
        $('#head').focus();
        let user = $('#user').attr('data-id');
        getPayrollByUserId(user, '.payroll-grid tbody');
    });


    //Edit Ajax
    EditAjax('hr/payroll/middlewire', EditFormInputValue);


    // Update Ajax
    UpdateAjax('hr/payroll/middlewire', ShowPayrollMiddlewire, {user: { selector: '#updateUser', attribute: 'data-id' }});
    

    // Delete Ajax
    DeleteAjax('hr/payroll/middlewire', ShowPayrollMiddlewire);


    // Pagination Ajax
    PaginationAjax(ShowPayrollMiddlewire, { month: { selector: '#optionMonth'}, year: { selector: '#optionYear'}});


    // Search Ajax
    SearchAjax('hr/payroll/middlewire', ShowPayrollMiddlewire, { month: { selector: '#optionMonth'}, year: { selector: '#optionYear'}});


    // Search By Month or Year
    SearchBySelect('hr/payroll/middlewire', ShowPayrollMiddlewire, '#optionMonth, #optionYear', { month: { selector: '#optionMonth'}, year: { selector: '#optionYear'}})


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.payroll.id);
        
        CreateSelectOptions('#updateWith', 'Select Employee Type', res.tranwith, res.payroll.employee.tran_user_type, 'tran_with_name');

        $('#updateUser').val(res.payroll.employee.user_name);
        $('#updateUser').attr('data-id', res.payroll.emp_id);
        $('#updateAmount').val(res.payroll.amount);
        
        CreateSelectOptions('#updateHead', 'Select Payroll Category', res.heads, res.payroll.head_id, 'tran_head_name');

        $('#updateDate').val(res.payroll.date)
        $('#updateWith').focus();
    }
});