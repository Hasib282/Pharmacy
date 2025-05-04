function ShowAppointment(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['appoinment_serial','ptn_id','name','mobile','Doctor', 'date','schedule'],
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
        { label: 'Doctor', key: 'Doctor' },
       
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



