<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 80%;">
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
                {{-- id  --}}
                <input type="hidden" name="id" id="id">
                {{-- employee id  --}}
                <input type="hidden" name="empId" id="empId">
                {{-- degree title  --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_degree">Degree Title <span class="required" title="Required">*</span></label>
                        <input type="text" name="degree" id="update_degree" class="form-input">
                        <span class="error" id="update_degree_error"></span>
                    </div>
                </div>
                {{-- groupe --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_group">Group</label>
                        <select name="group" id="update_group">

                        </select>           
                        <span class="error" id="update_group_error"></span>
                    </div>
                </div>
                {{-- institution --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_institution">Institution Name <span class="required" title="Required">*</span></label>
                        <input type="text" name="institution" id="update_institution" class="form-input">
                        <span class="error" id="update_institution_error"></span>
                    </div>
                </div>
                {{-- result --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_result">Result <span class="required" title="Required">*</span></label>
                            <select name="result" id="update_result">

                            </select>
                        <span class="error" id="update_result_error"></span>
                    </div>
                </div>
                {{-- scale --}}
                <div class="c-6 hidden" id="update_scale-group">
                    <div class="form-input-group">
                        <label for="update_scale">Scale </label>
                        <input type="decimal" step="0.01" name="scale" id="update_scale" class="form-input">
                        <span class="error" id="update_scale_error"></span>
                    </div>
                </div>
                {{-- cgpa --}}
                <div class="c-6 hidden" id="update_cgpa-group">
                    <div class="form-input-group">
                        <label for="update_cgpa">CGPA </label>
                        <input type="decimal" step="0.01" name="cgpa" id="update_cgpa" class="form-input">
                        <span class="error" id="update_cgpa_error"></span>
                    </div>
                </div>
                {{-- marks --}}
                <div class="c-6 hidden" id="update_marks-group">
                    <div class="form-input-group">
                        <label for="update_marks">Marks </label>
                        <input type="number" name="marks" id="update_marks" class="form-input">
                        <span class="error" id="update_marks_error"></span>
                    </div>
                </div>
                {{-- batch --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_batch">Batch <span class="required" title="Required">*</span></label>
                        <input type="integer" name="batch" id="update_batch" class="form-input">
                        <span class="error" id="update_batch_error"></span>
                    </div>
                </div>
            </div>
            
            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</div>