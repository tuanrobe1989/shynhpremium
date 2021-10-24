var kenEvents = Object;
kenEvents.current_width = function () {
    return jQuery(window).width();
}
kenEvents.current_height = function () {
    return Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
}
kenEvents.menu = function () {
    jQuery('.header__menutab').click(function () {
        jQuery(this).toggleClass('actived');
        jQuery('.header__menuround').toggleClass('actived');
    })
    jQuery('.menu-item-has-children').click(function () {
        jQuery(this).toggleClass('actived');
        return false;
    })
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 400) {
            if (jQuery('.header').hasClass('header__normal') == true) {
                jQuery('.header').removeClass('header__normal').addClass('header__fixed');
            }
        } else {
            if (jQuery('.header').hasClass('header__fixed') == true) {
                jQuery('.header').removeClass('header__fixed').addClass('header__normal');
            }
        }
    })
}
kenEvents.scrollToId = function () {
    jQuery('a[href*="#"]:not([href="#"])').click(function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = jQuery(this.hash);
            target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                if (jQuery('.header__buttons').hasClass('actived')) {
                    jQuery('.header__buttons').removeClass('actived');
                }
                jQuery('html, body').animate({
                    scrollTop: target.offset().top - 70
                }, 500);
                return false;
            }
        }
    });
}
kenEvents.backTop = function () {
    jQuery('span.arrow').click(function () {
        jQuery("html, body").animate({
            scrollTop: 0
        }, 1000);
    })
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 100) {
            jQuery('span.arrow').fadeIn();
        } else {
            jQuery('span.arrow').fadeOut();
        }
    });
}
kenEvents.curlinkTo = function () {
    var curlink = window.location.href;
    if (curlink.indexOf('#') > -1) {
        curlink = curlink.split('#');
        vartoId = curlink.pop();
        if (vartoId != '') {
            setTimeout(function () {
                jQuery('html, body').animate({
                    scrollTop: (jQuery("#" + vartoId).offset().top - 70)
                }, 500);
            }, 1000);
        }
    }
}
kenEvents.popup = function () {
    jQuery('.kpopup__bg').click(function () {
        jQuery(this).closest('.kpopup').removeClass('animate__animated').removeClass('animate__fadeIn');
    })
    jQuery('.buttonpopup').click(function () {
        var buttonID = jQuery(this).attr('data-id');
        jQuery('#' + buttonID).addClass('animate__animated animate__fadeIn');
    })
    jQuery('.kpopup__buttonclose').click(function () {
        jQuery(this).closest('.kpopup').removeClass('animate__animated animate__fadeIn');
    })
}
kenEvents.gotEffects = function () {
    jQuery('.goteffect').each(function () {
        jQuery(this).addClass('re_eff');
    })
}
kenEvents.menuEffects = function () {
    jQuery('.header__menu__item').hover(function () {
        jQuery(this).addClass('actived');
    }, function () {
        jQuery(this).removeClass('actived');
    })
    jQuery('.header__menu__item.sub').hover(function () {
        jQuery(this).find('ul').eq(0).addClass('animate__animated animate__fadeIn');
        kenEvents.current_width();
        var headContainer = jQuery('.header .container').width();
        var leftOff = jQuery(this).offset().left;
        var curWidth = jQuery(this).find('ul').eq(0).outerWidth();
        var haftSubCon = leftOff - ((kenEvents.current_width() - headContainer) / 2);
        var curPoWidth = haftSubCon + curWidth;
        if (curPoWidth > headContainer) {
            jQuery(this).addClass('fixright');
        }
    }, function () {
        jQuery(this).removeClass('fixright');
        jQuery(this).find('ul').eq(0).removeClass('animate__animated animate__fadeIn');
    })
}

kenEvents.fixHeight = function () {
    jQuery('.mxHeight').matchHeight();
}

kenEvents.serviceBlock = function () {
    if (jQuery('.service_block__logos__item--img').length > 0) {
        jQuery('.service_block__logos__item--img').hover(function () {
            if (jQuery(this).hasClass('actived') == false) {
                var srcActived = jQuery(this).attr('data-src-actived');
                var src = jQuery(this).attr('src');
                jQuery(this).attr('src', srcActived);
                jQuery(this).attr('data-src-actived', src);
            }
        })
    }
    //Slider Services
    if (jQuery('.service__aside').length > 0) {
        jQuery('.service__aside').owlCarousel({
            lazyLoad: true,
            nav: false,
            loop: false,
            mouseDrag: true,
            dots: true,
            // startPosition: (actived_cate - 1),
            margin:16,
            responsive: {
                0: {
                    items: 1,
                    center: true,
                    loop: true,
                },
                580: {
                    items: 2,
                },
                767: {
                    items: 4,
                    margin:24,
                },
                1440: {
                    items: 6,
                    margin:32,
                },
            }
        });
    }

    //Slider Services
    if (jQuery('.serviceCategory').length > 0) {
        jQuery('.serviceCategory').owlCarousel({
            lazyLoad: true,
            nav: false,
            loop: false,
            mouseDrag: true,
            dots: true,
            startPosition: (actived_cate - 1),
            margin:16,
            responsive: {
                0: {
                    items: 1,
                    center: true,
                    loop: true,
                },
                580: {
                    items: 2,
                },
                767: {
                    items: 3,
                    margin:24,
                },
                1440: {
                    items: 4,
                    margin:32,
                },
            }
        });
    }

    
}

