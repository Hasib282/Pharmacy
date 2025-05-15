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
            {{-- bed category --}}
            <div class="form-input-group">
                <label for="bed_category">@if (Request::segment(1) == 'hotel') Room Category @else Bed Category @endif <span class="required">*</span></label>
                <input type="text" name="bed_category" id="bed_category" class="form-input" autocomplete="off"><hr>
                <div id='bed_category-list'></div>
                <span class="error" id="bed_category_error"></span>
            </div>
            {{-- bedlist name --}}
            <div class="form-input-group">
                <label for="bed_list">@if (Request::segment(1) == 'hotel') Room Number @else Bed List @endif <span class="required">*</span></label>
                <input type="text" name="bed_list" class="form-input" id="bed_list" autocomplete="off"><hr>
                <div id='bed_list-list'></div>
                <span class="error" id="bed_list_error"></span>
            </div>
            
            @if (Request::segment(1) == 'hospital')
                {{-- nursing station --}}
                <div class="form-input-group">
                    <label for="nursing_station">Nursing station</label>
                    <input type="text" name="nursing_station" class="form-input" id="nursing_station" autocomplete="off"><hr>
                    <div id='nursing_station-list'></div>
                    <span class="error" id="nursing_station_error"></span>
                </div>
            @endif
            
            @if (Request::segment(1) == 'hotel')
                {{-- floor --}}
                <div class="form-input-group">
                    <label for="floor">Floor</label>
                    <input type="text" name="floor" class="form-input" id="floor" autocomplete="off"><hr>
                    <div id="floor-list"></div>
                    <span class="error" id="floor_error"></span>
                </div>

                {{-- price --}}
                <div class="form-input-group">
                    <label for="price">Price</label>
                    <input type="text" name="price" class="form-input" id="price" autocomplete="off">
                    <div id='price-list'></div>
                    <span class="error" id="price_error"></span>
                </div>

                {{-- capacity --}}
                <div class="form-input-group">
                    <label for="capacity">Capacity</label>
                    <input type="text" name="capacity" class="form-input" id="capacity" autocomplete="off">
                    <div id='capacity-list'></div>
                    <span class="error" id="capacity_error"></span>
                </div>
            @endif



            <div class="center">
                <button type="submit" id="Insert" class="btn-blue">Submit</button>
            </div>
        </form>
    </div>
</div>