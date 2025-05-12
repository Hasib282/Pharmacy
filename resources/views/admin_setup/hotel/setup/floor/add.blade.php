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
                <label for="floor_name">Floor Name <span class="required" title="Required">*</span></label>
                <input type="text" name="floor_name" id="floor_name" class="form-input" autocomplete="off">
                <span class="error" id="floor_name_error"></span>
            </div>

            {{-- Number of Rooms --}}
            <div class="form-input-group">
                <label for="number_of_rooms">Number of Rooms <span class="required" title="Required">*</span></label>
                <input type="number" name="number_of_rooms" id="number_of_rooms" class="form-input" min="1">
                <span class="error" id="number_of_rooms_error"></span>
            </div>

            {{-- Starting Floor --}}
            <div class="form-input-group">
                <label for="starting_floor">Starting Floor <span class="required" title="Required">*</span></label>
                <input type="text" name="starting_floor" id="starting_floor" class="form-input">
                <span class="error" id="starting_floor_error"></span>
            </div>

            {{-- Action / Status --}}
            <div class="form-input-group">
                <label for="action">Action / Status <span class="required" title="Required">*</span></label>
                <select name="action" id="action" class="form-input">
                    <option value="">Select Action/Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <span class="error" id="action_error"></span>
            </div>

            <div class="center">
                <button type="submit" id="Insert" class="btn-blue">Submit</button>
            </div>
        </form>
    </div>
</div>
