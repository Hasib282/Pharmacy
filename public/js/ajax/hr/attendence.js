function ShowAttendence(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            let startTime = new Date(`1970-01-01 ${item.in}`);
            let endTime = new Date(`1970-01-01 ${item.out}`);
            let timeDiffInMilliseconds = endTime - startTime;

            // Calculate time difference in hours
            let timeDiffInHours = (timeDiffInMilliseconds / (1000 * 60 * 60)).toFixed(1);


            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.emp_id}</td>
                    <td>${item.user.user_name}</td>
                    
                    <td>${item.date}</td>
                    <td>${item.in}</td>
                    <td>${item.out}</td>
                    <td>${timeDiffInHours}</td>
                    <td>${item.insert_at}</td>
                    <td>${item.updated_at}</td>
                    <td>
                        <div style="display: flex;gap:5px;">
                            <button class="open-modal" data-modal-id="editModal" id="edit"
                                    data-id="${item.id}"><i class="fas fa-edit"></i></button>
                        </div>
                    </td>
                </tr>
            `;
        });

        // Inject the generated rows into the table body
        $('.load-data .show-table tbody').html(tableRows);
        $('.load-data .show-table tfoot').html('')
    }
    else{
        $('.load-data .show-table tbody').html('');
        $('.load-data .show-table tfoot').html('<tr><td colspan="12" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
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
    SearchAjax('hr/employee/attendence', ShowAttendence);


    // Search By Date
    SearchByDateAjax('hr/employee/attendence', ShowAttendence);


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.attendence.id);

        $('#updateUser').val(res.attendence.user.user_name);
        $('#updateDate').val(res.attendence.date);
        $('#updateIn').val(res.attendence.in);
        $('#updateOut').val(res.attendence.out);

        $('#updateOut').focus();
    }

});