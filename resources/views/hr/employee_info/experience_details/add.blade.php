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

    .experience-form {
        margin-bottom: 20px;
        /* Adjust the value as needed */
    }
</style>
@endsection

<div id="addModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3 class="card-title">Add Experience Detail</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>
        <br>
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
            <form id='form1' class='experience-form' method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Education Details Section -->
                <div class="rows">
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="company_name_1">Company Name<span class="red">*</span></label>
                            <input type="text" name="company_name" id="company_name_1" class="form-input">
                            <span class="error" id="company_name_error_1"></span>
                        </div>
                    </div>
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="department_1">Department<span class="red">*</span></label>
                            <input type="text" name="department" id="department_1" class="form-input">
                            <span class="error" id="department_error_1"></span>
                        </div>
                    </div>
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="designation">Designation<span class="red">*</span></label>
                            <input type="text" name="designation" id="designation" class="form-input">
                            <span class="error" id="designation_error_1"></span>
                        </div>
                    </div>
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="company_location_1">Company Address<span class="red">*</span></label>
                            <input type="text" name="company_location" id="company_location_1" class="form-input">
                            <span class="error" id="company_location_error_1"></span>
                        </div>
                    </div>
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="start_date_1">Start Date</label>
                            <input type="date" name="start_date" id="start_date_1" class="form-input">
                            <span class="error" id="start_date_error_1"></span>
                        </div>
                    </div>
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="end_date_1">End Date</label>
                            <input type="date" name="end_date" id="end_date_1" class="form-input">
                            <span class="error" id="end_date_error_1"></span>
                        </div>
                    </div>
                    <!-- Forms will be dynamically added here -->
                </div>
            </form>
        </div>
        <div>
            <button type="button" name="addExperience" id="addExperience" class="btn-blue">Add+</button>
        </div>
        <div class="center">
            <button type="submit" id="Insert" class="btn-blue">Save</button>
        </div>
    </div>
</div>