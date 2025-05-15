<div id="editModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit {{ $name }}</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <form id="EditForm" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            {{-- id  --}}
            <input type="hidden" name="id" id="id">
            {{-- bed category --}}
            <div class="form-input-group">
                <label for="updateBed_Category">@if (Request::segment(1) == 'hotel') Room Category @else Bed Category @endif <span class="required">*</span></label>
                <input type="text" name="bed_catagory" id="updateBed_Category" class="form-input" autocomplete="off"><hr>
                <div id='update-bed_category'></div>
                <span class="error" id="update_bed_category_error"></span>
            </div>
            {{-- bedlist name --}}
            <div class="form-input-group">
                <label for="updateBed_List">@if (Request::segment(1) == 'hotel') Room Number @else Bed List @endif <span class="required">*</span></label>
                <input type="text" name="bed_list" class="form-input" id="updateBed_List" autocomplete="off"><hr>
                <div id='update-bed_list'></div>
                <span class="error" id="update_bed_list_error"></span>
            </div>

            @if (Request::segment(1) == 'hospital') 
                {{-- nursing station --}}
                <div class="form-input-group">
                    <label for="updateNursing_Station">Nursing Station</label>
                    <input type="text" name="nursing_station" class="form-input" id="updateNursing_Station" autocomplete="off"><hr>
                    <div id='update-nursing_station'></div>
                    <span class="error" id="update_nursing_station_error"></span>
                </div>
            @endif 
            
            @if (Request::segment(1) == 'hotel') 
                {{-- floor --}}
                <div class="form-input-group">
                    <label for="updateFloor">Floor</label>
                    <input type="text" name="floor" class="form-input" id="updateFloor" autocomplete="off"><hr>
                    <div id="update-floor"></div>
                    <span class="error" id="update_floor_error"></span>
                </div>

                {{-- price --}}
                <div class="form-input-group">
                    <label for="updatePrice">Price</label>
                    <input type="text" name="price" class="form-input" id="updatePrice" autocomplete="off">
                    <div id='price-list'></div>
                    <span class="error" id="update_price_error"></span>
                </div>


                {{-- capacity --}}
                <div class="form-input-group">
                    <label for="updateCapacity">Capacity</label>
                    <input type="text" name="capacity" class="form-input" id="updateCapacity" autocomplete="off">
                    <div id='capacity-list'></div>
                    <span class="error" id="update_capacity_error"></span>
                </div>
            @endif 
            
            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</div>