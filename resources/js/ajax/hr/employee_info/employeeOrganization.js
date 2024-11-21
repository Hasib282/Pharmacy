$(document).ready(function () {

    ///////////// ------------------ Show Organization Details Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#details', function (e) {
        let modal = $(this).attr('data-modal-id');
        let id = $(this).attr('data-id');
        $.ajax({
            url: urls.detail,
            method: 'GET',
            data: { id },
            success: function (res) {
                $("#"+ modal).show();
                $('.employeeorganizationdetails').html(res.data)
            },
            error: function (err) {
                console.log(err)
            }
        });
    });

    // Show Employee Details List Toggle Functionality
    $(document).on('click', '.employeeorganizationdetails li', function(e){
        let id = $(this).attr('data-id');
        if(id == 1){
            if($('.personal').is(':visible')){
                $('.personal').hide()
            }
            else{
                $('.personal').show();
            }
        }
        else if(id == 2){
            if($('.organization').is(':visible')){
                $('.organization').hide()
            }
            else{
                $('.organization').show();
            }
        }
    });




    ///////////// ------------------ Show Organization Grid Ajax Part Start ---------------- /////////////////////////////
    // Show Button functionality
    $(document).on('click', '.emp_organizationDetail', function (e) {
        let id = $(this).attr('data-id');
        let $detailsRow = $(`#detailsorganization${id}`);
        let $button = $(this); // Reference to the clicked button

        if ($detailsRow.is(':visible')) {
            // If the row is visible, hide it, change button text to "Show", and remove caret rotation
            $detailsRow.hide();
            $button.find('.fa-chevron-circle-right').removeClass('rotate');
        } else {
            // Fetch data and show it, then change button text to "Hide", and add caret rotation
            $.ajax({
                url: urls.grid,
                method: 'GET',
                data: { id },
                success: function (res) {
                    console.log(res);
                    $detailsRow.find('td').html(res.data);
                    $detailsRow.show();
                    $button.find('.fa-chevron-circle-right').addClass('rotate');
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }
    });



    ///////////// ------------------ Insert Organization Details Ajax Part Start ---------------- /////////////////////////////
    $(document).on('submit', '#AddForm', function (e) {
        e.preventDefault();
        let user = $('#user').attr('data-id');
        let locations = $('#location').attr('data-id');
        let department = $('#department').attr('data-id');
        let designation = $('#designation').attr('data-id');
        let formData = new FormData(this);
        formData.append('user', user === undefined ? '' : user);
        formData.append('location', locations === undefined ? '' : locations);
        formData.append('department', department === undefined ? '' : department);
        formData.append('designation', designation === undefined ? '' : designation);
        $.ajax({
            url: urls.insert,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                console.log(res)
                if (res.status == "success") {
                    $('#AddForm')[0].reset();
                    $('#name').focus();
                    $('#user').removeAttr('data-id');
                    $('#location').removeAttr('data-id');
                    $('#department').removeAttr('data-id');
                    $('#designation').removeAttr('data-id');
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    $('#previewImage').attr('src',`#`).hide();
                    toastr.success('Organization Detail Added Successfully', 'Added!');
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



    ///////////// ------------------ Edit Organization Details Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id },
            success: function (res) {
                $('#id').val(res.employee.id);
                $('#emp_id').val(res.employee.emp_id);
                $('#update_joining_date').val(res.employee.joining_date);
                $('#updateLocation').val(res.employee.location.upazila);
                $('#updateLocation').attr('data-id',res.employee.joining_location);
                $('#updateDepartment').val(res.employee.department.dept_name);
                $('#updateDepartment').attr('data-id',res.employee.Department);
                $('#updateDesignation').val(res.employee.designation.designation);
                $('#updateDesignation').attr('data-id',res.employee.Designation);

                var modal = document.getElementById(modalId);
                modal.style.display = 'block';
            },
            error: function (err) {
                console.log(err);
            }
        });
    });



    /////////////// ------------------ Update Organization Details Ajax Part Start ---------------- /////////////////////////////
    $(document).on('submit', '#EditForm', function (e) {
        e.preventDefault();
        let locations = $('#updateLocation').attr('data-id');
        let department = $('#updateDepartment').attr('data-id');
        let designation = $('#updateDesignation').attr('data-id');
        let formData = new FormData(this);
        formData.append('location',locations);
        formData.append('department',department);
        formData.append('designation',designation);
        $.ajax({
            url: urls.update,
            method: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#editModal').hide();
                    $('#EditForm')[0].reset();
                    $('#search').val('');
                    $('.load-data').load(location.href + ' .load-data');
                    toastr.success('Organization Details Updated Successfully', 'Updated!');
                }
            },
            error: function (err) {
                let error = err.responseJSON;
                $.each(error.errors, function (key, value) {
                    $('#update_' + key + "_error").text(value);
                })
            }
        });
    });



    DeleteAjax('Employee Organization Details Deleted', 'Deleted!');

    PaginationAjax({  });

    SearchAjax({  });

    SearchPaginationAjax({  });
});