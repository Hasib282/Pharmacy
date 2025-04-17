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
                {{-- id --}}
                <input type="hidden" name="id" id="id">
                {{-- employee id  --}}
                <input type="hidden" name="emp_id" id="emp_id">
                {{-- joining date  --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_joining_date">Joining Date</label>
                        <input type="date" name="joining_date" id="update_joining_date" class="form-input">
                        <span class="error" id="update_joining_date_error"></span>
                    </div>
                </div>
                {{-- joining location --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateLocation">Joining Location</label>
                        <input type="text" name="location" id="updateLocation" class="form-input" autocomplete="off"><hr>
                        <div id="update-location"></div>
                        <span class="error" id="update_location_error"></span>
                    </div>
                </div>
                {{-- department --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateDepartment">Department</label>
                        <input type="text" name="department" id="updateDepartment" class="form-input" autocomplete="off"><hr>
                        <div id="update-department"></div>
                        <span class="error" id="update_department_error"></span>
                    </div>
                </div>
                {{-- designation --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateDesignation">Designation</label>
                        <input type="text" name="designation" id="updateDesignation" class="form-input" autocomplete="off"><hr>
                        <div id="update-designation"></div>
                        <span class="error" id="update_designation_error"></span>
                    </div>
                </div>
            </div>
            
            <div class="center">
                <button type="submit" class="btn-blue" id="Update">Update</button>
            </div>
        </form>
    </div>
</div>