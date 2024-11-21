$(document).ready(function () {
    $(document).on('click', '.add', function (e) {
        $('#name').focus();
    });

    //Show Employee Details on Details Modal
    $(document).on('click', '.showEmployeeDetails', function (e) {
        let modal = $(this).attr('data-modal-id');
        let id = $(this).attr('data-id');
        $.ajax({
            url: urls.detail,
            method: 'GET',
            data: { id },
            success: function (res) {
                $("#"+ modal).show();
                $('.details').html(res.data)
            },
            error: function (err) {
                console.log(err)
            }
        });
    });


    // Show Employee Details List Toggle Functionality
    $(document).on('click', '.details li', function(e){
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
            if($('.education').is(':visible')){
                $('.education').hide()
            }
            else{
                $('.education').show();
            }
        }
        else if(id == 3){
            if($('.training').is(':visible')){
                $('.training').hide()
            }
            else{
                $('.training').show();
            }
        }
        else if(id == 4){
            if($('.experience').is(':visible')){
                $('.experience').hide()
            }
            else{
                $('.experience').show();
            }
        }
        else if(id == 5){
            if($('.organization').is(':visible')){
                $('.organization').hide()
            }
            else{
                $('.organization').show();
            }
        }
        else if(id == 6){
            if($('.payroll').is(':visible')){
                $('.payroll').hide()
            }
            else{
                $('.payroll').show();
            }
        }
    });


    DeleteAjax('Employee Details Deleted', 'Deleted!');

    PaginationAjax({  });

    SearchAjax({  });

    SearchPaginationAjax({  });
});