function ShowPatients(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['user_id','title','user_name','user_email', 'user_phone','gender','address'],
        
        actions: (row) => {
            let buttons = '';
        
            if (userPermissions.includes(396) || role == 1) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }

            if (userPermissions.includes(397) || role == 1) {
                buttons += `
                <button data-id="${row.id}" id="delete_status" class="icon-wrapper" title="Toggle Delete"><i class="fa-solid fa-trash-arrow-up main-icon"></i><i class="fa-solid fa-arrows-rotate ring-icon"></i></button>
                `;
            }
            
            if (role == (1 || 2)) {
                buttons += `
                    <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                `;
            }
        
            return buttons;
        }
    });
}




$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Patient Id', key: 'user_id' },
        { label: 'Title', key: 'title' },
        { label: 'Name', key: 'user_name' },
        { label: 'Email', key: 'user_email' },
        { label: 'Phone', key: 'user_phone' },
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

    
    // Delete status Ajax
    DeleteStatusAjax('hospital/users/patients', ShowPatients);


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateName').val(item.user_name);
        $('#updateTitle').val(item.title);
        $('#updatePhone').val(item.user_phone);
        $('#updateAddress').val(item.address);
        $('#updateEmail').val(item.user_email);

        const age = calculateAge(item.dob);

        $('#updateAge_years').val(age.years);
        $('#updateAge_months').val(age.months);
        $('#updateAge_days').val(age.days);
        
        $('#updateGender').val(item.gender);
        $('#updateNationality').val(item.nationality);
        $('#updateReligion').val(item.religion);
        
        $('#updateTitle').focus();
    }; // End Method
});