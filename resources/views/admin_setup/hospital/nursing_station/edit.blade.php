<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 40%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit {{ $name }}</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>
        <!-- form start -->
        <form id="EditForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="id">
            <div class="form-input-group">
                <label for="updateName"> Name <span class="required" title="Required">*</span></label>
                <input type="text" name="name" class="form-input" id="updateName">
                <span class="error" id="update_name_error"></span>
            </div>
            <div class="form-input-group">
                <label for="updateFloor">Floor <span class="required" title="Required">*</span></label>
                <input type="text" name="floor" class="form-input" id="updateFloor" autocomplete="off"><hr>
                <div id="update-floor"></div>
                <span class="error" id="update_floor_error"></span>
            </div>
           
            <div class="center">
                <button type="submit" class="btn-blue" id="Update">Update</button>
            </div>
        </form>
    </div>
</div>