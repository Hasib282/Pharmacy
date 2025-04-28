function ShowBedList(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['category.name','name','nursing.name'],
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
        { label: 'Bed Category Name', key: 'category.name' },
        { label: 'Bed List Name', key: 'name' },
        { label: 'NursingName', key: 'nursing.name' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('hospital/setup/bedlist', ShowBedList);
    
    
    // Add Modal Open Functionality
    AddModalFunctionality("#bed_category", function () {
        $('#nursing_station').removeAttr('data-id');
        $('#bed_category').removeAttr('data-id');
    });


    // Insert Ajax
    InsertAjax('hospital/setup/bedlist', {nursing_station: { selector: '#nursing_station', attribute: 'data-id' }, bed_category: { selector: '#bed_category', attribute: 'data-id' }}, function() {
        $('#bed_category').focus();
        $('#nursing_station').removeAttr('data-id');
        $('#bed_category').removeAttr('data-id');
    });


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hospital/setup/bedlist', {nursing_station: { selector: '#updateNursing_Station', attribute: 'data-id' }, bed_category: { selector: '#updateBed_Category', attribute: 'data-id' }});
    

    // Delete Ajax
    DeleteAjax('hospital/setup/bedlist');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#EditForm')[0].reset();
        $('#id').val('');
        $('#updateName').val('');
        $('#updateBed_Category').val('');
        $('#updateBed_Category').removeAttr('data-id');
        $('#updateNursing_Station').val('');
        $('#updateNursing_Station').removeAttr('data-id');

        $('#id').val(item.id);
        $('#updateName').val(item.name);
        $('#updateBed_Category').val(item.category.name);
        $('#updateBed_Category').attr('data-id',item.category.id);
        $('#updateNursing_Station').val(item.nursing.name);
        $('#updateNursing_Station').attr('data-id',item.nursing.id);
        $('#updateBed_Category').focus();
    }; // End Method
});