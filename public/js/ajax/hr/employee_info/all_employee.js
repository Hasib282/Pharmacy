function ShowEmployees(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr style="${item.status == 1 ? 'background:#a1f2a1;' : 'background:#ff5353;' }}">
                    <td>${startIndex + key + 1}</td>
                    <td>${item.user_id}</td>
                    <td>${item.user_name}</td>
                    <td>${item.withs.tran_with_name}</td>
                    <td>${item.dob}</td>
                    <td>${item.gender}</td>
                    <td>${item.user_email}</td>
                    <td>${item.user_phone}</td>
                    <td>${item.address}</td>
                    <td><img src="${apiUrl.replace('/api', '')}/storage/profiles/${item.image ? item.image : (item.gender == 'female' ? 'female.png' : 'male.png')}?${new Date().getTime()}" alt="" height="50px" width="50px"></td>
                    <td>
                        <div style="display: flex;gap:5px;">
                        
                            <button class="open-modal" data-modal-id="detailsModal" id="details"
                                    data-id="${item.user_id}"><i class="fa-solid fa-circle-info"></i></button>
                            
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
        $('.load-data .show-table tfoot').html('<tr><td colspan="11" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Load Data on Hard Reload
    ReloadData('hr/employee/all', ShowEmployees);
    

    // Delete Ajax
    DeleteAjax('hr/employee/all', ShowEmployees);


    // Pagination Ajax
    PaginationAjax(ShowEmployees);


    // Search Ajax
    SearchAjax('hr/employee/all', ShowEmployees, {  });


    // Show Detals Ajax
    DetailsAjax('hr/employee/all');
});