function stringToSlug(string) {
    return string
        .toString()
        .trim()
        .toLowerCase()
        .replace(/\s+/g, "-")
        .replace(/[^\w\-]+/g, "")
        .replace(/\-\-+/g, "-")
        .replace(/^-+/, "")
        .replace(/-+$/, "");
}

function emailVail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function phoneVail(phone) {
    //var re = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/;
    var re = /((09|03|07|08|05)+([0-9]{8})\b)/g;
    return re.test(phone);
}

function stringToObject(str, delimiter) {
    var result = {};
    if (str && str.length > 0) {
        str = str.split(delimiter || ',');
        for (var i = 0; i < str.length; i++) {
            var cur = str[i].split('=');
            result[cur[0]] = cur[1];
        }
    }
    return result;
}

function getParamsUrl(url) {
    var regex = /[?&]([^=#]+)=([^&#]*)/g,
        params = {},
        match;
    while (match = regex.exec(url)) {
        params[match[1]] = match[2];
    }
    return params;
}

function getCookie(name) {
    var re = new RegExp(name + "=([^;]+)");
    var value = re.exec(document.cookie);
    return (value != null) ? unescape(value[1]) : null;
}

function setCookie(name, value) {
    var today = new Date();
    var expiry = new Date(today.getTime() + 30 * 24 * 3600 * 1000);
    document.cookie = name + "=" + escape(value) + "; path=/; expires=" + expiry.toGMTString();
}
jQuery(document).ready(function () {
    kenEvents.backTop();
    kenEvents.menu();
    kenEvents.scrollToId();
    kenEvents.curlinkTo();
    kenEvents.gotEffects();
    kenEvents.menuEffects();
    kenEvents.popup();
    kenEvents.fixHeight();
    kenEvents.serviceBlock();
    jQuery('.slider__carousel').owlCarousel({
        items: 1,
        lazyLoad: true,
        nav: false,
        loop: true,
        mouseDrag: true,
        dots: true,
        autoplay: true,
        autoplayTimeout: 4500,
        autoplayHoverPause: true
    });

    jQuery('#detail-experts_carousel').owlCarousel({
        items: 1,
        lazyLoad: true,
        nav: false,
        // center:true,
        // autoWidth:true,
        loop: true,
        mouseDrag: true,
        dots: true,
    });

    jQuery('#our-experts_carousel').owlCarousel({
        // items:1,
        lazyLoad: true,
        nav: false,
        // center:true,
        // autoWidth:true,
        loop: true,
        mouseDrag: true,
        dots: true,
        responsive: {
            0: {
                items: 1,
            },
            580: {
                items: 2,
            },
            767: {
                items: 3,
            },
            980: {
                items: 4,
            },
        }
    });

    jQuery('#enjoy-the-difference__slider').owlCarousel({
        // items:1,
        lazyLoad: true,
        nav: false,
        center: true,
        loop: true,
        mouseDrag: true,
        dots: true,
        responsive: {
            0: {
                items: 1,
                stagePadding: 50,
            },
            767: {
                items: 2,
                margin: 14,
            },
            991: {
                items: 2,
            },
            1199: {
                items: 3,
            }
        }
    });

})
jQuery(function () {
    function logElementEvent(eventName, element) {
        //console.log(Date.now(), eventName, element.getAttribute("data-src"));
    }

    var callback_enter = function (element) {
        logElementEvent("🔑 ENTERED", element);
    };
    var callback_exit = function (element) {
        logElementEvent("🚪 EXITED", element);
    };
    var callback_loading = function (element) {
        logElementEvent("⌚ LOADING", element);
    };
    var callback_loaded = function (element) {
        logElementEvent("👍 LOADED", element);
    };
    var callback_error = function (element) {
        logElementEvent("💀 ERROR", element);
        element.src =
            "https://via.placeholder.com/440x560/?text=Error+Placeholder";
    };
    var callback_finish = function () {
        logElementEvent("✔️ FINISHED", document.documentElement);
    };
    var callback_cancel = function (element) {
        logElementEvent("🔥 CANCEL", element);
    };

    var ll = new LazyLoad({
        threshold: 0,
        // Assign the callbacks defined above
        callback_enter: callback_enter,
        callback_exit: callback_exit,
        callback_cancel: callback_cancel,
        callback_loading: callback_loading,
        callback_loaded: callback_loaded,
        callback_error: callback_error,
        callback_finish: callback_finish
    });
});