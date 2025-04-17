<div id="addModal" class="modal-container">
    <div class="modal-subject" style="width: 80%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Add Organization Detail</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>
        <br>
        <!-- form start -->
        <form id="AddForm" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="rows">
                {{-- type --}}
                <div class="c-6">
                    <div class="form-input-group">   
                        <label for="type">Employee Type <span class="required" title="Required">*</span></label>
                        <select name="type" id="type">
                            
                        </select>
                        <span class="error" id="type_error"></span>
                    </div>
                </div>
                {{-- name --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="user">Name</label>
                        <input type="text" name="user" class="form-input" id="user" autocomplete="off"><hr>
                        <div id="user-list"></div>
                        <span class="error" id="user_error"></span>
                    </div>
                </div>
                {{-- joining date  --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="joining_date">Joining Date</label>
                        <input type="date" name="joining_date" id="joining_date" class="form-input">
                        <span class="error" id="joining_date_error"></span>
                    </div>
                </div>
                {{-- joining location --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="location">Joining Location</label>
                        <input type="text" name="location" id="location" class="form-input" autocomplete="off"><hr>
                        <div id="location-list"></div>
                        <span class="error" id="location_error"></span>
                    </div>
                </div>
                {{-- department --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="department">Department</label>
                        <input type="text" name="department" id="department" class="form-input" autocomplete="off"><hr>
                        <div id="department-list"></div>
                        <span class="error" id="department_error"></span>
                    </div>
                </div>
                {{-- designation --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="designation">Designation</label>
                        <input type="text" name="designation" id="designation" class="form-input" autocomplete="off"><hr>
                        <div id="designation-list"></div>
                        <span class="error" id="designation_error"></span>
                    </div>
                </div>
            </div>
            <div class="center">
                <button type="submit" id="Insert" class="btn-blue">Save</button>
            </div>
        </form>
    </div>
</div>