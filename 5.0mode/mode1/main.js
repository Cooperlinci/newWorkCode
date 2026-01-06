// zbanner_init();

index_show_video($(".video_btn"));
    var swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    slidesPerGroup: 1,
    loop: true,
    autoplay:true,
    loopFillGroupWithBlank: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".ro_prev",
        prevEl: ".ro_next",
    },
    breakpoints: {
        768: { //当屏幕宽度大于等于320
        slidesPerView: 1,
        slidesPerGroup: 1,
        }
    }
});


$('.ro_next').click(function(){

    $(this).css('background','#0075c2')
    $(this).find('span').css('background','url(../../../../static/themes/t245/images/arrow_l_w.png) no-repeat center')
    $('.ro_prev').css('background','unset')
    $('.ro_prev').find('span').css('background','url(../../../../static/themes/t262/images/arrow_r_w.png) no-repeat center')
})

$('.ro_prev').click(function(){

    $(this).css('background','#0075c2')
    $(this).find('span').css('background','url(../../../../static/themes/t245/images/arrow_r_w.png) no-repeat center')
    $('.ro_next').css('background','unset')
    $('.ro_next').find('span').css('background','url(../../../../static/themes/t262/images/arrow_l_w.png) no-repeat center')
})