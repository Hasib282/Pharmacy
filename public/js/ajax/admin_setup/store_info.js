function ShowStores(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.store_name}</td>
                    <td>${item.division}</td>
                    <td>${item.location.upazila}</td>
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
        $('.load-data .show-table tfoot').html('<tr><td colspan="8" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Load Data on Hard Reload
    ReloadData('admin/stores', ShowStores);
    
    
    // Add Modal Open Functionality
    AddModalFunctionality("#store_name");


    // Insert Ajax
    InsertAjax('admin/stores', ShowStores, {location: { selector: '#location', attribute: 'data-id' }}, function() {
        $('#store_name').focus();
        $('#location').removeAttr('data-id');
    });


    //Edit Ajax
    EditAjax('admin/stores', EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/stores', ShowStores, {location: { selector: '#updateLocation', attribute: 'data-id' }});
    

    // Delete Ajax
    DeleteAjax('admin/stores', ShowStores);


    // Pagination Ajax
    PaginationAjax(ShowStores);


    // Search Ajax
    SearchAjax('admin/stores', ShowStores, {division: { selector: '#searchDivision'}});


    // Search By Division
    SearchBySelect('admin/stores', ShowStores, "#searchDivision", {division: { selector: '#searchDivision'}} );


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.store.id);
        $('#update_store_name').val(res.store.store_name);

        // Create options dynamically
        $('#updateDivision').empty();
        $('#updateDivision').append(`<option value="Dhaka" ${res.store.division === 'Dhaka' ? 'selected' : ''}>Dhaka</option>
            <option value="Chittagong" ${res.store.division === 'Chittagong' ? 'selected' : ''}>Chittagong</option>
            <option value="Rajshahi" ${res.store.division === 'Rajshahi' ? 'selected' : ''}>Rajshahi</option>
            <option value="Khulna" ${res.store.division === 'Khulna' ? 'selected' : ''}>Khulna</option>
            <option value="Sylhet" ${res.store.division === 'Sylhet' ? 'selected' : ''}>Sylhet</option>
            <option value="Barishal" ${res.store.division === 'Barishal' ? 'selected' : ''}>Barishal</option>
            <option value="Rangpur" ${res.store.division === 'Rangpur' ? 'selected' : ''}>Rangpur</option>
            <option value="Mymensingh" ${res.store.division === 'Mymensingh' ? 'selected' : ''}>Mymensingh</option>`);

        $('#updateLocation').val(res.store.location.upazila);
        $('#updateLocation').attr('data-id',res.store.location_id);
        $('#updateAddress').val(res.store.address);
    }; // End Method
});