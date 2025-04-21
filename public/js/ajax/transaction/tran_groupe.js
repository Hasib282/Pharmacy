function ShowTranGroupe(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.tran_groupe_name}</td>
                    <td>${item.tran_method}</td>
                    ${role == 1 ? `<td>${item.company_id }</td>`: ''}
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
    $(document).off(`.${'SearchBySelect'}`);


    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'select', options: [15, 30, 50, 100, 500] },
        { label: 'Company Id', key: 'company_id' },
        { label: 'Company Name', key: 'name' },
        { label: 'Permission', key: 'permission' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('transaction/setup/groupes', ShowTranGroupe);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#groupeName");


    // Insert Ajax
    InsertAjax('transaction/setup/groupes', ShowTranGroupe, {company: { selector: "#company", attribute: 'data-id' },type: 1}, function() {
        $('#groupeName').focus();
    });


    //Edit Ajax
    EditAjax('transaction/setup/groupes', EditFormInputValue);


    // Update Ajax
    UpdateAjax('transaction/setup/groupes', ShowTranGroupe, {type: 1});
    

    // Delete Ajax
    DeleteAjax('transaction/setup/groupes', ShowTranGroupe);


    // Pagination Ajax
    // PaginationAjax(ShowTranGroupe);


    // Search Ajax
    // SearchAjax('transaction/setup/groupes', ShowTranGroupe, {type: 1, method: { selector: "#methods"}});


    // Search By Methods, Types
    // SearchBySelect('transaction/setup/groupes', ShowTranGroupe, '#methods', {type: 1, method: { selector: "#methods"}} );


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.data.id);
        $('#updateGroupeName').val(res.data.tran_groupe_name);

        $('#updateMethod').empty();
        $('#updateMethod').append(`<option value="" >Select Transaction Method</option>
                                    <option value="Receive" ${res.data.tran_method === 'Receive' ? 'selected' : ''}>Receive</option>
                                    <option value="Payment" ${res.data.tran_method === 'Payment' ? 'selected' : ''}>Payment</option>
                                    <option value="Both" ${res.data.tran_method === 'Both' ? 'selected' : ''}>Both</option>`);

        $('#updateGroupeName').focus();
    }; // End Method
});