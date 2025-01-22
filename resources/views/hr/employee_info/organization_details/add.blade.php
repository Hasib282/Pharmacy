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
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="with">Employee Type</label>
                        <select name="with" id="with">
                            
                        </select>
                        <span class="error" id="with_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="user">Name</label>
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
                        <label for="joining_date">Joining Date</label>
                        <input type="date" name="joining_date" id="joining_date" class="form-input">
                        <span class="error" id="joining_date_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="location">Joining Location</label>
                        <input type="text" name="location" id="location" class="form-input">
                        <div id="location-list">
                            <ul>

                            </ul>
                        </div>
                        <span class="error" id="location_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="department">Department</label>
                        <input type="text" name="department" id="department" class="form-input">
                        <div id="department-list">
                            <ul>

                            </ul>
                        </div>
                        <span class="error" id="department_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="designation">Designation</label>
                        <input type="text" name="designation" id="designation" class="form-input">
                        <div id="designation-list">
                            <ul>

                            </ul>
                        </div>
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