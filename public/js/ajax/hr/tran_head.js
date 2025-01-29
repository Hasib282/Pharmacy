function ShowTranHead(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.tran_head_name }</td>
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
    
    // Load Data on Hard Reload
    ReloadData('hr/payroll/heads', ShowTranHead);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#headName");


    // Insert Ajax
    InsertAjax('hr/payroll/heads', ShowTranHead, {groupe: 1, company: { selector: "#company", attribute: 'data-id' }}, function() {
        $('#headName').focus();
        $('#company').removeAttr('data-id');
    });


    //Edit Ajax
    EditAjax('hr/payroll/heads', EditFormInputValue);


    // Update Ajax
    UpdateAjax('hr/payroll/heads', ShowTranHead, {groupe: 1});
    

    // Delete Ajax
    DeleteAjax('hr/payroll/heads', ShowTranHead);


    // Pagination Ajax
    PaginationAjax(ShowTranHead);


    // Search Ajax
    SearchAjax('hr/payroll/heads', ShowTranHead, {groupe: 1, searchOption: 1});


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.heads.id);
        $('#updateHeadName').val(res.heads.tran_head_name);
        
        $('#updateHeadName').focus();
    }; // End Method
});