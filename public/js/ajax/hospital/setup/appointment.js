function ShowAppointment(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['appoinment_serial','ptn_id','name','mobile','doctor.name', 'date','schedule'],
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
        { label: 'Patient Serial', key: 'appoinment_serial' },
        { label: 'Patient Id', key: 'ptn_id' },
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
        $('#updatePatient').val(item.ptn_id);        //id
        $('#updatePatient').attr('data-id',item.ptn_id);        //id
        $('#updateTitle').val(item.patient.title);  //title
        $('#updateName').val(item.patient.name);    //name
        $('#updatePhone').val(item.patient.phone);  //phone
        $('#updateEmail').val(item.patient.email); // email 
        $('#updateGender').val(item.patient.gender);     //gender
        $('#updateNationality').val(item.patient.nationality);    //Nationality
        $('#updateReligion').val(item.patient.religion);    
        $('#updateAddress').val(item.patient.address);      
        $('#updateDoctor').val(item.doctor.name);      
        $('#updateDoctor').attr('data-id',item.doctor.id);    //doctor
        $('#updateDate').val(item.date);  
        $('#updateSchedule').val(item.schedule);  
        $('#updateAppointment').val(item.appoinment_serial);  
        // $('#updateTitle').val(item.);
        $('#updatePtn_Ide').focus();
    }; // End Method
});



