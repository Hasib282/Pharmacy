<div id="editModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit Designation</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="EditForm" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="id">
            <div class="form-input-group">
                <label for="updateDesignations">Designation</label>
                <input type="text" name="designations" class="form-input" id="updateDesignations">
                <span class="error" id="update_designations_error"></span>
            </div>
            <div class="form-input-group">
                <label for="updateDepartment">Department</label>
                <input type="text" name="department" class="form-input" id="updateDepartment" autocomplete="off">
                <div id="update-department">
                    <ul>

                    </ul>
                </div>
                <span class="error" id="update_department_error"></span>
            </div>
            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</div>