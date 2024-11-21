// $(document).ready(function () {
    // // Add Button Click Functionality
    // $(document).on('click', '.add', function (e) {
    //     $('#with').focus();
    // });



    // /////////////// ------------------ Add Payroll Middlewire ajax part start ---------------- /////////////////////////////
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
    //                 $('#head').focus();
    //                 $('#amount').val('');
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



    // ///////////// ------------------ Edit Payroll Middlewire ajax part start ---------------- /////////////////////////////
    // $(document).on('click', '#edit', function () {
    //     let modalId = $(this).data('modal-id');
    //     let id = $(this).data('id');
    //     $.ajax({
    //         url: urls.edit,
    //         method: 'GET',
    //         data: { id },
    //         success: function (res) {
                

    //             var modal = document.getElementById(modalId);

    //             if (modal) {
    //                 modal.style.display = 'block';
    //             }
    //         },
    //         error: function (err) {
    //             console.log(err);
    //         }
    //     });
    // });



    /////////////// ------------------ Update Payroll Middelwire ajax part start ---------------- /////////////////////////////
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
    //                 toastr.success('Payroll Middlewire Updated Successfully', 'Updated!');
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


    // DeleteAjax('Payroll Middlewire Details Deleted', 'Deleted');

    // PaginationAjax({  });

    // SearchAjax({ month: $("#optionMonth").val(), year: $("#optionYear").val() });

    // SearchPaginationAjax({ month: $("#optionMonth").val(), year: $("#optionYear").val() });

    //  // Search By Month and Year
    //  $(document).on('change', '#optionMonth, #optionYear', function (e) {
    //     e.preventDefault();
    //     let search = $('#search').val();
    //     let month = $("#optionMonth").val();
    //     let year = $('#optionYear').val();
    //     let searchOption = $("#searchOption").val();
    //     LoadData(urls.search, { search, month, year, searchOption});
    // });


    

// });







function ShowPayrollMiddlewire(data, startIndex) {
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
                    ${item.date != null ?
                        `<td>${new Date(item.date).toLocaleString('en-US', { month: '2-digit' })}</td>
                        <td>${new Date(item.date).getFullYear()}</td>`
                        :
                        `<td colspan="2"></td>`
                    }
                    
                    <td>
                        <div style="display: flex;gap:5px;">
                            <button class="open-modal" data-modal-id="editModal" id="edit"
                                    data-id="${item.id}"><i class="fas fa-edit"></i></button>
                            
                            <button data-id="${item.id}" id="delete"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            `;

            lastEmpId = item.emp_id;
        });

        // Inject the generated rows into the table body
        $('.load-data .show-table tbody').html(tableRows);
        $('.load-data .show-table tfoot').html('')
    }
    else{
        $('.load-data .show-table tbody').html('');
        $('.load-data .show-table tfoot').html('<tr><td colspan="8" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Creating Select Options Dynamically
    $.ajax({
        url: `${apiUrl}/hr/payroll/middlewire`,
        method: "GET",
        success: function (res) {
            CreateSelectOptions('#with', 'Select Employee Type', res.tranwith, null, 'tran_with_name')
            CreateSelectOptions('#head', 'Select Payroll Category', res.heads, null, 'tran_head_name')
        },
    });

    // Load Data on Hard Reload
    ReloadData('hr/payroll/middlewire', ShowPayrollMiddlewire);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#with");


    // Insert Ajax
    InsertAjax('hr/payroll/middlewire', ShowPayrollMiddlewire, {user: { selector: '#user', attribute: 'data-id' }}, function() {
        $('#with').focus();
        $('#user').removeAttr('data-id');
        $('.payroll-grid tbody').html('');
        // getPayrollByUserId(user, '.payroll-grid tbody');
    });


    //Edit Ajax
    EditAjax('hr/payroll/middlewire', EditFormInputValue);


    // Update Ajax
    UpdateAjax('hr/payroll/middlewire', ShowPayrollMiddlewire, {user: { selector: '#updateUser', attribute: 'data-id' }});
    

    // Delete Ajax
    DeleteAjax('hr/payroll/middlewire', ShowPayrollMiddlewire);


    // Pagination Ajax
    PaginationAjax(ShowPayrollMiddlewire, { month: { selector: '#optionMonth'}, year: { selector: '#optionYear'}});


    // Search Ajax
    SearchAjax('hr/payroll/middlewire', ShowPayrollMiddlewire, { month: { selector: '#optionMonth'}, year: { selector: '#optionYear'}});


    // Search By Month or Year
    SearchBySelect('hr/payroll/middlewire', ShowPayrollMiddlewire, '#optionMonth, #optionYear', { month: { selector: '#optionMonth'}, year: { selector: '#optionYear'}})


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


        $('#updateDate').val(res.payroll.date)
        $('#updateWith').focus();
    }


    // Get Payroll Data By User Id
    function getPayrollByUserId(id, grid) {
        $.ajax({
            url: urls.getuser,
            method: 'GET',
            data: { id },
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