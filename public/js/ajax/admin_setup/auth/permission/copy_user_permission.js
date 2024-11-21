$(document).ready(function () {
    $(document).off('click', '#permissionCopy').on('click', '#permissionCopy', function(){
        $('#copyPermission').show();
        $('#from').val('');
        $('#from').removeAttr('data-id');
        $('#to').val('');
        $('#to').removeAttr('data-id');
    });


    $(document).off('click','#AssignCopy').on('click','#AssignCopy', function(e){
        e.preventDefault();
        let from = $('#from').attr('data-id');
        let to = $('#to').attr('data-id');
        $.ajax({
            url: `${apiUrl}/admin/auth/permission/userpermissions/copy`,
            method: 'PUT',
            data: { from, to },
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status) {
                    $('#CopyForm')[0].reset();
                    $('#from').removeAttr('data-id');
                    $('#to').removeAttr('data-id');
                    $('#from').focus();
                    $('#search').val('');
                    ReloadData('admin/auth/permission/userpermissions', ShowUserPermissions);
                    toastr.success(res.message, 'Copy!');
                }
            }
        });
    });





    /////////////// ------------------ Search From User Name and add value to input ajax part start ---------------- /////////////////////////////
    // From User Keyup Event
    $(document).off('keyup', '#from').on('keyup', '#from', function (e) {
        let from = $(this).val();
        let id = $(this).attr('data-id');
        FromUserKeyUp(e, from, id, '#from', '#from-list ul');
    });


    // From User Keydown Event
    $(document).off('keydown', '#from').on('keydown', '#from', function (e) {
        let list = $('#from-list ul li');
        FromUserKeyDown(e, list, '#from', '#from-list ul');
    });


    // From User List keydown Event
    $(document).off('keydown', '#from-list ul li').on('keydown', '#from-list ul li', function (e) {
        let list = $('#from-list ul li');
        let focused = $('#from-list ul li:focus');
        FromUserListKeyDown(e, list, focused, '#from', '#from-list ul');
    });


    // From User List Click Event
    $(document).off('click', '#from-list li').on('click', '#from-list li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#from').val(value);
        $('#from').attr('data-id', id);
        $('#from-list ul').html('');
    });


    // From User Focus Event
    $(document).off('focus', '#from').on('focus', '#from', function (e) {
        let from = $(this).val();
        let id = $(this).attr('data-id');
        if(id == undefined){
            getFromUserByName(from, '#from-list ul');
        }
        else{
            e.preventDefault();
        }
    });


    // From User Focousout event
    $(document).off('focusout', '#from').on('focusout', '#from', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#from-list ul').html('');
                }
            });
        }
    });


    // From User Keyup Event Function
    function FromUserKeyUp(e, from, id, targetElement1, targetElement2){
        if (e.keyCode === 13) { // Enter Key
            e.preventDefault();
        }
        else if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 8){
            //keyCode 65 = a, keyCode 90 = z, keyCode 96 = 0, keyCode 105 = 9, keyCode 8 = backSpace
            $(targetElement1).removeAttr('data-id');
            getFromUserByName(from, targetElement2);
        }
        else if (e.keyCode === 9) { // Tab key
            if (id != undefined) {
                e.preventDefault();
            }
            else{
                $(targetElement1).removeAttr('data-id');
                getFromUserByName(from, targetElement2);
            }
        }
    }


    // From User Keydown Event Function
    function FromUserKeyDown(e, list, targetElement1, targetElement2) {
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
    

    // From User List Keydown Event function
    function FromUserListKeyDown(e, list, focused, targetElement1, targetElement2) {
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

    // Search From User by Upazila
    function getFromUserByName(from, targetElement1) {
        $.ajax({
            url: `${apiUrl}/admin/auth/permission/userpermissions/from`,
            method: 'GET',
            data: { from },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }
    /////////////// ------------------ Search From User Name and add value to input ajax part end ---------------- /////////////////////////////





    /////////////// ------------------ Search To User Name and add value to input ajax part start ---------------- /////////////////////////////
    // To User Keyup Event
    $(document).off('keyup', '#to').on('keyup', '#to', function (e) {
        let to = $(this).val();
        let id = $(this).attr('data-id');
        ToUserKeyUp(e, to, id, '#to', '#to-list ul');
    });


    // To User Keydown Event
    $(document).off('keydown', '#to').on('keydown', '#to', function (e) {
        let list = $('#to-list ul li');
        ToUserKeyDown(e, list, '#to', '#to-list ul');
    });


    // To User List keydown Event
    $(document).off('keydown', '#to-list ul li').on('keydown', '#to-list ul li', function (e) {
        let list = $('#to-list ul li');
        let focused = $('#to-list ul li:focus');
        ToUserListKeyDown(e, list, focused, '#to', '#to-list ul');
    });


    // To User List Click Event
    $(document).off('click', '#to-list li').on('click', '#to-list li', function () {
        let value = $(this).text();
        let id = $(this).data('id');
        $('#to').val(value);
        $('#to').attr('data-id', id);
        $('#to-list ul').html('');
    });


    // To User Focus Event
    $(document).off('focus', '#to').on('focus', '#to', function (e) {
        let to = $(this).val();
        let id = $(this).attr('data-id');
        if(id == undefined){
            getToUserByName(to, '#to-list ul');
        }
        else{
            e.preventDefault();
        }
    });


    // To User Focousout event
    $(document).off('focusout', '#to').on('focusout', '#to', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#to-list ul').html('');
                }
            });
        }
    });


    // To User Keyup Event Function
    function ToUserKeyUp(e, to, id, targetElement1, targetElement2){
        if (e.keyCode === 13) { // Enter Key
            e.preventDefault();
        }
        else if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 8){
            //keyCode 65 = a, keyCode 90 = z, keyCode 96 = 0, keyCode 105 = 9, keyCode 8 = backSpace
            $(targetElement1).removeAttr('data-id');
            getToUserByName(to, targetElement2);
        }
        else if (e.keyCode === 9) { // Tab key
            if (id != undefined) {
                e.preventDefault();
            }
            else{
                $(targetElement1).removeAttr('data-id');
                getToUserByName(to, targetElement2);
            }
        }
    }


    // To User Keydown Event Function
    function ToUserKeyDown(e, list, targetElement1, targetElement2) {
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
    

    // To User List Keydown Event function
    function ToUserListKeyDown(e, list, focused, targetElement1, targetElement2) {
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

    // Search To User by Upazila
    function getToUserByName(to, targetElement1) {
        $.ajax({
            url: `${apiUrl}/admin/auth/permission/userpermissions/to`,
            method: 'GET',
            data: { to },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }
    /////////////// ------------------ Search To User Name and add value to input ajax part end ---------------- /////////////////////////////
});