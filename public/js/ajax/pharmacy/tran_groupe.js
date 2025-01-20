function ShowTranGroupe(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.tran_groupe_name}</td>
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
    // Load Data on Hard Reload
    ReloadData('pharmacy/setup/groupes', ShowTranGroupe);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#groupeName");


    // Insert Ajax
    InsertAjax('pharmacy/setup/groupes', ShowTranGroupe, {company: { selector: "#company", attribute: 'data-id' }, type: 6, method: 'Both'}, function() {
        $('#groupeName').focus();
        $('#company').removeAttr('data-id');
    });


    //Edit Ajax
    EditAjax('pharmacy/setup/groupes', EditFormInputValue);


    // Update Ajax
    UpdateAjax('pharmacy/setup/groupes', ShowTranGroupe, {type: 6, method: 'Both'});
    

    // Delete Ajax
    DeleteAjax('pharmacy/setup/groupes', ShowTranGroupe);


    // Pagination Ajax
    PaginationAjax(ShowTranGroupe);


    // Search Ajax
    SearchAjax('pharmacy/setup/groupes', ShowTranGroupe, {type: 6, method: 'Both'});


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.groupes.id);
        $('#updateGroupeName').val(res.groupes.tran_groupe_name);

        $('#updateGroupeName').focus();
    }; // End Method
});