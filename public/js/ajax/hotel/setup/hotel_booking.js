function ShowAppointment(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: [ 'booking_id', 'user.user_name', 'user.user_phone', 'adult', 'children', 'check_in', 'check_out', 'status'],
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
        { label: 'Booking Id', key: 'Booking Id' },
        { label: 'Guest Name', key: 'user.user_name' },
        { label: 'Phone', key: 'user.user_phone' },
        { label: 'Adult', key: 'adult' },
        { label: 'Children', key: 'children' },
        { label: 'Check In', key: 'check_in' },
        { label: 'Check Out', key: 'check_out' },
        { label: 'Status', key: 'status' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('hotel/booking', ShowAppointment);


    // Add Modal Open Functionality
    AddModalFunctionality("#check_in", function () {
        $('#doctor').removeAttr('data-id');
    });


    // Insert Ajax
    InsertAjax('hotel/booking', {guest: { selector: '#guest-all', attribute: 'data-id' },bed_category: { selector: '#bed_category', attribute: 'data-id' }, bed_id: { selector: '#bed_list', attribute: 'data-id' }, sr: { selector: '#sr', attribute: 'data-id' } }, function () {
        $('#title').focus();
        $('#guest').removeAttr('data-id');
        $('#bed_category').removeAttr('data-id');
        $('#bed_list').removeAttr('data-id');
        $('#sr').removeAttr('data-id');
        $('.toggleGuestid').hide();
    });


    // Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('hotel/booking', {guest: { selector: '#updateGuest-all', attribute: 'data-id' },bed_category: { selector: '#updateBed_Category', attribute: 'data-id' }, bed_id: { selector: '#updateBed_List', attribute: 'data-id' }, sr: { selector: '#updateSr', attribute: 'data-id' } });


    // Delete Ajax
    DeleteAjax('hotel/booking');


    // Additional Edit Functionality
    function EditFormInputValue(item) {
        $('#id').val(item.id);
        $('#updateCheck_in').val(item.check_in);
        $('#updateCheck_out').val(item.check_out);
        $('#updateSr').val(item.sr?.user_name);
        $('#updateSr').attr('data-id', item.sr?.user_id);
        $('#updateStatus').val(item.status);

        $('#updateBed_Category').val(item.category?.name);
        $('#updateBed_Category').attr('data-id', item.category?.id);
        $('#updateBed_List').val(item.list?.name);
        $('#updateBed_List').attr('data-id', item.list?.id);
        $('#updateTotal').val(item.list?.price);
        $('#updateAdult').val(item.adult);
        $('#updateChildren').val(item.children);

        $('#updateGuest-all').val(item.user?.user_id);
        $('#updateGuest-all').attr('data-id', item.user?.user_id);
        $('#updateTitle').val(item.user?.title);
        $('#updateName').val(item.user?.user_name);
        $('#updatePhone').val(item.user?.user_phone);
        $('#updateEmail').val(item.user?.user_email); 
        $('#updateNid').val(item.user?.nid); 
        $('#updatePassport').val(item.user?.passport); 
        $('#updatedriving_license').val(item.user?.driving_license); 
        $('#updateGender').val(item.user?.gender);
        $('#updateNationality').val(item.user?.nationality);
        $('#updateReligion').val(item.user?.religion);
        $('#updateAddress').val(item.user?.address);

        $('#updateDiscount').val(item.bill.discount);
        $('#updateAdvance').val(item.bill.receive);
        $('#updateBalance').val(item.bill.due);
        $('#updatePayment_method').val(item.bill.payment_mode);

        $('#updatePatient').focus();
    }; // End Method


    //  radio button controll on new and old patient
    $(document).on('change', '#newGuest', function () {
        if ($(this).is(':checked')) {
            $('.toggleGuestid').hide();
        }
    })

    $(document).on('change', '#oldGuest', function () {
        if ($(this).is(':checked')) {
            $('.toggleGuestid').show();
        }
    })

    $(document).on('change', '#corporateGuest', function () {
        if ($(this).is(':checked')) {
            $('.toggleGuestid').hide();
        }
    })


    // Get Company Type
    GetSelectInputList('admin/payment_method/get', function (res) {
        CreateSelectOptions('#payment_method', 'Select Payment Method', res.data, 'name');
        CreateSelectOptions('#updatePayment_method', 'Select Payment Method', res.data, 'name');
    })


    // General function to calculate total amount
    $(document).off('keyup', '#discount, #advance').on('keyup', '#discount, #advance', function (e) {
        let total = $('#total').val();
        let discount = $('#discount').val();
        let advance = $('#advance').val();
        let totalAmount = total - discount - advance;
        $('#balance').val(totalAmount);
    });


    $(document).off('keyup', '#updateDiscount, #updateAdvance').on('keyup', '#updateDiscount, #updateAdvance', function (e) {
        let total = $('#updateTotal').val();
        let discount = $('#updateDiscount').val();
        let advance = $('#updateAdvance').val();
        let totalAmount = total - discount - advance;
        $('#updateBalance').val(totalAmount);
    });
});



