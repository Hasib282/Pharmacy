<div id="verifyModal" class="modal-container">
    <div class="modal-subject" style="width: 40%; margin:10% auto;">
        <div class="modal-heading">
            <div class="center icon-center"><i class="fa-solid fa-circle-exclamation"></i></div>
            <h3 class="center">Are you sure?</h3>
            <span class="close-modal" data-modal-id="verifyModal" style="top: 10px;">&times;</span>
        </div>
        <p class="center">Are you sure you want to verify this {{ $name }}?</p>
        <p class="center">Once you Verify you can't change it.</p>
        <div class="center button">
            <button type="button" class="btn-blue" id="yes">Verify</button>
            <button type="button" class="btn-red" id="no" data-dismiss="modal">Cancel</button>
        </div>
    </div>
</div>