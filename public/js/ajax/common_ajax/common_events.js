$(document).ready(function () {
    //////////////////// --------------------- Show Image When Select File ---------------- /////////////////////
    $(document).on('change','#image', function (e){
        let path = $(this).val();
        let extension = path.substring(path.lastIndexOf('.')+1).toLowerCase();
        
        if(extension == 'jpg' || extension == 'jpeg' || extension == 'png' || extension == 'gif'){
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
            else{
                $('#previewImage').attr('src', "/images/male.png");
            }
        }
        else{
            $('#previewImage').attr('src', "/images/male.png");
        }
    });


    //////////////////// --------------------- Show Update Image When Select File ---------------- /////////////////////
    $(document).on('change','#updateImage', function (e){
        let path = $(this).val();
        let extension = path.substring(path.lastIndexOf('.')+1).toLowerCase();
        
        if(extension == 'jpg' || extension == 'jpeg' || extension == 'png' || extension == 'gif'){
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#updatePreviewImage').attr('src', " ");
                    $('#updatePreviewImage').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(file);
            }
            else{
                $('#updatePreviewImage').attr('src', "/images/male.png");
            }
        }
        else{
            $('#updatePreviewImage').attr('src', "/images/male.png");
        }
    });




    /////////////// ------------------ User Details List Toggle Functionality Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '.details li', function(e){
        let id = $(this).attr('data-id');
        if(id == 1){
            if($('.general').is(':visible')){
                $('.general').hide()
            }
            else{
                $('.general').show();
            }
        }
        else if(id == 2){
            if($('.contact').is(':visible')){
                $('.contact').hide()
            }
            else{
                $('.contact').show();
            }
        }
        else if(id == 3){
            if($('.address').is(':visible')){
                $('.address').hide()
            }
            else{
                $('.address').show();
            }
        }
        else if(id == 4){
            if($('.transaction').is(':visible')){
                $('.transaction').hide()
            }
            else{
                $('.transaction').show();
            }
        }
        else if(id == 5){
            if($('.others').is(':visible')){
                $('.others').hide()
            }
            else{
                $('.others').show();
            }
        }
    }); // End Toggle  Event
    /////////////// ------------------ User Details List Toggle Functionality Ajax Part End ---------------- /////////////////////////////
    
    
    
    
    /////////////// ------------------ Show Invoice And Print Functionality Ajax Part End ---------------- /////////////////////////////
    // Show Transaction Print Details 
    $(document).off('click','#invoice').on('click','#invoice', function(e){
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        let status = $('#status').length ? $('#status').val() : 1;
        $.ajax({
            url: `${apiUrl}/transaction/get/invoice`,
            method: 'GET',
            data: { id, status },
            success: function (res) {
                $('.print-details').html(res.data);

                var modal = document.getElementById(modalId);
                modal.style.display = 'block';
            }
        });
    });



    // Print Transaction Details 
    $(document).off('click','#print').on('click','#print', function(){
        var printContent = document.getElementById("print-part").innerHTML;
        var originalContent = document.body.innerHTML;
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
    });
    /////////////// ------------------ Show Invoice And Print Functionality Ajax Part End ---------------- /////////////////////////////





    //////////////////// -------------------- Logout Button Click Event Start -------------------- ////////////////////
    $(document).on('click', '#logout', function (e) {
        e.preventDefault();
        $.ajax({
            url: `${apiUrl}/logout`,
            type: 'POST',
            success: function() {
                localStorage.removeItem('token');
                window.location.href = '/login';
            }
        });
    }); // End Logout Event
    //////////////////// -------------------- Logout Button Click Event End -------------------- ////////////////////
});