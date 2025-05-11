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
            {{-- room_number --}}
            <div class="form-input-group">
                <label for="room_number">Room Number <span class="required" title="Required">*</span></label>
                <input type="text" name="room_number" id="room_number" class="form-input" autocomplete="off">
                <hr>
                <div id='room_number-list'></div>
                <span class="error" id="room_number_error"></span>
            </div>
            {{-- room_catagory --}}

            <div class="form-input-group">
                <label for="room_catagory">Room Catagory <span class="required" title="Required">*</span></label>
                <input type="text" name="room_catagory" id="room_catagory" class="form-input" autocomplete="off">
                <hr>
                <div id='room_catagory-list'></div>
                <span class="error" id="room_catagory_error"></span>
            </div>

            {{-- floor --}}
            <div class="form-input-group">
                <label for="floor">Floor <span class="required" title="Required">*</span></label>
                <input type="text" name="floor" class="form-input" id="floor" autocomplete="off">
                <hr>
                <div id='floor-list'></div>
                <span class="error" id="floor_error"></span>
            </div>

            {{-- price --}}
            <div class="form-input-group">
                <label for="price">Price <span class="required" title="Required">*</span></label>
                <input type="text" name="price" class="form-input" id="price" autocomplete="off">
                <hr>
                <div id='price-list'></div>
                <span class="error" id="price_error"></span>
            </div>

            {{-- capacity --}}
            <div class="form-input-group">
                <label for="capacity">Capacity <span class="required" title="Required">*</span></label>
                <input type="text" name="capacity" class="form-input" id="capacity" autocomplete="off">
                <hr>
                <div id='capacity-list'></div>
                <span class="error" id="capacity_error"></span>
            </div>
            <div class="center">
                <button type="submit" id="Insert" class="btn-blue">Submit</button>
            </div>
        </form>
    </div>
</div>
