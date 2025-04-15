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
            {{-- id --}}
            <input type="hidden" name="id" id="id">
            {{-- name --}}
            <div class="form-input-group">
                <label for="updateHeadName">Head Name <span class="required" title="Required">*</span></label>
                <input type="text" name="headName" class="form-input" id="updateHeadName">
                <span class="error" id="update_headName_error"></span>
            </div>
            {{-- groupe --}}
            @if (Request::segment(1) != 'hr')
                <div class="form-input-group">
                    <label for="updateGroupe">Transaction Groupe <span class="required" title="Required">*</span></label>
                    <select name="groupe" id="updateGroupe">
                        {{-- options will be display dynamically --}}
                    </select>
                    <span class="error" id="update_groupe_error"></span>
                </div>
            @endif

            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</div>