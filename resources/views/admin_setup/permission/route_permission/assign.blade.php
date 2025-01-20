<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 80%">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Assign Route Permission</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="EditForm" method="post">
            @csrf
            @method('PUT')
            <h4 id="permissionid"></h4>
            <hr>
            <label style="float: right;">
                <input type="checkbox" id="select-all"> Select All
            </label>
            <input type="hidden" name="permission" id="permission">
            <div class="form-input-group">
                <div class="rows" id="route-container">

                </div>
            </div>
            <span class="error" id="update_routes_error"></span>
            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Assign</button>
            </div>
        </form>
    </div>
</div>