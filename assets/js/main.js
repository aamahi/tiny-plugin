;(function($){
    $(document).ready(function(){
        var slider = tns({
            container: ".slider",
            items : 3.3,
            slideBy :2.6,
            speed:300,
            autoWidth : true,
            autoplayTimeout:3000,
            items: 1,
            speed: 200,
            autoplay: true,
            autoHeight:false,
            controls:false,
            nav:false,
            autoplayButtonOutput:false,
            gutter : 10,
            mouseDrag : true,
            lazyload:true,
        });
    });
})(jQuery);
