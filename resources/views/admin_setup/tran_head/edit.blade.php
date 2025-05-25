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
            {{-- groupe --}}
            @if (Request::segment(1) != 'hr')
                <div class="form-input-group">
                    <label for="updateGroupe">Groupe Name<span class="required" title="Required">*</span></label>
                    <select name="groupe" id="updateGroupe">
                        {{-- options will be display dynamically --}}
                    </select>
                    <span class="error" id="update_groupe_error"></span>
                </div>
            @endif
            {{-- name --}}
            <div class="form-input-group">
                <label for="updateHeadName">Service/Product Name <span class="required" title="Required">*</span></label>
                <input type="text" name="headName" class="form-input" id="updateHeadName">
                <span class="error" id="update_headName_error"></span>
            </div>
            {{-- price --}}
            <div class="form-input-group">
                <label for="updatePrice">Price </label>
                <input type="text" name="price" class="form-input" id="updatePrice" value="0">
                <span class="error" id="update_price_error"></span>
            </div>


            <input type="checkbox" name="editable" id="updateEditable"> <label for="updateEditable">Editable</label>

            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</div>