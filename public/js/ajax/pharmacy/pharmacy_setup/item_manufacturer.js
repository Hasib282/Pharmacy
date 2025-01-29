function ShowPharmacyManufacturers(data, startIndex) {
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
    $('#id').val(res.manufacturer.id);
    $('#updateName').val(res.manufacturer.manufacturer_name);
}



$(document).ready(function () {
    SingleInputDataCrudeAjax('pharmacy/setup/manufacturer', ShowPharmacyManufacturers);
});