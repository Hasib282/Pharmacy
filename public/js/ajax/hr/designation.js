function ShowDesignations(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.designation}</td>
                    <td>${item.department.dept_name}</td>
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
    ReloadData('hr/designations', ShowDesignations);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#designations", function(){
        $("#designations").val('');
        $('#department').removeAttr('data-id');
        $('#department').val('');
    });


    // Insert Ajax
    InsertAjax('hr/designations', ShowDesignations, {department: { selector: '#department', attribute: 'data-id' }}, function() {
        $("#designations").focus();
        $('#department').removeAttr('data-id');
    });


    //Edit Ajax
    EditAjax('hr/designations', EditFormInputValue);


    // Update Ajax
    UpdateAjax('hr/designations', ShowDesignations, {department: { selector: '#updateDepartment', attribute: 'data-id' }}, function(){
        $('#updateDepartment').removeAttr('data-id');
    });
    

    // Delete Ajax
    DeleteAjax('hr/designations', ShowDesignations);


    // Pagination Ajax
    PaginationAjax(ShowDesignations);


    // Search Ajax
    SearchAjax('hr/designations', ShowDesignations, {  });


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.designations.id);
        $('#updateDesignations').val(res.designations.designation);
        $('#updateDepartment').attr('data-id',res.designations.dept_id);
        $('#updateDepartment').val(res.designations.department.dept_name);
        $('#updateDesignations').focus();
    }
});