function ShowDepartments(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.dept_name}</td>
                    <td>
                        <div style="display: flex;gap:5px;">
                        
                            <button class="open-modal" data-modal-id="editModal" id="edit"
                                    data-id="${item.id}"><i class="fas fa-edit"></i></button>
                            
                            <button data-id="${item.id}" id="delete"><i class="fas fa-trash"></i></button>

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
        $('.load-data .show-table tfoot').html('<tr><td colspan="8" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Load Data on Hard Reload
    ReloadData('hr/departments', ShowDepartments);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#deptName");


    // Insert Ajax
    InsertAjax('hr/departments', ShowDepartments, {}, function() {
        $('#deptName').focus();
    });


    //Edit Ajax
    EditAjax('hr/departments', EditFormInputValue);


    // Update Ajax
    UpdateAjax('hr/departments', ShowDepartments);
    

    // Delete Ajax
    DeleteAjax('hr/departments', ShowDepartments);


    // Pagination Ajax
    PaginationAjax(ShowDepartments);


    // Search Ajax
    SearchAjax('hr/departments', ShowDepartments, {  });


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.department.id);
        $('#updateDeptName').val(res.department.dept_name);
        $('#updateDeptName').focus();
    }
});