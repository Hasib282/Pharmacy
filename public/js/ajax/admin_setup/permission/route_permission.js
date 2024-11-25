function ShowPermissionMainheads(data, startIndex) {
    let tableRows = '';

    if(data.length > 0){
        $.each(data, function(key, item) {
            let routeNames = '';

            // Loop through item.routes and concatenate the route names
            $.each(item.routes, function (key, route) {
                routeNames += `${route.route_name}, `;
            });

            // Remove the trailing comma and space if there are route names
            routeNames = routeNames.slice(0, -2);
            tableRows += `
                <tr>
                    <td style="width: 4%;">${startIndex + key + 1}</td>
                    <td style="width: 20%;">${item.name}</td>
                    <td>
                        ${routeNames}
                    </td>
                    <td style="width: 10%;">
                        <div style="display: flex;gap:5px;">
                            <button class="open-modal" data-modal-id="editModal" id="edit"
                                    data-id="${item.id }"><i class="fas fa-edit"></i> Assign</button>
                        </div>
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
        $('.load-data .show-table tfoot').html('<tr><td colspan="8" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Load Data on Hard Reload
    ReloadData('admin/permission/routepermissions', ShowPermissionMainheads);


    //Edit Ajax
    EditAjax('admin/permission/routepermissions', EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/permission/routepermissions', ShowPermissionMainheads, {}, function() {
        $('#select-all').prop('checked', false);
    });


    // Pagination Ajax
    PaginationAjax(ShowPermissionMainheads);


    // Search Ajax
    SearchAjax('admin/permission/routepermissions', ShowPermissionMainheads, {  });


    // Additional Edit Functionality
    function EditFormInputValue(res){
        $('#permissionid').text(`Permission Name: ${res.permission.name}`);
        $('#permission').val(res.permission.id);
        
        $('#route-container').html('');
        $.each(res.routeDetails, function (key, route) {
            $('#route-container').append(`
                <div class="c-4">
                    <label for="routes-${route['name']}">
                        <input type="checkbox" id="routes-${route['name']}" class="route" name="routes[]" value="${route['name']}" ${res.permissionroute.includes(route['name']) ? 'checked' : ''} } />
                        ${route['name']}
                    </label>
                </div>
            `);
        });
    }


    
    $(document).off('click', '#select-all').on('click', '#select-all', function() {
        $('.route').prop('checked', this.checked);
    });



    // Individual checkboxes click handler
    $(document).off('click', '.route').on('click', '.route', function() {
        if ($('.route:checked').length === $('.route').length) {
            $('#select-all').prop('checked', true);
        } else {
            $('#select-all').prop('checked', false);
        }
    });
});