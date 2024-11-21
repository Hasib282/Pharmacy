<div id="editModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit Employee Education Detail</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="EditForm" class="education-form" method="POST">
            @csrf
            @method('put')
            <div class="rows">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="empId" id="empId">
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_level_of_education">Level of Education<span class="red">*</span></label>
                        <input type="text" name="level_of_education" id="update_level_of_education" class="form-input">
                        <span class="error" id="update_level_of_education_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_degree_title">Degree Title<span class="red">*</span></label>
                        <input type="text" name="degree_title" id="update_degree_title" class="form-input">
                        <span class="error" id="update_degree_title_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_group">Group</label>
                        <select name="group" id="update_group">

                        </select>           
                        <span class="error" id="update_group_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_institution_name">Institution Name<span class="red">*</span></label>
                        <input type="text" name="institution_name" id="update_institution_name" class="form-input">
                        <span class="error" id="update_institution_name_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_result">Result<span class="red">*</span></label>
                            <select name="result" id="update_result">

                            </select>
                        <span class="error" id="update_result_error"></span>
                    </div>
                </div>
                <div class="c-6 hidden" id="update_scale-group">
                    <div class="form-input-group">
                        <label for="update_scale">Scale<span class="red">*</span></label>
                        <input type="decimal" step="0.01" name="scale" id="update_scale" class="form-input">
                        <span class="error" id="update_scale_error"></span>
                    </div>
                </div>
                <div class="c-6 hidden" id="update_cgpa-group">
                    <div class="form-input-group">
                        <label for="update_cgpa">CGPA<span class="red">*</span></label>
                        <input type="decimal" step="0.01" name="cgpa" id="update_cgpa" class="form-input">
                        <span class="error" id="update_cgpa_error"></span>
                    </div>
                </div>
                <div class="c-6 hidden" id="update_marks-group">
                        <div class="form-input-group">
                            <label for="update_marks">Marks<span class="red">*</span></label>
                            <input type="number" name="marks" id="update_marks" class="form-input">
                            <span class="error" id="update_marks_error"></span>
                        </div>
                    </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_batch">Batch</label>
                        <input type="integer" name="batch" id="update_batch" class="form-input">
                        <span class="error" id="update_batch_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_passing_year">Passing Year<span class="red">*</span></label>
                        <input type="integer" name="passing_year" id="update_passing_year" class="form-input">
                        <span class="error" id="update_passing_year_error"></span>
                    </div>
                </div>
            </div>
            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</div>