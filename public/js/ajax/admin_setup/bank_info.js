function ShowBanks(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.user_id }</td>
                    <td>${item.name }</td>
                    <td>${item.email }</td>
                    <td>${item.phone }</td>
                    <td>${item.location.upazila }</td>
                    <td>${item.address }</td>
                    <td>
                        <div style="display: flex;gap:5px;">
                            
                            <button class="open-modal" data-modal-id="detailsModal" id="details"
                                    data-id="${item.user_id}"><i class="fa-solid fa-circle-info"></i></button>
                                    
                            <button class="open-modal" data-modal-id="editModal" id="edit"
                                    data-id="${item.id}"><i class="fas fa-edit"></i></button>
                                    
                            <button data-modal-id="deleteModal" data-id="${item.id}" id="delete"><i
                                    class="fas fa-trash"></i></button>
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
    ReloadData('admin/banks', ShowBanks);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#name");


    // Insert Ajax
    InsertAjax('admin/banks', ShowBanks, {location: { selector: '#location', attribute: 'data-id' }}, function() {
        $('#name').focus();
        $('#location').removeAttr('data-id');
    });


    // Edit Ajax
    EditAjax('admin/banks', EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/banks', ShowBanks, {location: { selector: '#updateLocation', attribute: 'data-id' }});
    

    // Delete Ajax
    DeleteAjax('admin/banks', ShowBanks);


    // Pagination Ajax
    PaginationAjax(ShowBanks);


    // Search Ajax
    SearchAjax('admin/banks', ShowBanks);


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.bank.id);
        $('#updateName').val(res.bank.name);
        $('#updatePhone').val(res.bank.phone);
        $('#updateEmail').val(res.bank.email);

        // Create options dynamically
        $('#updateDivision').empty();
        $('#updateDivision').append(`<option value="Dhaka" ${res.bank.location.division === 'Dhaka' ? 'selected' : ''}>Dhaka</option>
            <option value="Chittagong" ${res.bank.location.division === 'Chittagong' ? 'selected' : ''}>Chittagong</option>
            <option value="Rajshahi" ${res.bank.location.division === 'Rajshahi' ? 'selected' : ''}>Rajshahi</option>
            <option value="Khulna" ${res.bank.location.division === 'Khulna' ? 'selected' : ''}>Khulna</option>
            <option value="Sylhet" ${res.bank.location.division === 'Sylhet' ? 'selected' : ''}>Sylhet</option>
            <option value="Barisal" ${res.bank.location.division === 'Barisal' ? 'selected' : ''}>Barisal</option>
            <option value="Rangpur" ${res.bank.location.division === 'Rangpur' ? 'selected' : ''}>Rangpur</option>
            <option value="Mymensingh" ${res.bank.location.division === 'Mymensingh' ? 'selected' : ''}>Mymensingh</option>`);

        $('#updateLocation').val(res.bank.location.upazila);
        $('#updateLocation').attr('data-id',res.bank.loc_id);
        $('#updateAddress').val(res.bank.address);
        $('#updateName').focus();
    }; // End Method


    // Show Detals Ajax
    DetailsAjax('admin/banks');
});