! function(e) {
    "use strict";
    
    function s() {
        e(".newsletter-form").addClass("animated shake"), setTimeout(function() {
            e(".newsletter-form").removeClass("animated shake")
        }, 1e3)
    }

    function a(s, a) {
        if (s) var t = "validation-success";
        else t = "validation-danger";
        e("#validator-newsletter").removeClass().addClass(t).text(a)
    }
    jQuery(".mean-menu").meanmenu({
            meanScreenWidth: "991"
        }), e('a[href="#header-search"]').on("click", function(s) {
            s.preventDefault(), e("#header-search").addClass("open"), e('#header-search > form > input[type="search"]').focus()
        }), e("#header-search, #header-search button.close").on("click", function(s) {
            s.target !== this && "close" !== s.target.className && 27 !== s.keyCode || e(this).removeClass("open")
        }), e(".home-slides").owlCarousel({
            items: 1,
            loop: !0,
            autoplay: !0,
            nav: !0,
            responsiveClass: !0,
            dots: !1,
            autoplayHoverPause: !0,
            mouseDrag: !0,
            navText: ["<i class='icofont-bubble-left'></i>", "<i class='icofont-bubble-right'></i>"]
        }), e(".home-slides").on("translate.owl.carousel", function() {
            e(".main-banner h1").removeClass("animate__animated animate__fadeInUp").css("opacity", "0"), e(".main-banner p").removeClass("animate__animated animate__zoomIn").css("opacity", "0"), e(".main-banner .btn, .main-banner .video-btn").removeClass("animate__animated animate__fadeInDown").css("opacity", "0"), e(".main-banner .startup-image").removeClass("animate__animated animate__zoomIn").css("opacity", "0")
        }), e(".home-slides").on("translated.owl.carousel", function() {
            e(".main-banner h1").addClass("animate__animated animate__fadeInUp").css("opacity", "1"), e(".main-banner p").addClass("animate__animated animate__zoomIn").css("opacity", "1"), e(".main-banner .btn, .main-banner .video-btn").addClass("animate__animated animate__fadeInDown").css("opacity", "1"), e(".main-banner .startup-image").addClass("animate__animated animate__zoomIn").css("opacity", "1")
        }), e.fn.tilt.destroy = function() {
            e(this).each(function() {
                e(this).find(".js-tilt-glare").remove(), e(this).css({
                    "will-change": "",
                    transform: ""
                }), e(this).off("mousemove mouseenter mouseleave")
            })
        }, e(".popup-youtube").magnificPopup({
            disableOn: 320,
            type: "iframe",
            mainClass: "mfp-fade",
            removalDelay: 160,
            preloader: !1,
            fixedContentPos: !1
        }),
        function(e) {
            e(".tab ul.tabs").addClass("active").find("> li:eq(0)").addClass("current"), e(".tab ul.tabs li a").on("click", function(s) {
                var a = e(this).closest(".tab"),
                    t = e(this).closest("li").index();
                a.find("ul.tabs > li").removeClass("current"), e(this).closest("li").addClass("current"), a.find(".tab_content").find("div.tabs_item").not("div.tabs_item:eq(" + t + ")").slideUp(), a.find(".tab_content").find("div.tabs_item:eq(" + t + ")").slideDown(), s.preventDefault()
            })
        }(jQuery), e(window).on("scroll", function() {
            e(this).scrollTop() > 120 ? e(".crake-nav").addClass("is-sticky") : e(".crake-nav").removeClass("is-sticky")
        }), e(".feedback-slides").owlCarousel({
            loop: !0,
            nav: !0,
            autoplay: !0,
            autoplayHoverPause: !0,
            mouseDrag: !0,
            center: !0,
            margin: 30,
            dots: !1,
            navText: ["<i class='icofont-bubble-left'></i>", "<i class='icofont-bubble-right'></i>"],
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1200: {
                    items: 3
                }
            }
        }), e(".screenshot-slides").owlCarousel({
            loop: !0,
            nav: !0,
            autoplay: !0,
            autoplayHoverPause: !0,
            mouseDrag: !0,
            center: !0,
            margin: 30,
            dots: !1,
            navText: ["<i class='icofont-bubble-left'></i>", "<i class='icofont-bubble-right'></i>"],
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1024: {
                    items: 3
                },
                1200: {
                    items: 3
                }
            }
        }), e(".team-slides").owlCarousel({
            loop: !0,
            nav: !0,
            autoplay: !0,
            autoplayHoverPause: !0,
            mouseDrag: !0,
            margin: 30,
            dots: !1,
            navText: ["<i class='icofont-bubble-left'></i>", "<i class='icofont-bubble-right'></i>"],
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1024: {
                    items: 3
                },
                1200: {
                    items: 4
                }
            }
        }), e(".blog-slides").owlCarousel({
            autoplay: !0,
            nav: !0,
            loop: !0,
            mouseDrag: !0,
            autoplayHoverPause: !0,
            responsiveClass: !0,
            margin: 30,
            dots: !1,
            navText: ["<i class='icofont-bubble-left'></i>", "<i class='icofont-bubble-right'></i>"],
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1200: {
                    items: 3
                }
            }
        }), e(".project-slides").owlCarousel({
            autoplay: !0,
            nav: !0,
            loop: !0,
            mouseDrag: !0,
            margin: 30,
            autoplayHoverPause: !0,
            responsiveClass: !0,
            dots: !1,
            navText: ["<i class='icofont-bubble-left'></i>", "<i class='icofont-bubble-right'></i>"],
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1200: {
                    items: 4
                }
            }
        }), e(".product-slides").owlCarousel({
            autoplay: !0,
            nav: !0,
            loop: !0,
            mouseDrag: !0,
            autoplayHoverPause: !0,
            responsiveClass: !0,
            margin: 30,
            dots: !1,
            navText: ["<i class='icofont-bubble-left'></i>", "<i class='icofont-bubble-right'></i>"],
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1200: {
                    items: 3
                }
            }
        }), e(".partner-slides").owlCarousel({
            autoplay: !0,
            nav: !1,
            mouseDrag: !0,
            autoplayHoverPause: !0,
            responsiveClass: !0,
            margin: 30,
            dots: !1,
            loop: !0,
            navText: ["<i class='icofont-bubble-left'></i>", "<i class='icofont-bubble-right'></i>"],
            responsive: {
                0: {
                    items: 2
                },
                768: {
                    items: 3
                },
                1024: {
                    items: 4
                },
                1200: {
                    items: 5
                }
            }
        }), e(".product-img-slides").owlCarousel({
            items: 1,
            nav: !0,
            dots: !1,
            touchDrag: !1,
            mouseDrag: !0,
            margin: 30,
            autoplay: !0,
            smartSpeed: 500,
            loop: !0,
            autoplayHoverPause: !0,
            navText: ["<i class='icofont-bubble-left'></i>", "<i class='icofont-bubble-right'></i>"]
        }), jQuery(window).on("scroll", function() {
            e(this).scrollTop() > 800 ? e(".back-to-top").addClass("show-back-to-top") : e(".back-to-top").removeClass("show-back-to-top")
        }), e(".back-to-top").on("click", function() {
            e("html, body").animate({
                scrollTop: "0"
            }, 500)
        }), e(".popup-btn").magnificPopup({
            type: "image",
            gallery: {
                enabled: !0
            }
        }), e(function() {
            e(".accordion").find(".accordion-title").on("click", function() {
                e(this).toggleClass("active"), e(this).next().slideToggle("fast"), e(".accordion-content").not(e(this).next()).slideUp("fast"), e(".accordion-title").not(e(this)).removeClass("active")
            })
        }), setInterval(function() {
            var s, a, t, o, i, n, l;
            s = new Date("April 26, 2025 17:00:00 PDT"), s = Date.parse(s) / 1e3, a = new Date, t = s - (a = Date.parse(a) / 1e3), o = Math.floor(t / 86400), i = Math.floor((t - 86400 * o) / 3600), n = Math.floor((t - 86400 * o - 3600 * i) / 60), l = Math.floor(t - 86400 * o - 3600 * i - 60 * n), i < "10" && (i = "0" + i), n < "10" && (n = "0" + n), l < "10" && (l = "0" + l), e("#days").html(o + "<span>Days</span>"), e("#hours").html(i + "<span>Hours</span>"), e("#minutes").html(n + "<span>Minutes</span>"), e("#seconds").html(l + "<span>Seconds</span>")
        }, 1e3), e("#tabs li").on("click", function() {
            var s = e(this).attr("id");
            e(this).hasClass("inactive") && (e(this).removeClass("inactive"), e(this).addClass("active"), e(this).siblings().removeClass("active").addClass("inactive"), e("#" + s + "_content").addClass("show"), e("#" + s + "_content").siblings("div").removeClass("show"))
        }), e("select").niceSelect(), e(".newsletter-form").validator().on("submit", function(e) {
            e.isDefaultPrevented() ? (s(), a(!1, "Please enter your email correctly.")) : e.preventDefault()
        }), e(".newsletter-form").ajaxChimp({
            url: "https://salakit.us20.list-manage.com/subscribe/post?u=a5891eb96ac2e08f22da1faf3&amp;id=a1861bcb1e",
            callback: function(t) {
                "success" === t.result ? (e(".newsletter-form")[0].reset(), a(!0, "Thank you for subscribing!"), setTimeout(function() {
                    e("#validator-newsletter").addClass("hide")
                }, 4e3)) : s()
            }
        })
         e(window).on("load", function() {
        e(".wow").length && new WOW({
            boxClass: "wow",
            animateClass: "animated",
            offset: 20,
            mobile: !0,
            live: !0
        }).init()
        }), jQuery(window).on("load", function() {
            e(".preloader-area").fadeOut()
        })

        // Buy Now Btn
	   // $('body').append("<a href='https://themeforest.net/checkout/from_item/23433969?license=regular&support=bundle_6month&_ga=2.221978392.1657781501.1653794352-1356931366.1645330919' target='_blank' class='buy-now-btn'><img src='assets/img/envato.png' alt='envato'/>Buy Now</a>");

        // Switch Btn
	    //$('body').append("<div class='switch-box'><label id='switch' class='switch'><input type='checkbox' onchange='toggleTheme()' id='slider'><span class='slider round'></span></label></div>");

}(jQuery);

// function to set a given theme/color-scheme
function setTheme(themeName) {
	localStorage.setItem('crake_theme', themeName);
	document.documentElement.className = themeName;
}
// function to toggle between light and dark theme
function toggleTheme() {
	if (localStorage.getItem('crake_theme') === 'theme-dark') {
		setTheme('theme-light');
	} else {
		setTheme('theme-dark');
	}
}
// // Immediately invoked function to set the theme on initial load
// (function () {
// 	if (localStorage.getItem('crake_theme') === 'theme-dark') {
// 		setTheme('theme-dark');
// 		document.getElementById('slider').checked = false;
// 	} else {
// 		setTheme('theme-light');
// 	document.getElementById('slider').checked = true;
// 	}
// })();