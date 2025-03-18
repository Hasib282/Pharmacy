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
                <label for="updateTitle"> Title <span class="required" title="Required">*</span></label>
                <input type="text" name="title" class="form-input" id="updateTitle">
                <span class="error" id="update_title_error"></span>
            </div>

            <!-- name -->
            <div class="form-input-group">
                <label for="updateName"> Name <span class="required" title="Required">*</span></label>
                <input type="text" name="name" class="form-input" id="updateName">
                <span class="error" id="update_name_error"></span>
            </div>
            <!-- degree -->
            <div class="form-input-group">
                <label for="updateDegree"> Degree <span class="required" title="Required">*</span></label>
                <input type="text" name="degree" class="form-input" id="updateDegree">
                <span class="error" id="update_degree_error"></span>
            </div>
            <!-- email -->
            <div class="form-input-group">
                <label for="updateEmail"> Email <span class="required" title="Required">*</span></label>
                <input type="text" name="email" class="form-input" id="updateEmail">
                <span class="error" id="update_email_error"></span>
            </div>

            <!-- phone -->
            <div class="form-input-group">
                <label for="updatePhone"> Phone <span class="required" title="Required">*</span></label>
                <input type="text" name="phone" class="form-input" id="updatePhone">
                <span class="error" id="update_phone_error"></span>
            </div>

            <!-- chamber -->
            <div class="form-input-group">
                <label for="updateChamber"> Chamber <span class="required" title="Required">*</span></label>
                <input type="text" name="chamber" class="form-input" id="updateChamber">
                <span class="error" id="update_chamber_error"></span>
            </div>
            
            <!-- marketing head -->
            <div class="form-input-group">
                <label for="updateSpecialization"> Specialization <span class="required" title="Required">*</span></label>
                <input type="text" name="specialization" class="form-input" id="updateSpecialization" autocomplete="off">
                <div id='update-specialization'>
                    <ul>

                    </ul>
                </div>
                <span class="error" id="update_specialization_error"></span>
            </div>
            
            <!-- marketing head -->
            <div class="form-input-group">
                <label for="updateMarketing_Head"> Marketing Head <span class="required" title="Required">*</span></label>
                <input type="text" name="marketing_head" class="form-input" id="updateMarketing_Head" autocomplete="off">
                <div id='update-marketing_head'>
                    <ul>

                    </ul>
                </div>
                <span class="error" id="update_marketing_head_error"></span>
            </div>
           
        
            <div class="center">
                <button type="submit" class="btn-blue" id="update">Submit</button>
            </div>
        </form>
    </div>
</div>