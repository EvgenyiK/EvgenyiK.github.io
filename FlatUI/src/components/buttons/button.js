import $ from 'jquery';

(function($) {
    //ripple-effect
    var parent, ink, d, x, y;
    $(".ripple").click(function(e){
        parent = $(this).parent();

        //создаём .ink элемент, если еще не создан
        if (parent.find(".ink").length == 0)
            parent.prepend("<span class='ink'></span>");

        ink = parent.find(".ink");
        //сбрасываем анимацию
        ink.removeClass("animate");

        //рассчитываем размеры .ink элемента
        //они определяются размерами родительского контейнера
        if(!ink.height() && !ink.width())
        {
            d = Math.max(parent.outerWidth(), parent.outerHeight());
            ink.css({height: d, width: d});
        }

        //получим начальные координаты,
        //центр .ink нужно поместить в точку клика
        x = e.pageX - parent.offset().left - ink.width()/2;
        y = e.pageY - parent.offset().top - ink.height()/2;

        //установим координаты и запустим анимацию
        ink.css({top: y+'px', left: x+'px'}).addClass("animate");
    })
})(jQuery);