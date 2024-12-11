<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 80%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit Organization Detail</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="EditForm" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="rows">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="emp_id" id="emp_id">
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_joining_date">Joining Date</label>
                        <input type="date" name="joining_date" id="update_joining_date" class="form-input">
                        <span class="error" id="update_joining_date_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateLocation">Joining Location</label>
                        <input type="text" name="location" id="updateLocation" class="form-input">
                        <div id="update-location">
                            <ul>

                            </ul>
                        </div>
                        <span class="error" id="update_location_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateDepartment">Department</label>
                        <input type="text" name="department" id="updateDepartment" class="form-input">
                        <div id="update-department">
                            <ul>

                            </ul>
                        </div>
                        <span class="error" id="update_department_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateDesignation">Designation</label>
                        <input type="text" name="designation" id="updateDesignation" class="form-input">
                        <div id="update-designation">
                            <ul>

                            </ul>
                        </div>
                        <span class="error" id="update_designation_error"></span>
                    </div>
                </div>
                <div class="center">
                    <button type="submit" class="btn-blue" id="Update">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>