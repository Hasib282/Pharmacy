<div id="editModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit {{ $name }}</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <form id="EditForm" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            {{-- id  --}}
            <input type="hidden" name="id" id="id">
            {{-- Floor Name --}}
            <div class="form-input-group">
                <label for="updateName">Floor Name <span class="required" title="Required">*</span></label>
                <input type="text" name="name" id="updateName" class="form-input" autocomplete="off">
                <span class="error" id="update_name_error"></span>
            </div>

         

            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</div>
