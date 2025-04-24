function ShowLocations(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['division','district','upazila'],
        actions: (row) => `
                <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                        
                <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                `,
    });
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Division', key: 'division' },
        { label: 'District', key: 'district' },
        { label: 'Upazila', key: 'upazila' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('admin/locations', ShowLocations);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#division");


    // Insert Ajax
    InsertAjax('admin/locations', {}, function() {
        $('#division').focus();
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/locations');
    

    // Delete Ajax
    DeleteAjax('admin/locations');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        // Create options dynamically
        $('#updateDivision').empty();
        $('#updateDivision').append(`<option value="Dhaka" ${item.division === 'Dhaka' ? 'selected' : ''}>Dhaka</option>
                                    <option value="Chittagong" ${item.division === 'Chittagong' ? 'selected' : ''}>Chittagong</option>
                                    <option value="Rajshahi" ${item.division === 'Rajshahi' ? 'selected' : ''}>Rajshahi</option>
                                    <option value="Khulna" ${item.division === 'Khulna' ? 'selected' : ''}>Khulna</option>
                                    <option value="Sylhet" ${item.division === 'Sylhet' ? 'selected' : ''}>Sylhet</option>
                                    <option value="Barishal" ${item.division === 'Barishal' ? 'selected' : ''}>Barishal</option>
                                    <option value="Rangpur" ${item.division === 'Rangpur' ? 'selected' : ''}>Rangpur</option>
                                    <option value="Mymensingh" ${item.division === 'Mymensingh' ? 'selected' : ''}>Mymensingh</option>`);
        $('#updateDistrict').val(item.district);
        $('#updateUpazila').val(item.upazila);
        $('#updateDivision').focus();
    }
});