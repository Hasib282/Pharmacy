<div id= "addModal" class="modal-container">
    <div class="modal-subject" style="width: 80%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Add Training Detail</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>

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
                        <label for = "training_title_0">Training Title <span class="required" title="Required">*</span></label>
                        <input type="text" name="training_title[]" id="training_title_0" class="form-input">
                        <span class="error" id="training_title_0_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for = "country_0">Country</label>
                        <input type="text" name="country[]" id="country_0" class="form-input">
                        <span class="error" id="country_0_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for = "topic_0">Topic <span class="required" title="Required">*</span></label>
                        <input type="text" name="topic[]" id="topic_0" class="form-input">
                        <span class="error" id="topic_0_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for = "institution_name_0">Institution Name <span class="required" title="Required">*</span></label>
                        <input type="text" name="institution_name[]" id="institution_name_0" class="form-input">
                        <span class="error" id="institution_name_0_error"></span>
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
                <div class="c-6">
                    <div class="form-input-group">
                        <label for = "training_year_0">Training Year <span class="required" title="Required">*</span></label>
                        <input type="integer" name="training_year[]" id="training_year_0" class="form-input">
                        <span class="error" id="training_year_0_error"></span>
                    </div>
                </div>
            </div>
            <div id="formContainer"></div>
            <div>
                <button type = "button" name = "addTraining" id = "addTraining" class="btn-blue">Add+</button>
            </div>
            <div class="center">
                <button type="submit" id="Insert" class="btn-blue">Save</button>
            </div>
        </form>
    </div>            
</div>

