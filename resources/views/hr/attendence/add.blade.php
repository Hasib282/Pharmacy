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
            {{-- type --}}
            <div class="form-input-group">   
                <label for="type">Employee Type <span class="required" title="Required">*</span></label>
                <select name="type" id="type">
                    
                </select>
                <span class="error" id="type_error"></span>
            </div>
            {{-- name --}}
            <div class="form-input-group">
                <label for="user">Employee Name</label>
                <input type="text" name="user" class="form-input" id="user" autocomplete="off"><hr>
                <div id="user-list"></div>
                <span class="error" id="user_error"></span>
            </div>
            {{-- date  --}}
            <div class="form-input-group">
                <label for="date">Date</label>
                <input type="date" name="date" class="form-input" id="date" value="{{date('Y-m-d')}}" autocomplete="off">
                <span class="error" id="date_error"></span>
            </div>
            {{-- in  --}}
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