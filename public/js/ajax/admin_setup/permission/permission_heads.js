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
    $(document).off(`.${'SearchBySelect'}`);
    
    // Creating Select Options Dynamically
    $.ajax({
        url: `${apiUrl}/admin/permission/heads`,
        method: "GET",
        success: function (res) {
            let queryParams = GetQueryParams();
            CreateSelectOptions('#searchHead', 'All', res.permissionMainhead, queryParams['searchHead'], 'name');
            CreateSelectOptions('#mainhead', 'Select Permission Mainhead', res.permissionMainhead, null, 'name');
        },
    });

    // Load Data on Hard Reload
    ReloadData('admin/permission/heads', ShowPermissions);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#mainhead");


    // Insert Ajax
    InsertAjax('admin/permission/heads', ShowPermissions, {}, function() {
        $('#mainhead').focus();
    });


    //Edit Ajax
    EditAjax('admin/permission/heads', EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/permission/heads', ShowPermissions);
    

    // Delete Ajax
    DeleteAjax('admin/permission/heads', ShowPermissions);


    // Pagination Ajax
    PaginationAjax(ShowPermissions);


    // Search Ajax
    SearchAjax('admin/permission/heads', ShowPermissions, {searchHead: { selector: "#searchHead"}});


    // Search By Methods, Roles, Types
    SearchBySelect('admin/permission/heads', ShowPermissions, '#searchHead', {searchHead: { selector: "#searchHead"}} );


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.data.id);

        CreateSelectOptions('#updateMainhead', 'Select Main Head', res.permissionMainhead, res.data.permission_mainhead, 'name');

        $('#updateName').val(res.data.name);
        $('#updateName').focus();
    }
});