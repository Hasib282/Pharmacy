function ShowData(){
    $.ajax({
        url: '/api/hospital/setup/doctors',
        method:'GET',
        success: function(res){
            console.log(res);
            let view =``;
            $.each(res.data.data, function(key,item){
                view+=`
                <tr>
                    <td>${ key + 1}</td>
                    <td>${item.title}</td>
                    <td>${item.name}</td>
                    <td>${item.degree}</td>
                    <td>${item.email}</td>
                    <td>${item.phone}</td>
                    <td>${item.chamber}</td>
                    
                    
                   
                    <td>
                        <div style="display: flex;gap:5px;">
                            <button class="open-modal" data-modal-id="editModal" id="edit"
                                    data-id="${item.id}"><i class="fas fa-edit"></i></button>
                            <button data-id="${item.id}" id="delete"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            `
            $('.load-data table tbody').html(view);
            
            
            });
        }

    });
}



$(document).ready(function(){
    ShowData();
    
    //insert data 
    $(document).on('submit','#AddForm',function(e){
        e.preventDefault();
        let fromData = new FormData(this);
        $.ajax({
            url:'/api/hospital/setup/doctors',
            method:'POST',
            processData:false,
            contentType:false,
            data:fromData,
            success:function(res){
                    console.log(res);
                    if(res.status == true){
                        // $('#addModal').hide()
                        $('#AddForm')[0].reset();
                        ShowData();
                    }
                    
            }
        })
    })

    //edit data

    $(document).on('click','#edit',function(e){
        let id = $(this).attr('data-id');
        $.ajax({
            url: '/api/hospital/setup/doctors/edit',
            data: { id },
            success: function (res) {
                    console.log(res);
                    $('#id').val(res.data.id);
                    $('#updatetitle').val(res.data.title);
                    $('#updatename').val(res.data.name);
                    $('#updatedegree').val(res.data.degree);
                    $('#updateemail').val(res.data.email);
                    $('#updatephone').val(res.data.phone);
                    $('#updatechamber').val(res.data.chamber);
                    $('#updatemarketing_head').val(res.data.marketing_head);
            

            }
        });
    })


    //update date
    $(document).on('submit','#EditForm',function(e){
        e.preventDefault();
        let fromdata = new FormData(this);

        $.ajax({
            url :'/api/hospital/setup/doctors',
            method:'POST',
            data: fromdata,
            processData:false,
            contentType:false,
            success:function(res){
                console.log(res);
                if(res.status == true){
                    
                    $('#AddForm')[0].reset();
                    $('#editModal').hide();
                    ShowData();
                }
                
        }

        })
    })

    //delete
    $(document).on('click','#confirm',function(){
        let id = $(this).attr('data-id');
        $.ajax({
            url:'/api/hospital/setup/doctors',
            method:'DELETE',
            data : {id},
            success: function(res){
                if(res.status == true){
                    $('#deleteModal').hide();
                    ShowData();
                }
            }

        })
    })


 
})


