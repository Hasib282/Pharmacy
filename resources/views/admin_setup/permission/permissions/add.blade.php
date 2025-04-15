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
            {{-- mainhead --}}
            <div class="form-input-group">
                <label for="mainhead">Transaction Groupe <span class="required" title="Required">*</span></label>
                <select name="mainhead" id="mainhead">
                    {{-- options will be display dynamically --}}
                </select>
                <span class="error" id="mainhead_error"></span>
            </div>
            {{-- name --}}
            <div class="form-input-group">
                <label for="name">Permission Name <span class="required" title="Required">*</span></label>
                <input type="text" name="name" class="form-input" id="name">
                <span class="error" id="name_error"></span>
            </div>
            <div class="center">
                <button type="submit" id="Insert" class="btn-blue">Submit</button>
            </div>
        </form>
    </div>
</div>