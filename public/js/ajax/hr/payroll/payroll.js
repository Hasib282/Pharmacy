// function ShowPayrolls(data, startIndex) {
//     let tableRows = '';
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             tableRows += `
//                 <tr>
//                     <td>${key + 1}</td>
//                     <td>${item['emp_id']}</td>
//                     <td>${item['emp_name']}</td>
//                     <td>${item['salary'].toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
//                     <td>
                        
//                         <button class="open-modal" data-modal-id="editModal" id="edit"
//                                     data-id="${item['emp_id']}"><i class="fa-solid fa-circle-info"></i></button>
                        
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
//         $('.load-data .show-table tfoot').html('<tr><td colspan="6" style="text-align:center;">No Data Found</td></tr>')
//     }
// }; // End Function

function ShowPayrolls(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['emp_id','emp_name','salary'],
        actions: (row) => `
                <button data-modal-id="editModal" id="edit" data-id="${row.emp_id}"><i class="fas fa-edit"></i></button>
                `,
                
    });
}


$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Employee Id', key: 'emp_id' },
        { label: 'Employee Name', key: 'emp_name' },
        { label: 'Salary', key: 'salary'},
        { label: 'Action', type: 'button' }
    ]);
    
    // Load Data on Hard Reload
    ReloadData('hr/payroll/process', ShowPayrolls);


    //Edit Ajax
    EditAjax('hr/payroll/process', EditFormInputValue);


    // Pagination Ajax
    // PaginationAjax(ShowPayrolls, { month: { selector: '#month'}, year: { selector: '#year'}});


    // Search Ajax
    // SearchAjax('hr/payroll/process', ShowPayrolls, { month: { selector: '#month'}, year: { selector: '#year'}});


    // Search By Month or Year
    // SearchBySelect('hr/payroll/process', ShowPayrolls, '#month, #year', { month: { selector: '#month'}, year: { selector: '#year'}})


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('.payroll-grid tbody').html(item);
    }


    /////////////// ----------------------- Payroll Process Part Ajax start here ------------------- //////////////////////////
    // Process Button Functionality
    $(document).off('click', '#PayrollProcess').on('click', '#PayrollProcess', function (e) {
        e.preventDefault();
        $('#confirmModal').show();
        $('#cancelProcessBtn').focus();
    });



    // Cancel Button Functionality
    $(document).off('click', '#cancelProcessBtn').on('click', '#cancelProcessBtn', function (e) {
        e.preventDefault();
        $('#confirmModal').hide();
    });



    // Confirm Button Functionality
    $(document).off('click', '#confirmProcessBtn').on('click', '#confirmProcessBtn', function (e) {
        e.preventDefault();
        $.ajax({
            url: `${apiUrl}/hr/payroll/process`,
            method: 'POST',
            success: function (res) {
                if (res.status) {
                    $('#confirmModal').hide();
                    toastr.success(res.message, 'Added!');
                }
                else{
                    toastr.error(res.message, 'Error!');
                    $('#confirmModal').hide();
                }
            },
            error: function (err) {
                console.log(err)
                let error = err.responseJSON;
                $.each(error.errors, function (key, value) {
                    $('#' + key + "_error").text(value);
                });
            }
        });
    });

    /////////////// ----------------------- Payroll Process Part Ajax end here ------------------- //////////////////////////
});