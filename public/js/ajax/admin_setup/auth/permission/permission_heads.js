function ShowPermissions(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.mainhead.name}</td>
                    <td>${item.name}</td>
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
    // Creating Select Options Dynamically
    $.ajax({
        url: `${apiUrl}/admin/auth/permission`,
        method: "GET",
        success: function (res) {
            let queryParams = GetQueryParams();
            CreateSelectOptions('#searchHead', 'All', res.permissionMainhead, queryParams['searchHead'], 'name');
            CreateSelectOptions('#mainhead', 'Select Permission Mainhead', res.permissionMainhead, null, 'name');
        },
    });

    // Load Data on Hard Reload
    ReloadData('admin/auth/permission', ShowPermissions);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#mainhead");


    // Insert Ajax
    InsertAjax('admin/auth/permission', ShowPermissions, {}, function() {
        $('#mainhead').focus();
    });


    //Edit Ajax
    EditAjax('admin/auth/permission', EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/auth/permission', ShowPermissions);
    

    // Delete Ajax
    DeleteAjax('admin/auth/permission', ShowPermissions);


    // Pagination Ajax
    PaginationAjax(ShowPermissions);


    // Search Ajax
    SearchAjax('admin/auth/permission', ShowPermissions, {searchHead: { selector: "#searchHead"}});


    // Search By Methods, Roles, Types
    SearchBySelect('admin/auth/permission', ShowPermissions, '#searchHead', {searchHead: { selector: "#searchHead"}} );


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.permission.id);

        CreateSelectOptions('#updateMainhead', 'Select Main Head', res.permissionMainhead, res.permission.permission_mainhead, 'name');

        $('#updateName').val(res.permission.name);
        $('#updateName').focus();
    }
});