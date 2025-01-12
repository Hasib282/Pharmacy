<div id="editModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3 class="card-title">Edit {{ $name }}</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        
        <!-- form start -->
        <form id="EditForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="id">
            <div class="form-input-group">
                <label for="updateUser">Employee Name</label>
                <input type="text" name="user" class="form-input" id="updateUser" autocomplete="off" disabled>
                <div id="update-user">
                    <ul>

                    </ul>
                </div>
                <span class="error" id="update_user_error"></span>
            </div>
            
            <div class="form-input-group">
                <label for="updateDate">Date</label>
                <input type="date" name="date" class="form-input" id="updateDate" autocomplete="off" disabled>
                <span class="error" id="update_date_error"></span>
            </div>
            
            @if(Auth::user()->role_id = 1 || Auth::user()->role_id = 2)
                <div class="form-input-group">
                    <label for="updateIn">In</label>
                    <input type="time" name="in" class="form-input" id="updateIn" autocomplete="off">
                    <span class="error" id="update_in_error"></span>
                </div>
            @endif
            
            <div class="form-input-group">
                <label for="updateOut">Out</label>
                <input type="time" name="out" class="form-input" id="updateOut" autocomplete="off">
                <span class="error" id="update_out_error"></span>
            </div>

            <div class="center">
                <button type="submit" class="btn-blue" id="Update">Update</button>
            </div>
        </form>
    </div>
</div>