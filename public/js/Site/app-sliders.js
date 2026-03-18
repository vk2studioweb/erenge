function slickmobilecheck(){
    var win = $(this);  //Global Window element to resize

    // Verify size width < 800
    if(win.width() < 800){
        var slideimg = $('.banner-slide-img img').first();

        if(slideimg.length >= 1){
            if(slideimg[0].hasAttribute('data-lazymobile')){
                $.each($('.banner-slide-img'), function () {

                    var lazyDesktop = $(this).find('img').attr('src'),
                        lazyMobile = $(this).find('img').attr('data-lazymobile');

                    $(this).find('img').attr('data-lazy', lazyMobile).attr('data-lazydesktop', lazyDesktop).removeAttr('data-lazymobile');

                });

                if($('.banner-slider.slick-initialized').length){ $('.banner-slider').slick('refresh') };
            }
        }
    }

    if(win.width() >= 800){
        var slideimg = $('.banner-slide-img img').first();

        if(slideimg.length >= 1){
            if(slideimg[0].hasAttribute('data-lazydesktop')){
                $.each($('.banner-slide-img'), function () {

                    var lazyMobile = $(this).find('img').attr('src'),
                        lazyDesktop = $(this).find('img').attr('data-lazydesktop');

                    $(this).find('img').attr('data-lazy', lazyDesktop).attr('data-lazymobile', lazyMobile).removeAttr('data-lazydesktop');
                });
               if($('.banner-slider.slick-initialized').length){ $('.banner-slider').slick('refresh') };
            }
        }
    }
}

$(window).on("load", function (e) {

    slickmobilecheck();

	let banner = $('#banner');
	banner.slick({
		autoplay: true,
		dots: false,
		arrows: false,
		lazyLoad: 'ondemand',
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
        autoplaySpeed: 10000
	});

	let stories = $('.company-stories-list');
	var updateSliderCounter = function (slick, currentIndex) {
		var currentSlide = slick.slickCurrentSlide() + 1;
		var html = '<strong class="paginate-numbers-actual">' + currentSlide + '</strong>/<span class="paginate-numbers-last">' + slick.slideCount + '</span>';
		$('.company-stories-number').html(html);
	};
	stories.on('init', function (event, slick) {
		updateSliderCounter(slick);
	});
	stories.on('afterChange', function (event, slick, currentSlide) {
		updateSliderCounter(slick, currentSlide);
	});


	stories.slick({
		autoplay: false,
		dots: false,
		arrows: true,
		lazyLoad: 'ondemand',
		infinite: false,
		slidesToShow: 1,
		slidesToScroll: 1,
		prevArrow: $('.company-stories-arrows-prev'),
		nextArrow: $('.company-stories-arrows-next'),
	});
});
$(window).resize(function () {
	// Variaveis de altura e largura novas da tela
	var viewportWidth = $(window).width();
	var viewportHeight = $(window).height();

    slickmobilecheck();
});

/*
prevArrow: $('.prev')
nextArrow: $('.next')*/
