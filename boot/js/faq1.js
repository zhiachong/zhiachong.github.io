$(document).ready(function() {



    var block = $('#sliding_box');

    if (block.length > 0) {
        var parentBlock = block.parent();
        var blockTop = block.offset().top - 10;
        var bottomLimit = $('footer').offset().top;
        var blockLeft = 0;
        var wScrollTop = 0;
        var initCss = {position: "relative", top: "", left: ""};
        var fixedBottomCss = {position: "relative", top: bottomLimit - blockTop - block.outerHeight(true) - 40 , left: ""};

        window.registerFormStickinessHandler = function () {

            blockLeft = parentBlock.offset().left + parentBlock.outerWidth() - block.outerWidth(true);
            wScrollTop = $(window).scrollTop();
            console.log(blockLeft);
            if(wScrollTop > blockTop){
                if(wScrollTop + block.outerHeight(true) + 40> bottomLimit){
                    block.css(fixedBottomCss);
                    return;
                }
                block.css({position: "fixed", top: 10, left: blockLeft});
            } else {
                block.css(initCss);
            }

        };

        function update_bottom_limit() {
            bottomLimit = $('footer').offset().top;
            fixedBottomCss.top = bottomLimit - blockTop - block.outerHeight(true) - 40;
        }

        $('.trigger').on('click', function(e) {
            e.preventDefault();
            $(this).toggleClass('active');
            if($(this).hasClass('active')) {
                $(this).next().slideDown();
            } else {
                $(this).next().slideUp();
            }
            update_bottom_limit();
        })

        $(window).scroll(registerFormStickinessHandler);
        $(window).resize(registerFormStickinessHandler);
        window.registerFormStickinessHandler();

    }
});

