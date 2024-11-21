$(document).ready(function () {
    PaginationAjax({ type:'5', method:'Purchase' });

    SearchAjax({ type:'5', method:'Purchase' });
    
    SearchByDateAjax({ type:'5', method:'Purchase' });

    SearchPaginationAjax({ type:'5', method:'Purchase' });
});