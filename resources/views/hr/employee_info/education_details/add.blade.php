<div id="addModal" class="modal-container">
    <div class="modal-subject" style="width: 80%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3 class="card-title">Add Education Detail</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>


        <!-- form start -->
        <form id='AddForm' enctype="multipart/form-data">
            @csrf
            @method('POST')
            <!-- Education Details Section -->
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
                        <label for="user">Name <span class="required" title="Required">*</span></label>
                        <input type="text" name="user" class="form-input" id="user" autocomplete="off"><hr>
                        <div id="user-list"></div>
                        <span class="error" id="user_error"></span>
                    </div>
                </div>
                {{-- degree title  --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="degree_0">Degree Title <span class="required" title="Required">*</span></label>
                        <input type="text" name="degree[]" id="degree_0" class="form-input">
                        <span class="error" id="degree_0_error"></span>
                    </div>
                </div>
                {{-- groupe --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="group_0">Group</label>
                        <select name="group" id="group_0" class="group-dropdown">
                            <option value="">Select</option>
                            <option value="Science">Science</option>
                            <option value="Commerce">Commerce</option>
                            <option value="Arts">Arts</option>
                        </select>
                        <span class="error" id="group_0_error"></span>
                    </div>
                </div>
                {{-- institution --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="institution_0">Institution Name <span class="required" title="Required">*</span></label>
                        <input type="text" name="institution[]" id="institution_0" class="form-input">
                        <span class="error" id="institution_0_error"></span>
                    </div>
                </div>
                {{-- result --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="result_0">Result <span class="required" title="Required">*</span></label>
                        <select name="result[]" id="result_0" class="result-dropdown">
                            <option value="">Select</option>
                            <option value="First Division/Class">First Division/Class</option>
                            <option value="Second Division/Class">Second Division/Class</option>
                            <option value="Third Division/Class">Third Division/Class</option>
                            <option value="Grade">Grade</option>
                        </select>
                        <span class="error" id="result_0_error"></span>
                    </div>
                </div>
                {{-- scale --}}
                <div class="c-6 hidden" id="scale-group_0">
                    <div class="form-input-group">
                        <label for="scale_0">Scale </label>
                        <input type="decimal" step="0.01" name="scale[]" id="scale_0" class="form-input">
                        <span class="error" id="scale_0_error"></span>
                    </div>
                </div>
                {{-- cgpa --}}
                <div class="c-6 hidden" id="cgpa-group_0">
                    <div class="form-input-group">
                        <label for="cgpa_0">CGPA </label>
                        <input type="decimal" step="0.01" name="cgpa[]" id="cgpa_0" class="form-input">
                        <span class="error" id="cgpa_0_error"></span>
                    </div>
                </div>
                {{-- marks --}}
                <div class="c-6 hidden" id="marks-group_0">
                    <div class="form-input-group">
                        <label for="marks_0">Marks</label>
                        <input type="number" name="marks[]" id="marks_0" class="form-input">
                        <span class="error" id="marks_0_error"></span>
                    </div>
                </div>
                {{-- batch --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="batch_0">Batch <span class="required" title="Required">*</span></label>
                        <input type="integer" name="batch[]" id="batch_0" class="form-input">
                        <span class="error" id="batch_0_error"></span>
                    </div>
                </div>
            </div>

            <div id="formContainer">
                {{-- Forms will be dynamically added here --}}
            </div>

            <div>
                <button type="button" name="addEducation" id="addEducation" class="btn-blue">Add+</button>
            </div>
            <div class="center">
                <button type="submit" id="Insert" class="btn-blue">Save</button>
            </div>
        </form>
    </div>
</div>
