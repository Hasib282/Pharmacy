// $(document).ready(function () {
    function SidebarAjax() {
        ///////////////////////// --------------- Toggle sidebar Functionality Start ----------------- ///////////////
        const sideNav = document.getElementById("mySidenav");
        // console.log(document)
        $(document).on('click','.toggle-sidebar',function(){
            if (sideNav.classList.contains("hide")) {
                sideNav.classList.remove("hide");
            }
            else{
                sideNav.classList.add("hide");
            }
        });


        //////////// -------------------- On click navbar-tree unhide navbar-link part start -------------- //////////////
        $('.navbar-tree').click(function () {
            const submenu = $(this).next('ul');
            submenu.toggleClass('show');
        
            const rightIcon = $(this).children().last();
            if (rightIcon.hasClass('fa-angle-right')) {
                rightIcon.toggleClass('rotate');
            }
        });
        



        ////////////// -------------------- Navbar link activ functionality part start ----------------- ///////////
        $('.navbar-link').click(function () {
            // Remove 'active' class from all tree and links
            $('.navbar-tree').removeClass('active');

            $('.sub-navbar-tree').removeClass('active');

            $('.sub-navbar-link').removeClass('active');
        
            // Remove 'active' class from all navbar-links except the clicked one
            $('.navbar-link').not(this).removeClass('active');
            
            // Add 'active' class to the clicked navbar-link
            $(this).addClass('active');
        
            // Add 'active' class to the closest parent navbar-tree
            $(this).closest('ul').prev().addClass('active');
        });


        ///////////---------------- Navbar link activ functionality part start -------------------////////////
        $('.sub-link').click(function () {
            // Remove 'active' class from all tree and links
            $('.navbar-tree').removeClass('active');

            $('.navbar-link').removeClass('active');
            
            // Add 'active' class to the clicked navbar-link
            $(this).addClass('active');
        
            // Add 'active' class to the closest parent sub-navbar-tree
            $(this).closest('ul').prev().addClass('active');

            // Add 'active' class to the closest parent navbar-tree
            $(this).closest('ul').parent().parent().prev().addClass('active');
            
        });
    }
    



    





            

    // const navbar = document.querySelectorAll('.navbar-link');
    
    // const navbarArray = Array.from(navbar);
    // // Add click event listener to each drop-navbar-link element
    // navbarArray.forEach(function (nav) {
    //     nav.addEventListener('click', function (event) {
    //         navbarArray.forEach(function (other) {
    //             console.log('abc');
    //             other.classList.remove('active');
    //         });
    //         // Toggle active class on clicked link
    //         nav.classList.toggle('active');

    //         // Toggle display of sibling ul element
    //         // const submenu = nav.nextElementSibling;
    //         // if (submenu && submenu.classList) {
    //         //     if (submenu.classList.contains('show')) {
    //         //         submenu.classList.remove('show');
    //         //         submenu.style.maxHeight = null;
    //         //     } else {
    //         //         submenu.classList.add('show');
    //         //     }
    //         // }

    //         // // Rotate the right icon
    //         // const rightIcon = nav.querySelector('.right');
    //         // const active = nav.querySelector('.active');
    //         // if (rightIcon && active) {
    //         //     rightIcon.style.transform = rightIcon.style.transform ? '' : 'rotate(-90deg)';
    //         // }
    //         // else if(rightIcon){
    //         //     rightIcon.style.transform = rightIcon.style.transform ? '' : 'rotate(+90deg)';
    //         // }

    //         // Get the href value from the active sidebar menu
    //         // const active = document.querySelector('.drop-navbar-link.active');
    //         // const url = active.getAttribute('href');
    //         // if (url) {
                
    //         //     console.log(url);
    //         //     $.ajax({
    //         //         url: url,
    //         //         method: 'GET',
    //         //         success: function (res) {
    //         //             // $('.main-content').html('');
    //         //             $('.main-content').html(res);
    //         //         },
    //         //         error: function (err) {
    //         //             console.log(err);
    //         //         }
    //         //     });
    //         // }

    //     });
    // });
// });