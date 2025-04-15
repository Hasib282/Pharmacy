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
            <div class="form-input-group">
                <label for="name">BedList Name <span class="required" title="Required">*</span></label>
                <input type="text" name="name" class="form-input" id="name">
                <span class="error" id="name_error"></span>
            </div>
            <div class="form-input-group">
                <label for="bed_category">Bed Category <span class="required" title="Required">*</span></label>
                <input type="text" name="bed_category" id="bed_category" class="form-input" autocomplete="off">
                <div id='bed_category-list'></div>
                <span class="error" id="bed_category_error"></span>
            </div>
            <div class="form-input-group">
                <label for="nursing_station">Nursing station <span class="required" title="Required">*</span></label>
                <input type="text" name="nursing_station" class="form-input" id="nursing_station" autocomplete="off">
                <div id='nursing_station-list'></div>
                <span class="error" id="nursing_station_error"></span>
            </div>
            <div class="center">
                <button type="submit" id="Insert" class="btn-blue">Submit</button>
            </div>
        </form>
    </div>
</div>