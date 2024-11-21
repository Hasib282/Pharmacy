function ShowCompanies(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.company_id}</td>
                    <td>${item.company_name}</td>
                    <td>${item.type.name}</td>
                    <td>${item.company_email}</td>
                    <td>${item.company_phone}</td>
                    <td>${item.address ? item.address : "" }</td>
                    <td><img src="${apiUrl.replace('/api', '')}/storage/logos/${item.logo ? item.logo : 'male.png'}?${new Date().getTime()}" alt="" height="50px" width="50px"></td>
                    <td>
                        <div style="display: flex;gap:5px;">
                            
                            <button class="open-modal" data-modal-id="detailsModal" id="details" data-id="${item.id}"><i class="fa-solid fa-circle-info"></i></button>

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
        url: `${apiUrl}/admin/companies`,
        method: "GET",
        success: function (res) {
            // let queryParams = GetQueryParams();
            // CreateSelectOptions('#types', 'All', res.types, queryParams['type'], 'type_name')
            CreateSelectOptions('#type', 'Select Company Type', res.type, null, 'name')
        },
    });

    // Load Data on Hard Reload
    ReloadData('admin/companies', ShowCompanies);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#type");


    // Insert Ajax
    InsertAjax('admin/companies', ShowCompanies, {}, function() {
        $('#type').focus();
    });


    // Edit Ajax
    EditAjax('admin/companies', EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/companies', ShowCompanies);
    

    // Delete Ajax
    DeleteAjax('admin/companies', ShowCompanies);


    // Pagination Ajax
    PaginationAjax(ShowCompanies);


    // Search Ajax
    SearchAjax('admin/companies', ShowCompanies);


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.company.id);

        CreateSelectOptions('#updateType', 'Select Company Type', res.type, res.company.company_type, 'name');

        $('#updateName').val(res.company.company_name);
        $('#updatePhone').val(res.company.company_phone);
        $('#updateEmail').val(res.company.company_email);
        $('#updateAddress').val(res.company.address);
        $('#updatePreviewImage').attr('src',`${apiUrl.replace('/api', '')}/storage/logos/${res.company.logo}?${new Date().getTime()} `).show();
        $('#updateName').focus();
    }; // End Method


    // Show Detals Ajax
    DetailsAjax('admin/companies');


    // Creating Select Options Dynamically
    // GetTransactionWith(null, null, null, 3, 'Ok');
});