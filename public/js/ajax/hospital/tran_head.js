// function ShowTranHead(data, startIndex) {
//     let tableRows = '';
    
//     if(data.length > 0){
//         $.each(data, function(key, item) {
//             tableRows += `
//                 <tr>
//                     <td>${startIndex + key + 1}</td>
//                     <td>${item.tran_head_name }</td>
//                     <td>${item.groupe.tran_groupe_name }</td>
//                     <td>${item.company_id}</td>
//                     <td>
//                         <div style="display: flex;gap:5px;">
                            
//                             <button class="open-modal" data-modal-id="editModal" id="edit" data-id="${item.id}"><i class="fas fa-edit"></i></button>
                            
//                             <button data-id="${item.id}" id="delete"><i class="fas fa-trash"></i></button>
                            
//                         </div>
//                     </td>
//                 </tr>
//             `;
//         });

//         // Inject the generated rows into the table body
//         $('.load-data .show-table tbody').html(tableRows);
//         $('.load-data .show-table tfoot').html('')
//     }
//     else{
//         $('.load-data .show-table tbody').html('');
//         $('.load-data .show-table tfoot').html('<tr><td colspan="8" style="text-align:center;">No Data Found</td></tr>')
//     }
// }; // End Function

function ShowTranHead(res) {
    new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_head_name','groupe.tran_groupe_name','company_id'],
        actions: (row) => `
                <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                        
                <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                `,
    });
}



$(document).ready(function () {
    $(document).off(`.${'SearchBySelect'}`);

    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'select', options: [15, 30, 50, 100, 500] },
        { label: 'Transaction Head Name', key: 'tran_head_name' },
        { label: 'Transaction Groupe', key: 'tran_groupe_name' },
        { label: 'Company Id', key: 'company_id' },
        { label: 'Action', type: 'button' }
    ]);

    GetTransactionGroupe(null, null, "Ok");
    // // Creating Select Options Dynamically
    // $.ajax({
    //     url: `${apiUrl}/hospital/setup/services`,
    //     method: "GET",
    //     success: function (res) {
    //         CreateSelectOptions('#groupe', 'Select Transaction Groupe', res.groupes, null, 'tran_groupe_name')
    //     },
    // });

    
    // Load Data on Hard Reload
    ReloadData('hospital/setup/services', ShowTranHead);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#headName");


    // Insert Ajax
    InsertAjax('hospital/setup/services', ShowTranHead, {company: { selector: "#company", attribute: 'data-id' }}, function() {
        $('#headName').focus();
        $('#company').removeAttr('data-id');
    });


    //Edit Ajax
    EditAjax('hospital/setup/services', EditFormInputValue);


    // Update Ajax
    UpdateAjax('hospital/setup/services', ShowTranHead);
    

    // Delete Ajax
    DeleteAjax('hospital/setup/services', ShowTranHead);


    // Pagination Ajax
    PaginationAjax(ShowTranHead);


    // Search Ajax
    SearchAjax('hospital/setup/services', ShowTranHead, {type: { selector: "#types"}, method: { selector: "#methods"}, role: { selector: "#roles"}});


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.data.id);
        $('#updateHeadName').val(res.data.tran_head_name);

        CreateSelectOptions('#updateGroupe', 'Select Transaction Groupe', res.groupes, res.data.groupe_id, 'tran_groupe_name')
        
        $('#updateHeadName').focus();
    }; // End Method
});