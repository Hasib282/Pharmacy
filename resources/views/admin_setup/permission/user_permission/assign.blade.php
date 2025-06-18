<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 100%;margin:0;padding:0;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Assign User Permission</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="EditForm" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" id="id" name="id">
            <div class="rows">
                <div class="c-8"><h4 id="userid"></h4></div>
                <div class="c-4">
                    <label style="float: right;">
                        <input type="checkbox" id="select-all"> Select All
                    </label>
                </div>
            </div>
            
            <hr>
            
            <input type="hidden" name="user" id="user">
            <div class="form-input-group">
                <div id="permission-container">

                </div>
            </div>
            <span class="error" id="update_permissions_error"></span>
            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</div>