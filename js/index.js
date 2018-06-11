$('#main').fullpage({
    navigation: true,
    paddingTop: 50,
    scrollOverflow: true,
    navigationTooltips: ['index', 'Feature', 'Function', 'About'],
    afterLoad: function (link, index) {
        switch (index) {
            case 1:
                move('#banner .imac').set('margin-top', '0').end(function () {
                    move('.text h1').set('margin-left', '0').end(function () {
                        move('.text ul').set('margin-top', '20px').end();
                    });
                });
                break;
            case 2:
                $('#features .column img').popup({
                    position: 'top center',
                    delay: {
                        show: 500,
                        hide: 0
                    }
                });
                move('#features h1').set('margin-left', '0').end(function () {
                    move('#features p').skewX(360).end(function () {
                        $('#features .ui.column').animate({
                            opacity: 1
                        }, 500);
                    });
                });
                break;
            case 3:
                move('#parts h1').rotate(360).end();
                move('#parts p').set('margin-top', '0').delay('1s').end();
                move('#parts .cards').set('margin-top', '25px').delay('1s').end();
                break;
            case 4:
            	$('#screenshots img').each(function(){
            		$(this).attr('src', $(this).data('url'));
            	});
                setInterval(function () {
                    $.fn.fullpage.moveSlideRight();
                }, 8000);
                break;

            default:
                break;
        }
    },
    onLeave: function (link, index) {
        if ($('#navbar .menu').is(':visible')) {
            $('#navbar nav').slideUp();
            $('#navbar .menu').removeClass('active').find('.icon').attr('class', 'sidebar icon');
        }
        $('#features .column img').popup('hide');
    }
});

$('#parts .card .dimmer').dimmer({
    on: 'hover'
});
