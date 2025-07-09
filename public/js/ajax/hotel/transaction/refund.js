function ShowRefunds(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['tran_id','user.user_name',{key:'bill_amount', type: 'number',footerType:'sum'}, 'booking_id'],
       
         actions: (row) => {
            let buttons = '';

            buttons += `
                     <a class="print-receipt" href="/api/get/invoice?id=${row.tran_id}&status=1"> <i class="fa-solid fa-receipt"></i></a>
                `;
        
            if (userPermissions.includes(341) || role == 1) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }

            if (userPermissions.includes(342) || role == 1) {
                buttons += `
                <button data-id="${row.id}" id="delete_status" class="icon-wrapper" title="Toggle Delete"><i class="fa-solid fa-trash-arrow-up main-icon"></i><i class="fa-solid fa-arrows-rotate ring-icon"></i></button>
                `;
                
                if (role == 1 || role == 2) {
                    buttons += `
                        <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                    `;
                }
            }
            
            return buttons;
        }
    });
}

$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Transaction Id', key: 'tran_id' },
        { label: 'User', key: 'user.user_name' },
        { label: 'Deposit Amount' },
        { label: 'Booking Id', key:'booking_id' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('hotel/transaction/refunds', ShowRefunds);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#date");


    // Insert Ajax
    InsertAjax('hotel/transaction/refunds', {guest_id: { selector: '#guest', attribute: 'data-id' }, booking_id: { selector: '#hotel-booking', attribute: 'data-id' },head_id: { selector: '#head', attribute: 'data-id' }, groupe_id: { selector: '#head', attribute: 'data-groupe' }, type: 8, method: "Deposit"}, function () {
        $('#guest').removeAttr('data-id');
        $('#hotel-booking').removeAttr('data-id');
        $('#date').focus();
    });


    // Edit Ajax
    EditAjax(EditFormInputValue);


    // Update ajax
    UpdateAjax('hotel/transaction/refunds', {guest_id: { selector: '#updateGuest', attribute: 'data-id' }, booking_id: { selector: '#updateHotel-booking', attribute: 'data-id' },head_id: { selector: '#updateHead', attribute: 'data-id' }, groupe_id: { selector: '#updateHead', attribute: 'data-groupe' }});
    

    // Delete Ajax
    DeleteAjax('hotel/transaction/refunds');
    

    // Delete status  Ajax
    DeleteStatusAjax('hotel/transaction/refunds');


    // Search By Date
    SearchByDateAjax('hotel/transaction/refunds/search', ShowRefunds, {type: 8, method: 'Deposit'});


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateTranId').val(item.tran_id);
        
        $('#updateGuest').attr('data-id',item.tran_user);
        $('#updateGuest').val(item.user.user_name);
        $('#updateGuest').val(item.user.user_name);
        $('#updateTitle').val(item.user.title);
        $('#updateName').val(item.user.user_name);
        $('#updatePhone').val(item.user.user_phone);
        $('#updateEmail').val(item.user.user_email);
        $('#updateAddress').val(item.user.address);
        
        $('#updateHotel-booking').attr('data-id',item.booking_id);
        $('#updateHotel-booking').val(item.booking_id);
        $('#updateCheck_in').val(item.booking.check_in);
        $('#updateCheck_out').val(item.booking.check_out);
        $("#updateAmount").val(item.bill_amount);
        $("#updateTotAmount").val(item.bill_amount);
        $("#updatePayment_method").val(item.payment_mode);

        $("#updateAmount").focus();
    }


    // Get Company Type
    GetSelectInputList('admin/payment_method/get', function (res) {
        CreateSelectOptions('#payment_method', 'Select Payment Method', res.data, 'name');
        CreateSelectOptions('#updatePayment_method', 'Select Payment Method', res.data, 'name');
    })
});