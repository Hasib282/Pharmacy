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
            {{-- designation --}}
            <div class="form-input-group">
                <label for="designations">Designation</label>
                <input type="text" name="designations" class="form-input" id="designations">
                <span class="error" id="designations_error"></span>
            </div>
            {{-- department --}}
            <div class="form-input-group">
                <label for="department">Department</label>
                <input type="text" name="department" class="form-input" id="department" autocomplete="off"><hr>
                <div id="department-list"></div>
                <span class="error" id="department_error"></span>
            </div>
            <div class="center">
                <button type="submit" id="Insert" class="btn-blue">Submit</button>
            </div>
        </form>
    </div>
</div>