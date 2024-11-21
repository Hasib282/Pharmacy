$(document).ready(function () {
    PaginationAjax({ type:'5', method:'Issue' });

    SearchAjax({ type:'5', method:'Issue' });
    
    SearchByDateAjax({ type:'5', method:'Issue' });

    SearchPaginationAjax({ type:'5', method:'Issue' });
});