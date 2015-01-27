jQuery(document).ready(function ($) {

    /* Transform --> Begin */
    var $menu = $('#navigation'),
            $menuItems = $('#navigation li').children('a'),
            $more = $('.more').not('.link'),
            $title_link = $('.post-title a'),
            $post_thumb_link = $('.post-thumb a').not('.zoomer'),
            $mbWrapper = $('#content_wrapper'),
            $mbClose = $mbWrapper.children('.close'),
            $mbContentItems = $mbWrapper.children('.content'),
            $mbContentInnerItems = $mbContentItems.children('.content_inner');


    Menu = (function () {

        var init = function () {
            initEventsHandler();
        },
               initEventsHandler = function () {
                    /*
                     click a link in the menu
                     */
                    $title_link.bind('click', clickin);
                    $more.bind('click', clickin);
                    $menuItems.bind('click', clickin);
                    $post_thumb_link.bind('click', clickin);


                    function clickin(e) {
                        var $this = $(this),
                                speed = $this.data('speed'),
                                easing = $this.data('easing');
                        href = $this.attr('href');

                        //if an item is not yet shown
                        if (!$menu.data('open')) {
                            //if current animating return
                            if ($menu.data('moving'))
                                return false;
                            $menu.data('moving', true);
                            $.when(openItem(speed, easing)).done(function () {
                                $menu.data({
                                    open: true,
                                    moving: false
                                });
                                showContentItem(href);
                                $mbPattern.children().fadeOut(500);
                            });

                        }
                        else
                            showContentItem(href);
                        return false;
                    }
                    ;
				$mbClose.bind('click', function(e) {
					$menu.data('open', false);
					$mbPattern.children().fadeIn(500, function() {
						$mbContentItems.hide();
						$mbWrapper.hide();
                                                //$('#cont').html();
					});
				});
                },
                /*
                 This shows a content item when there is already one shown:
                 */
                showContentItem = function () {

                    $mbContentItems.hide();
                    $mbWrapper.show();

                    $.ajax({
                        type: "POST",
                        url: href,
                        success: function (data) {
                            $('#cont').html(data);
                        }
                    });
                    var $mbContentEq = $('#cont'); //$mbContentItems.eq(pos-1);
                    $mbContentEq.show().children('.content_inner').jScrollPane();
                    //initialize(); 
                },
                /*
                 moves the boxes from the top to the center of the page,
                 and shows the respective content item
                 */
                openItem = function (speed, easing) {
                    return $.Deferred(
                            function (dfd) {
                                $mbPattern.children().each(function (i) {
                                    var $el = $(this),
                                            param = {
                                                width: '100px',
                                                height: '100px',
                                                top: 50 + 100 * Math.floor(i / 7),
                                                left: 337 + 100 * (i % 7),
                                                opacity: 1,
                                            };
                                    $el.css('-ms-transform', 'rotate(0deg)');
                                    $el.css('-webkit-transform', 'rotate(0deg)');
                                    $el.css(' transform', 'rotate(0deg)');
                                    $el.animate(param, speed, easing, dfd.resolve);

                                });
                            }
                    ).promise();
                };

        return {
            init: init
        };

    })();

    Menu.init();

    /* Transform --> End */

});


