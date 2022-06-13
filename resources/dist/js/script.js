$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    responsiveClass:true,
    responsive:{
        0:{
            items:2,
            nav:true,
            loop:false
        },
        768:{
            items:3,
            nav:false,
            loop:false
        },
        1100:{
            items:5,
            nav:true,
            loop:false
        }
    }
})