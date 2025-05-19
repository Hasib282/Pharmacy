function ShowPatientRegistration(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['booking_id','user.user_name','list.name','doctors.name', 'sr.user_name','admission_by',{key:'added_at',type:'date'}],
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
        { label: 'Registration Id', key: 'booking_id' },
        { label: 'Patient Name', key: 'user.user_name' },
        { label: 'Bed list', key: 'list.name' },
        { label: 'Doctor', key: 'doctors.name' },
        { label: 'SR', key: 'sr.user_name' },
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
    InsertAjax('hospital/ptnregistration', {ptn_id: { selector: '#patient', attribute: 'data-id' },bed_category: { selector: '#bed_category', attribute: 'data-id' }, bed_list: { selector: '#bed_list', attribute: 'data-id' }, doctor: { selector: '#doctor', attribute: 'data-id' }, sr: { selector: '#sr', attribute: 'data-id' }}, function() {
        $('#title').focus();
        $('#patient').removeAttr('data-id');
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
    UpdateAjax('hospital/ptnregistration', {ptn_id: { selector: '#updatePatient', attribute: 'data-id' },bed_category: { selector: '#updateBed_Category', attribute: 'data-id' }, bed_list: { selector: '#updateBed_List', attribute: 'data-id' }, doctor: { selector: '#updateDoctor', attribute: 'data-id' }, sr: { selector: '#updateSr', attribute: 'data-id' }});
    

    // Delete Ajax
    DeleteAjax('hospital/ptnregistration');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updatePatient').val(item.user.user_id);
        $('#updatePatient').attr('data-id',item.user.user_id);
        $('#updateTitle').val(item.user.title);
        $('#updateName').val(item.user.user_name);
        $('#updatePhone').val(item.user.user_phone);
        $('#updateEmail').val(item.user.user_email);
        $('#updateGender').val(item.user.gender);
        $('#updateNationality').val(item.user.nationality);
        $('#updateReligion').val(item.user.religion);    
        $('#updateAddress').val(item.user.address);
        $('#updateBed_Category').val(item.category.name);
        $('#updateBed_Category').attr('data-id',item.category.id);
        $('#updateBed_List').val(item.list.name);
        $('#updateBed_List').attr('data-id',item.list.id);
        $('#updateDoctor').val(item.doctors.name);
        $('#updateDoctor').attr('data-id',item.doctors.id);
        $('#updateSr').val(item.sr.user_name);
        $('#updateSr').attr('data-id',item.sr.user_id);
        $('#updateDate').val(item.date);  
        $('#updateSchedule').val(item.schedule);  
        $('#updateAppointment').val(item.appoinment_serial);  

        const age = calculateAge(item.user.dob);

        $('#updateAge_years').val(age.years);
        $('#updateAge_months').val(age.months);
        $('#updateAge_days').val(age.days);
        // $('#updateTitle').val(item.);
        $('#updatePatient').focus();
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