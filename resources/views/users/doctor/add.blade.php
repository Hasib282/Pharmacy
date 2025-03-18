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

            <div class="rows">
                <!-- title -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="title"> Title <span class="required" title="Required">*</span></label>
                        <input type="text" name="title" class="form-input" id="title">
                        <span class="error" id="title_error"></span>
                    </div>
                </div>
                <!-- name -->
                <div class="c-8">
                    <div class="form-input-group">
                        <label for="name"> Name <span class="required" title="Required">*</span></label>
                        <input type="text" name="name" class="form-input" id="name">
                        <span class="error" id="name_error"></span>
                    </div>
                </div>
                <!-- degree -->
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="degree"> Degree <span class="required" title="Required">*</span></label>
                        <input type="text" name="degree" class="form-input" id="degree">
                        <span class="error" id="degree_error"></span>
                    </div>
                </div>
                <!-- chamber -->
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="chamber"> Chamber <span class="required" title="Required">*</span></label>
                        <input type="text" name="chamber" class="form-input" id="chamber">
                        <span class="error" id="chamber_error"></span>
                    </div>
                </div>
                <!-- email -->
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="email"> Email <span class="required" title="Required">*</span></label>
                        <input type="text" name="email" class="form-input" id="email">
                        <span class="error" id="email_error"></span>
                    </div>
                </div>
                <!-- phone -->
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="phone"> Phone <span class="required" title="Required">*</span></label>
                        <input type="text" name="phone" class="form-input" id="phone">
                        <span class="error" id="phone_error"></span>
                    </div>
                </div>
                <!-- Specialization -->
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="specialization"> Specialization <span class="required" title="Required">*</span></label>
                        <input type="text" name="specialization" class="form-input" id="specialization" autocomplete="off">
                        <div id='specialization-list'>
                            <ul>
        
                            </ul>
                        </div>
                        <span class="error" id="specialization_error"></span>
                    </div>
                </div>
                <!-- marketing head -->
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="marketing_head"> Marketing Head <span class="required" title="Required">*</span></label>
                        <input type="text" name="marketing_head" class="form-input" id="marketing_head" autocomplete="off">
                        <div id='marketing_head-list'>
                            <ul>
        
                            </ul>
                        </div>
                        <span class="error" id="marketing_head_error"></span>
                    </div>
                </div>
            </div>
            <div class="center">
                <button type="submit" class="btn-blue" id="Insert">Submit</button>
            </div>
        </form>
    </div>
</div>