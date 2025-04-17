<div id="editModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit {{ $name }}</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>
        <!-- form start -->
        <form id="EditForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- id  --}}
            <input type="hidden" name="id" id="id">
            {{-- type --}}
            <div class="form-input-group">
                <label for="updateWith">Employee Type</label>
                <select name="with" id="updateWith">
                    <option value="">Select employee Type</option>
                </select>
                <span class="error" id="update_with_error"></span>
            </div>
            {{-- name --}}
            <div class="form-input-group">
                <label for="updateUser">Employee Name</label>
                <input type="text" name="user" class="form-input" id="updateUser" autocomplete="off"><hr>
                <div id="update-user"></div>
                <span class="error" id="update_user_error"></span>
            </div>
            {{-- category --}}
            <div class="form-input-group">
                <label for="updateHead">Payroll Category</label>
                <select name="head" id="updateHead">
                    <option value="">Select Payroll Category</option>
                </select>
                <span class="error" id="update_head_error"></span>
            </div>
            {{-- amount --}}
            <div class="form-input-group">
                <label for="updateAmount">Amount</label>
                <input type="text" name="amount" class="form-input" id="updateAmount">
                <span class="error" id="update_amount_error"></span>
            </div>
            
            <div class="center">
                <button type="submit" class="btn-blue" id="Update">Update</button>
            </div>
        </form>
    </div>
</div>