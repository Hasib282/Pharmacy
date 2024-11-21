// $(document).ready(function () {
    /////////////// ------------------ Add Payroll Setup ajax part start ---------------- /////////////////////////////
    // $(document).on('submit', '#AddForm', function (e) {
    //     e.preventDefault();
    //     let user = $('#user').attr('data-id');
    //     let formData = new FormData(this);
    //     formData.append('user', user === undefined ? '' : user);
    //     $.ajax({
    //         url: urls.insert,
    //         method: 'POST',
    //         processData: false,
    //         contentType: false,
    //         cache: false,
    //         data: formData,
    //         beforeSend:function() {
    //             $(document).find('span.error').text('');  
    //         },
    //         success: function (res) {
    //             if (res.status == "success") {
    //                 $('#head').val('');
    //                 $('#amount').val('');
    //                 $('#head').focus();
    //                 $('#search').val('');
    //                 $('.load-data').load(location.href + ' .load-data');
    //                 getPayrollByUserId(user, '.payroll-grid tbody');
    //                 toastr.success('Payroll Added Successfully', 'Added!');
    //             }
    //         },
    //         error: function (err) {
    //             console.log(err)
    //             let error = err.responseJSON;
    //             $.each(error.errors, function (key, value) {
    //                 $('#' + key + "_error").text(value);
    //             });
    //         }
    //     });
    // });







    /////////////// ------------------ Update Payroll Setup ajax part start ---------------- /////////////////////////////
    // $(document).on('submit', '#EditForm', function (e) {
    //     e.preventDefault();
    //     let user = $('#updateUser').attr('data-id');
    //     let formData = new FormData(this);
    //     formData.append('user', user === undefined ? '' : user);
    //     $.ajax({
    //         url: urls.update,
    //         method: 'POST',
    //         processData: false,
    //         contentType: false,
    //         cache: false,
    //         data:formData,
    //         beforeSend:function() {
    //             $(document).find('span.error').text('');  
    //         },
    //         success: function (res) {
    //             if (res.status == "success") {
    //                 $('#editModal').hide();
    //                 $('#EditForm')[0].reset();
    //                 $('#search').val('');
    //                 $('.load-data').load(location.href + ' .load-data');
    //                 toastr.success('Payroll Setup Updated Successfully', 'Updated!');
    //             }
    //         },
    //         error: function (err) {
    //             let error = err.responseJSON;
    //             $.each(error.errors, function (key, value) {
    //                 $('#update_' + key + "_error").text(value);
    //             })
    //         }
    //     });
    // });

    // DeleteAjax('Payroll Middlewire Details Deleted', 'Deleted!');

    // PaginationAjax({  });

    // SearchAjax({  });

    // SearchPaginationAjax({  });

    
// });





function ShowPayrollSetup(data, startIndex) {
    let tableRows = '';
    let lastEmpId = null;
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    ${item.emp_id != lastEmpId ?
                        `<td>${item.emp_id}</td>
                        <td>${item.employee.user_name}</td>`
                        :
                        `<td colspan="2"></td>`
                    }
                    
                    <td>${item.head.tran_head_name}</td>
                    <td>${item.amount}</td>
                    <td>
                        <div style="display: flex;gap:5px;">
                            <button class="open-modal" data-modal-id="editModal" id="edit"
                                    data-id="${item.id}"><i class="fas fa-edit"></i></button>
                                    
                            <button data-id="${item.id}" id="delete"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            `;

            lastEmpId = item.emp_id
        });

        // Inject the generated rows into the table body
        $('.load-data .show-table tbody').html(tableRows);
        $('.load-data .show-table tfoot').html('')
    }
    else{
        $('.load-data .show-table tbody').html('');
        $('.load-data .show-table tfoot').html('<tr><td colspan="6" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Creating Select Options Dynamically
    $.ajax({
        url: `${apiUrl}/hr/payroll/setup`,
        method: "GET",
        success: function (res) {
            CreateSelectOptions('#with', 'Select Employee Type', res.tranwith, null, 'tran_with_name')
            CreateSelectOptions('#head', 'Select Payroll Category', res.heads, null, 'tran_head_name')
        },
    });


    // Load Data on Hard Reload
    ReloadData('hr/payroll/setup', ShowPayrollSetup);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#with");


    // Insert Ajax
    InsertAjax('hr/payroll/setup', ShowPayrollSetup, {user: { selector: '#user', attribute: 'data-id' }}, function() {
        $('#with').focus();
        $('#user').removeAttr('data-id');
        $('.payroll-grid tbody').html('');
        // getPayrollByUserId(user, '.payroll-grid tbody');
    });


    //Edit Ajax
    EditAjax('hr/payroll/setup', EditFormInputValue);


    // Update Ajax
    UpdateAjax('hr/payroll/setup', ShowPayrollSetup, {user: { selector: '#updateUser', attribute: 'data-id' }});
    

    // Delete Ajax
    DeleteAjax('hr/payroll/setup', ShowPayrollSetup);


    // Pagination Ajax
    PaginationAjax(ShowPayrollSetup);


    // Search Ajax
    SearchAjax('hr/payroll/setup', ShowPayrollSetup, {  });


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#id').val(res.payroll.id);

        CreateSelectOptions('#updateWith', 'Select Employee Type', res.tranwith, res.payroll.employee.tran_user_type, 'tran_with_name');
        // $('#updateWith').empty();
        // $.each(res.tranwith, function (key, withs) {
        //     $('#updateWith').append(`<option value="${withs.id}">${withs.tran_with_name}</option>`);
        // });
        
        $('#updateUser').val(res.payroll.employee.user_name);
        $('#updateUser').attr('data-id', res.payroll.emp_id);
        $('#updateAmount').val(res.payroll.amount);
        
        CreateSelectOptions('#updateHead', 'Select Payroll Category', res.heads, res.payroll.head_id, 'tran_head_name');
        // $('#updateHead').empty();
        // $.each(res.heads, function (key, head) {
        //     $('#updateHead').append(`<option value="${head.id}" ${res.payroll.head_id === head.id ? 'selected' : ''}>${head.tran_head_name}</option>`);
        // });
        $('#updateWith').focus();
    }





    // Get Payroll Data By User Id
    function getPayrollByUserId(id, grid) {
        $.ajax({
            url: urls.getuser,
            method: 'GET',
            data: { id:id },
            success: function (res) {
                if(res.status === 'success'){
                    $(grid).html(res.data);
                }
                else{
                    $(grid).html('');
                }
            }
        });
    }
});