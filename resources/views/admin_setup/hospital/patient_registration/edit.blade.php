<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 40%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit {{ $name }}</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>
       
         <!-- form start -->
         <form id="EditForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="id" name="id">
            <!-- pid -->
            <div class="form-input-group">
                <label for="ptn_id">Patient Id<span class="required" title="Required">*</span></label>
                <input type="text" name="ptn_id" class="form-input" id="ptn_id">
                <span class="error" id="ptn_id_error"></span>
            </div>
  
            <!-- Rid -->
            <div class="form-input-group">
                <label for="reg_id"> Registration Id <span class="required" title="Required">*</span></label>
                <input type="text" name="reg_id" class="form-input" id="reg_id">
                <span class="error" id="reg_id_error"></span>
            </div>

          
           
            
            <!-- Bed list -->
            <div class="form-input-group">
                <label for="bed_list">Bed list<span class="required" title="Required">*</span></label>
                <input type="text" name="bed_list" class="form-input" id="bed_list">
                <span class="error" id="bed_list_error"></span>
            </div>

            <!-- Doctor -->
            <div class="form-input-group">
                <label for="doctor"> Doctor <span class="required" title="Required">*</span></label>
                <input type="text" name="doctor" class="form-input" id="doctor">
                <span class="error" id="doctor_error"></span>
            </div>

             <!-- Sells_representative(SR) -->
             <div class="form-input-group">
                <label for="sr_id"> Sells_representative(SR) Id <span class="required" title="Required">*</span></label>
                <input type="text" name="sr_id" class="form-input" id="sr_id">
                <span class="error" id="sr_id_error"></span>
            </div>

              <!-- Admission By -->
            <div class="form-input-group">
                <label for="addmission_by">Admission By<span class="required" title="Required">*</span></label>
                <input type="text" name="addmission_by" class="form-input" id="addmission_by">
                <span class="error" id="addmission_by_error"></span>
            </div>

           
          
            <div class="center">
                <button type="submit" class="btn-blue" id="Insert">Submit</button>
            </div>
        </form>
    </div>
</div>