function ShowCompanies(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['company_id','company_name','type.name','company_email', 'company_phone','address','domain',{key:'logo', type: 'image'}],
        actions: (row) => `
                <button class="open-modal" data-modal-id="detailsModal" id="details" data-id="${row.id}"><i class="fa-solid fa-circle-info"></i></button>
                
                <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                        
                <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                `,
    });
}



$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Company Id', key: 'company_id' },
        { label: 'Name', key: 'company_name' },
        { label: 'Type Name', type:"select", key: 'company_type', method:"fetch", link:'admin/companytype/get', name:"name" },
        { label: 'Email', key: 'company_email' },
        { label: 'Phone', key: 'company_phone' },
        { label: 'Address', key: 'address' },
        { label: 'Domain', key: 'domain' },
        { label: 'Logo' },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('admin/companies', ShowCompanies);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#type");


    // Insert Ajax
    InsertAjax('admin/companies', {}, function() {
        $('#type').focus();
    });


    // Edit Ajax
    EditAjax(EditFormInputValue);


    // Update Ajax
    UpdateAjax('admin/companies');
    

    // Delete Ajax
    DeleteAjax('admin/companies');


    // Additional Edit Functionality
    function EditFormInputValue(item){
        $('#id').val(item.id);
        $('#updateType').val(item.company_type);
        $('#updateName').val(item.company_name);
        $('#updatePhone').val(item.company_phone);
        $('#updateEmail').val(item.company_email);
        $('#updateAddress').val(item.address);
        $('#updateDomain').val(item.domain);
        $('#updateWebsite').val(item.website);
        $('#updatePreviewImage').attr('src',`${apiUrl.replace('/api', '')}/storage/${item.logo ? item.logo : 'tsbd.png'}?${new Date().getTime()} `).show();
        $('#updateName').focus();
    }; // End Method


    // Show Detals Ajax
    DetailsAjax('admin/companies');


    // Get Company Type
    GetSelectInputList('admin/companytype/get', function (res) {
        CreateSelectOptions('#type', 'Select Company Type', res.data, 'name');
        CreateSelectOptions('#updateType', 'Select Company Type', res.data, 'name');
    })
});