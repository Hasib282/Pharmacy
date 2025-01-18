function ShowTranGroupe(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.tran_groupe_name}</td>
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
    // Load Data on Hard Reload
    ReloadData('transaction/setup/groupes', ShowTranGroupe);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#groupeName");


    // Insert Ajax
    InsertAjax('transaction/setup/groupes', ShowTranGroupe, {type: 1}, function() {
        $('#groupeName').focus();
    });


    //Edit Ajax
    EditAjax('transaction/setup/groupes', EditFormInputValue);


    // Update Ajax
    UpdateAjax('transaction/setup/groupes', ShowTranGroupe, {type: 1});
    

    // Delete Ajax
    DeleteAjax('transaction/setup/groupes', ShowTranGroupe);


    // Pagination Ajax
    PaginationAjax(ShowTranGroupe);


    // Search Ajax
    SearchAjax('transaction/setup/groupes', ShowTranGroupe, {type: 1, method: { selector: "#methods"}});


    // Search By Methods, Types
    SearchBySelect('transaction/setup/groupes', ShowTranGroupe, '#methods', {type: 1, method: { selector: "#methods"}} );


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.groupes.id);
        $('#updateGroupeName').val(res.groupes.tran_groupe_name);

        $('#updateMethod').empty();
        $('#updateMethod').append(`<option value="" >Select Transaction Method</option>
                                    <option value="Receive" ${res.groupes.tran_method === 'Receive' ? 'selected' : ''}>Receive</option>
                                    <option value="Payment" ${res.groupes.tran_method === 'Payment' ? 'selected' : ''}>Payment</option>
                                    <option value="Both" ${res.groupes.tran_method === 'Both' ? 'selected' : ''}>Both</option>`);

        $('#updateGroupeName').focus();
    }; // End Method
});