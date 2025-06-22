function ShowBillSettlements(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: [ 'booking_id', 'user.user_name', 'user.user_phone', 'adult', 'children', 'check_in', 'check_out', {key:'status', type:'status-show', options:[{id:0, name:'Check-Out'},{id:1, name:'Check-In'},{id:2, name:'Booked'},{id:3, name:'Maintenence'}]} ],
        actions: (row) => `
                <a class="print-receipt" href="/api/get/clearence?id=${row.booking_id}"> <i class="fa-solid fa-receipt"></i></a>
                
                <button data-modal-id="editModal" id="edit" data-id="${row.booking_id}"><i class="fas fa-edit"></i></button>
                `,
        actions: (row) => {
            let buttons = '';

            buttons += `
                   <a class="print-receipt" href="/api/get/clearence?id=${row.booking_id}"> <i class="fa-solid fa-receipt"></i></a>
                `;
        
            if (userPermissions.includes(345)) {
                buttons += `
                   <button data-modal-id="editModal" id="edit" data-id="${row.booking_id}"><i class="fas fa-edit"></i></button>
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
        { label: 'Booking Id', key: 'Booking Id' },
        { label: 'Guest Name', key: 'user.user_name' },
        { label: 'Phone', key: 'user.user_phone' },
        { label: 'Adult', key: 'adult' },
        { label: 'Children', key: 'children' },
        { label: 'Check In', key: 'check_in' },
        { label: 'Check Out', key: 'check_out' },
        { label: 'Status', key:'status', type: 'select', method:'custom', options:[{val:0, text:'Check-Out'},{val:1, text:'Check-In'},{val:2, text:'Booked'},{val:3, text:'Maintenence'}] },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('hotel/billsettlement', ShowBillSettlements);


    // Edit Modal On Part
    $(document).off('click', '#edit').on('click', '#edit', function (e) {
        let id = $(this).attr('data-id');
        $.ajax({
            url: `${apiUrl}/hotel/billsettlement/edit`,
            method: 'GET',
            data: { id },
            success: function (res) {
                if(res.status){
                    $("#editModal").show();
                    $('#bill').html(res.data)
                }
            },
            error: function(response, textStatus, errorThrown) {
                // Form Input Errors
                if (response.responseJSON && response.responseJSON.errors) {
                    $.each(response.responseJSON.errors, function (key, value) {
                        $('#' + key + "_error").text(value);
                    });
                }

                // Show Error Message
                toastr.error('An unexpected error occurred.', errorThrown);
                // console.log('Failed to load dashboard data:', error);
                // console.log("Error: ", response);
                // console.log("Text Status: ", textStatus);
                // console.log("Error Thrown: ", errorThrown);
                // toastr.error('An unexpected error occurred.', "Error");
            },
        });
    });
    
    
    function settlement(){
        let id = $(this).attr('data-id');
        console.log(id);
    }
    // // Confirm Settlement Part
    // $(document).off('click', '#settlement').on('click', '#settlement', function (e) {
    //     let id = $(this).attr('data-id');
    //     console.log(id);
        
    //     // $.ajax({
    //     //     url: `${apiUrl}/hotel/billsettlement/edit`,
    //     //     method: 'GET',
    //     //     data: { id },
    //     //     success: function (res) {
    //     //         if(res.status){
    //     //             $("#editModal").show();
    //     //             $('#bill').html(res.data)
    //     //         }
    //     //     }
    //     // });
    // });

    // // Add Modal Open Functionality
    // AddModalFunctionality("#check_in", function () {
    //     $('#doctor').removeAttr('data-id');
    // });


    // // Insert Ajax
    // InsertAjax('hotel/billsettlement', {guest: { selector: '#guest-all', attribute: 'data-id' },bed_category: { selector: '#bed_category', attribute: 'data-id' }, bed_id: { selector: '#bed_list', attribute: 'data-id' }, sr: { selector: '#sr', attribute: 'data-id' } }, function () {
    //     $('#title').focus();
    //     $('#guest').removeAttr('data-id');
    //     $('#bed_category').removeAttr('data-id');
    //     $('#bed_list').removeAttr('data-id');
    //     $('#sr').removeAttr('data-id');
    //     $('.toggleGuestid').hide();
    // });


    // // Edit Ajax
    // EditAjax(EditFormInputValue);


    // // Update Ajax
    // UpdateAjax('hotel/billsettlement', {guest: { selector: '#updateGuest-all', attribute: 'data-id' },bed_category: { selector: '#updateBed_Category', attribute: 'data-id' }, bed_id: { selector: '#updateBed_List', attribute: 'data-id' }, sr: { selector: '#updateSr', attribute: 'data-id' } });


    // // Delete Ajax
    // DeleteAjax('hotel/billsettlement');


    // // Additional Edit Functionality
    // function EditFormInputValue(item) {
    //     $('#id').val(item.id);
    //     $('#updateCheck_in').val(item.check_in);
    //     $('#updateCheck_out').val(item.check_out);
    //     $('#updateSr').val(item.sr?.user_name);
    //     $('#updateSr').attr('data-id', item.sr?.user_id);
    //     $('#updateStatus').val(item.status);

    //     $('#updateBed_Category').val(item.category?.name);
    //     $('#updateBed_Category').attr('data-id', item.category?.id);
    //     $('#updateBed_List').val(item.list?.name);
    //     $('#updateBed_List').attr('data-id', item.list?.id);
    //     $('#updateTotal').val(item.list?.price);
    //     $('#updateAdult').val(item.adult);
    //     $('#updateChildren').val(item.children);

    //     $('#updateGuest-all').val(item.user?.user_id);
    //     $('#updateGuest-all').attr('data-id', item.user?.user_id);
    //     $('#updateTitle').val(item.user?.title);
    //     $('#updateName').val(item.user?.user_name);
    //     $('#updatePhone').val(item.user?.user_phone);
    //     $('#updateEmail').val(item.user?.user_email); 
    //     $('#updateNid').val(item.user?.nid); 
    //     $('#updatePassport').val(item.user?.passport); 
    //     $('#updatedriving_license').val(item.user?.driving_license); 
    //     $('#updateGender').val(item.user?.gender);
    //     $('#updateNationality').val(item.user?.nationality);
    //     $('#updateReligion').val(item.user?.religion);
    //     $('#updateAddress').val(item.user?.address);

    //     $('#updateDiscount').val(item.bill.discount);
    //     $('#updateAdvance').val(item.bill.receive);
    //     $('#updateBalance').val(item.bill.due);
    //     $('#updatePayment_method').val(item.bill.payment_mode);

    //     $('#updatePatient').focus();
    // }; // End Method


    // //  radio button controll on new and old patient
    // $(document).on('change', '#newGuest', function () {
    //     if ($(this).is(':checked')) {
    //         $('.toggleGuestid').hide();
    //     }
    // })

    // $(document).on('change', '#oldGuest', function () {
    //     if ($(this).is(':checked')) {
    //         $('.toggleGuestid').show();
    //     }
    // })

    // $(document).on('change', '#corporateGuest', function () {
    //     if ($(this).is(':checked')) {
    //         $('.toggleGuestid').hide();
    //     }
    // })


    // // Get Company Type
    // GetSelectInputList('admin/payment_method/get', function (res) {
    //     CreateSelectOptions('#payment_method', 'Select Payment Method', res.data, 'name');
    //     CreateSelectOptions('#updatePayment_method', 'Select Payment Method', res.data, 'name');
    // })


    // // General function to calculate total amount
    // $(document).off('keyup', '#discount, #advance').on('keyup', '#discount, #advance', function (e) {
    //     let total = $('#total').val();
    //     let discount = $('#discount').val();
    //     let advance = $('#advance').val();
    //     let totalAmount = total - discount - advance;
    //     $('#balance').val(totalAmount);
    // });


    // $(document).off('keyup', '#updateDiscount, #updateAdvance').on('keyup', '#updateDiscount, #updateAdvance', function (e) {
    //     let total = $('#updateTotal').val();
    //     let discount = $('#updateDiscount').val();
    //     let advance = $('#updateAdvance').val();
    //     let totalAmount = total - discount - advance;
    //     $('#updateBalance').val(totalAmount);
    // });
});



