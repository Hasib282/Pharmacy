<div id="addModal" class="modal-container">
    <div class="modal-subject" style="width: 80%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Add {{ $name }}</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>
        <!-- form start -->
        <form id="AddForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="rows">
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="type">Company Type <span class="required" title="Required">*</span></label>
                        <select name="type" id="type">
                            {{-- options will be display dynamically --}}
                        </select>
                        <span class="error" id="type_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="name">Name <span class="required" title="Required">*</span></label>
                        <input type="text" name="name" class="form-input" id="name">
                        <span class="error" id="name_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="email">Email <span class="required" title="Required">*</span></label>
                        <input type="text" name="email" class="form-input" id="email">
                        <span class="error" id="email_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="phone">Phone <span class="required" title="Required">*</span></label>
                        <input type="text" name="phone" class="form-input" id="phone">
                        <span class="error" id="phone_error"></span>
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
                        <label for="image">Image<span class="red">*</span></label>
                        <input type="file" name="image" id="image" class="form-input">
                        <span class="error" id="image_error"></span>
                        <img src="/images/male.png" alt="Selected Image" id="previewImage"
                            style="width:150; height:150;">
                    </div>
                </div>
            </div>

            <div class="center">
                <button type="submit" class="btn-blue" id="Insert">Submit</button>
            </div>
        </form>
    </div>
</div>