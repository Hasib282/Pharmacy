<div id="editModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3 class="card-title">Edit {{ $name }}</h3>
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
                <label for="updateGroupeName">Groupe Name <span class="required" title="Required">*</span></label>
                <input type="text" name="groupeName" class="form-input" id="updateGroupeName">
                <span class="error" id="update_groupeName_error"></span>
            </div>

            @if (Request::segment(1) == 'admin')
                {{-- type --}}
                <div class="form-input-group">
                    <label for="updateType">Type <span class="required" title="Required">*</span></label>
                    <select name="type" id="updateType">
                        {{-- options will be display dynamically --}}
                    </select>
                    <span class="error" id="update_type_error"></span>
                </div>
                {{-- method --}}
                <div class="form-input-group">
                    <label for="updateMethod">Method <span class="required" title="Required">*</span></label>
                    <select name="method" id="updateMethod">
                        <option value="">Select Method</option>
                        <option value="Receive">Receive</option>
                        <option value="Payment">Payment</option>
                        <option value="Both">Both</option>
                    </select>
                    <span class="error" id="update_method_error"></span>
                </div>
            @elseif (Request::segment(1) == 'transaction')
                {{-- method --}}
                <div class="form-input-group">
                    <label for="updateMethod">Method <span class="required" title="Required">*</span></label>
                    <select name="method" id="updateMethod">
                        <option value="">Select Method</option>
                        <option value="Receive">Receive</option>
                        <option value="Payment">Payment</option>
                        <option value="Both">Both</option>
                    </select>
                    <span class="error" id="update_method_error"></span>
                </div>
            @endif

            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</div>