$(".owl-carousel").owlCarousel({

    lazyLoad: true,
    rewind: true,
    nav: true,
    dots: true,
    loop: true,
    margin: 10,
    responsiveClass: true,
    responsive: {
        0:{
            items: 1,
        },
        768:{
            items: 2,
        },
        1100:{
            items: 3,
        },
        1400:{
            items: 4,
            loop: false,
        }
    }
});
