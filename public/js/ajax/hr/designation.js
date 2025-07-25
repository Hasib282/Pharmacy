function ShowDesignations(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['department.name','designation'],
       
        actions: (row) => {
            let buttons = '';
        
            if (userPermissions.includes(63) || role == 1) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }

            if (userPermissions.includes(64) || role == 1) {
                buttons += `
                <button data-id="${row.id}" id="delete_status" class="icon-wrapper" title="Toggle Delete"><i class="fa-solid fa-trash-arrow-up main-icon"></i><i class="fa-solid fa-arrows-rotate ring-icon"></i></button>
                `;
                
                if (role == 1 || role == 2) {
                    buttons += `
                        <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                    `;
                }
            }
        
            return buttons;
        }
    });
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Department Name', key: 'department.name' },
        { label: 'Designation', key: 'designation' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('hr/setup/designations', ShowDesignations);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#department", function(){
        $("#designations").val('');
        $('#department').removeAttr('data-id');
        $('#department').val('');
    });


    // Insert Ajax
    InsertAjax('hr/setup/designations', {department: { selector: '#department', attribute: 'data-id' }}, function() {
        $("#department").focus();
        $('#department').removeAttr('data-id');
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hr/setup/designations', {department: { selector: '#updateDepartment', attribute: 'data-id' }}, function(){
        $('#updateDepartment').removeAttr('data-id');
    });
    

    // Delete Ajax
    DeleteAjax('hr/setup/designations');
    

    // Delete status Ajax
    DeleteStatusAjax('hr/setup/designations');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateDesignations').val(item.designation);
        $('#updateDepartment').attr('data-id',item.dept_id);
        $('#updateDepartment').val(item.department.name);
        $('#updateDepartment').focus();
    }
});