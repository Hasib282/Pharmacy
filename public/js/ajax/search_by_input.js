//Get Payroll By User Id
function getPayrollByUserId(id, grid) {
    let tableRows = '';
    $.ajax({
        url: `${apiUrl}/hr/payroll/get`,
        method: 'GET',
        data: { id },
        success: function (res) {
            if(res.status){
                $.each(res.data, function(key, item) {
                    tableRows += `
                    <tr>
                        <td>${key+1}</td>
                        <td>${item.head.tran_head_name}</td>
                        <td>${item.amount}</td>
                        ${
                            item.date ? `
                            <td>${String(new Date(item.date).getMonth() + 1).padStart(2, '0')}</td>
                            <td>${new Date(item.date).getFullYear()}</td>`
                            :
                            `<td></td>
                            <td></td>`
                        }
                    </tr>`
                });

                $(grid).html(tableRows);
            }
        }
    });
}

$(document).ready(function () {
    /////////////// ------------------ Search Company by name and add value to input ajax part start ---------------- /////////////////////////////
    //Company Keyup Event
    $(document).off('keyup', '#company').on('keyup', '#company', function (e) {
        let company = $(this).val();
        let id = $(this).attr('data-id');
        CompanyKeyUp(e, company, id, '#company', '#designation', '#company-list ul');
    });

    // Company Key down Event
    $(document).off('keydown', '#company').on('keydown', '#company', function (e) {
        let list = $('#company-list ul li');
        CompanyKeyDown(e, list, '#company', '#company-list ul');
    });


    // Company List Key down Event
    $(document).off('keydown', '#company-list ul li').on('keydown', '#company-list ul li', function (e) {
        let list = $('#company-list ul li');
        let focused = $('#company-list ul li:focus');
        CompanyListKeyDown(e, list, focused, '#company', '#company-list ul');
    });


    // Company Focus Event
    $(document).off('focus', '#company').on('focus', '#company', function (e) {
        let company = $(this).val();
        let id = $(this).attr('data-id');
        if(id == undefined){
            getCompanyByName(company, '#company-list ul');
        }
        else{
            e.preventDefault();
        }
    });


    // Company Focous out event
    $(document).off('focusout', '#company').on('focusout', '#company', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#company-list ul').html('');
                }
            });
        }
    });


    // Company List Click Event
    $(document).off('click', '#company-list li').on('click', '#company-list li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#company').val(value);
        $('#company').attr('data-id', id);
        $('#company-list ul').html('');
    });



    // Update Company Keyup event
    $(document).off('keyup', '#updateCompany').on('keyup', '#updateCompany', function (e) {
        let company = $(this).val();
        let id = $(this).attr('data-id');
        CompanyKeyUp(e, company, id, '#updateCompany', '#updateDesignation', '#update-company ul');
    });



    // Update Company Keydown event
    $(document).off('keydown', '#updateCompany').on('keydown', '#updateCompany', function (e) {
        let list = $('#update-company ul li');
        CompanyKeyDown(e, list, '#updateCompany', '#update-company ul');
    });



    // Update Company List Keydown event
    $(document).off('keydown', '#update-company ul li').on('keydown', '#update-company ul li', function (e) {
        let list = $('#update-company ul li');
        let focused = $('#update-company ul li:focus');
        CompanyListKeyDown(e, list, focused, '#updateCompany', '#update-company ul');
    });



    // Update Company Focus Event
    $(document).off('focus', '#updateCompany').on('focus', '#updateCompany', function (e) {
        let company = $(this).val();
        let id = $(this).attr('data-id');
        if(id == undefined){
            getCompanyByName(company, '#update-company ul');
        }
        else{
            e.preventDefault();
        }
    });


    
    // Update Company Focousout event
    $(document).off('focusout', '#updateCompany').on('focusout', '#updateCompany', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#update-company ul').html('');
                }
            });
        }
    });


    // Update Company Click Event
    $(document).off('click', '#update-company li').on('click', '#update-company li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#updateCompany').val(value);
        $('#updateCompany').attr('data-id', id);
        $('#update-company ul').html('');
    });



    // Company Key Up Event Function
    function CompanyKeyUp(e, company, id, targetElement1, targetElement2, targetElement3){
        if (e.keyCode === 13) { // Enter Key
            e.preventDefault();
        }
        else if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 8){
            //keyCode 65 = a, keyCode 90 = z, keyCode 96 = 0, keyCode 105 = 9, keyCode 8 = backSpace
            $(targetElement1).removeAttr('data-id');
            $(targetElement2).removeAttr('data-id');
            $(targetElement2).val('');
            getCompanyByName(company, targetElement3);
        }
        else if (e.keyCode === 9) { // Tab key
            if (id != undefined) {
                e.preventDefault();
            }
            else{
                $(targetElement1).removeAttr('data-id');
                $(targetElement2).removeAttr('data-id');
                $(targetElement2).val('');
                getCompanyByName(company, targetElement3);
            }
        }
    }


    // Company Key Down Event Function
    function CompanyKeyDown(e, list, targetElement1, targetElement2) {
        if (list.length > 0) {
            if (e.keyCode === 40) { // Down arrow key
                e.preventDefault();
                list.first().focus();
                $(targetElement1).val(list.first().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 38) { // Up arrow key
                e.preventDefault();
                list.last().focus();
                $(targetElement1).val(list.last().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 13) { // Enter key
                e.preventDefault();
            } 
            else if (e.keyCode === 9) { // Tab key
                $(targetElement2).html('');
            }
        }
    }


    // Company List Key Down Event function
    function CompanyListKeyDown(e, list, focused, targetElement1, targetElement2) {
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            let nextIndex = focused.index() + 1;
            if (nextIndex >= list.length) {
                nextIndex = 0; // Loop to the first item
            }
            list.eq(nextIndex).focus();
            $(targetElement1).val(list.eq(nextIndex).text());
            $(targetElement1).attr("data-id", list.eq(nextIndex).data('id'));
        } 
        else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            let prevIndex = focused.index() - 1;
            if (prevIndex < 0) {
                prevIndex = list.length - 1; // Loop to the last item
            }
            list.eq(prevIndex).focus();
            $(targetElement1).val(list.eq(prevIndex).text());
            $(targetElement1).attr("data-id", list.eq(prevIndex).data('id'));
        } 
        else if (e.keyCode === 13) { // Enter key
            e.preventDefault();
            $(targetElement2).html('');
            $(targetElement1).focus();
        }
    }

    // Search Company by Name
    function getCompanyByName(company, targetElement1) {
        $.ajax({
            url: `${apiUrl}/admin/companies/get`,
            method: 'GET',
            data: { company },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }

    /////////////// ------------------ Search Department by name and add value to input ajax part end ---------------- /////////////////////////////



    /////////////// ------------------ Search Department by name and add value to input ajax part start ---------------- /////////////////////////////
    //Department Keyup Event
    $(document).off('keyup', '#department').on('keyup', '#department', function (e) {
        let department = $(this).val();
        let id = $(this).attr('data-id');
        DepartmentKeyUp(e, department, id, '#department', '#designation', '#department-list ul');
    });

    // Department Key down Event
    $(document).off('keydown', '#department').on('keydown', '#department', function (e) {
        let list = $('#department-list ul li');
        DepartmentKeyDown(e, list, '#department', '#department-list ul');
    });


    // Department List Key down Event
    $(document).off('keydown', '#department-list ul li').on('keydown', '#department-list ul li', function (e) {
        let list = $('#department-list ul li');
        let focused = $('#department-list ul li:focus');
        DepartmentListKeyDown(e, list, focused, '#department', '#department-list ul');
    });


    // Department Focus Event
    $(document).off('focus', '#department').on('focus', '#department', function (e) {
        let department = $(this).val();
        let id = $(this).attr('data-id');
        if(id == undefined){
            getDepartmentByName(department, '#department-list ul');
        }
        else{
            e.preventDefault();
        }
    });


    // Department Focous out event
    $(document).off('focusout', '#department').on('focusout', '#department', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#department-list ul').html('');
                }
            });
        }
    });


    // Department List Click Event
    $(document).off('click', '#department-list li').on('click', '#department-list li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#department').val(value);
        $('#department').attr('data-id', id);
        $('#department-list ul').html('');
    });



    // Update Department Keyup event
    $(document).off('keyup', '#updateDepartment').on('keyup', '#updateDepartment', function (e) {
        let department = $(this).val();
        let id = $(this).attr('data-id');
        DepartmentKeyUp(e, department, id, '#updateDepartment', '#updateDesignation', '#update-department ul');
    });



    // Update Department Keydown event
    $(document).off('keydown', '#updateDepartment').on('keydown', '#updateDepartment', function (e) {
        let list = $('#update-department ul li');
        DepartmentKeyDown(e, list, '#updateDepartment', '#update-department ul');
    });



    // Update Department List Keydown event
    $(document).off('keydown', '#update-department ul li').on('keydown', '#update-department ul li', function (e) {
        let list = $('#update-department ul li');
        let focused = $('#update-department ul li:focus');
        DepartmentListKeyDown(e, list, focused, '#updateDepartment', '#update-department ul');
    });



    // Update Department Focus Event
    $(document).off('focus', '#updateDepartment').on('focus', '#updateDepartment', function (e) {
        let department = $(this).val();
        let id = $(this).attr('data-id');
        if(id == undefined){
            getDepartmentByName(department, '#update-department ul');
        }
        else{
            e.preventDefault();
        }
    });


    
    // Update Department Focousout event
    $(document).off('focusout', '#updateDepartment').on('focusout', '#updateDepartment', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#update-department ul').html('');
                }
            });
        }
    });


    // Update Department Click Event
    $(document).off('click', '#update-department li').on('click', '#update-department li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#updateDepartment').val(value);
        $('#updateDepartment').attr('data-id', id);
        $('#update-department ul').html('');
    });



    // Department Key Up Event Function
    function DepartmentKeyUp(e, department, id, targetElement1, targetElement2, targetElement3){
        if (e.keyCode === 13) { // Enter Key
            e.preventDefault();
        }
        else if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 8){
            //keyCode 65 = a, keyCode 90 = z, keyCode 96 = 0, keyCode 105 = 9, keyCode 8 = backSpace
            $(targetElement1).removeAttr('data-id');
            $(targetElement2).removeAttr('data-id');
            $(targetElement2).val('');
            getDepartmentByName(department, targetElement3);
        }
        else if (e.keyCode === 9) { // Tab key
            if (id != undefined) {
                e.preventDefault();
            }
            else{
                $(targetElement1).removeAttr('data-id');
                $(targetElement2).removeAttr('data-id');
                $(targetElement2).val('');
                getDepartmentByName(department, targetElement3);
            }
        }
    }


    // Department Key Down Event Function
    function DepartmentKeyDown(e, list, targetElement1, targetElement2) {
        if (list.length > 0) {
            if (e.keyCode === 40) { // Down arrow key
                e.preventDefault();
                list.first().focus();
                $(targetElement1).val(list.first().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 38) { // Up arrow key
                e.preventDefault();
                list.last().focus();
                $(targetElement1).val(list.last().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 13) { // Enter key
                e.preventDefault();
            } 
            else if (e.keyCode === 9) { // Tab key
                $(targetElement2).html('');
            }
        }
    }


    // Department List Key Down Event function
    function DepartmentListKeyDown(e, list, focused, targetElement1, targetElement2) {
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            let nextIndex = focused.index() + 1;
            if (nextIndex >= list.length) {
                nextIndex = 0; // Loop to the first item
            }
            list.eq(nextIndex).focus();
            $(targetElement1).val(list.eq(nextIndex).text());
            $(targetElement1).attr("data-id", list.eq(nextIndex).data('id'));
        } 
        else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            let prevIndex = focused.index() - 1;
            if (prevIndex < 0) {
                prevIndex = list.length - 1; // Loop to the last item
            }
            list.eq(prevIndex).focus();
            $(targetElement1).val(list.eq(prevIndex).text());
            $(targetElement1).attr("data-id", list.eq(prevIndex).data('id'));
        } 
        else if (e.keyCode === 13) { // Enter key
            e.preventDefault();
            $(targetElement2).html('');
            $(targetElement1).focus();
        }
    }

    // Search Department by Name
    function getDepartmentByName(department, targetElement1) {
        $.ajax({
            url: `${apiUrl}/hr/setup/department/get`,
            method: 'GET',
            data: { department:department },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }

    /////////////// ------------------ Search Department by name and add value to input ajax part end ---------------- /////////////////////////////




    /////////////// ------------------ Search Designation by name and Department and add value to input ajax part start ---------------- /////////////////////////////
    // Designation Keyup event
    $(document).off('keyup', '#designation').on('keyup', '#designation', function (e) {
        let department = $('#department').attr('data-id');
        let designation = $(this).val();
        let id = $(this).attr('data-id');
        DesignationKeyUp(e, department, designation, id, '#designation', '#designation-list ul');
    });


    // Designation Key Down Event
    $(document).off('keydown', '#designation').on('keydown', '#designation', function (e) {
        let list = $('#designation-list ul li');
        DesignationKeyDown(e, list, '#designation', '#designation-list ul');
    });


    // Designation List key Down Event
    $(document).off('keydown', '#designation-list ul li').on('keydown', '#designation-list ul li', function (e) {
        let list = $('#designation-list ul li');
        let focused = $('#designation-list ul li:focus');
        DesignationListKeyDown(e, list, focused, '#designation', '#designation-list ul');
    });


    // Designation Focus Event
    $(document).off('focus', '#designation').on('focus', '#designation', function (e) {
        let designation = $(this).val();
        let department = $('#department').attr('data-id');
        let id = $(this).attr('data-id');
        if(id == undefined){
            getDesignationByNameAndDepartment(designation, '#designation-list ul', department);
        }
        else{
            e.preventDefault();
        }
    });


    // Designation Focousout event
    $(document).off('focusout', '#designation').on('focusout', '#designation', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#designation-list ul').html('');
                }
            });
        }
    });


    // Designation List Click event
    $(document).off('click', '#designation-list li').on('click', '#designation-list li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#designation').val(value);
        $('#designation').attr('data-id', id);
        $('#designation-list ul').html('');
    });

    // Update Designation Keyup Event
    $(document).off('keyup', '#updateDesignation').on('keyup', '#updateDesignation', function (e) {
        let department = $('#updateDepartment').attr('data-id');
        let designation = $(this).val();
        let id = $(this).attr('data-id');
        DesignationKeyUp(e, department, designation, id, '#updateDesignation', '#update-designation ul');
    });


    // Update Designation Keydown Event
    $(document).off('keydown', '#updateDesignation').on('keydown', '#updateDesignation', function (e) {
        let list = $('#update-designation ul li');
        DesignationKeyDown(e, list, '#updateDesignation', '#update-designation ul');
    });


    // Update Designation List keydown Event
    $(document).off('keydown', '#update-designation ul li').on('keydown', '#update-designation ul li', function (e) {
        let list = $('#update-designation ul li');
        let focused = $('#update-designation ul li:focus');
        DesignationListKeyDown(e, list, focused, '#updateDesignation', '#update-designation ul');
    });


    // Update Designation List Click Event
    $(document).off('click', '#update-designation li').on('click', '#update-designation li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#updateDesignation').val(value);
        $('#updateDesignation').attr('data-id', id);
        $('#update-designation ul').html('');
    });


    // Update Designation Focus Event
    $(document).off('focus', '#updateDesignation').on('focus', '#updateDesignation', function (e) {
        let designation = $(this).val();
        let department = $('#updateDepartment').attr('data-id');
        let id = $(this).attr('data-id');
        if(id == undefined){
            getDesignationByNameAndDepartment(designation, '#update-designation ul', department);
        }
        else{
            e.preventDefault();
        }
    });


    // Update Designation Focous out event
    $(document).off('focusout', '#updateDesignation').on('focusout', '#updateDesignation', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#update-designation ul').html('');
                }
            });
        }
    });



    // Designation Keyup Event Function
    function DesignationKeyUp(e, department, designation, id, targetElement1, targetElement2){
        if (e.keyCode === 13) { // Enter Key
            e.preventDefault();
        }
        else if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 8){
            //keyCode 65 = a, keyCode 90 = z, keyCode 96 = 0, keyCode 105 = 9, keyCode 8 = backSpace
            $(targetElement1).removeAttr('data-id');
            getDesignationByNameAndDepartment(designation, targetElement2, department);
        }
        else if (e.keyCode === 9) { // Tab key
            if (id != undefined) {
                e.preventDefault();
            }
            else{
                $(targetElement1).removeAttr('data-id');
                getDesignationByNameAndDepartment(designation, targetElement2, department);
            }
        }
    }


    // Designation Keydown Event Function
    function DesignationKeyDown(e, list, targetElement1, targetElement2) {
        if (list.length > 0) {
            if (e.keyCode === 40) { // Down arrow key
                e.preventDefault();
                list.first().focus();
                $(targetElement1).val(list.first().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } else if (e.keyCode === 38) { // Up arrow key
                e.preventDefault();
                list.last().focus();
                $(targetElement1).val(list.last().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } else if (e.keyCode === 13) { // Enter key
                e.preventDefault();
            } 
            else if (e.keyCode === 9) { // Tab key
                $(targetElement2).html('');
            }
        }
    }
    

    // Department List Keydown Event function
    function DesignationListKeyDown(e, list, focused, targetElement1, targetElement2) {
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            let nextIndex = focused.index() + 1;
            if (nextIndex >= list.length) {
                nextIndex = 0; // Loop to the first item
            }
            list.eq(nextIndex).focus();
            $(targetElement1).val(list.eq(nextIndex).text());
            $(targetElement1).attr("data-id", list.eq(nextIndex).data('id'));
        } 
        else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            let prevIndex = focused.index() - 1;
            if (prevIndex < 0) {
                prevIndex = list.length - 1; // Loop to the last item
            }
            list.eq(prevIndex).focus();
            $(targetElement1).val(list.eq(prevIndex).text());
            $(targetElement1).attr("data-id", list.eq(prevIndex).data('id'));
        } 
        else if (e.keyCode === 13) { // Enter key
            e.preventDefault();
            $(targetElement2).html('');
            $(targetElement1).focus();
        }
    }


    // Search Designation by Name and Department
    function getDesignationByNameAndDepartment(designation, targetElement1, department = "") {
        $.ajax({
            url: `${apiUrl}/hr/setup/designation/get`,
            method: 'GET',
            data: { designation, department },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }

    /////////////// ------------------ Search Designation by name and Department and add value to input ajax part end ---------------- /////////////////////////////



    /////////////// ------------------ Search Location by Upazila and add value to input ajax part start ---------------- /////////////////////////////
    // Location Keyup Event
    $(document).off('keyup', '#location').on('keyup', '#location', function (e) {
        let location = $(this).val();
        let division = $('#division').val();
        let id = $(this).attr('data-id');
        if ($('#division').length) {
            LocationKeyUp(e, location, id, '#location', '#location-list ul', division);
        } else {
            LocationKeyUp(e, location, id, '#location', '#location-list ul');
        }
    });


    // Location Keydown Event
    $(document).off('keydown', '#location').on('keydown', '#location', function (e) {
        let list = $('#location-list ul li');
        LocationKeyDown(e, list, '#location', '#location-list ul');
    });


    // Location List keydown Event
    $(document).off('keydown', '#location-list ul li').on('keydown', '#location-list ul li', function (e) {
        let list = $('#location-list ul li');
        let focused = $('#location-list ul li:focus');
        LocationListKeyDown(e, list, focused, '#location', '#location-list ul');
    });


    // Location List Click Event
    $(document).off('click', '#location-list li').on('click', '#location-list li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#location').val(value);
        $('#location').attr('data-id', id);
        $('#location-list ul').html('');
    });


    // Location Focus Event
    $(document).off('focus', '#location').on('focus', '#location', function (e) {
        let location = $(this).val();
        let division = $('#division').val();
        let id = $(this).attr('data-id');
        if(id == undefined){
            if ($('#division').length) {
                getLocationByDivision(location, division, '#location-list ul');
            } else {
                getLocationByUpazila(location, '#location-list ul');
            }
        }
        else{
            e.preventDefault();
        }
    });


    // Locaation Focousout event
    $(document).off('focusout', '#location').on('focusout', '#location', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#location-list ul').html('');
                }
            });
        }
    });

    // Update Location Keyup Event
    $(document).off('keyup', '#updateLocation').on('keyup', '#updateLocation', function (e) {
        let location = $(this).val();
        let division = $('#updateDivision').val();
        let id = $(this).attr('data-id');
        if ($('#updateDivision').length) {
            LocationKeyUp(e, location, id, '#updateLocation', '#update-location ul', division);
        } else {
            LocationKeyUp(e, location, id, '#updateLocation', '#update-location ul');
        }
    });


    // Update Location Keydown Event
    $(document).off('keydown', '#updateLocation').on('keydown', '#updateLocation', function (e) {
        let list = $('#update-location ul li');
        LocationKeyDown(e, list, '#updateLocation', '#update-location ul');
    });


    // Update Location List Keydown Event
    $(document).on('keydown', '#update-location ul li', function (e) {
        let list = $('#update-location ul li');
        let focused = $('#update-location ul li:focus');
        LocationListKeyDown(e, list, focused, '#updateLocation', '#update-location ul');
    });


    // Update Location List Click Event
    $(document).off('click', '#update-location li').on('click', '#update-location li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#updateLocation').val(value);
        $('#updateLocation').attr('data-id', id);
        $('#update-location ul').html('');
    });



    // Update Location Focus Event
    $(document).off('focus', '#updateLocation').on('focus', '#updateLocation', function (e) {
        let location = $(this).val();
        let division = $('#updateDivision').val();
        let id = $(this).attr('data-id');
        if(id == undefined){
            if ($('#updateDivision').length) {
                getLocationByDivision(location, division, '#update-location ul');
            } else {
                getLocationByUpazila(location, '#update-location ul');
            }
        }
        else{
            e.preventDefault();
        }
    });



    // Update Locaation Focousout Event
    $(document).off('focusout', '#updateLocation').on('focusout', '#updateLocation', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#update-location ul').html('');
                }
            });
        }
    });


    // Location Keyup Event Function
    function LocationKeyUp(e, location, id, targetElement1, targetElement2, division){
        if (e.keyCode === 13) { // Enter Key
            e.preventDefault();
        }
        else if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 8){
            //keyCode 65 = a, keyCode 90 = z, keyCode 96 = 0, keyCode 105 = 9, keyCode 8 = backSpace
            $(targetElement1).removeAttr('data-id');
            if ($('#division').length) {
                getLocationByDivision(location, division, targetElement2);
            } else {
                getLocationByUpazila(location, targetElement2);
            }
        }
        else if (e.keyCode === 9) { // Tab key
            if (id != undefined) {
                e.preventDefault();
            }
            else{
                $(targetElement1).removeAttr('data-id');
                if ($('#division').length) {
                    getLocationByDivision(location, division, targetElement2);
                } else {
                    getLocationByUpazila(location, targetElement2);
                }
            }
        }
    }


    // Location Keydown Event Function
    function LocationKeyDown(e, list, targetElement1, targetElement2) {
        if (list.length > 0) {
            if (e.keyCode === 40) { // Down arrow key
                e.preventDefault();
                list.first().focus();
                $(targetElement1).val(list.first().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 38) { // Up arrow key
                e.preventDefault();
                list.last().focus();
                $(targetElement1).val(list.last().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 13) { // Enter key
                e.preventDefault();
            } 
            else if (e.keyCode === 9) { // Tab key
                $(targetElement2).html('');
            }
        }
    }
    

    // Location List Keydown Event function
    function LocationListKeyDown(e, list, focused, targetElement1, targetElement2) {
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            let nextIndex = focused.index() + 1;
            if (nextIndex >= list.length) {
                nextIndex = 0; // Loop to the first item
            }
            list.eq(nextIndex).focus();
            $(targetElement1).val(list.eq(nextIndex).text());
            $(targetElement1).attr("data-id", list.eq(nextIndex).data('id'));
        } 
        else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            let prevIndex = focused.index() - 1;
            if (prevIndex < 0) {
                prevIndex = list.length - 1; // Loop to the last item
            }
            list.eq(prevIndex).focus();
            $(targetElement1).val(list.eq(prevIndex).text());
            $(targetElement1).attr("data-id", list.eq(prevIndex).data('id'));
        } 
        else if (e.keyCode === 13) { // Enter key
            e.preventDefault();
            $(targetElement2).html('');
            $(targetElement1).focus();
        }
    }

    // Get Location by Upazila
    function getLocationByUpazila(location, targetElement1) {
        $.ajax({
            url: `${apiUrl}/admin/locations/get`,
            method: 'GET',
            data: { location },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }



    // Get Location by Division
    function getLocationByDivision(location, division, targetElement1) {
        $.ajax({
            url: `${apiUrl}/admin/locations/get/division`,
            method: 'GET',
            data: { location, division },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }

    /////////////// ------------------ Search Location by Upazila and add value to input ajax part end ---------------- /////////////////////////////



    /////////////// ------------------ Search Bank by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Bank Keyup Event
    $(document).off('keyup', '#bank').on('keyup', '#bank', function (e) {
        let bank = $(this).val();
        let id = $(this).attr('data-id');
        BankKeyUp(e, bank, id, '#bank', '#bank-list ul');
    });


    // Bank Keydown Event
    $(document).off('keydown', '#bank').on('keydown', '#bank', function (e) {
        let list = $('#bank-list ul li');
        BankKeyDown(e, list, '#bank', '#bank-list ul');
    });


    // Bank List keydown Event
    $(document).off('keydown', '#bank-list ul li').on('keydown', '#bank-list ul li', function (e) {
        let list = $('#bank-list ul li');
        let focused = $('#bank-list ul li:focus');
        BankListKeyDown(e, list, focused, '#bank', '#bank-list ul');
    });


    // Bank List Click Event
    $(document).off('click', '#bank-list li').on('click', '#bank-list li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#bank').val(value);
        $('#bank').attr('data-id', id);
        $('#bank-list ul').html('');
    });


    // Bank Focus Event
    $(document).off('focus', '#bank').on('focus', '#bank', function (e) {
        let bank = $(this).val();
        let id = $(this).attr('data-id');
        if(id == undefined){
            getBankByName(bank, '#bank-list ul');
        }
        else{
            e.preventDefault();
        }
    });


    // Locaation Focousout event
    $(document).off('focusout', '#bank').on('focusout', '#bank', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#bank-list ul').html('');
                }
            });
        }
    });

    // Update Bank Keyup Event
    $(document).off('keyup', '#updateBank').on('keyup', '#updateBank', function (e) {
        let bank = $(this).val();
        let id = $(this).attr('data-id');
        BankKeyUp(e, bank, id, '#updateBank', '#update-bank ul');
    });


    // Update Bank Keydown Event
    $(document).off('keydown', '#updateBank').on('keydown', '#updateBank', function (e) {
        let list = $('#update-bank ul li');
        BankKeyDown(e, list, '#updateBank', '#update-bank ul');
    });


    // Update Bank List Keydown Event
    $(document).on('keydown', '#update-bank ul li', function (e) {
        let list = $('#update-bank ul li');
        let focused = $('#update-bank ul li:focus');
        BankListKeyDown(e, list, focused, '#updateBank', '#update-bank ul');
    });


    // Update Bank List Click Event
    $(document).off('click', '#update-bank li').on('click', '#update-bank li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#updateBank').val(value);
        $('#updateBank').attr('data-id', id);
        $('#update-bank ul').html('');
    });



    // Update Bank Focus Event
    $(document).off('focus', '#updateBank').on('focus', '#updateBank', function (e) {
        let bank = $(this).val();
        let id = $(this).attr('data-id');
        if(id == undefined){
            getBankByName(bank, '#update-bank ul');
        }
        else{
            e.preventDefault();
        }
    });



    // Update Locaation Focousout Event
    $(document).off('focusout', '#updateBank').on('focusout', '#updateBank', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#update-bank ul').html('');
                }
            });
        }
    });


    // Bank Keyup Event Function
    function BankKeyUp(e, bank, id, targetElement1, targetElement2){
        if (e.keyCode === 13) { // Enter Key
            e.preventDefault();
        }
        else if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 8){
            //keyCode 65 = a, keyCode 90 = z, keyCode 96 = 0, keyCode 105 = 9, keyCode 8 = backSpace
            $(targetElement1).removeAttr('data-id');
            getBankByName(bank, targetElement2);
        }
        else if (e.keyCode === 9) { // Tab key
            if (id != undefined) {
                e.preventDefault();
            }
            else{
                $(targetElement1).removeAttr('data-id');
                getBankByName(bank, targetElement2);
            }
        }
    }


    // Bank Keydown Event Function
    function BankKeyDown(e, list, targetElement1, targetElement2) {
        if (list.length > 0) {
            if (e.keyCode === 40) { // Down arrow key
                e.preventDefault();
                list.first().focus();
                $(targetElement1).val(list.first().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 38) { // Up arrow key
                e.preventDefault();
                list.last().focus();
                $(targetElement1).val(list.last().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 13) { // Enter key
                e.preventDefault();
            } 
            else if (e.keyCode === 9) { // Tab key
                $(targetElement2).html('');
            }
        }
    }
    

    // Bank List Keydown Event function
    function BankListKeyDown(e, list, focused, targetElement1, targetElement2) {
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            let nextIndex = focused.index() + 1;
            if (nextIndex >= list.length) {
                nextIndex = 0; // Loop to the first item
            }
            list.eq(nextIndex).focus();
            $(targetElement1).val(list.eq(nextIndex).text());
            $(targetElement1).attr("data-id", list.eq(nextIndex).data('id'));
        } 
        else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            let prevIndex = focused.index() - 1;
            if (prevIndex < 0) {
                prevIndex = list.length - 1; // Loop to the last item
            }
            list.eq(prevIndex).focus();
            $(targetElement1).val(list.eq(prevIndex).text());
            $(targetElement1).attr("data-id", list.eq(prevIndex).data('id'));
        } 
        else if (e.keyCode === 13) { // Enter key
            e.preventDefault();
            $(targetElement2).html('');
            $(targetElement1).focus();
        }
    }

    // Search Bank by Upazila
    function getBankByName(bank, targetElement1) {
        $.ajax({
            url: `${apiUrl}/admin/banks/get`,
            method: 'GET',
            data: { bank },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }

    /////////////// ------------------ Search Bank by Name and add value to input ajax part end ---------------- /////////////////////////////

    


    
    /////////////// ------------------ Search Store by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Store Keyup Event
    $(document).off('keyup', '#store').on('keyup', '#store', function (e) {
        let store = $(this).val();
        let id = $(this).attr('data-id');
        StoreKeyUp(e, store, id, '#store', '#store-list ul');
    });


    // Store Keydown Event
    $(document).off('keydown', '#store').on('keydown', '#store', function (e) {
        let list = $('#store-list ul li');
        StoreKeyDown(e, list, '#store', '#store-list ul');
    });


    // Store List keydown Event
    $(document).off('keydown', '#store-list ul li').on('keydown', '#store-list ul li', function (e) {
        let list = $('#store-list ul li');
        let focused = $('#store-list ul li:focus');
        StoreListKeyDown(e, list, focused, '#store', '#store-list ul');
    });


    // Store List Click Event
    $(document).off('click', '#store-list li').on('click', '#store-list li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#store').val(value);
        $('#store').attr('data-id', id);
        $('#store-list ul').html('');
    });


    // Store Focus Event
    $(document).off('focus', '#store').on('focus', '#store', function (e) {
        let store = $(this).val();
        let id = $(this).attr('data-id');
        if(id == undefined){
            getStoreByName(store, '#store-list ul');
        }
        else{
            e.preventDefault();
        }
    });


    // Locaation Focousout event
    $(document).off('focusout', '#store').on('focusout', '#store', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#store-list ul').html('');
                }
            });
        }
    });

    // Update Store Keyup Event
    $(document).off('keyup', '#updateStore').on('keyup', '#updateStore', function (e) {
        let store = $(this).val();
        let id = $(this).attr('data-id');
        StoreKeyUp(e, store, id, '#updateStore', '#update-store ul');
    });


    // Update Store Keydown Event
    $(document).off('keydown', '#updateStore').on('keydown', '#updateStore', function (e) {
        let list = $('#update-store ul li');
        StoreKeyDown(e, list, '#updateStore', '#update-store ul');
    });


    // Update Store List Keydown Event
    $(document).off('keydown', '#update-store ul li').on('keydown', '#update-store ul li', function (e) {
        let list = $('#update-store ul li');
        let focused = $('#update-store ul li:focus');
        StoreListKeyDown(e, list, focused, '#updateStore', '#update-store ul');
    });


    // Update Store List Click Event
    $(document).off('click', '#update-store li').on('click', '#update-store li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#updateStore').val(value);
        $('#updateStore').attr('data-id', id);
        $('#update-store ul').html('');
    });



    // Update Store Focus Event
    $(document).off('focus', '#updateStore').on('focus', '#updateStore', function (e) {
        let store = $(this).val();
        let id = $(this).attr('data-id');
        if(id == undefined){
            getStoreByName(store, '#update-store ul');
        }
        else{
            e.preventDefault();
        }
    });



    // Update Locaation Focousout Event
    $(document).off('focusout', '#updateStore').on('focusout', '#updateStore', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#update-store ul').html('');
                }
            });
        }
    });


    // Store Keyup Event Function
    function StoreKeyUp(e, store, id, targetElement1, targetElement2){
        if (e.keyCode === 13) { // Enter Key
            e.preventDefault();
        }
        else if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 8){
            //keyCode 65 = a, keyCode 90 = z, keyCode 96 = 0, keyCode 105 = 9, keyCode 8 = backSpace
            $(targetElement1).removeAttr('data-id');
            getStoreByName(store, targetElement2);
        }
        else if (e.keyCode === 9) { // Tab key
            if (id != undefined) {
                e.preventDefault();
            }
            else{
                $(targetElement1).removeAttr('data-id');
                getStoreByName(store, targetElement2);
            }
        }
    }


    // Store Keydown Event Function
    function StoreKeyDown(e, list, targetElement1, targetElement2) {
        if (list.length > 0) {
            if (e.keyCode === 40) { // Down arrow key
                e.preventDefault();
                list.first().focus();
                $(targetElement1).val(list.first().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 38) { // Up arrow key
                e.preventDefault();
                list.last().focus();
                $(targetElement1).val(list.last().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 13) { // Enter key
                e.preventDefault();
            } 
            else if (e.keyCode === 9) { // Tab key
                $(targetElement2).html('');
            }
        }
    }
    

    // Store List Keydown Event function
    function StoreListKeyDown(e, list, focused, targetElement1, targetElement2) {
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            let nextIndex = focused.index() + 1;
            if (nextIndex >= list.length) {
                nextIndex = 0; // Loop to the first item
            }
            list.eq(nextIndex).focus();
            $(targetElement1).val(list.eq(nextIndex).text());
            $(targetElement1).attr("data-id", list.eq(nextIndex).data('id'));
        } 
        else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            let prevIndex = focused.index() - 1;
            if (prevIndex < 0) {
                prevIndex = list.length - 1; // Loop to the last item
            }
            list.eq(prevIndex).focus();
            $(targetElement1).val(list.eq(prevIndex).text());
            $(targetElement1).attr("data-id", list.eq(prevIndex).data('id'));
        } 
        else if (e.keyCode === 13) { // Enter key
            e.preventDefault();
            $(targetElement2).html('');
            $(targetElement1).focus();
        }
    }

    // Search Store by Name
    function getStoreByName(store, targetElement1) {
        $.ajax({
            url: `${apiUrl}/admin/stores/get`,
            method: 'GET',
            data: { store },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }

    /////////////// ------------------ Search Store by Name and add value to input ajax part end ---------------- /////////////////////////////




    ////////////// ------------------- Search Transaction User and add value to input ajax part start --------------- ////////////////////////////
    //search Transaction User on add modal
    $(document).off('keyup', '#user').on('keyup', '#user', function (e) {
        let tranUser = $(this).val();
        let tranUserType;
        let within;
        if ($('#within').length) {
            tranUserType = $('.with-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            within = 1;
        } else {
            tranUserType = $('#with').val();
            within = 0;
        }
        let id = $(this).attr('data-id');
        UserKeyUp(e, tranUserType, within, tranUser, id, '#user', '#user-list ul', '#name', "#phone", "#address");
        $('.due-grid tbody, .due-grid tfoot').html('');
    });



    // User Key Down Event
    $(document).off('keydown', '#user').on('keydown', '#user', function (e) {
        let list = $('#user-list ul li');
        UserKeyDown(e, list, '#user', '#user-list ul', '#name', "#phone", "#address");
    });



    // User List key Down Event
    $(document).off('keydown', '#user-list ul li').on('keydown', '#user-list ul li', function (e) {
        let list = $('#user-list ul li');
        let focused = $('#user-list ul li:focus');
        UserListKeyDown(e, list, focused, '#user', '#user-list ul', '#name', "#phone", "#address");
    });



    //add list value in Transaction User input of add modal
    $(document).off('click', '#user-list li').on('click', '#user-list li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        let withs = $(this).data('with');
        let name = $(this).data('name');
        let phone = $(this).data('phone');
        let address = $(this).data('address');
        $('#user').val(value);
        $('#user').attr('data-id', id);
        $('#user').attr('data-with', withs);
        $('#name').val(name);
        $('#phone').val(phone);
        $('#address').val(address);
        $('#user-list ul').html('');
        getDueListByUserId(id, '.due-grid tbody');
        getPayrollByUserId(id, '.payroll-grid tbody');
        // getPayrollSetupByUserId(id, '.setup tbody');
        // getPayrollMiddlewireByUserId(id, '.middlewire tbody');
    });



    // User Focus Event
    $(document).off('focus', '#user').on('focus', '#user', function (e) {
        let tranUser = $(this).val();
        let tranUserType;
        let within;
        if ($('#within').length) {
            tranUserType = $('.with-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            within = 1;
        } else {
            tranUserType = $('#with').val();
            within = 0;
        }
        let id = $(this).attr('data-id');
        if(id == undefined){
            getTransactionUser(tranUserType, within, tranUser, '#user-list ul');
        }
        else{
            e.preventDefault();
        }
    });


    // User Focousout event
    $(document).off('focusout', '#user').on('focusout', '#user', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#user-list ul').html('');
                }
            });
        }
    });



    //search Transaction User on edit modal
    $(document).off('keyup', '#updateUser').on('keyup', '#updateUser', function (e) {
        let tranUser = $(this).val();
        let tranUserType;
        let within;
        if ($('#within').length) {
            tranUserType = $('.with-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            within = 1;
        } else {
            tranUserType = $('#updateWith').val();
            within = 0;
        }
        let id = $(this).attr('data-id');
        UserKeyUp(e, tranUserType, within, tranUser, id, '#updateUser', '#update-user ul', '#updateName', "#updatePhone", "#updateAddress");
    });



    // Update User Key Down Event
    $(document).off('keydown', '#updateUser').on('keydown', '#updateUser', function (e) {
        let list = $('#update-user ul li');
        UserKeyDown(e, list, '#updateUser', '#update-user ul', '#updateName', "#updatePhone", "#updateAddress");
    });



    // Update User List key Down Event
    $(document).off('keydown', '#update-user ul li').on('keydown', '#update-user ul li', function (e) {
        let list = $('#update-user ul li');
        let focused = $('#update-user ul li:focus');
        UserListKeyDown(e, list, focused, '#updateUser', '#update-user ul', '#updateName', "#updatePhone", "#updateAddress");
    });



    //add list value in Transaction User input of add modal
    $(document).off('click', '#update-user li').on('click', '#update-user li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        let withs = $(this).data('with');
        let name = $(this).data('name');
        let phone = $(this).data('phone');
        let address = $(this).data('address');
        $('#updateUser').val(value);
        $('#updateUser').attr('data-id', id);
        $('#updateUser').attr('data-with', withs);
        $('#updateName').val(name);
        $('#updatePhone').val(phone);
        $('#updateAddress').val(address);
        $('#update-user ul').html('');
        getDueListByUserId(id, '.due-grid tbody');
    });


    // User Focus Event
    $(document).off('focus', '#updateUser').on('focus', '#updateUser', function (e) {
        let tranUser = $(this).val();
        let tranUserType;
        let within;
        if ($('#within').length) {
            tranUserType = $('.with-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            within = 1;
        } else {
            tranUserType = $('#updateWith').val();
            within = 0;
        }
        let id = $(this).attr('data-id');
        if(id == undefined){
            getTransactionUser(tranUserType, within, tranUser, '#update-user ul');
        }
        else{
            e.preventDefault();
        }
    });


    // User Focousout event
    $(document).off('focusout', '#updateUser').on('focusout', '#updateUser', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#update-user ul').html('');
                }
            });
        }
    });



    // User Key Up Event Function
    function UserKeyUp(e, tranUserType, within, tranUser, id, targetElement1, targetElement2, targetElement3, targetElement4, targetElement5){
        if (e.keyCode === 13) { // Enter Key
            e.preventDefault();
        }
        else if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 8){
            //keyCode 65 = a, keyCode 90 = z, keyCode 96 = 0, keyCode 105 = 9, keyCode 8 = backSpace
            $(targetElement1).removeAttr('data-id');
            $(targetElement1).removeAttr('data-with');
            $(targetElement3).val('');
            $(targetElement4).val('');
            $(targetElement5).val('');
            getTransactionUser(tranUserType, within, tranUser, targetElement2);
        }
        else if (e.keyCode === 9) { // Tab key
            if (id != undefined) {
                e.preventDefault();
            }
            else{
                $(targetElement1).removeAttr('data-id');
                $(targetElement1).removeAttr('data-with');
                $(targetElement3).val('');
                $(targetElement4).val('');
                $(targetElement5).val('');
                getTransactionUser(tranUserType, within, tranUser, targetElement2);
            }
        }
    }



    // User Key Down Event Function
    function UserKeyDown(e, list, targetElement1, targetElement2, targetElement3, targetElement4, targetElement5) {
        if (list.length > 0) {
            if (e.keyCode === 40) { // Down arrow key
                e.preventDefault();
                list.first().focus();
                $(targetElement1).val(list.first().text());
                $(targetElement1).attr("data-id", list.data('id'));
                $(targetElement1).attr("data-with", list.data('with'));
                $(targetElement3).val(list.data('name'));
                $(targetElement4).val(list.data('phone'));
                $(targetElement5).val(list.data('address'));
            } 
            else if (e.keyCode === 38) { // Up arrow key
                e.preventDefault();
                list.last().focus();
                $(targetElement1).val(list.last().text());
                $(targetElement1).attr("data-id", list.data('id'));
                $(targetElement1).attr("data-with", list.data('with'));
                $(targetElement3).val(list.data('name'));
                $(targetElement4).val(list.data('phone'));
                $(targetElement5).val(list.data('address'));
            } 
            else if (e.keyCode === 13) { // Enter key
                e.preventDefault();
            }
            else if (e.keyCode === 9) { // Tab key
                $(targetElement2).html('');
            }
        }
    }
    


    // User List Key Down Event function
    function UserListKeyDown(e, list, focused, targetElement1, targetElement2, targetElement3, targetElement4, targetElement5) {
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            let nextIndex = focused.index() + 1;
            if (nextIndex >= list.length) {
                nextIndex = 0; // Loop to the first item
            }
            list.eq(nextIndex).focus();
            $(targetElement1).val(list.eq(nextIndex).text());
            $(targetElement1).attr("data-id", list.eq(nextIndex).data('id'));
            $(targetElement1).attr("data-with", list.eq(nextIndex).data('with'));
            $(targetElement3).val(list.eq(nextIndex).data('name'));
            $(targetElement4).val(list.eq(nextIndex).data('phone'));
            $(targetElement5).val(list.eq(nextIndex).data('address'));
        } 
        else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            let prevIndex = focused.index() - 1;
            if (prevIndex < 0) {
                prevIndex = list.length - 1; // Loop to the last item
            }
            list.eq(prevIndex).focus();
            $(targetElement1).val(list.eq(prevIndex).text());
            $(targetElement1).attr("data-id", list.eq(prevIndex).data('id'));
            $(targetElement1).attr("data-with", list.eq(nextIndex).data('with'));
            $(targetElement3).val(list.eq(nextIndex).data('name'));
            $(targetElement4).val(list.eq(nextIndex).data('phone'));
            $(targetElement5).val(list.eq(nextIndex).data('address'));
        } 
        else if (e.keyCode === 13) { // Enter key
            e.preventDefault();
            let id = $(targetElement1).attr('data-id');
            getDueListByUserId(id, '.due-grid tbody');
            getPayrollByUserId(id, '.payroll-grid tbody');
            // getPayrollSetupByUserId(id, '.setup tbody');
            // getPayrollMiddlewireByUserId(id, '.middlewire tbody');
            $(targetElement2).html('');
            $(targetElement1).focus();
        }
    }



    // Search Transaction User by Name
    function getTransactionUser(tranUserType, within, tranUser, targetElement1) {
        $.ajax({
            url: `${apiUrl}/transaction/get/user`,
            method: 'GET',
            data: { tranUserType, within, tranUser },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }



    


    ////////////// ------------------- Search Transaction user and add value to input ajax part end --------------- ////////////////////////////



    /////////////// ------------------ Search Heads By Name And Group add value to input ajax part start ---------------- /////////////////////////////
    // Head Keyup Event
    $(document).off('keyup', '#head').on('keyup', '#head', function (e) {
        let head = $(this).val();
        let groupe;
        let groupein;
        if ($('#groupein').length) {
            groupe = $('.groupe-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            groupein = 1;
        } else {
            groupe = $('#groupe').val();
            groupein = 0;
        }
        let id = $(this).attr('data-id');
        HeadKeyUp(e, groupe, groupein, head, id, '#head', '#head-list ul');
    });

    // Head Key down Event
    $(document).off('keydown', '#head').on('keydown', '#head', function (e) {
        let list = $('#head-list ul li');
        HeadKeyDown(e, list, '#head', '#head-list ul');
    });


    // Head List Key down Event
    $(document).off('keydown', '#head-list ul li').on('keydown', '#head-list ul li', function (e) {
        let list = $('#head-list ul li');
        let focused = $('#head-list ul li:focus');
        HeadListKeyDown(e, list, focused, '#head', '#head-list ul');
    });


    // Head Focus Event
    $(document).off('focus', '#head').on('focus', '#head', function (e) {
        let head = $(this).val();
        let groupe;
        let groupein;
        if ($('#groupein').length) {
            groupe = $('.groupe-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            groupein = 1;
        } else {
            groupe = $('#groupe').val();
            groupein = 0;
        }
        let id = $(this).attr('data-id');
        if(id == undefined){
            getHeadByGroupe(groupe, groupein, head,  '#head-list ul');
        }
        else{
            e.preventDefault();
        }
    });


    // Head Focous out event
    $(document).off('focusout', '#head').on('focusout', '#head', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#head-list ul').html('');
                }
            });
        }
    });


    // Head List Click Event
    $(document).off('click', '#head-list li').on('click', '#head-list li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        let groupe = $(this).data('groupe');
        $('#head').val(value);
        $('#head').attr('data-id', id);
        $('#head').attr('data-groupe', groupe);
        $('#head-list ul').html('');
    });



    // Update Head Keyup event
    $(document).off('keyup', '#updateHead').on('keyup', '#updateHead', function (e) {
        let head = $(this).val();
        let groupe;
        let groupein;
        if ($('#updategroupein').length) {
            groupe = $('.updategroupe-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            groupein = 1;
        } else {
            groupe = $('#updategroupe').val();
            groupein = 0;
        }
        let id = $(this).attr('data-id');
        HeadKeyUp(e, groupe, groupein, head, id, '#updateHead', '#update-head ul');
    });



    // Update Head Keydown event
    $(document).off('keydown', '#updateHead').on('keydown', '#updateHead', function (e) {
        let list = $('#update-head ul li');
        HeadKeyDown(e, list, '#updateHead', '#update-head ul');
    });



    // Update Head List Keydown event
    $(document).off('keydown', '#update-head ul li').on('keydown', '#update-head ul li', function (e) {
        let list = $('#update-head ul li');
        let focused = $('#update-head ul li:focus');
        HeadListKeyDown(e, list, focused, '#updateHead', '#update-head ul');
    });



    // Update Head Focus Event
    $(document).off('focus', '#updateHead').on('focus', '#updateHead', function (e) {
        let head = $(this).val();
        let groupe;
        let groupein;
        if ($('#updategroupein').length) {
            groupe = $('.updategroupe-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            groupein = 1;
        } else {
            groupe = $('#updateGroupe').val();
            groupein = 0;
        }
        let id = $(this).attr('data-id');
        if(id == undefined){
            getHeadByGroupe(groupe, groupein, head, '#update-head ul');
        }
        else{
            e.preventDefault();
        }
    });


    
    // Update Head Focousout event
    $(document).off('focusout', '#updateHead').on('focusout', '#updateHead', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#update-head ul').html('');
                }
            });
        }
    });


    // Update Head Click Event
    $(document).off('click', '#update-head li').on('click', '#update-head li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        let groupe = $(this).data('groupe');
        $('#updateHead').val(value);
        $('#updateHead').attr('data-id', id);
        $('#updateHead').attr('data-groupe', groupe);
        $('#update-head ul').html('');
    });



    // Head Key Up Event Function
    function HeadKeyUp(e, groupe, groupein, head, id, targetElement1, targetElement2){
        if (e.keyCode === 13) { // Enter Key
            e.preventDefault();
        }
        else if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 8){
            //keyCode 65 = a, keyCode 90 = z, keyCode 96 = 0, keyCode 105 = 9, keyCode 8 = backSpace
            $(targetElement1).removeAttr('data-id');
            $(targetElement1).removeAttr('data-groupe');
            getHeadByGroupe(groupe, groupein, head,  targetElement2);
        }
        else if (e.keyCode === 9) { // Tab key
            if (id != undefined) {
                e.preventDefault();
            }
            else{
                $(targetElement1).removeAttr('data-id');
                $(targetElement1).removeAttr('data-groupe');
                getHeadByGroupe(groupe, groupein, head,  targetElement2);
            }
        }
    }


    // Head Key Down Event Function
    function HeadKeyDown(e, list, targetElement1, targetElement2) {
        if (list.length > 0) {
            if (e.keyCode === 40) { // Down arrow key
                e.preventDefault();
                list.first().focus();
                $(targetElement1).val(list.first().text());
                $(targetElement1).attr("data-id", list.data('id'));
                $(targetElement1).attr("data-groupe", list.data('groupe'));
            } 
            else if (e.keyCode === 38) { // Up arrow key
                e.preventDefault();
                list.last().focus();
                $(targetElement1).val(list.last().text());
                $(targetElement1).attr("data-id", list.data('id'));
                $(targetElement1).attr("data-groupe", list.data('groupe'));
            } 
            else if (e.keyCode === 13) { // Enter key
                e.preventDefault();
            } 
            else if (e.keyCode === 9) { // Tab key
                $(targetElement2).html('');
            }
        }
    }


    // Head List Key Down Event function
    function HeadListKeyDown(e, list, focused, targetElement1, targetElement2) {
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            let nextIndex = focused.index() + 1;
            if (nextIndex >= list.length) {
                nextIndex = 0; // Loop to the first item
            }
            list.eq(nextIndex).focus();
            $(targetElement1).val(list.eq(nextIndex).text());
            $(targetElement1).attr("data-id", list.eq(nextIndex).data('id'));
            $(targetElement1).attr("data-groupe", list.eq(nextIndex).data('groupe'));
        } 
        else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            let prevIndex = focused.index() - 1;
            if (prevIndex < 0) {
                prevIndex = list.length - 1; // Loop to the last item
            }
            list.eq(prevIndex).focus();
            $(targetElement1).val(list.eq(prevIndex).text());
            $(targetElement1).attr("data-id", list.eq(prevIndex).data('id'));
            $(targetElement1).attr("data-groupe", list.eq(prevIndex).data('groupe'));
        } 
        else if (e.keyCode === 13) { // Enter key
            e.preventDefault();
            $(targetElement2).html('');
            $(targetElement1).focus();
        }
    }

    // Search Head by Name
    function getHeadByGroupe(groupe, groupein, head, targetElement1) {
        $.ajax({
            url: `${apiUrl}/admin/tranheads/get`,
            method: 'GET',
            data: { groupe, groupein, head },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }

    /////////////// ------------------ Search Head By Name And Groupe add value to input ajax part end ---------------- /////////////////////////////







    /////////////// ------------------ Search Manufacturer by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Manufacturer Keyup Event
    $(document).off('keyup', '#manufacturer').on('keyup', '#manufacturer', function (e) {
        let manufacturer = $(this).val();
        let id = $(this).attr('data-id');
        let url = $(this).attr('data-url');
        ManufacturerKeyUp(e, url, manufacturer, id, '#manufacturer', '#manufacturer-list ul');
    });


    // Manufacturer Keydown Event
    $(document).off('keydown', '#manufacturer').on('keydown', '#manufacturer', function (e) {
        let list = $('#manufacturer-list ul li');
        ManufacturerKeyDown(e, list, '#manufacturer', '#manufacturer-list ul');
    });


    // Manufacturer List keydown Event
    $(document).off('keydown', '#manufacturer-list ul li').on('keydown', '#manufacturer-list ul li', function (e) {
        let list = $('#manufacturer-list ul li');
        let focused = $('#manufacturer-list ul li:focus');
        ManufacturerListKeyDown(e, list, focused, '#manufacturer', '#manufacturer-list ul');
    });


    // Manufacturer List Click Event
    $(document).off('click', '#manufacturer-list li').on('click', '#manufacturer-list li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#manufacturer').val(value);
        $('#manufacturer').attr('data-id', id);
        $('#manufacturer-list ul').html('');
    });


    // Manufacturer Focus Event
    $(document).off('focus', '#manufacturer').on('focus', '#manufacturer', function (e) {
        let manufacturer = $(this).val();
        let id = $(this).attr('data-id');
        let url = $(this).attr('data-url');
        if(id == undefined){
            getManufacturerByName(url, manufacturer, '#manufacturer-list ul');
        }
        else{
            e.preventDefault();
        }
    });


    // Manufacturer Focusout event
    $(document).off('focusout', '#manufacturer').on('focusout', '#manufacturer', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#manufacturer-list ul').html('');
                }
            });
        }
    });

    // Update Manufacturer Keyup Event
    $(document).off('keyup', '#updateManufacturer').on('keyup', '#updateManufacturer', function (e) {
        let manufacturer = $(this).val();
        let id = $(this).attr('data-id');
        let url = $(this).attr('data-url');
        ManufacturerKeyUp(e, url, manufacturer, id, '#updateManufacturer', '#update-manufacturer ul');
    });


    // Update Manufacturer Keydown Event
    $(document).off('keydown', '#updateManufacturer').on('keydown', '#updateManufacturer', function (e) {
        let list = $('#update-manufacturer ul li');
        ManufacturerKeyDown(e, list, '#updateManufacturer', '#update-manufacturer ul');
    });


    // Update Manufacturer List Keydown Event
    $(document).off('keydown', '#update-manufacturer ul li').on('keydown', '#update-manufacturer ul li', function (e) {
        let list = $('#update-manufacturer ul li');
        let focused = $('#update-manufacturer ul li:focus');
        ManufacturerListKeyDown(e, list, focused, '#updateManufacturer', '#update-manufacturer ul');
    });


    // Update Manufacturer List Click Event
    $(document).off('click', '#update-manufacturer li').on('click', '#update-manufacturer li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#updateManufacturer').val(value);
        $('#updateManufacturer').attr('data-id', id);
        $('#update-manufacturer ul').html('');
    });



    // Update Manufacturer Focus Event
    $(document).off('focus', '#updateManufacturer').on('focus', '#updateManufacturer', function (e) {
        let manufacturer = $(this).val();
        let id = $(this).attr('data-id');
        let url = $(this).attr('data-url');
        if(id == undefined){
            getManufacturerByName(url, manufacturer, '#update-manufacturer ul');
        }
        else{
            e.preventDefault();
        }
    });



    // Update Location Focousout Event
    $(document).off('focusout', '#updateManufacturer').on('focusout', '#updateManufacturer', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#update-manufacturer ul').html('');
                }
            });
        }
    });


    // Manufacturer Keyup Event Function
    function ManufacturerKeyUp(e, url, manufacturer, id, targetElement1, targetElement2){
        if (e.keyCode === 13) { // Enter Key
            e.preventDefault();
        }
        else if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 8){
            //keyCode 65 = a, keyCode 90 = z, keyCode 96 = 0, keyCode 105 = 9, keyCode 8 = backSpace
            $(targetElement1).removeAttr('data-id');
            getManufacturerByName(url, manufacturer, targetElement2);
        }
        else if (e.keyCode === 9) { // Tab key
            if (id != undefined) {
                e.preventDefault();
            }
            else{
                $(targetElement1).removeAttr('data-id');
                getManufacturerByName(url, manufacturer, targetElement2);
            }
        }
    }


    // Manufacturer Keydown Event Function
    function ManufacturerKeyDown(e, list, targetElement1, targetElement2) {
        if (list.length > 0) {
            if (e.keyCode === 40) { // Down arrow key
                e.preventDefault();
                list.first().focus();
                $(targetElement1).val(list.first().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 38) { // Up arrow key
                e.preventDefault();
                list.last().focus();
                $(targetElement1).val(list.last().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 13) { // Enter key
                e.preventDefault();
            } 
            else if (e.keyCode === 9) { // Tab key
                $(targetElement2).html('');
            }
        }
    }
    

    // Manufacturer List Keydown Event function
    function ManufacturerListKeyDown(e, list, focused, targetElement1, targetElement2) {
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            let nextIndex = focused.index() + 1;
            if (nextIndex >= list.length) {
                nextIndex = 0; // Loop to the first item
            }
            list.eq(nextIndex).focus();
            $(targetElement1).val(list.eq(nextIndex).text());
            $(targetElement1).attr("data-id", list.eq(nextIndex).data('id'));
        } 
        else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            let prevIndex = focused.index() - 1;
            if (prevIndex < 0) {
                prevIndex = list.length - 1; // Loop to the last item
            }
            list.eq(prevIndex).focus();
            $(targetElement1).val(list.eq(prevIndex).text());
            $(targetElement1).attr("data-id", list.eq(prevIndex).data('id'));
        } 
        else if (e.keyCode === 13) { // Enter key
            e.preventDefault();
            $(targetElement2).html('');
            $(targetElement1).focus();
        }
    }


    // Search Manufacturer by Name
    function getManufacturerByName(url, manufacturer, targetElement1) {
        $.ajax({
            url: url,
            method: 'GET',
            data: { manufacturer },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }

    /////////////// ------------------ Search Manufacturer by Name and add value to input ajax part end ---------------- /////////////////////////////








    /////////////// ------------------ Search Category by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Category Keyup Event
    $(document).off('keyup', '#category').on('keyup', '#category', function (e) {
        let category = $(this).val();
        let id = $(this).attr('data-id');
        let url = $(this).attr('data-url');
        CategoryKeyUp(e, url, category, id, '#category', '#category-list ul');
    });


    // Category Keydown Event
    $(document).off('keydown', '#category').on('keydown', '#category', function (e) {
        let list = $('#category-list ul li');
        CategoryKeyDown(e, list, '#category', '#category-list ul');
    });


    // Category List keydown Event
    $(document).off('keydown', '#category-list ul li').on('keydown', '#category-list ul li', function (e) {
        let list = $('#category-list ul li');
        let focused = $('#category-list ul li:focus');
        CategoryListKeyDown(e, list, focused, '#category', '#category-list ul');
    });


    // Category List Click Event
    $(document).off('click', '#category-list li').on('click', '#category-list li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#category').val(value);
        $('#category').attr('data-id', id);
        $('#category-list ul').html('');
    });


    // Category Focus Event
    $(document).off('focus', '#category').on('focus', '#category', function (e) {
        let category = $(this).val();
        let id = $(this).attr('data-id');
        let url = $(this).attr('data-url');
        if(id == undefined){
            getCategoryByName(url, category, '#category-list ul');
        }
        else{
            e.preventDefault();
        }
    });


    // Locaation Focousout event
    $(document).off('focusout', '#category').on('focusout', '#category', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#category-list ul').html('');
                }
            });
        }
    });

    // Update Category Keyup Event
    $(document).off('keyup', '#updateCategory').on('keyup', '#updateCategory', function (e) {
        let category = $(this).val();
        let id = $(this).attr('data-id');
        let url = $(this).attr('data-url');
        CategoryKeyUp(e, url, category, id, '#updateCategory', '#update-category ul');
    });


    // Update Category Keydown Event
    $(document).off('keydown', '#updateCategory').on('keydown', '#updateCategory', function (e) {
        let list = $('#update-category ul li');
        CategoryKeyDown(e, list, '#updateCategory', '#update-category ul');
    });


    // Update Category List Keydown Event
    $(document).off('keydown', '#update-category ul li').on('keydown', '#update-category ul li', function (e) {
        let list = $('#update-category ul li');
        let focused = $('#update-category ul li:focus');
        CategoryListKeyDown(e, list, focused, '#updateCategory', '#update-category ul');
    });


    // Update Category List Click Event
    $(document).off('click', '#update-category li').on('click', '#update-category li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#updateCategory').val(value);
        $('#updateCategory').attr('data-id', id);
        $('#update-category ul').html('');
    });



    // Update Category Focus Event
    $(document).off('focus', '#updateCategory').on('focus', '#updateCategory', function (e) {
        let category = $(this).val();
        let id = $(this).attr('data-id');
        let url = $(this).attr('data-url');
        if(id == undefined){
            getCategoryByName(url, category, '#update-category ul');
        }
        else{
            e.preventDefault();
        }
    });



    // Update Location Focousout Event
    $(document).off('focusout', '#updateCategory').on('focusout', '#updateCategory', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#update-category ul').html('');
                }
            });
        }
    });


    // Category Keyup Event Function
    function CategoryKeyUp(e, url, category, id, targetElement1, targetElement2){
        if (e.keyCode === 13) { // Enter Key
            e.preventDefault();
        }
        else if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 8){
            //keyCode 65 = a, keyCode 90 = z, keyCode 96 = 0, keyCode 105 = 9, keyCode 8 = backSpace
            $(targetElement1).removeAttr('data-id');
            getCategoryByName(url, category, targetElement2);
        }
        else if (e.keyCode === 9) { // Tab key
            if (id != undefined) {
                e.preventDefault();
            }
            else{
                $(targetElement1).removeAttr('data-id');
                getCategoryByName(url, category, targetElement2);
            }
        }
    }


    // Category Keydown Event Function
    function CategoryKeyDown(e, list, targetElement1, targetElement2) {
        if (list.length > 0) {
            if (e.keyCode === 40) { // Down arrow key
                e.preventDefault();
                list.first().focus();
                $(targetElement1).val(list.first().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 38) { // Up arrow key
                e.preventDefault();
                list.last().focus();
                $(targetElement1).val(list.last().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 13) { // Enter key
                e.preventDefault();
            } 
            else if (e.keyCode === 9) { // Tab key
                $(targetElement2).html('');
            }
        }
    }
    

    // Category List Keydown Event function
    function CategoryListKeyDown(e, list, focused, targetElement1, targetElement2) {
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            let nextIndex = focused.index() + 1;
            if (nextIndex >= list.length) {
                nextIndex = 0; // Loop to the first item
            }
            list.eq(nextIndex).focus();
            $(targetElement1).val(list.eq(nextIndex).text());
            $(targetElement1).attr("data-id", list.eq(nextIndex).data('id'));
        } 
        else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            let prevIndex = focused.index() - 1;
            if (prevIndex < 0) {
                prevIndex = list.length - 1; // Loop to the last item
            }
            list.eq(prevIndex).focus();
            $(targetElement1).val(list.eq(prevIndex).text());
            $(targetElement1).attr("data-id", list.eq(prevIndex).data('id'));
        } 
        else if (e.keyCode === 13) { // Enter key
            e.preventDefault();
            $(targetElement2).html('');
            $(targetElement1).focus();
        }
    }

    // Search Category by Name
    function getCategoryByName(url, category, targetElement1) {
        $.ajax({
            url: url,
            method: 'GET',
            data: { category },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }

    /////////////// ------------------ Search Category by Name and add value to input ajax part end ---------------- /////////////////////////////



    /////////////// ------------------ Search Form by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Form Keyup Event
    $(document).off('keyup', '#form').on('keyup', '#form', function (e) {
        let form = $(this).val();
        let id = $(this).attr('data-id');
        let url = $(this).attr('data-url');
        FormKeyUp(e, url, form, id, '#form', '#form-list ul');
    });


    // Form Keydown Event
    $(document).off('keydown', '#form').on('keydown', '#form', function (e) {
        let list = $('#form-list ul li');
        FormKeyDown(e, list, '#form', '#form-list ul');
    });


    // Form List keydown Event
    $(document).off('keydown', '#form-list ul li').on('keydown', '#form-list ul li', function (e) {
        let list = $('#form-list ul li');
        let focused = $('#form-list ul li:focus');
        FormListKeyDown(e, list, focused, '#form', '#form-list ul');
    });


    // Form List Click Event
    $(document).off('click', '#form-list li').on('click', '#form-list li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#form').val(value);
        $('#form').attr('data-id', id);
        $('#form-list ul').html('');
    });


    // Form Focus Event
    $(document).off('focus', '#form').on('focus', '#form', function (e) {
        let form = $(this).val();
        let id = $(this).attr('data-id');
        let url = $(this).attr('data-url');
        if(id == undefined){
            getFormByName(url, form, '#form-list ul');
        }
        else{
            e.preventDefault();
        }
    });


    // Location Focousout event
    $(document).off('focusout', '#form').on('focusout', '#form', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#form-list ul').html('');
                }
            });
        }
    });

    // Update Form Keyup Event
    $(document).off('keyup', '#updateForm').on('keyup', '#updateForm', function (e) {
        let form = $(this).val();
        let id = $(this).attr('data-id');
        let url = $(this).attr('data-url');
        FormKeyUp(e, url, form, id, '#updateForm', '#update-form ul');
    });


    // Update Form Keydown Event
    $(document).off('keydown', '#updateForm').on('keydown', '#updateForm', function (e) {
        let list = $('#update-form ul li');
        FormKeyDown(e, list, '#updateForm', '#update-form ul');
    });


    // Update Form List Keydown Event
    $(document).off('keydown', '#update-form ul li').on('keydown', '#update-form ul li', function (e) {
        let list = $('#update-form ul li');
        let focused = $('#update-form ul li:focus');
        FormListKeyDown(e, list, focused, '#updateForm', '#update-form ul');
    });


    // Update Form List Click Event
    $(document).off('click', '#update-form li').on('click', '#update-form li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#updateForm').val(value);
        $('#updateForm').attr('data-id', id);
        $('#update-form ul').html('');
    });



    // Update Form Focus Event
    $(document).off('focus', '#updateForm').on('focus', '#updateForm', function (e) {
        let form = $(this).val();
        let id = $(this).attr('data-id');
        let url = $(this).attr('data-url');
        if(id == undefined){
            getFormByName(url, form, '#update-form ul');
        }
        else{
            e.preventDefault();
        }
    });



    // Update Locaation Focousout Event
    $(document).off('focusout', '#updateForm').on('focusout', '#updateForm', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#update-form ul').html('');
                }
            });
        }
    });


    // Form Keyup Event Function
    function FormKeyUp(e, url, form, id, targetElement1, targetElement2){
        if (e.keyCode === 13) { // Enter Key
            e.preventDefault();
        }
        else if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 8){
            //keyCode 65 = a, keyCode 90 = z, keyCode 96 = 0, keyCode 105 = 9, keyCode 8 = backSpace
            $(targetElement1).removeAttr('data-id');
            getFormByName(url, form, targetElement2);
        }
        else if (e.keyCode === 9) { // Tab key
            if (id != undefined) {
                e.preventDefault();
            }
            else{
                $(targetElement1).removeAttr('data-id');
                getFormByName(url, form, targetElement2);
            }
        }
    }


    // Form Keydown Event Function
    function FormKeyDown(e, list, targetElement1, targetElement2) {
        if (list.length > 0) {
            if (e.keyCode === 40) { // Down arrow key
                e.preventDefault();
                list.first().focus();
                $(targetElement1).val(list.first().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 38) { // Up arrow key
                e.preventDefault();
                list.last().focus();
                $(targetElement1).val(list.last().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 13) { // Enter key
                e.preventDefault();
            } 
            else if (e.keyCode === 9) { // Tab key
                $(targetElement2).html('');
            }
        }
    }
    

    // Form List Keydown Event function
    function FormListKeyDown(e, list, focused, targetElement1, targetElement2) {
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            let nextIndex = focused.index() + 1;
            if (nextIndex >= list.length) {
                nextIndex = 0; // Loop to the first item
            }
            list.eq(nextIndex).focus();
            $(targetElement1).val(list.eq(nextIndex).text());
            $(targetElement1).attr("data-id", list.eq(nextIndex).data('id'));
        } 
        else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            let prevIndex = focused.index() - 1;
            if (prevIndex < 0) {
                prevIndex = list.length - 1; // Loop to the last item
            }
            list.eq(prevIndex).focus();
            $(targetElement1).val(list.eq(prevIndex).text());
            $(targetElement1).attr("data-id", list.eq(prevIndex).data('id'));
        } 
        else if (e.keyCode === 13) { // Enter key
            e.preventDefault();
            $(targetElement2).html('');
            $(targetElement1).focus();
        }
    }

    // Search Form by Name
    function getFormByName(url, form, targetElement1) {
        $.ajax({
            url: url,
            method: 'GET',
            data: { form },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }

    /////////////// ------------------ Search Form by Name and add value to input ajax part end ---------------- /////////////////////////////






    /////////////// ------------------ Search Unit by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Unit Keyup Event
    $(document).off('keyup', '#unit').on('keyup', '#unit', function (e) {
        let unit = $(this).val();
        let id = $(this).attr('data-id');
        let url = $(this).attr('data-url');
        UnitKeyUp(e, url, unit, id, '#unit', '#unit-list ul');
    });


    // Unit Keydown Event
    $(document).off('keydown', '#unit').on('keydown', '#unit', function (e) {
        let list = $('#unit-list ul li');
        UnitKeyDown(e, list, '#unit', '#unit-list ul');
    });


    // Unit List keydown Event
    $(document).off('keydown', '#unit-list ul li').on('keydown', '#unit-list ul li', function (e) {
        let list = $('#unit-list ul li');
        let focused = $('#unit-list ul li:focus');
        UnitListKeyDown(e, list, focused, '#unit', '#unit-list ul');
    });


    // Unit List Click Event
    $(document).off('click', '#unit-list li').on('click', '#unit-list li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#unit').val(value);
        $('#unit').attr('data-id', id);
        $('#unit-list ul').html('');
    });


    // Unit Focus Event
    $(document).off('focus', '#unit').on('focus', '#unit', function (e) {
        let unit = $(this).val();
        let id = $(this).attr('data-id');
        let url = $(this).attr('data-url');
        if(id == undefined){
            getUnitByName(url, unit, '#unit-list ul');
        }
        else{
            e.preventDefault();
        }
    });


    // Locaation Focousout event
    $(document).off('focusout', '#unit').on('focusout', '#unit', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#unit-list ul').html('');
                }
            });
        }
    });

    // Update Unit Keyup Event
    $(document).off('keyup', '#updateUnit').on('keyup', '#updateUnit', function (e) {
        let unit = $(this).val();
        let url = $(this).attr('data-url');
        let id = $(this).attr('data-id');
        UnitKeyUp(e, url, unit, id, '#updateUnit', '#update-unit ul');
    });


    // Update Unit Keydown Event
    $(document).off('keydown', '#updateUnit').on('keydown', '#updateUnit', function (e) {
        let list = $('#update-unit ul li');
        UnitKeyDown(e, list, '#updateUnit', '#update-unit ul');
    });


    // Update Unit List Keydown Event
    $(document).off('keydown', '#update-unit ul li').on('keydown', '#update-unit ul li', function (e) {
        let list = $('#update-unit ul li');
        let focused = $('#update-unit ul li:focus');
        UnitListKeyDown(e, list, focused, '#updateUnit', '#update-unit ul');
    });


    // Update Unit List Click Event
    $(document).off('click', '#update-unit li').on('click', '#update-unit li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#updateUnit').val(value);
        $('#updateUnit').attr('data-id', id);
        $('#update-unit ul').html('');
    });



    // Update Unit Focus Event
    $(document).off('focus', '#updateUnit').on('focus', '#updateUnit', function (e) {
        let unit = $(this).val();
        let id = $(this).attr('data-id');
        let url = $(this).attr('data-url');
        if(id == undefined){
            getUnitByName(url, unit, '#update-unit ul');
        }
        else{
            e.preventDefault();
        }
    });



    // Update Locaation Focousout Event
    $(document).off('focusout', '#updateUnit').on('focusout', '#updateUnit', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#update-unit ul').html('');
                }
            });
        }
    });


    // Unit Keyup Event Function
    function UnitKeyUp(e, url, unit, id, targetElement1, targetElement2){
        if (e.keyCode === 13) { // Enter Key
            e.preventDefault();
        }
        else if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 8){
            //keyCode 65 = a, keyCode 90 = z, keyCode 96 = 0, keyCode 105 = 9, keyCode 8 = backSpace
            $(targetElement1).removeAttr('data-id');
            getUnitByName(url, unit, targetElement2);
        }
        else if (e.keyCode === 9) { // Tab key
            if (id != undefined) {
                e.preventDefault();
            }
            else{
                $(targetElement1).removeAttr('data-id');
                getUnitByName(url, unit, targetElement2);
            }
        }
    }


    // Unit Keydown Event Function
    function UnitKeyDown(e, list, targetElement1, targetElement2) {
        if (list.length > 0) {
            if (e.keyCode === 40) { // Down arrow key
                e.preventDefault();
                list.first().focus();
                $(targetElement1).val(list.first().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 38) { // Up arrow key
                e.preventDefault();
                list.last().focus();
                $(targetElement1).val(list.last().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 13) { // Enter key
                e.preventDefault();
            } 
            else if (e.keyCode === 9) { // Tab key
                $(targetElement2).html('');
            }
        }
    }
    

    // Unit List Keydown Event function
    function UnitListKeyDown(e, list, focused, targetElement1, targetElement2) {
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            let nextIndex = focused.index() + 1;
            if (nextIndex >= list.length) {
                nextIndex = 0; // Loop to the first item
            }
            list.eq(nextIndex).focus();
            $(targetElement1).val(list.eq(nextIndex).text());
            $(targetElement1).attr("data-id", list.eq(nextIndex).data('id'));
        } 
        else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            let prevIndex = focused.index() - 1;
            if (prevIndex < 0) {
                prevIndex = list.length - 1; // Loop to the last item
            }
            list.eq(prevIndex).focus();
            $(targetElement1).val(list.eq(prevIndex).text());
            $(targetElement1).attr("data-id", list.eq(prevIndex).data('id'));
        } 
        else if (e.keyCode === 13) { // Enter key
            e.preventDefault();
            $(targetElement2).html('');
            $(targetElement1).focus();
        }
    }

    // Search Unit by Name
    function getUnitByName(url, unit, targetElement1) {
        $.ajax({
            url: url,
            method: 'GET',
            data: { unit },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }

    /////////////// ------------------ Search Unit by Name and add value to input ajax part end ---------------- /////////////////////////////





    /////////////// ------------------ Search Products By Name And Group add value to input ajax part start ---------------- /////////////////////////////
    // Head Keyup Event
    $(document).off('keyup', '#product').on('keyup', '#product', function (e) {
        let product = $(this).val();
        let groupe;
        let groupein;
        if ($('#groupein').length) {
            groupe = $('.groupe-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            groupein = 1;
        } else {
            groupe = $('#groupe').val();
            groupein = 0;
        }
        let id = $(this).attr('data-id');
        ProductKeyUp(e, groupe, groupein, product, id, '#product', '#product-list table tbody', '#mrp', '#cp', '#unit', '#quantity', '#totAmount');
    });

    // Product Key down Event
    $(document).off('keydown', '#product').on('keydown', '#product', function (e) {
        let list = $('#product-list table tbody tr');
        ProductKeyDown(e, list, '#product', '#product-list table tbody', '#mrp', '#cp', '#unit', '#quantity', '#totAmount');
    });


    // Product List Key down Event
    $(document).off('keydown', '#product-list table tbody tr').on('keydown', '#product-list table tbody tr', function (e) {
        let list = $('#product-list table tbody tr');
        let focused = $('#product-list table tbody tr:focus');
        ProductListKeyDown(e, list, focused, '#product', '#product-list table tbody', '#mrp', '#cp', '#unit', '#quantity', '#totAmount');
    });


    // Product Focus Event
    $(document).off('focus', '#product').on('focus', '#product', function (e) {
        let product = $(this).val();
        let groupe;
        let groupein;
        if ($('#groupein').length) {
            groupe = $('.groupe-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            groupein = 1;
        } else {
            groupe = $('#groupe').val();
            groupein = 0;
        }
        let id = $(this).attr('data-id');
        if(id == undefined){
            getProductByGroupe(groupe, groupein, product,  '#product-list table tbody');
        }
        else{
            e.preventDefault();
        }
    });


    // Product Focous out event
    $(document).off('focusout', '#product').on('focusout', '#product', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#product-list table tbody').html('');
                }
            });
        }
    });


    // Product List Click Event
    $(document).off('click', '#product-list tbody tr').on('click', '#product-list tbody tr', function () {
        let value = $(this).find('td:first').text();
        let id = $(this).data('id');
        let groupe = $(this).data('groupe');
        let qty = $('#quantity').val();
        let cp = $(this).data('cp');
        let mrp = $(this).data('mrp');
        let unitid = $(this).data('unit-id');
        let unitname = $(this).data('unit');

        $('#product').val(value);
        $('#product').attr('data-id', id);
        $('#product').attr('data-groupe', groupe);
        $('#mrp').val(mrp);
        $('#cp').val(cp);
        $('#unit').val(unitname);
        $('#unit').attr('data-id', unitid);

        const path = window.location.pathname;
        const pathSegments = path.split("/");

        if(pathSegments[3] === 'issue'){
            $('#totAmount').val(mrp * qty);
        }
        else if(pathSegments[3] === 'purchase'){
            $('#totAmount').val(cp * qty);
        }

        $('#product-list table tbody').html('');
        $('#product').focus();
        
    });



    // Update Product Keyup event
    $(document).off('keyup', '#updateProduct').on('keyup', '#updateProduct', function (e) {
        let product = $(this).val();
        let groupe;
        let groupein;
        if ($('#updategroupein').length) {
            groupe = $('.updategroupe-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            groupein = 1;
        } else {
            groupe = $('#updategroupe').val();
            groupein = 0;
        }
        let id = $(this).attr('data-id');
        ProductKeyUp(e, groupe, groupein, product, id, '#updateProduct', '#update-product table tbody', '#updateMrp', '#updateCp', '#updateUnit', '#updateQuantity', '#updateTotAmount');
    });



    // Update Product Keydown event
    $(document).off('keydown', '#updateProduct').on('keydown', '#updateProduct', function (e) {
        let list = $('#update-product table tbody tr');
        ProductKeyDown(e, list, '#updateProduct', '#update-product table tbody', '#updateMrp', '#updateCp', '#updateUnit', '#updateQuantity', '#updateTotAmount');
    });



    // Update Product List Keydown event
    $(document).off('keydown', '#update-product table tbody tr').on('keydown', '#update-product table tbody tr', function (e) {
        let list = $('#update-product table tbody tr');
        let focused = $('#update-product table tbody tr:focus');
        ProductListKeyDown(e, list, focused, '#updateProduct', '#update-product table tbody', '#updateMrp', '#updateCp', '#updateUnit', '#updateQuantity', 'totAmount');
    });



    // Update Product Focus Event
    $(document).off('focus', '#updateProduct').on('focus', '#updateProduct', function (e) {
        let product = $(this).val();
        let groupe;
        let groupein;
        if ($('#updategroupein').length) {
            groupe = $('.updategroupe-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            groupein = 1;
        } else {
            groupe = $('#updateGroupe').val();
            groupein = 0;
        }
        let id = $(this).attr('data-id');
        if(id == undefined){
            getProductByGroupe(groupe, groupein, product, '#update-product table tbody');
        }
        else{
            e.preventDefault();
        }
    });


    
    // Update Product Focousout event
    $(document).off('focusout', '#updateProduct').on('focusout', '#updateProduct', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#update-product table tbody').html('');
                }
            });
        }
    });


    // Update Product Click Event
    $(document).off('click', '#update-product tbody tr').on('click', '#update-product tbody tr', function () {
        let value = $(this).find('td:first').text();
        let id = $(this).data('id');
        let groupe = $(this).data('groupe');
        let qty = $('#updateQuantity').val();
        let cp = $(this).data('cp');
        let mrp = $(this).data('mrp');
        let unitid = $(this).data('unit-id');
        let unitname = $(this).data('unit');

        $('#updateProduct').val(value);
        $('#updateProduct').attr('data-id', id);
        $('#updateProduct').attr('data-groupe', groupe);
        $('#updateMrp').val(mrp);
        $('#updateCp').val(cp);
        $('#updateUnit').val(unitname);
        $('#updateUnit').attr('data-id', unitid);

        const path = window.location.pathname;
        const pathSegments = path.split("/");

        if(pathSegments[3] === 'issue'){
            $('#updateTotAmount').val(mrp * qty);
        }
        else if(pathSegments[3] === 'purchase'){
            $('#updateTotAmount').val(cp * qty);
        }



        $('#update-product table tbody').html('');
        $('#updateProduct').focus();
    });



    // Product Key Up Event Function
    function ProductKeyUp(e, groupe, groupein, product, id, targetElement1, targetElement2, targetElement3, targetElement4, targetElement5, targetElement6, targetElement7){
        if (e.keyCode === 13) { // Enter Key
            e.preventDefault();
        }
        else if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 8){
            //keyCode 65 = a, keyCode 90 = z, keyCode 96 = 0, keyCode 105 = 9, keyCode 8 = backSpace
            $(targetElement1).removeAttr('data-id');
            $(targetElement1).removeAttr('data-groupe');
            $(targetElement5).removeAttr('data-id');
            $(targetElement3).val('');
            $(targetElement4).val('');
            $(targetElement5).val('');
            $(targetElement7).val('');
            getProductByGroupe(groupe, groupein, product,  targetElement2);
        }
        else if (e.keyCode === 9) { // Tab key
            if (id != undefined) {
                e.preventDefault();
            }
            else{
                $(targetElement1).removeAttr('data-id');
                $(targetElement1).removeAttr('data-groupe');
                $(targetElement5).removeAttr('data-id');
                $(targetElement3).val('');
                $(targetElement4).val('');
                $(targetElement5).val('');
                $(targetElement7).val('');
                getProductByGroupe(groupe, groupein, product,  targetElement2);
            }
        }
    }


    // Product Key Down Event Function
    function ProductKeyDown(e, list, targetElement1, targetElement2, targetElement3, targetElement4, targetElement5, targetElement6, targetElement7) {
        if (list.length > 0) {
            let qty = $(targetElement6).val();
            if (e.keyCode === 40) { // Down arrow key
                e.preventDefault();
                list.first().focus();
                $(targetElement1).val(list.first().find('td:first').text());
                $(targetElement1).attr("data-id", list.data('id'));
                $(targetElement1).attr("data-groupe", list.data('groupe'));
                $(targetElement5).attr('data-id',list.data('unit-id'));
                $(targetElement3).val(list.first().attr('data-mrp'));
                $(targetElement4).val(list.first().attr('data-cp'));
                $(targetElement5).val(list.first().attr('data-unit'));

                const path = window.location.pathname;
                const pathSegments = path.split("/");

                if(pathSegments[3] === 'issue'){
                    $(targetElement7).val(list.first().attr('data-mrp') * qty);
                }
                else if(pathSegments[3] === 'purchase'){
                    $(targetElement7).val(list.first().attr('data-cp') * qty);
                }
            } 
            else if (e.keyCode === 38) { // Up arrow key
                e.preventDefault();
                list.last().focus();
                $(targetElement1).val(list.last().find('td:first').text());
                $(targetElement1).attr("data-id", list.data('id'));
                $(targetElement1).attr("data-groupe", list.data('groupe'));
                $(targetElement5).attr('data-id',list.data('unit-id'));
                $(targetElement3).val(list.last().attr('data-mrp'));
                $(targetElement4).val(list.last().attr('data-cp'));
                $(targetElement5).val(list.last().attr('data-unit'));

                const path = window.location.pathname;
                const pathSegments = path.split("/");

                if(pathSegments[3] === 'issue'){
                    $(targetElement7).val(list.last().attr('data-mrp') * qty);
                }
                else if(pathSegments[3] === 'purchase'){
                    $(targetElement7).val(list.last().attr('data-cp') * qty);
                }
            } 
            else if (e.keyCode === 13) { // Enter key
                e.preventDefault();
            } 
            else if (e.keyCode === 9) { // Tab key
                $(targetElement2).html('');
            }
        }
    }


    // Product List Key Down Event function
    function ProductListKeyDown(e, list, focused, targetElement1, targetElement2, targetElement3, targetElement4, targetElement5, targetElement6, targetElement7) {
        let qty = $(targetElement6).val();
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            let nextIndex = focused.index() + 1;
            if (nextIndex >= list.length) {
                nextIndex = 0; // Loop to the first item
            }
            list.eq(nextIndex).focus();
            $(targetElement1).val(list.eq(nextIndex).find('td:first').text());
            $(targetElement1).attr("data-id", list.eq(nextIndex).data('id'));
            $(targetElement1).attr("data-groupe", list.eq(nextIndex).data('groupe'));
            $(targetElement5).attr('data-id',list.data('unit-id'));
            $(targetElement3).val(list.eq(nextIndex).attr('data-mrp'));
            $(targetElement4).val(list.eq(nextIndex).attr('data-cp'));
            $(targetElement5).val(list.eq(nextIndex).attr('data-unit'));

            const path = window.location.pathname;
            const pathSegments = path.split("/");
            
            if(pathSegments[3] === 'issue'){
                $(targetElement7).val(list.eq(nextIndex).attr('data-mrp') * qty);
            }
            else if(pathSegments[3] === 'purchase'){
                $(targetElement7).val(list.eq(nextIndex).attr('data-cp') * qty);
            }
        } 
        else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            let prevIndex = focused.index() - 1;
            if (prevIndex < 0) {
                prevIndex = list.length - 1; // Loop to the last item
            }
            list.eq(prevIndex).focus();
            $(targetElement1).val(list.eq(prevIndex).find('td:first').text());
            $(targetElement1).attr("data-id", list.eq(prevIndex).data('id'));
            $(targetElement1).attr("data-groupe", list.eq(prevIndex).data('groupe'));
            $(targetElement5).attr('data-id',list.data('unit-id'));
            $(targetElement3).val(list.eq(prevIndex).attr('data-mrp'));
            $(targetElement4).val(list.eq(prevIndex).attr('data-cp'));
            $(targetElement5).val(list.eq(prevIndex).attr('data-unit'));

            const path = window.location.pathname;
            const pathSegments = path.split("/");
            
            if(pathSegments[3] === 'issue'){
                $(targetElement7).val(list.eq(prevIndex).attr('data-mrp') * qty);
            }
            else if(pathSegments[3] === 'purchase'){
                $(targetElement7).val(list.eq(prevIndex).attr('data-cp') * qty);
            }
        } 
        else if (e.keyCode === 13) { // Enter key
            e.preventDefault();
            $(targetElement2).html('');
            $(targetElement1).focus();
        }
        else if (e.keyCode === 9) { // Tab key
            e.preventDefault();
        }
    }


    // Search Product by Name
    function getProductByGroupe(groupe, groupein, product, targetElement1) {
        $.ajax({
            url: `${apiUrl}/inventory/setup/product/get`,
            method: 'GET',
            data: { groupe, groupein, product },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }

    /////////////// ------------------ Search Head By Name And Groupe add value to input ajax part end ---------------- /////////////////////////////





    /////////////// ------------------ Search Batch Id and add value to input ajax part start ---------------- /////////////////////////////
    //Batch Keyup Event
    $(document).off('keyup', '#batch').on('keyup', '#batch', function (e) {
        let batch = $(this).val();
        let id = $(this).attr('data-id');
        BatchKeyUp(e, batch, id, '#batch', '#batch-list ul');
        $('#batch-details-list tbody').html('');
    });

    // Batch Key down Event
    $(document).off('keydown', '#batch').on('keydown', '#batch', function (e) {
        let list = $('#batch-list ul li');
        BatchKeyDown(e, list, '#batch', '#batch-list ul');
    });


    // Batch List Key down Event
    $(document).off('keydown', '#batch-list ul li').on('keydown', '#batch-list ul li', function (e) {
        let list = $('#batch-list ul li');
        let focused = $('#batch-list ul li:focus');
        BatchListKeyDown(e, list, focused, '#batch', '#batch-list ul');
    });


    // Batch Focus Event
    $(document).off('focus', '#batch').on('focus', '#batch', function (e) {
        let batch = $(this).val();
        let id = $(this).attr('data-id');
        if(id == undefined){
            getBatch(batch, '#batch-list ul');
        }
        else{
            getBatchDetails(id, '#batch-details-list tbody');
        }
    });


    // Batch Focous out event
    $(document).off('focusout', '#batch').on('focusout', '#batch', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#batch-list ul').html('');
                }
            });
        }
    });


    // Batch List Click Event
    $(document).off('click', '#batch-list li').on('click', '#batch-list li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#batch').val(value);
        $('#batch').attr('data-id', id);
        $('#batch-list ul').html('');
        $('#batch').focus();
    });



    // Update Batch Keyup event
    $(document).off('keyup', '#updateBatch').on('keyup', '#updateBatch', function (e) {
        let batch = $(this).val();
        let id = $(this).attr('data-id');
        BatchKeyUp(e, batch, id, '#updateBatch',  '#update-batch ul');
    });



    // Update Batch Keydown event
    $(document).off('keydown', '#updateBatch').on('keydown', '#updateBatch', function (e) {
        let list = $('#update-batch ul li');
        BatchKeyDown(e, list, '#updateBatch', '#update-batch ul');
    });



    // Update Batch List Keydown event
    $(document).off('keydown', '#update-batch ul li').on('keydown', '#update-batch ul li', function (e) {
        let list = $('#update-batch ul li');
        let focused = $('#update-batch ul li:focus');
        BatchListKeyDown(e, list, focused, '#updateBatch', '#update-batch ul');
    });



    // Update Batch Focus Event
    $(document).off('focus', '#updateBatch').on('focus', '#updateBatch', function (e) {
        let batch = $(this).val();
        let id = $(this).attr('data-id');
        if(id == undefined){
            getBatch(batch, '#update-batch ul');
        }
        else{
            getBatchDetails(id, '#update-batch-details-list tbody');
        }
    });


    
    // Update Batch Focousout event
    $(document).off('focusout', '#updateBatch').on('focusout', '#updateBatch', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#update-batch ul').html('');
                }
            });
        }
    });


    // Update Batch Click Event
    $(document).off('click', '#update-batch li').on('click', '#update-batch li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#updateBatch').val(value);
        $('#updateBatch').attr('data-id', id);
        $('#update-batch ul').html('');
        $('#updateBatch').focus();
    });



    // Batch Key Up Event Function
    function BatchKeyUp(e, batch, id, targetElement1, targetElement2){
        if (e.keyCode === 13) { // Enter Key
            e.preventDefault();
        }
        else if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 8){
            //keyCode 65 = a, keyCode 90 = z, keyCode 96 = 0, keyCode 105 = 9, keyCode 8 = backSpace
            $(targetElement1).removeAttr('data-id');
            getBatch(batch, targetElement2);
        }
        else if (e.keyCode === 9) { // Tab key
            if (id != undefined) {
                e.preventDefault();
            }
            else{
                $(targetElement1).removeAttr('data-id');
                getBatch(batch, targetElement2);
            }
        }
    }


    // Batch Key Down Event Function
    function BatchKeyDown(e, list, targetElement1, targetElement2) {
        if (list.length > 0) {
            if (e.keyCode === 40) { // Down arrow key
                e.preventDefault();
                list.first().focus();
                $(targetElement1).val(list.first().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 38) { // Up arrow key
                e.preventDefault();
                list.last().focus();
                $(targetElement1).val(list.last().text());
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 13) { // Enter key
                e.preventDefault();
            } 
            else if (e.keyCode === 9) { // Tab key
                $(targetElement2).html('');
            }
        }
    }


    // Batch List Key Down Event function
    function BatchListKeyDown(e, list, focused, targetElement1, targetElement2) {
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            let nextIndex = focused.index() + 1;
            if (nextIndex >= list.length) {
                nextIndex = 0; // Loop to the first item
            }
            list.eq(nextIndex).focus();
            $(targetElement1).val(list.eq(nextIndex).text());
            $(targetElement1).attr("data-id", list.eq(nextIndex).data('id'));
        } 
        else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            let prevIndex = focused.index() - 1;
            if (prevIndex < 0) {
                prevIndex = list.length - 1; // Loop to the last item
            }
            list.eq(prevIndex).focus();
            $(targetElement1).val(list.eq(prevIndex).text());
            $(targetElement1).attr("data-id", list.eq(prevIndex).data('id'));
        } 
        else if (e.keyCode === 13) { // Enter key
            e.preventDefault();
            $(targetElement2).html('');
            $(targetElement1).focus();
        }
    }



    // Search Batch Id
    function getBatch(batch, targetElement1) {
        let type = $('#type').val();
        let method = $('#method').val();
        $.ajax({
            url: `${apiUrl}/transaction/get/batch`,
            method: 'GET',
            data: { batch, type, method },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }


    // Get Batch Details
    function getBatchDetails(batch, targetElement1) {
        $.ajax({
            url: `${apiUrl}/transaction/get/batch/details`,
            method: 'GET',
            data: { batch },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }


    // Select batch item to return 
    $(document).off('click', '.batch-table tbody tr').on('click', '.batch-table tbody tr', function (e) {
        $('#product').val($(this).attr('data-name'))
        $('#product').attr("data-id", $(this).attr('data-id'))
        $('#product').attr("data-groupe",$(this).attr('data-groupe'))
        $('#product').attr("data-batch",$(this).attr('data-batch'))
        $('#product').attr("data-quantity",$(this).attr('data-quantity'))
        $('#quantity').val($(this).attr('data-quantity'))
        $('#price').val($(this).attr('data-price'))
        $('#totAmount').val($(this).attr('data-tot'))
        $('#quantity').focus();
    });

    /////////////// ------------------ Search Batch Id and add value to input ajax part End ---------------- /////////////////////////////
    
    
    
    
    
    
    /////////////// ------------------ Search Product Batch Id and add value to input ajax part start ---------------- /////////////////////////////
    //Batch Keyup Event
    $(document).off('keyup', '#pbatch').on('keyup', '#pbatch', function (e) {
        let batch = $(this).val();
        let id = $(this).attr('data-id');
        let product = $('#product').attr('data-id');
        PBatchKeyUp(e, batch, id, product, '#pbatch', '#pbatch-list ul');
        $('#pbatch-details-list tbody').html('');
    });

    // Batch Key down Event
    $(document).off('keydown', '#pbatch').on('keydown', '#pbatch', function (e) {
        let list = $('#pbatch-list ul li');
        PBatchKeyDown(e, list, '#pbatch', '#pbatch-list ul');
    });


    // Batch List Key down Event
    $(document).off('keydown', '#pbatch-list ul li').on('keydown', '#pbatch-list ul li', function (e) {
        let list = $('#pbatch-list ul li');
        let focused = $('#pbatch-list ul li:focus');
        PBatchListKeyDown(e, list, focused, '#pbatch', '#pbatch-list ul');
    });


    // Batch Focus Event
    $(document).off('focus', '#pbatch').on('focus', '#pbatch', function (e) {
        let batch = $(this).val();
        let id = $(this).attr('data-id');
        let product = $('#product').attr('data-id');
        if(id == undefined && product != undefined){
            getProductBatch(batch, product, '#pbatch-list ul');
        }
        else if(product == undefined){
            $('#pbatch-list ul').html('<li>Select Product First </li>')
        }
    });


    // Batch Focous out event
    $(document).off('focusout', '#pbatch').on('focusout', '#pbatch', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#pbatch-list ul').html('');
                }
            });
        }
    });


    // Batch List Click Event
    $(document).off('click', '#pbatch-list li').on('click', '#pbatch-list li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#pbatch').val(id);
        $('#pbatch').attr('data-id', id);
        $('#pbatch-list ul').html('');
        $('#pbatch').focus();
    });



    // Update Batch Keyup event
    $(document).off('keyup', '#updatePbatch').on('keyup', '#updatePbatch', function (e) {
        let batch = $(this).val();
        let id = $(this).attr('data-id');
        let product = $('#updateProduct').attr('data-id');
        PBatchKeyUp(e, batch, id, product, '#updatePbatch',  '#update-pbatch ul');
    });



    // Update Batch Keydown event
    $(document).off('keydown', '#updatePbatch').on('keydown', '#updatePbatch', function (e) {
        let list = $('#update-pbatch ul li');
        PBatchKeyDown(e, list, '#updatePbatch', '#update-pbatch ul');
    });



    // Update Batch List Keydown event
    $(document).off('keydown', '#update-pbatch ul li').on('keydown', '#update-pbatch ul li', function (e) {
        let list = $('#update-pbatch ul li');
        let focused = $('#update-pbatch ul li:focus');
        PBatchListKeyDown(e, list, focused, '#updatePbatch', '#update-pbatch ul');
    });



    // Update Batch Focus Event
    $(document).off('focus', '#updatePbatch').on('focus', '#updatePbatch', function (e) {
        let batch = $(this).val();
        let id = $(this).attr('data-id');
        let product = $('#updateProduct').attr('data-id');
        if(id == undefined && product != undefined){
            getProductBatch(batch, product, '#update-pbatch ul');
        }
        else{
            $('#update-pbatch ul').html('<li>Select Product First </li>')
        }
    });


    
    // Update Batch Focousout event
    $(document).off('focusout', '#updatePbatch').on('focusout', '#updatePbatch', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#update-pbatch ul').html('');
                }
            });
        }
    });


    // Update Batch Click Event
    $(document).off('click', '#update-pbatch li').on('click', '#update-pbatch li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#updatePbatch').val(id);
        $('#updatePbatch').attr('data-id', id);
        $('#update-pbatch ul').html('');
        $('#updatePbatch').focus();
    });



    // Batch Key Up Event Function
    function PBatchKeyUp(e, batch, id, product, targetElement1, targetElement2){
        if(product != undefined){
            if (e.keyCode === 13) { // Enter Key
                e.preventDefault();
            }
            else if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 8){
                //keyCode 65 = a, keyCode 90 = z, keyCode 96 = 0, keyCode 105 = 9, keyCode 8 = backSpace
                $(targetElement1).removeAttr('data-id');
                getProductBatch(batch, product, targetElement2);
            }
            else if (e.keyCode === 9) { // Tab key
                if (id != undefined) {
                    e.preventDefault();
                }
                else{
                    $(targetElement1).removeAttr('data-id');
                    getProductBatch(batch, product, targetElement2);
                }
            }
        }
        else{
            $('#pbatch-list ul').html('<li>Select Product First </li>')
        }
    }


    // Batch Key Down Event Function
    function PBatchKeyDown(e, list, targetElement1, targetElement2) {
        if (list.length > 0) {
            if (e.keyCode === 40) { // Down arrow key
                e.preventDefault();
                list.first().focus();
                $(targetElement1).val(list.first().attr('data-id'));
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 38) { // Up arrow key
                e.preventDefault();
                list.last().focus();
                $(targetElement1).val(list.last().attr('data-id'));
                $(targetElement1).attr("data-id", list.data('id'));
            } 
            else if (e.keyCode === 13) { // Enter key
                e.preventDefault();
            } 
            else if (e.keyCode === 9) { // Tab key
                $(targetElement2).html('');
            }
        }
    }


    // Batch List Key Down Event function
    function PBatchListKeyDown(e, list, focused, targetElement1, targetElement2) {
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            let nextIndex = focused.index() + 1;
            if (nextIndex >= list.length) {
                nextIndex = 0; // Loop to the first item
            }
            list.eq(nextIndex).focus();
            $(targetElement1).val(list.eq(nextIndex).attr('data-id'));
            $(targetElement1).attr("data-id", list.eq(nextIndex).data('id'));
        } 
        else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            let prevIndex = focused.index() - 1;
            if (prevIndex < 0) {
                prevIndex = list.length - 1; // Loop to the last item
            }
            list.eq(prevIndex).focus();
            $(targetElement1).val(list.eq(prevIndex).attr('data-id'));
            $(targetElement1).attr("data-id", list.eq(prevIndex).data('id'));
        } 
        else if (e.keyCode === 13) { // Enter key
            e.preventDefault();
            $(targetElement2).html('');
            $(targetElement1).focus();
        }
    }



    // Search Product Batch Id
    function getProductBatch(batch, product, targetElement1) {
        $.ajax({
            url: `${apiUrl}/transaction/get/productbatch`,
            method: 'GET',
            data: { batch, product },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }


    // // Get Batch Details
    // function getBatchDetails(batch, targetElement1) {
    //     $.ajax({
    //         url: `${apiUrl}/transaction/get/batch/details`,
    //         method: 'GET',
    //         data: { batch },
    //         success: function (res) {
    //             $(targetElement1).html(res);
    //         }
    //     });
    // }


    // // Select batch item to return 
    // $(document).off('click', '.batch-table tbody tr').on('click', '.batch-table tbody tr', function (e) {
    //     $('#product').val($(this).attr('data-name'))
    //     $('#product').attr("data-id", $(this).attr('data-id'))
    //     $('#product').attr("data-groupe",$(this).attr('data-groupe'))
    //     $('#product').attr("data-batch",$(this).attr('data-batch'))
    //     $('#product').attr("data-quantity",$(this).attr('data-quantity'))
    //     $('#quantity').val($(this).attr('data-quantity'))
    //     $('#price').val($(this).attr('data-price'))
    //     $('#totAmount').val($(this).attr('data-tot'))
    //     $('#quantity').focus();
    // });

    /////////////// ------------------ Search Product Batch Id and add value to input ajax part End ---------------- /////////////////////////////
});