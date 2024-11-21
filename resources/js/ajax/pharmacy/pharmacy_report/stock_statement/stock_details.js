$(document).ready(function () {
    //on select option search value will be remove
    $(document).on('change', '#searchOption', function (e) {
        $('#search').val('');
        let searchOption = $('#searchOption').val();
        if(searchOption == 5){
            $('#search').attr('type', "date")
            let currentDate = new Date().toISOString().split('T')[0];
            $('#search').val(currentDate);
        }
        else{
            $('#search').attr('type', "text")
        }
    });
    
    PaginationAjax({  });

    SearchAjax({  });
    
    SearchByDateAjax({  });

    SearchPaginationAjax({  });
});