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
                <label for="updateBed_Category">Bed Category <span class="required" title="Required">*</span></label>
                <input type="text" name="bed_catagory" id="updateBed_Category" class="form-input" autocomplete="off"><hr>
                <div id='update-bed_category'></div>
                <span class="error" id="update_bed_category_error"></span>
            </div>
            {{-- bedlist name --}}
            <div class="form-input-group">
                <label for="updateName">Bed List Name <span class="required" title="Required">*</span></label>
                <input type="text" name="name" class="form-input" id="updateName">
                <span class="error" id="update_name_error"></span>
            </div>
            {{-- nursing station --}}
            <div class="form-input-group">
                <label for="updateNursing_Station">Nursing Station <span class="required" title="Required">*</span></label>
                <input type="text" name="nursing_station" class="form-input" id="updateNursing_Station" autocomplete="off"><hr>
                <div id='update-nursing_station'></div>
                <span class="error" id="update_nursing_station_error"></span>
            </div>
            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</div>