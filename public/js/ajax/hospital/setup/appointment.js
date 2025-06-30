function ShowAppointment(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['appoinment_serial','user_id','name','mobile','doctor.name', 'date','schedule'],
      
         actions: (row) => {
            let buttons = '';
        
            if (userPermissions.includes(376)) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }
            
            buttons += `
                <button data-id="${row.id}" id="delete_status"><i class="fa-solid fa-trash-arrow-up"></i></button>
            `;

            if (userPermissions.includes(377)) {
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
        { label: 'Patient Serial', key: 'appoinment_serial' },
        { label: 'Patient Id', key: 'user_id' },
        { label: 'Name', key: 'name' },
        { label: 'Phone', key: 'moblie' },
        { label: 'Doctor', key: 'doctor.name' },
       
        { label: 'Date', key: 'date', type:'date' },
        { label: 'Shedule', key: 'schedule' },

        { label: 'Action', type: 'button' }
        
    ]);


    // Load Data on Hard Reload
    ReloadData('hospital/ptnappointment', ShowAppointment);

     
    // Add Modal Open Functionality
     AddModalFunctionality("#title", function () {
        $('#doctor').removeAttr('data-id');
    });


    // Insert Ajax
    InsertAjax('hospital/ptnappointment', {doctor: { selector: '#doctor', attribute: 'data-id' }}, function() {
        $('#title').focus();
        $('#doctor').removeAttr('data-id');
        $('.togglePatientid').hide();
    });

    
    
    // Edit Ajax
    EditAjax(EditFormInputValue);
    
    
    // Update Ajax
    UpdateAjax('hospital/ptnappointment',{doctor: { selector: '#updateDoctor', attribute: 'data-id' }});

    
    
    // Delete Ajax
    DeleteAjax('hospital/ptnappointment');
    

    // Delete status  Ajax
    DeleteStatusAjax('hospital/ptnappointment');
   
   
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
        $('#updateDoctor').val(item.doctor.name);      
        $('#updateDoctor').attr('data-id',item.doctor.id);
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
});



