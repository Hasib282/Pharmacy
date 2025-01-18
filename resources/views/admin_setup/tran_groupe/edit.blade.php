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
            <input type="hidden" name="id" id="id">
            <div class="form-input-group">
                <label for="updateGroupeName">Groupe Name <span class="required" title="Required">*</span></label>
                <input type="text" name="groupeName" class="form-input" id="updateGroupeName">
                <span class="error" id="update_groupeName_error"></span>
            </div>

            @if (Request::segment(1) == 'admin')
                <div class="form-input-group">
                    <label for="updateType">Transaction Type <span class="required" title="Required">*</span></label>
                    <select name="type" id="updateType">
                        {{-- options will be display dynamically --}}
                    </select>
                    <span class="error" id="update_type_error"></span>
                </div>
                <div class="form-input-group">
                    <label for="updateMethod">Transaction Method <span class="required" title="Required">*</span></label>
                    <select name="method" id="updateMethod">

                    </select>
                    <span class="error" id="update_method_error"></span>
                </div>
            @elseif (Request::segment(1) == 'transaction')
                <div class="form-input-group">
                    <label for="updateMethod">Transaction Method <span class="required" title="Required">*</span></label>
                    <select name="method" id="updateMethod">

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