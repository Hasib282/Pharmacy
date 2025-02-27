<div id="addModal" class="modal-container">
    <div class="modal-subject" style="width: 40%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Add {{ $name }}</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>
        <!-- form start -->
        <form id="AddForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <!-- title -->
            <div class="form-input-group">
                <label for="title"> Title <span class="required" title="Required">*</span></label>
                <input type="text" name="title" class="form-input" id="title">
                <span class="error" id="title_error"></span>
            </div>

            <!-- name -->
            <div class="form-input-group">
                <label for="name"> Name <span class="required" title="Required">*</span></label>
                <input type="text" name="name" class="form-input" id="name">
                <span class="error" id="name_error"></span>
            </div>
            <!-- degree -->
            <div class="form-input-group">
                <label for="degree"> Degree <span class="required" title="Required">*</span></label>
                <input type="text" name="degree" class="form-input" id="degree">
                <span class="error" id="degree_error"></span>
            </div>
            <!-- email -->
            <div class="form-input-group">
                <label for="email"> Email <span class="required" title="Required">*</span></label>
                <input type="text" name="email" class="form-input" id="email">
                <span class="error" id="email_error"></span>
            </div>

            <!-- phone -->
            <div class="form-input-group">
                <label for="phone"> Phone <span class="required" title="Required">*</span></label>
                <input type="text" name="phone" class="form-input" id="phone">
                <span class="error" id="phone_error"></span>
            </div>

            <!-- chamber -->
            <div class="form-input-group">
                <label for="chamber"> Chamber <span class="required" title="Required">*</span></label>
                <input type="text" name="chamber" class="form-input" id="chamber">
                <span class="error" id="chamber_error"></span>
            </div>
            
            <!-- marketing head -->
            <div class="form-input-group">
                <label for="marketing_head"> Marketing Head <span class="required" title="Required">*</span></label>
                <input type="text" name="marketing_head" class="form-input" id="marketing_head">
                <span class="error" id="marketing_head_error"></span>
            </div>
           
        
            <div class="center">
                <button type="submit" class="btn-blue" id="Insert">Submit</button>
            </div>
        </form>
    </div>
</div>