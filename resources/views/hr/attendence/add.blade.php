<div id="addModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3 class="card-title">Add {{ $name }}</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>

        
        <!-- form start -->
        <form id="AddForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            
            <div class="form-input-group">
                <label for="with">Employee Type</label>
                <select name="with" id="with">
                    {{-- options will be display dynamically --}}
                </select>
                <span class="error" id="with_error"></span>
            </div>
            
            <div class="form-input-group">
                <label for="user">Employee Name</label>
                <input type="text" name="user" class="form-input" id="user" autocomplete="off">
                <div id="user-list">
                    <ul>
    
                    </ul>
                </div>
                <span class="error" id="user_error"></span>
            </div>
            
            <div class="form-input-group">
                <label for="date">Date</label>
                <input type="date" name="date" class="form-input" id="date" value="{{date('Y-m-d')}}" autocomplete="off">
                <span class="error" id="date_error"></span>
            </div>
            
            <div class="form-input-group">
                <label for="in">In</label>
                <input type="time" name="in" class="form-input" id="in" autocomplete="off" value="{{ date('H:i') }}">
                <span class="error" id="in_error"></span>
            </div>

            <div class="center">
                <button type="submit" class="btn-blue" id="Insert">Submit</button>
            </div>
        </form>
    </div>
</div>