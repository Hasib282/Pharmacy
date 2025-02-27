<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 40%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit {{ $name }}</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>
        <!-- form start -->
          <!-- form start -->
          <form id="EditForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" id="id" name="id">
            <!-- title -->
            <div class="form-input-group">
                <label for="updatetitle"> Title <span class="required" title="Required">*</span></label>
                <input type="text" name="title" class="form-input" id="updatetitle">
                <span class="error" id="title_error"></span>
            </div>

            <!-- name -->
            <div class="form-input-group">
                <label for="name"> Name <span class="required" title="Required">*</span></label>
                <input type="text" name="name" class="form-input" id="updatename">
                <span class="error" id="name_error"></span>
            </div>
            <!-- degree -->
            <div class="form-input-group">
                <label for="degree"> Degree <span class="required" title="Required">*</span></label>
                <input type="text" name="degree" class="form-input" id="updatedegree">
                <span class="error" id="degree_error"></span>
            </div>
            <!-- email -->
            <div class="form-input-group">
                <label for="email"> Email <span class="required" title="Required">*</span></label>
                <input type="text" name="email" class="form-input" id="updateemail">
                <span class="error" id="email_error"></span>
            </div>

            <!-- phone -->
            <div class="form-input-group">
                <label for="phone"> Phone <span class="required" title="Required">*</span></label>
                <input type="text" name="phone" class="form-input" id="updatephone">
                <span class="error" id="phone_error"></span>
            </div>

            <!-- chamber -->
            <div class="form-input-group">
                <label for="chamber"> Chamber <span class="required" title="Required">*</span></label>
                <input type="text" name="chamber" class="form-input" id="updatechamber">
                <span class="error" id="chamber_error"></span>
            </div>
            
            <!-- marketing head -->
            <div class="form-input-group">
                <label for="marketing_head"> Marketing Head <span class="required" title="Required">*</span></label>
                <input type="text" name="marketing_head" class="form-input" id="updatemarketing_head">
                <span class="error" id="marketing_head_error"></span>
            </div>
           
        
            <div class="center">
                <button type="submit" class="btn-blue" id="update">Submit</button>
            </div>
        </form>
    </div>
</div>