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
            {{-- id  --}}
            <input type="hidden" name="id" id="id">
            {{-- name --}}
            <div class="form-input-group">
                <label for="updateName">Tran With Name <span class="required" title="Required">*</span></label>
                <input type="text" name="name" class="form-input" id="updateName">
                <span class="error" id="update_name_error"></span>
            </div>

            @if(Request::segment(1) == 'admin')
                {{-- role --}}
                <div class="form-input-groupe">
                    <label for="updateRole">User Role <span class="required" title="Required">*</span></label>
                    <select name="role" id="updateRole">
                        {{-- options will be import dynamically --}}
                    </select>
                    <span class="error" id="update_role_error"></span>
                </div>
                {{-- type --}}
                <div class="form-input-group">
                    <label for="updateTranType">Transaction Type <span class="required" title="Required">*</span></label>
                    <select name="tranType" id="updateTranType">
                        {{-- options will be import dynamically --}}
                    </select>
                    <span class="error" id="update_tranType_error"></span>
                </div>
                {{-- mrthod --}}
                <div class="form-input-group">
                    <label for="updateTranMethod">Transaction Method <span class="required" title="Required">*</span></label>
                    <select name="tranMethod" id="updateTranMethod">
                        {{-- options will be import dynamically --}}
                    </select>
                    <span class="error" id="update_tranMethod_error"></span>
                </div>
            @elseif(Request::segment(1) == 'transaction' || Request::segment(1) == 'inventory' || Request::segment(1) == 'pharmacy') 
                {{-- role --}}
                <div class="form-input-groupe">
                    <label for="updateRole">User Role <span class="required" title="Required">*</span></label>
                    <select name="role" id="updateRole">
                        {{-- options will be import dynamically --}}
                    </select>
                    <span class="error" id="update_role_error"></span>
                </div>
                {{-- method  --}}
                <div class="form-input-group">
                    <label for="updateTranMethod">Transaction Method <span class="required" title="Required">*</span></label>
                    <select name="tranMethod" id="updateTranMethod">
                        {{-- options will be import dynamically --}}
                    </select>
                    <span class="error" id="update_tranMethod_error"></span>
                </div>
            @endif

            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</div>