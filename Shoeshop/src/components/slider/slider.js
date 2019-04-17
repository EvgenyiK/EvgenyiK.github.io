import $ from 'jquery'
import 'slick-carousel'


$('.fade').slick({
    dots: false,
    infinite: true,
    speed: 500,
    fade: true,
    cssEase: 'linear',
    arrows: 'false',
    autoplay: 'true' ,
    pauseOnHover: 'false',
    pauseOnFocus: 'false',
});