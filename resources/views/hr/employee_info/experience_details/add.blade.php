<div id="addModal" class="modal-container">
    <div class="modal-subject" style="width: 80%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3 class="card-title">Add Experience Detail</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>
        <br>
        
        <!-- form start -->
        <form id='AddForm' enctype="multipart/form-data">
            @csrf
            @method('POST')
            
            <div class="rows">
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="with">Employee Type <span class="required" title="Required">*</span></label>
                        <select name="with" id="with">
                            
                        </select>
                        <span class="error" id="with_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="user">Name <span class="required" title="Required">*</span></label>
                        <input type="text" name="user" class="form-input" id="user" autocomplete="off">
                        <div id="user-list">
                            <ul>

                            </ul>
                        </div>
                        <span class="error" id="user_error"></span>
                    </div>
                </div>

                <div class="c-6">
                    <div class="form-input-group">
                        <label for="company_name_0">Company Name <span class="required" title="Required">*</span></label>
                        <input type="text" name="company_name[]" id="company_name_0" class="form-input">
                        <span class="error" id="company_name_0_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="department_0">Department <span class="required" title="Required">*</span></label>
                        <input type="text" name="department[]" id="department_0" class="form-input">
                        <span class="error" id="department_0_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="designation">Designation <span class="required" title="Required">*</span></label>
                        <input type="text" name="designation[]" id="designation" class="form-input">
                        <span class="error" id="designation_0_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="company_location_0">Company Address <span class="required" title="Required">*</span></label>
                        <input type="text" name="company_location[]" id="company_location_0" class="form-input">
                        <span class="error" id="company_location_0_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="start_date_0">Start Date</label>
                        <input type="date" name="start_date[]" id="start_date_0" class="form-input">
                        <span class="error" id="start_date_0_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="end_date_0">End Date</label>
                        <input type="date" name="end_date[]" id="end_date_0" class="form-input">
                        <span class="error" id="end_date_0_error"></span>
                    </div>
                </div>
            </div>

            <div id="formContainer"></div>

            <div>
                <button type="button" name="addExperience" id="addExperience" class="btn-blue">Add+</button>
            </div>
            <div class="center">
                <button type="submit" id="Insert" class="btn-blue">Save</button>
            </div>
        </form>
    </div>
</div>