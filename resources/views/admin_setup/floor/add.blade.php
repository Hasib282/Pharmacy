<div id="addModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Add {{ $name }}</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>

        <form id="AddForm" method="post">
            @csrf

            {{-- Floor Name --}}
            <div class="form-input-group">
                <label for="name">Floor Name <span class="required" title="Required">*</span></label>
                <input type="text" name="name" id="name" class="form-input" autocomplete="off">
                <span class="error" id="name_error"></span>
            </div>

            

            <div class="center">
                <button type="submit" id="Insert" class="btn-blue">Submit</button>
            </div>
        </form>
    </div>
</div>
