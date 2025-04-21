// function ShowAttendence(data, startIndex) {
//     let tableRows = '';
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             let startTime = new Date(`1970-01-01 ${item.in}`);
//             let endTime = new Date(`1970-01-01 ${item.out}`);
//             let timeDiffInMilliseconds = endTime - startTime;

//             // Calculate time difference in hours
//             let timeDiffInHours = (timeDiffInMilliseconds / (1000 * 60 * 60)).toFixed(1);


//             tableRows += `
//                 <tr>
//                     <td>${startIndex + key + 1}</td>
//                     <td>${item.emp_id}</td>
//                     <td>${item.user.user_name}</td>
                    
//                     <td>${item.date}</td>
//                     <td>${item.in}</td>
//                     <td>${item.out}</td>
//                     <td>${timeDiffInHours}</td>
//                     <td>${item.insert_at}</td>
//                     <td>${item.updated_at}</td>
//                     <td>
//                         <div style="display: flex;gap:5px;">
//                             <button class="open-modal" data-modal-id="editModal" id="edit"
//                                     data-id="${item.id}"><i class="fas fa-edit"></i></button>
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
//         $('.load-data .show-table tfoot').html('<tr><td colspan="12" style="text-align:center;">No Data Found</td></tr>')
//     }
// }; // End Function

function ShowAttendence(res) {
    new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['emp_id','user.user_name','date','in','out','','insert_at','updated_at'],
        actions: (row) => `
                <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `,
    });
}


$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'select', options: [15, 30, 50, 100, 500] },
        { label: 'Company Id', key: 'company_id' },
        { label: 'Company Name', key: 'name' },
        { label: 'Permission', key: 'permission' },
        { label: 'Action', type: 'button' }
    ]);


    // Get Transaction With / User Type 
    GetTransactionWith(3, '', '#with', 3, 'Ok');


    // Load Data on Hard Reload
    ReloadData('hr/employee/attendence', ShowAttendence);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#with", function () {
        $('#with').val('');
        $('#user').removeAttr('data-id');
        $('#user').val('');
    });


    // Insert Ajax
    InsertAjax('hr/employee/attendence', ShowAttendence, {user: { selector: '#user', attribute: 'data-id' }}, function() {
        $('#with').focus();
    });


    //Edit Ajax
    EditAjax('hr/employee/attendence', EditFormInputValue);


    // Update Ajax
    UpdateAjax('hr/employee/attendence', ShowAttendence);
    

    // // Delete Ajax
    // DeleteAjax('hr/employee/attendence', ShowAttendence);


    // // Pagination Ajax
    // PaginationAjax(ShowAttendence);


    // Search Ajax
    // SearchAjax('hr/employee/attendence', ShowAttendence);


    // Search By Date
    // SearchByDateAjax('hr/employee/attendence', ShowAttendence);


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.data.id);

        $('#updateUser').val(res.data.user.user_name);
        $('#updateDate').val(res.data.date);
        $('#updateIn').val(res.data.in);
        $('#updateOut').val(res.data.out);

        $('#updateOut').focus();
    }

});