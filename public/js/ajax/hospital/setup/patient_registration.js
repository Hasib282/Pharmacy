function ShowPatientRegistration(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['reg_id','user_id','bed_list','doctor', 'sr_id','admission_by',{key:'added_at',type:'date'}],
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
        { label: 'Registration Id', key: 'reg_id' },
        { label: 'Patient Id', key: 'ptn_id' },
        { label: 'Bed list', key: 'bed_list' },
        { label: 'Doctor', key: 'doctor' },
        { label: 'SR', key: 'sr_id' },
        { label: 'Admission By', key: 'addmission_by' },
        { label: 'Added At', key: 'added_at' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('hospital/ptnregistration', ShowPatientRegistration);
    
    
    // Add Modal Open Functionality
    AddModalFunctionality("#title", function () {
        $('#bed_category').removeAttr('data-id');
        $('#bed_list').removeAttr('data-id');
        $('#doctor').removeAttr('data-id');
        $('#sr').removeAttr('data-id');
    });


    // Insert Ajax
    InsertAjax('hospital/ptnregistration', {bed_category: { selector: '#bed_category', attribute: 'data-id' }, bed_list: { selector: '#bed_list', attribute: 'data-id' }, doctor: { selector: '#doctor', attribute: 'data-id' }, sr: { selector: '#sr', attribute: 'data-id' }}, function() {
        $('#title').focus();
        $('#bed_category').removeAttr('data-id');
        $('#bed_list').removeAttr('data-id');
        $('#doctor').removeAttr('data-id');
        $('#sr').removeAttr('data-id');
        $('.togglePatientid').hide();
        $('#togglePhone').show();
    });


    // Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hospital/ptnregistration');
    

    // Delete Ajax
    DeleteAjax('hospital/ptnregistration');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateName').val(item.name);
        $('#updateFloor').val(item.floor);
        $('#updateName').focus();
    }; // End Method



    //  radio button controll on new and old patient
    $(document).on('change', '#newPatient', function () {
        if ($(this).is(':checked')) {
            $('.togglePatientid').hide();
        }
    })

    $(document).on('change', '#oldPatient', function () {
        if ($(this).is(':checked')) {
            $('.togglePatientid').show();
        }
    })
});