function ShowTranWith(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.tran_with_name}</td>
                    <td>${item.role.name}</td>
                    <td>${item.tran_method}</td>
                    <td>${item.type.type_name}</td>
                    <td>
                        <div style="display: flex;gap:5px;">
                            
                            <button class="open-modal" data-modal-id="editModal" id="edit" data-id="${item.id}"><i class="fas fa-edit"></i></button>
                            
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
        url: `${apiUrl}/admin/tranwith`,
        method: "GET",
        success: function (res) {
            let queryParams = GetQueryParams();
            CreateSelectOptions('#roles', 'All', res.roles, queryParams['role'], 'name')
            CreateSelectOptions('#types', 'All', res.types, queryParams['type'], 'type_name')
            CreateSelectOptions('#role', 'Select User Role', res.roles, null, 'name')
            CreateSelectOptions('#tranType', 'Select Transaction Type', res.types, null, 'type_name')
        },
    });

    
    // Load Data on Hard Reload
    ReloadData('admin/tranwith', ShowTranWith);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#name");


    // Insert Ajax
    InsertAjax('admin/tranwith', ShowTranWith, { company: { selector: "#company", attribute: 'data-id' }}, function() {
        $('#name').focus();
        $('#company').removeAttr('data-id');
    });


    //Edit Ajax
    EditAjax('admin/tranwith', EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/tranwith', ShowTranWith);
    

    // Delete Ajax
    DeleteAjax('admin/tranwith', ShowTranWith);


    // Pagination Ajax
    PaginationAjax(ShowTranWith);


    // Search Ajax
    SearchAjax('admin/tranwith', ShowTranWith, {type: { selector: "#types"}, method: { selector: "#methods"}, role: { selector: "#roles"}});


    // Search By Methods, Roles, Types
    SearchBySelect('admin/tranwith', ShowTranWith, '#methods, #roles, #types', {type: { selector: "#types"},    method: { selector: "#methods"}, role: { selector: "#roles"}} );


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.tranwith.id);
        $('#updateName').val(res.tranwith.tran_with_name);

        // Create options dynamically
        CreateSelectOptions('#updateRole', 'Select User Role', res.roles, res.tranwith.user_role, 'name')
        CreateSelectOptions('#updateTranType', 'Select Transaction Type', res.types, res.tranwith.tran_type, 'type_name')

        $('#updateTranMethod').html('');
        $('#updateTranMethod').append(`<option value="Receive" ${res.tranwith.tran_method === 'Receive' ? 'selected' : ''}>Receive</option>
                                    <option value="Payment" ${res.tranwith.tran_method === 'Payment' ? 'selected' : ''}>Payment</option>
                                    <option value="Both" ${res.tranwith.tran_method === 'Both' ? 'selected' : ''}>Both</option>`);
        $('#updateName').focus();
    }; // End Method
});