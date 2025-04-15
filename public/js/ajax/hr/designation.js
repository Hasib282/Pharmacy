function ShowDesignations(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.designation}</td>
                    <td>${item.department.name}</td>
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
    ReloadData('hr/setup/designations', ShowDesignations);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#designations", function(){
        $("#designations").val('');
        $('#department').removeAttr('data-id');
        $('#department').val('');
    });


    // Insert Ajax
    InsertAjax('hr/setup/designations', ShowDesignations, {department: { selector: '#department', attribute: 'data-id' }}, function() {
        $("#designations").focus();
        $('#department').removeAttr('data-id');
    });


    //Edit Ajax
    EditAjax('hr/setup/designations', EditFormInputValue);


    // Update Ajax
    UpdateAjax('hr/setup/designations', ShowDesignations, {department: { selector: '#updateDepartment', attribute: 'data-id' }}, function(){
        $('#updateDepartment').removeAttr('data-id');
    });
    

    // Delete Ajax
    DeleteAjax('hr/setup/designations', ShowDesignations);


    // Pagination Ajax
    PaginationAjax(ShowDesignations);


    // Search Ajax
    SearchAjax('hr/setup/designations', ShowDesignations, {  });


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.data.id);
        $('#updateDesignations').val(res.data.designation);
        $('#updateDepartment').attr('data-id',res.data.dept_id);
        $('#updateDepartment').val(res.data.department.name);
        $('#updateDesignations').focus();
    }
});