<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 80%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit Employee Training Detail</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="EditForm" class="training-form" method="POST">
            @csrf
            @method('put')
            <div class="rows">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="empId" id="empId">
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_training_title">Training Title</label>
                        <input type="text" name="training_title" id="update_training_title" class="form-input">
                        <span class="error" id="update_training_title_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_country">Country</label>
                        <input type="text" name="country" id="update_country" class="form-input">
                        <span class="error" id="update_country_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_topic">Topic</label>
                        <input type="text" name="topic" id="update_topic" class="form-input">
                        <span class="error" id="update_topic_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_institution_name">Institution Name</label>
                        <input type="text" name="institution_name" id="update_institution_name" class="form-input">
                        <span class="error" id="update_institution_name_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_start_date">Start Date</label>
                        <input type="date" name="start_date" id="update_start_date" class="form-input">
                        <span class="error" id="update_start_date_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_end_date">End Date</label>
                        <input type="date" name="end_date" id="update_end_date" class="form-input">
                        <span class="error" id="update_end_date_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_training_year">Training Year</label>
                        <input type="integer" name="training_year" id="update_training_year" class="form-input">
                        <span class="error" id="update_training_year_error"></span>
                    </div>
                </div>
            </div>
            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</div>