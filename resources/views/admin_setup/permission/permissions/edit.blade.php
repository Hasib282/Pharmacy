<div id="editModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit {{ $name }}</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="EditForm" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="id">
            <div class="form-input-group">
                <label for="updateMainhead">Mainhead <span class="required" title="Required">*</span></label>
                <select name="mainhead" id="updateMainhead">
                    {{-- options will be display dynamically --}}
                </select>
                <span class="error" id="update_mainhead_error"></span>
            </div>
            <div class="form-input-group">
                <label for="updateName">Permission Name <span class="required" title="Required">*</span></label>
                <input type="text" name="name" class="form-input" id="updateName">
                <span class="error" id="update_name_error"></span>
            </div>
            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</div>