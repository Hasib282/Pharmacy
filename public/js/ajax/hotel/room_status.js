function ShowBedStatus(res) {
    tableInstance = new GenerateTable({
        tableId: '#data-table',
        data: res.data,
        tbody: ['bed_category.name','name', 'latest_booking.user.user_name', {key:'latest_booking.status', type:'status-show', options:[{id:0, name:'Available'},{id:1, name:'Check-In'},{id:2, name:'Booked'},{id:3, name:'Maintenence'}]}],
    });
};


$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'SL:', type: 'rowsPerPage', options: [15, 30, 50, 100, 500] },
        { label: 'Room Catagory', key: 'bed_category.name' },
        { label: 'Room Number', key: 'name' },
        { label: 'Guest Name', key: '' },
        { label: 'Status', key:'latest_booking.status', type: 'select', method:'custom', options:[{val:0, text:'Available'},{val:1, text:'Check-In'},{val:2, text:'Booked'},{val:3, text:'Maintenence'}] },
    ]);


    // Load Data on Hard Reload
    ReloadData('hospital/bedstatus', ShowBedStatus);
});


