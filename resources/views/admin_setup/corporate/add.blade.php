<div id="addModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Add {{ $name }}</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="AddForm" method="post">
            @csrf
            {{-- name --}}
            <div class="form-input-group">
                <label for="name">Corporate Name<span class="required" title="Required">*</span></label>
                <input type="text" name="name" class="form-input" id="name">
                <span class="error" id="name_error"></span>
            </div>
            {{-- price --}}
            <div class="form-input-group">
                <label for="price">Discount Rate</label>
                <input type="text" name="price" class="form-input" id="price" value="0">
                <span class="error" id="price_error"></span>
            </div>

            <div class="center">
                <button type="submit" id="Insert" class="btn-blue">Submit</button>
            </div>
        </form>
    </div>
</div>