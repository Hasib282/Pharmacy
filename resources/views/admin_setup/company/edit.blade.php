<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 80%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3 class="card-title">Edit {{ $name }}</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="EditForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="rows">
                <input type="hidden" name="id" id="id">
                {{-- type --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateType">Company Type <span class="required" title="Required">*</span></label>
                        <select name="type" id="updateType">
                            {{-- options will be display dynamically --}}
                        </select>
                        <span class="error" id="update_type_error"></span>
                    </div>
                </div>
                {{-- name --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateName">Company Name <span class="required" title="Required">*</span></label>
                        <input type="text" name="name" class="form-input" id="updateName">
                        <span class="error" id="update_name_error"></span>
                    </div>
                </div>
                {{-- email  --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateEmail">Email <span class="required" title="Required">*</span></label>
                        <input type="text" name="email" class="form-input" id="updateEmail">
                        <span class="error" id="update_email_error"></span>
                    </div>
                </div>
                {{-- phone  --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updatePhone">Phone <span class="required" title="Required">*</span></label>
                        <input type="text" name="phone" class="form-input" id="updatePhone">
                        <span class="error" id="update_phone_error"></span>
                    </div>
                </div>
                {{-- address  --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateAddress">Address</label>
                        <input type="text" name="address" class="form-input" id="updateAddress">
                        <span class="error" id="update_address_error"></span>
                    </div>
                </div>
                {{-- website --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateWebsite">Website</label>
                        <input type="text" name="website" class="form-input" id="updateWebsite">
                        <span class="error" id="update_website_error"></span>
                    </div>
                </div>
                {{-- domain --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateDomain">Domain</label>
                        <input type="text" name="domain" class="form-input" id="updateDomain">
                        <span class="error" id="update_domain_error"></span>
                    </div>
                </div>
                {{-- image --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateImage">Image</label>
                        <input type="file" name="image" class="form-input" id="updateImage">
                        <span class="error" id="update_image_error"></span>
                        <img src="/storage/tsbd.png" alt="Selected Image" id="updatePreviewImage"
                            style="width:150px; height:150px;">
                    </div>
                </div>
            </div>
            <div class="center">
                <button type="submit" class="btn-blue" id="Update">Update</button>
            </div>
        </form>
    </div>
</div>