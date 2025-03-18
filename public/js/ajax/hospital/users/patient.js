function ShowPatients(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.ptn_id}</td>
                    <td>${item.title}</td>
                    <td>${item.name}</td>
                    <td>${item.phone}</td>
                    <td>${item.email}</td>
                    <td>${item.gender}</td>
                    <td>${item.address}</td>
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
        $('.load-data .show-table tfoot').html('<tr><td colspan="9" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Load Data on Hard Reload
    ReloadData('hospital/users/patients', ShowPatients);
    
    
    // Add Modal Open Functionality
    AddModalFunctionality("#title");


    // Insert Ajax
    // InsertAjax('hospital/users/patients', ShowPatients, {}, function() {
    //     $('#title').focus();
    // });


    //Edit Ajax
    EditAjax('hospital/users/patients', EditFormInputValue);


    // Update Ajax
    UpdateAjax('hospital/users/patients', ShowPatients);
    

    // Delete Ajax
    DeleteAjax('hospital/users/patients', ShowPatients);


    // Pagination Ajax
    PaginationAjax(ShowPatients);


    // Search Ajax
    SearchAjax('hospital/users/patients', ShowPatients);


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.data.id);
        $('#updateName').val(res.data.name);
        $('#updateFloor').val(res.data.floor);
        $('#updateTitle').focus();
    }; // End Method
});