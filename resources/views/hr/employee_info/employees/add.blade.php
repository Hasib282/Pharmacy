@section('style')
<style>
    .modal-subject {
        width: 80%;
    }

    .designation {
        color: #0af7b7f5;
        font-size: 20px;
    }

    .payroll table {
        margin: 20px 0;
    }

    .show-table td,
    th {
        border: 1px solid #4f4a4a63;
    }
</style>
@endsection


<div id="addModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Add Employee</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="AddForm" method="post" enctype="multipart/form-data">
            @csrf
            <div class="rows">
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-input" id="name">
                        <span class="error" id="name_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-input" id="email">
                        <span class="error" id="email_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" class="form-input" id="phone">
                        <span class="error" id="phone_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Others">Others</option>
                        </select>
                        <span class="error" id="gender_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="location">Location</label>
                        <input type="text" name="location" class="form-input" id="location" autocomplete="off">
                        <div id="location-list">
                            <ul>

                            </ul>
                        </div>
                        <span class="error" id="location_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="type">Employee Type</label>
                        <select name="type" id="type">
                            {{-- <option value="">Select Employee Type</option>
                            @foreach ($tranwith as $with)
                            <option value="{{$with->id}}">{{$with->tran_with_name}}</option>
                            @endforeach --}}
                        </select>
                        <span class="error" id="type_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="department">Department</label>
                        <input type="text" name="department" class="form-input" id="department" autocomplete="off">
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
                        <input type="text" name="designation" class="form-input" id="designation" autocomplete="off">
                        <div id="designation-list">
                            <ul>

                            </ul>
                        </div>
                        <span class="error" id="designation_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" name="dob" class="form-input" id="dob">
                        <span class="error" id="dob_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="nid">NID</label>
                        <input type="text" name="nid" class="form-input" id="nid">
                        <span class="error" id="nid_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-input" id="address">
                        <span class="error" id="address_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" class="form-input" id="image">
                        <span class="error" id="image_error"></span>
                        <img src="#" alt="Selected Image" id="previewImage"
                            style="display: none; width:200px; height:200px;">
                    </div>
                </div>
            </div>
            <div class="center">
                <button type="submit" id="Insert" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>