function ShowRoomCatagory(res) {
    tableInstance = new GenerateTable({
        tableId: "#data-table",
        data: res.data,
        tbody: ["name"],
        actions: (row) => {
            let buttons = "";

            if (userPermissions.includes(301) || role == 1) {
                buttons += `
                    <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                `;
            }

            if (userPermissions.includes(302) || role == 1) {
                buttons += `
                <button data-id="${row.id}" id="delete_status" class="icon-wrapper" title="Toggle Delete"><i class="fa-solid fa-trash-arrow-up main-icon"></i><i class="fa-solid fa-arrows-rotate ring-icon"></i></button>
                `;
            }
            
            if (role == 1 || role == 2) {
                buttons += `
                    <button data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                `;
            }

            return buttons;
        },
    });
}

$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: "SL:", type: "rowsPerPage", options: [15, 30, 50, 100, 500] },
        { label: "Name", key: "name" },
        { label: "Action", type: "button" },
    ]);

    // Load Data on Hard Reload
    ReloadData("hotel/setup/roomcatagory", ShowRoomCatagory);

    // Insert Ajax
    InsertAjax("hotel/setup/roomcatagory", function () {
        $("#name").focus();
    });

    // Edit Ajax
    EditAjax(EditFormInputValue);

    // Update Ajax
    UpdateAjax("hotel/setup/roomcatagory");

    // Delete Ajax
    DeleteAjax("hotel/setup/roomcatagory");

    // Delete status Ajax
    DeleteStatusAjax("hotel/setup/roomcatagory");

    // Additional Edit Functionality
    function EditFormInputValue(item) {
        $("#id").val(item.id);
        $("#updateName").val(item.name);
    } // End Method
});
