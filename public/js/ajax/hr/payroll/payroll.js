// $(document).ready(function () {
    ///////////// ------------------ Payroll Details Part Ajax Start Here ---------------- /////////////////////////////
    $(document).on('click', '#details', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        let month = $('#month').attr('data-id'); 
        let year = $('#year').val();
        $.ajax({
            url: urls.payrollByDate,
            method: 'GET',
            data: { id, month, year },
            success: function (res) {
                if (res.status === 'success') {
                    $('.payroll-grid tbody').html(res.data);
                    $('#employee').val(res.payrolls[0].employee.user_name);
                    $('#employee').attr('data-id', res.payrolls[0].emp_id);

                    $('#head').empty();
                    $('#head').append('<option value="">Select Payroll Category</option>');
                    $.each(res.heads, function (key, head) {
                        $('#head').append(`<option value="${head.id}">${head.tran_head_name}</option>`);
                    });
                } 
                else {
                    $('.payroll-grid tbody').html('');
                }

                var modal = document.getElementById(modalId);
                if (modal) {
                    modal.style.display = 'block';
                }
            },
            error: function (err) {
                console.log(err);
            }
        });
    });
    


    // /////////////// ------------------ Edit Payroll ajax part start ---------------- /////////////////////////////
    // $(document).on('click', '#EditPayroll', function (e) {
    //     e.preventDefault();
    //     let user = $('#employee').attr('data-id');
    //     let head = $('#head').val();
    //     let amount = $('#amount').val();
    //     let date = $('#year').val()+'-'+$('#month').attr('data-id')+'-'+'07';
    //     $.ajax({
    //         url: urls.middlewire,
    //         method: 'POST',
    //         data: { user, head, amount, date },
    //         beforeSend:function() {
    //             $(document).find('span.error').text('');
    //         },
    //         success: function (res) {
    //             if (res.status == "success") {
    //                 $('#head').val('');
    //                 $('#head').focus();
    //                 $('#amount').val('');
    //                 getPayrollByUserId(user);
    //                 toastr.success('Payroll Added Successfully', 'Added!');
    //                 $('.load-data').load(location.href + ' .load-data');
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
// });









function ShowPayrolls(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${key + 1}</td>
                    <td>${item['emp_id']}</td>
                    <td>${item['emp_name']}</td>
                    <td>${item['salary'].toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td>
                        
                        <button class="open-modal" data-modal-id="editModal" id="edit"
                                    data-id="${item['emp_id']}"><i class="fa-solid fa-circle-info"></i></button>
                        
                    </td>
                </tr>
            `;
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
    // Load Data on Hard Reload
    ReloadData('hr/payroll/process', ShowPayrolls);
    

    // // Add Modal Open Functionality
    // AddModalFunctionality("#division");


    // // Insert Ajax
    // InsertAjax('hr/payroll/process', ShowPayrolls, {}, function() {
    //     $('#division').focus();
    // });


    //Edit Ajax
    EditAjax('hr/payroll/process', EditFormInputValue, EditModalOn);


    // // Update Ajax
    // UpdateAjax('hr/payroll/process', ShowPayrolls);
    

    // Delete Ajax
    // DeleteAjax('hr/payroll/process', ShowPayrolls);


    // Pagination Ajax
    PaginationAjax(ShowPayrolls, { month: { selector: '#month'}, year: { selector: '#year'}});


    // Search Ajax
    SearchAjax('hr/payroll/process', ShowPayrolls, { month: { selector: '#month'}, year: { selector: '#year'}});


    // Search By Month or Year
    SearchBySelect('hr/payroll/process', ShowPayrolls, '#month, #year', { month: { selector: '#month'}, year: { selector: '#year'}})


    // Additional Edit Functionality
    function EditFormInputValue(res){
        if (res.status) {
            $('.payroll-grid tbody').html(res.data);
            $('#employee').val(res.payrolls[0].employee.user_name);
            $('#employee').attr('data-id', res.payrolls[0].emp_id);

            CreateSelectOptions('#head', 'Select Payroll Category', res.heads, null, 'tran_head_name');

            // $('#head').empty();
            // $('#head').append('<option value="">Select Payroll Category</option>');
            // $.each(res.heads, function (key, head) {
            //     $('#head').append(`<option value="${head.id}">${head.tran_head_name}</option>`);
            // });
        } 
        else {
            $('.payroll-grid tbody').html('');
        }
        // $('#id').val(res.location.id);
        // // Create options dynamically
        // $('#updateDivision').empty();
        // $('#updateDivision').append(`<option value="Dhaka" ${res.location.division === 'Dhaka' ? 'selected' : ''}>Dhaka</option>
        //                             <option value="Chittagong" ${res.location.division === 'Chittagong' ? 'selected' : ''}>Chittagong</option>
        //                             <option value="Rajshahi" ${res.location.division === 'Rajshahi' ? 'selected' : ''}>Rajshahi</option>
        //                             <option value="Khulna" ${res.location.division === 'Khulna' ? 'selected' : ''}>Khulna</option>
        //                             <option value="Sylhet" ${res.location.division === 'Sylhet' ? 'selected' : ''}>Sylhet</option>
        //                             <option value="Barishal" ${res.location.division === 'Barishal' ? 'selected' : ''}>Barishal</option>
        //                             <option value="Rangpur" ${res.location.division === 'Rangpur' ? 'selected' : ''}>Rangpur</option>
        //                             <option value="Mymensingh" ${res.location.division === 'Mymensingh' ? 'selected' : ''}>Mymensingh</option>`);
        // $('#updateDistrict').val(res.location.district);
        // $('#updateUpazila').val(res.location.upazila);
        // $('#updateDivision').focus();
    }



    // Additional Edit Functionality
    function EditModalOn(){
        let month = $('#month').attr('data-id'); 
        let year = $('#year').val();
    }



    // Get Payroll Data By User Id
    function getPayrollByUserId(id) {
        let month = $('#month').attr('data-id');
        let year = $('#year').val();
        $.ajax({
            url: urls.payrollByDate,
            method: 'GET',
            data: { id, month, year },
            success: function (res) {
                if(res.status === 'success'){
                    $('.payroll-grid tbody').html(res.data);
                }
                else{
                    $('.payroll-grid tbody').html('');
                }
            }
        });
    }








    /////////////// ----------------------- Payroll Process Part Ajax start here ------------------- //////////////////////////
    //Process Button Functionality
    $(document).on('click', '#PayrollProcess', function (e) {
        e.preventDefault();
        $('#confirmModal').show();
        $('#cancelProcessBtn').focus();
    });



    // Cancel Button Functionality
    $(document).on('click', '#cancelProcessBtn', function (e) {
        e.preventDefault();
        $('#confirmModal').hide();
    });



    // Confirm Button Functionality
    $(document).on('click', '#confirmProcessBtn', function (e) {
        e.preventDefault();
        $.ajax({
            url: `${apiUrl}/hr/payroll/process`,
            method: 'POST',
            success: function (res) {
                if (res.status) {
                    $('#confirmModal').hide();
                    toastr.success(res.message, 'Added!');
                }
                else{
                    toastr.error(res.message, 'Error!');
                    $('#confirmModal').hide();
                }
            },
            error: function (err) {
                console.log(err)
                let error = err.responseJSON;
                $.each(error.errors, function (key, value) {
                    $('#' + key + "_error").text(value);
                });
            }
        });
    });

    /////////////// ----------------------- Payroll Process Part Ajax end here ------------------- //////////////////////////
});