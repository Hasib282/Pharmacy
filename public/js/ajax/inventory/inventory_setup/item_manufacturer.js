function ShowInventoryManufacturers(data, startIndex) {
    let tableRows = '';
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.manufacturer_name}</td>
                    ${role == 1 ? `<td>${item.company_id }</td>`: ''}
                    <td>
                        <div style="display: flex;gap:5px;">
                            <button class="open-modal" data-modal-id="editModal" id="edit"
                                data-id="${item.id}"><i class="fas fa-edit"></i></button>
                            <button data-id="${item.id}" id="delete"><i class="fas fa-trash"></i></button>
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



// Additional Edit Functionality
function EditFormInputValue(res){
    $('#id').val(res.data.id);
    $('#updateName').val(res.data.manufacturer_name);
    $('#updateName').focus();
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'select', options: [15, 30, 50, 100, 500] },
        { label: 'Company Id', key: 'company_id' },
        { label: 'Company Name', key: 'name' },
        { label: 'Permission', key: 'permission' },
        { label: 'Action', type: 'button' }
    ]);

    
    SingleInputDataCrudeAjax('inventory/setup/manufacturer', ShowInventoryManufacturers);
});