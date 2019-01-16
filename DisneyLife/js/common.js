'use strict';

autoSlider();
var left =0;
var timer;

function autoSlider() {
    timer = setTimeout(function () {
        var menu = document.querySelector('.menu-item');
        left = left - 128;
        if (left< - 712) {
            left = 0 ;
            clearTimeout(timer);
        }
        menu.style.left = left + 'px';
        autoSlider();
    },1000);
}

var slides = document.querySelectorAll('#slides .slide');
var currentSlide = 0;
var slideInterval = setInterval(nextSlide,2000);

function nextSlide() {
    slides[currentSlide].className = 'slide';
    currentSlide = (currentSlide+1)%slides.length;
    slides[currentSlide].className = 'slide showing';
}
//3500
//взять высоту скролла для блока с видео, а затем в функции сравнивать если текущая высота скролла >= высоте скролла для блока с видео - запускать видео.

var videos = document.getElementsByTagName('video');
var info = document.getElementsByClassName('info');
var fraction = 3.5;
var video = videos[length];

function checkScroll() {
    var y = video.offsetTop,
        h = video.offsetHeight,
        b = y + h,
        visibleY;

    if (window.pageYOffset >= b ||
        window.pageYOffset + window.innerHeight < y
    ) {
        info.innerHTML = '0%';
        return;
    }
    visibleY = Math.max(0, Math.min(h, window.pageYOffset + window.innerHeight - y, b - window.pageYOffset));

    info.innerHTML = Math.round(visibleY * 100) + '%';

    if (visibleY >= fraction) {
       video.play();
    }else {video.pause();}
}

window.addEventListener('scroll', checkScroll, false);
checkScroll();





    var modal = document.querySelector("#modal"),
        modalOverlay = document.querySelector("#modal-overlay"),
        closeButton = document.querySelector("#close-button"),
        openButton = document.querySelector(".btn");

    closeButton.addEventListener("click", function() {
        modal.classList.toggle("closed");
        modalOverlay.classList.toggle("closed");
    });

    openButton.addEventListener("click", function() {
        modal.classList.toggle("closed");
        modalOverlay.classList.toggle("closed");
    });
