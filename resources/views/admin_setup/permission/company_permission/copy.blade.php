<div id="copyPermission" class="modal-container">
    <div class="modal-subject" style="width: 80%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Assign Permission to Another Company</h3>
                <span class="close-modal" data-modal-id="copyPermission">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="CopyForm" method="post">
            @csrf
            @method('PUT')
            <div class="rows">
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="from">From</label>
                        <input type="text" name="from" id="from" class="form-input" placeholder="select the company from whom you want to copy" autocomplete="off">
                        <div id='from-list'>
                            <ul>
        
                            </ul>
                        </div>
                        <span class="error" id="from_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="to">To</label>
                        <input type="text" name="to" id="to" class="form-input" placeholder="select the company whom you want to assign" autocomplete="off">
                        <div id='to-list'>
                            <ul>
        
                            </ul>
                        </div>
                        <span class="error" id="to_error"></span>
                    </div>
                </div>
            </div>
            <div class="center">
                <button type="submit" id="AssignCopy" class="btn-blue">Assign</button>
            </div>
        </form>
    </div>
</div>