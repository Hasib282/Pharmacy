function ShowPatients(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['ptn_id','title','name','email', 'phone','gender','address'],
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
        { label: 'Patient Id', key: 'ptn_id' },
        { label: 'Title', key: 'title' },
        { label: 'Name', key: 'name' },
        { label: 'Email', key: 'email' },
        { label: 'Phone', key: 'phone' },
        { label: 'Gender', key: 'gender'},
        { label: 'Address', key: 'address' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('hospital/users/patients', ShowPatients);
    
    
    // Add Modal Open Functionality
    AddModalFunctionality("#title");


    //Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hospital/users/patients');

    
    // Delete Ajax
    DeleteAjax('hospital/users/patients', ShowPatients);


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateName').val(item.name);
        $('#updateTitle').val(item.title);
        $('#updatePhone').val(item.phone);
        $('#updateAddress').val(item.address);
        $('#updateEmail').val(item.email);

        $('#updateAge_years').val(item.age_years);
        $('#updateAge_months').val(item.age_months);
        $('#updateAge_days').val(item.age_days);
        
        $('#updateGender').val(item.gender);
        $('#updateNationality').val(item.nationality);
        $('#updateReligion').val(item.religion);
        
        $('#updateTitle').focus();
    }; // End Method
});