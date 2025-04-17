<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 80%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3 class="card-title">Edit Employee Experience Detail</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="EditForm" class="experience-form" method="POST">
            @csrf
            @method('put')
            <div class="rows">
                {{-- id  --}}
                <input type="hidden" name="id" id="id">
                {{-- employee id  --}}
                <input type="hidden" name="empId" id="empId">
                {{-- company --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_company_name">Company Name</label>
                        <input type="text" name="company_name" id="update_company_name" class="form-input">
                        <span class="error" id="update_company_name_error"></span>
                    </div>
                </div>
                {{-- department --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_department">Department</label>
                        <input type="text" name="department" id="update_department" class="form-input">
                        <span class="error" id="update_department_error"></span>
                    </div>
                </div>
                {{-- designation --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_designation">Designation</label>
                        <input type="text" name="designation" id="update_designation" class="form-input">
                        <span class="error" id="update_designation_error"></span>
                    </div>
                </div>
                {{-- company address  --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_company_location">Company Address</label>
                        <input type="text" name="company_location" id="update_company_location" class="form-input">
                        <span class="error" id="update_company_location_error"></span>
                    </div>
                </div>
                {{-- start date  --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_start_date">Start Date</label>
                        <input type="date" name="start_date" id="update_start_date" class="form-input">
                        <span class="error" id="update_start_date_error"></span>
                    </div>
                </div>
                {{-- end date  --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_end_date">End Date</label>
                        <input type="date" name="end_date" id="update_end_date" class="form-input">
                        <span class="error" id="update_end_date_error"></span>
                    </div>
                </div>
            </div>
            
            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</div>