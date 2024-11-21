@section('style')
<style>
    .modal-subject {
        width: 75%;
    }

    label {
        font-size: 16px !important;
        font-weight: normal !important;
    }

    .container {
        background-color: #E8E8E8 !important;
    }

    .red {
        color: red;
    }

    .education-form {
        margin-bottom: 20px;
    }

    .hidden {
            display: none;
        }
</style>
@endsection


<div id="addModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3 class="card-title">Add Education Detail</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>

        <div id="formContainer">
            <div class="rows">
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="with">Employee Type<span class="red">*</span></label>
                        <select name="with" id="with">
                            {{-- <option value="">Select Employee Type</option>
                            @foreach ($tranwith as $with)
                            <option value="{{$with->id}}">{{$with->tran_with_name}}</option>
                            @endforeach --}}
                        </select>
                        <span class="error" id="with_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="user">Name<span class="red">*</span></label>
                        <input type="text" name="user" class="form-input" id="user" autocomplete="off">
                        <div id="user-list">
                            <ul>

                            </ul>
                        </div>
                        <span class="error" id="user_error"></span>
                    </div>
                </div>
            </div>

            <!-- form start -->
            <form id='form1' class='education-form' method="POST"
                enctype="multipart/form-data">
                @csrf
                <!-- Education Details Section -->
                <div class="rows">
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="level_of_education_1">Level of Education<span class="red">*</span></label>
                            <input type="text" name="level_of_education" id="level_of_education_1" class="form-input">
                            <span class="error" id="level_of_education_error_1"></span>
                        </div>
                    </div>
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="degree_title_1">Degree Title<span class="red">*</span></label>
                            <input type="text" name="degree_title" id="degree_title_1" class="form-input">
                            <span class="error" id="degree_title_error_1"></span>
                        </div>
                    </div>
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="group_1">Group</label>
                            <select name="group" id="group_1" class="group-dropdown">
                                <option value="">Select</option>
                                <option value="Science">Science</option>
                                <option value="Commerce">Commerce</option>
                                <option value="Arts">Arts</option>
                            </select>
                            <span class="error" id="group_error_1"></span>
                        </div>
                    </div>
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="institution_name_1">Institution Name<span class="red">*</span></label>
                            <input type="text" name="institution_name" id="institution_name_1" class="form-input">
                            <span class="error" id="institution_name_error_1"></span>
                        </div>
                    </div>
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="result_1">Result<span class="red">*</span></label>
                            <select name="result" id="result_1" class="result-dropdown">
                                <option value="">Select</option>
                                <option value="First Division/Class">First Division/Class</option>
                                <option value="Second Division/Class">Second Division/Class</option>
                                <option value="Third Division/Class">Third Division/Class</option>
                                <option value="Grade">Grade</option>
                            </select>
                            <span class="error" id="result_error_1"></span>
                        </div>
                    </div>
                    <div class="c-6 hidden" id="scale-group_1">
                        <div class="form-input-group">
                            <label for="scale_1">Scale<span class="red">*</span></label>
                            <input type="decimal" step="0.01" name="scale" id="scale_1" class="form-input">
                            <span class="error" id="scale_error_1"></span>
                        </div>
                    </div>
                    <div class="c-6 hidden" id="cgpa-group_1">
                        <div class="form-input-group">
                            <label for="cgpa_1">CGPA<span class="red">*</span></label>
                            <input type="decimal" step="0.01" name="cgpa" id="cgpa_1" class="form-input">
                            <span class="error" id="cgpa_error_1"></span>
                        </div>
                    </div>
                    <div class="c-6 hidden" id="marks-group_1">
                        <div class="form-input-group">
                            <label for="marks_1">Marks<span class="red">*</span></label>
                            <input type="number" name="marks" id="marks_1" class="form-input">
                            <span class="error" id="marks_error_1"></span>
                        </div>
                    </div>
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="batch_1">Batch</label>
                            <input type="integer" name="batch" id="batch_1" class="form-input">
                            <span class="error" id="batch_error_1"></span>
                        </div>
                    </div>
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="passing_year_1">Passing Year<span class="red">*</span></label>
                            <input type="integer" name="passing_year" id="passing_year_1" class="form-input">
                            <span class="error" id="passing_year_error_1"></span>
                        </div>
                    </div>
                    <!-- Forms will be dynamically added here -->
                </div>
            </form>
        </div>
        <div>
            <button type="button" name="addEducation" id="addEducation" class="btn-blue">Add+</button>
        </div>
        <div class="center">
            <button type="submit" id="Insert" class="btn-blue">Save</button>
        </div>
    </div>
</div>
