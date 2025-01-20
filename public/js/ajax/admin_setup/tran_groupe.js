function ShowTranGroupe(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.tran_groupe_name}</td>
                    <td>${item.type.type_name}</td>
                    <td>${item.tran_method}</td>
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
        url: `${apiUrl}/admin/trangroupes`,
        method: "GET",
        success: function (res) {
            let queryParams = GetQueryParams();
            CreateSelectOptions('#types', 'All', res.types, queryParams['type'], 'type_name')
            CreateSelectOptions('#type', 'Select Transaction Type', res.types, null, 'type_name')
        },
    });


    // Load Data on Hard Reload
    ReloadData('admin/trangroupes', ShowTranGroupe);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#groupeName");


    // Insert Ajax
    InsertAjax('admin/trangroupes', ShowTranGroupe, {company: { selector: "#company", attribute: 'data-id' }}, function() {
        $('#groupeName').focus();
        $('#company').removeAttr('data-id');
    });


    //Edit Ajax
    EditAjax('admin/trangroupes', EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/trangroupes', ShowTranGroupe);
    

    // Delete Ajax
    DeleteAjax('admin/trangroupes', ShowTranGroupe);


    // Pagination Ajax
    PaginationAjax(ShowTranGroupe);


    // Search Ajax
    SearchAjax('admin/trangroupes', ShowTranGroupe, {type: { selector: "#types"}, method: { selector: "#methods"}});


    // Search By Methods, Types
    SearchBySelect('admin/trangroupes', ShowTranGroupe, '#methods, #types', {type: { selector: "#types"},    method: { selector: "#methods"}} );


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.groupes.id);
        $('#updateGroupeName').val(res.groupes.tran_groupe_name);

        CreateSelectOptions('#updateType', 'Select Transaction Type', res.types, res.groupes.tran_groupe_type, 'type_name');

        $('#updateMethod').empty();
        $('#updateMethod').append(`<option value="" >Select Transaction Method</option>
                                    <option value="Receive" ${res.groupes.tran_method === 'Receive' ? 'selected' : ''}>Receive</option>
                                    <option value="Payment" ${res.groupes.tran_method === 'Payment' ? 'selected' : ''}>Payment</option>
                                    <option value="Both" ${res.groupes.tran_method === 'Both' ? 'selected' : ''}>Both</option>`);

        $('#updateGroupeName').focus();
    }; // End Method
});