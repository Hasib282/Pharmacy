function ShowEmployees(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['user_id','user_name','withs.tran_with_name',{key:'dob', type: 'date'},'gender','user_email', 'user_phone','address',{key:'image', type: 'image'},{key:'status', type: 'status'}],
        actions: (row) => `
                
                
                <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                `,
        actions: (row) => {
            let buttons = '';

            buttons += `
                    <button class="open-modal" data-modal-id="detailsModal" id="details" data-id="${row.user_id}"><i class="fa-solid fa-circle-info"></i></button>
                `;
            
            if (userPermissions.includes(71) || role == 1) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }
            
            if (userPermissions.includes(72) || role == 1) {
                buttons += `
                <button data-id="${row.id}" id="delete_status" class="icon-wrapper" title="Toggle Delete"><i class="fa-solid fa-trash-arrow-up main-icon"></i><i class="fa-solid fa-arrows-rotate ring-icon"></i></button>
                `;
                
                if (role == 1 || role == 2) {
                    buttons += `
                        <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                    `;
                }
            }
        
            return buttons;
        }
    });
}




$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Id', key: 'user_id' },
        { label: 'Name', key: 'user_name' },
        { label: 'Employee Type', key: 'withs.tran_with_name' },
        { label: 'DOB', key: 'dob', type:"date" },
        { label: 'Gender', type:"select", key: 'gender', method:"custom", options:['Male','Female','Others'] },
        { label: 'Email', key: 'user_email' },
        { label: 'Phone', key: 'user_phone' },
        { label: 'Address', key: 'address' },
        { label: 'Image' },
        { label: 'Status', status: [{key:1, label:'Active' }, { key:0, label:'Inactive'}] },
        { label: 'Action', type: 'button' }
    ]);


    // Load Data on Hard Reload
    ReloadData('hr/employee/all', ShowEmployees);
    

    // Delete Ajax
    DeleteAjax('hr/employee/all');
    

    // Delete Ajax
    DeleteAjax('hr/employee/all');
    

    // Delete status Ajax
    DeleteStatusAjax('hr/employee/all');


    // Show Detals Ajax
    DetailsAjax('hr/employee/all');
});