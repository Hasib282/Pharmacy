function ShowBedstatus(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['category.name','name', 'latest_booking.user.user_name', 'latest_booking.status'],
    });
};


$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Bed Catagory', key: 'category.name' },
        { label: 'Room Number', key: 'name' },
        { label: 'Guest Name', key: '' },
        { label: 'Status', key: 'status' },
    ]);


    // Load Data on Hard Reload
    ReloadData('hotel/bedstatus', ShowBedstatus);

});


