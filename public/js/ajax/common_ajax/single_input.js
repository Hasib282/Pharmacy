function SingleInputDataCrudeAjax(link, RenderData){
    // Load Data on Hard Reload
    ReloadData(link, RenderData);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#name");


    // Insert Ajax
    InsertAjax(link, RenderData, {}, function() {
        $('#name').focus();
    });


    //Edit Ajax
    EditAjax(link, EditFormInputValue);


    // Update Ajax
    UpdateAjax(link, RenderData);
    

    // Delete Ajax
    DeleteAjax(link, RenderData);


    // Pagination Ajax
    PaginationAjax(RenderData);


    // Search Ajax
    SearchAjax(link, RenderData);
}