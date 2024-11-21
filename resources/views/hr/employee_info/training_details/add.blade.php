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
        background-color: #E8E8E8!important; 
        }
        .red {
            color: red;
        }

        .training-form {
            margin-bottom: 20px; /* Adjust the value as needed */
        }
    </style>
@endsection

<div id= "addModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Add Training Detail</h3>
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
            <form id='form1' class='training-form' method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Training Details Section -->
                <div class="rows">
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for = "training_title_1">Training Title<span class="red">*</span></label>
                            <input type="text" name="training_title" id="training_title_1" class="form-input">
                            <span class="error" id="training_title_error_1"></span>
                        </div>
                    </div>
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for = "country_1">Country</label>
                            <input type="text" name="country" id="country_1" class="form-input">
                            <span class="error" id="country_error_1"></span>
                        </div>
                    </div>
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for = "topic_1">Topic<span class="red">*</span></label>
                            <input type="text" name="topic" id="topic_1" class="form-input">
                            <span class="error" id="topic_error_1"></span>
                        </div>
                    </div>
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for = "institution_name_1">Institution Name<span class="red">*</span></label>
                            <input type="text" name="institution_name" id="institution_name_1" class="form-input">
                            <span class="error" id="institution_name_error_1"></span>
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
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for = "training_year_1">Training Year<span class="red">*</span></label>
                            <input type="integer" name="training_year" id="training_year_1" class="form-input">
                            <span class="error" id="training_year_error_1"></span>
                        </div>
                    </div>
                <!-- Forms will be dynamically added here -->
                </div>
            </form>
        </div>
        <div>
            <button type = "button" name = "addTraining" id = "addTraining" class="btn-blue">Add+</button>
        </div>
        <div class="center">
            <button type="submit" id="Insert" class="btn-blue">Save</button>
        </div>
    </div>            
</div>

