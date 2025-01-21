function ShowTranHead(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.tran_head_name }</td>
                    <td>${item.groupe.tran_groupe_name }</td>
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
    CleanupEvents('SearchBySelect');

    // Creating Select Options Dynamically
    $.ajax({
        url: `${apiUrl}/transaction/setup/heads`,
        method: "GET",
        success: function (res) {
            CreateSelectOptions('#groupe', 'Select Transaction Groupe', res.groupes, null, 'tran_groupe_name')
        },
    });

    
    // Load Data on Hard Reload
    ReloadData('transaction/setup/heads', ShowTranHead);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#headName");


    // Insert Ajax
    InsertAjax('transaction/setup/heads', ShowTranHead, {company: { selector: "#company", attribute: 'data-id' },}, function() {
        $('#headName').focus();
    });


    //Edit Ajax
    EditAjax('transaction/setup/heads', EditFormInputValue);


    // Update Ajax
    UpdateAjax('transaction/setup/heads', ShowTranHead);
    

    // Delete Ajax
    DeleteAjax('transaction/setup/heads', ShowTranHead);


    // Pagination Ajax
    PaginationAjax(ShowTranHead);


    // Search Ajax
    SearchAjax('transaction/setup/heads', ShowTranHead);


    // Search By Methods, Roles, Types
    SearchBySelect('transaction/setup/heads', ShowTranHead, '#methods, #roles, #types' );


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.heads.id);
        $('#updateHeadName').val(res.heads.tran_head_name);

        CreateSelectOptions('#updateGroupe', 'Select Transaction Groupe', res.groupes, res.heads.groupe_id, 'tran_groupe_name')
        
        $('#updateHeadName').focus();
    }; // End Method
});