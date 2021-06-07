
/*********Arrow disable*********/
var checkitem = function() {
  var $this;
  $this = $("#itemCarousel");
  if ($("#itemCarousel .carousel-inner .item:first").hasClass("active")) {
    $this.children(".left").hide();
    $this.children(".right").show();
  } else if ($("#itemCarousel .carousel-inner .item:last").hasClass("active")) {
    $this.children(".right").hide();
    $this.children(".left").show();
  } else {
    $this.children(".carousel-control").show();
  }
};

checkitem();

$("#itemCarousel").on("slid.bs.carousel", "", checkitem);

/*********E O Arrow disable*********/


/*********Item Slider*********/
$('.carousel[data-type="multi"] .item').each(function(){
  var next = $(this).next();
  if (!next.length) {
	next = $(this).siblings(':first');
  }
  next.children(':first-child').clone().appendTo($(this));

  for (var i=0;i<1;i++) {
	next=next.next();
	if (!next.length) {
		next = $(this).siblings(':first');
	}

	next.children(':first-child').clone().appendTo($(this));
  }
});
/***/
$('.carousel[data-type="multiple"] .item').each(function(){
  var next = $(this).next();
  if (!next.length) {
	next = $(this).siblings(':first');
  }
  next.children(':first-child').clone().appendTo($(this));

  for (var i=0;i<10;i++) {
	next=next.next();
	if (!next.length) {
		next = $(this).siblings(':first');
	}

	next.children(':first-child').clone().appendTo($(this));
  }
});
/***/
$('.carousel[data-type="multiples"] .item').each(function(){
  var next = $(this).next();
  if (!next.length) {
	next = $(this).siblings(':first');
  }
  next.children(':first-child').clone().appendTo($(this));

  for (var i=0;i<10;i++) {
	next=next.next();
	if (!next.length) {
		next = $(this).siblings(':first');
	}

	next.children(':first-child').clone().appendTo($(this));
  }
});
/***/
$('.carousel[data-type="multipro"] .item').each(function(){
  var next = $(this).next();
  if (!next.length) {
	next = $(this).siblings(':first');
  }
  next.children(':first-child').clone().appendTo($(this));

  for (var i=0;i<2;i++) {
	next=next.next();
	if (!next.length) {
		next = $(this).siblings(':first');
	}

	next.children(':first-child').clone().appendTo($(this));
  }
});
/*********E O Item Slider*********/
/************Nav right to left slide************/
$(document).ready(function() {
	var sideslider = $('[data-toggle=collapse-side]');
	var sel = sideslider.attr('data-target');
	var sel2 = sideslider.attr('data-target-2');
	sideslider.click(function(event){
		$(sel).toggleClass('in');
		$(sel2).toggleClass('out');
	});
});
/**********E O Nav right to left slide**********/
/****To close while opening another mobile header menu****/
$(document).ready(function(){
$('.notif-btn-cnt').on('click',function(){
	if($('.cart-btn-cnt').hasClass('collapsed') == false){
		$('.cart-btn-cnt').addClass('collapsed');
		$('#mobile-cart').removeClass('in');
	}
});
$('.cart-btn-cnt').on('click',function(){
	if($('.notif-btn-cnt').hasClass('collapsed') == false){
		$('.notif-btn-cnt').addClass('collapsed');
		$('#notificationid').removeClass('in');
	}
});
$('.notif-btn-cnt').on('click',function(){
	if($('#side-navigation').hasClass('in') == false){
		$('#side-navigation').addClass('in');
		$('.side-collapse-container').removeClass('out');
	}
});
$('.cart-btn-cnt').on('click',function(){
	if($('#side-navigation').hasClass('in') == false){
		$('#side-navigation').addClass('in');
		$('.side-collapse-container').removeClass('out');
	}
});
$('.side-slide-btn').on('click',function(){
	if($('#mobile-cart').hasClass('in') == true){
		$('#mobile-cart').removeClass('in');
	}
});
$('.side-slide-btn').on('click',function(){
	if($('#notificationid').hasClass('in') == true){
		$('#notificationid').removeClass('in');
		$('body').css('overflow-y','hidden');
	}
});
$('.side-slide-btn').on('click',function(){
	if($('.side-collapse-container').hasClass('out') == true){
		$('body').css('overflow-y','hidden');
	}else{
		$('body').css('overflow-y','scroll');
	}
});
$('.notif-btn-cnt').on('click',function(){
	if(!$('#notificationid').hasClass('in') == true){
		$('body').css('overflow-y','hidden');
	}else{
		$('body').css('overflow-y','scroll');
	}
});

$('.cart-btn-cnt').on('click',function(){
	if(!$('#mobile-cart').hasClass('in') == true){
		$('body').css('overflow-y','hidden');
	}else{
		$('body').css('overflow-y','scroll');
	}
});
});


/****E O To close while opening another mobile header menu****/

/****To avoid background scroll while opening the popup****/
$(document).on('show.bs.modal', function (event) {
	if (!event.relatedTarget) {
		$('.modal').not(event.target).modal('hide');
	};
	if ($(event.relatedTarget).parents('.modal').length > 0) {
		$(event.relatedTarget).parents('.modal').modal('hide');
	};
});

$(document).on('shown.bs.modal', function (event) {
	if ($('body').hasClass('modal-open') == false) {
		$('body').addClass('modal-open');
	};
});
/****E O To avoid background scroll while opening the popup****/
/****Product page image magnifier****/
(function($){
  var defaults = {
    cursorcolor:'255,255,255',
    opacity:0.5,
    cursor:'crosshair',
    zindex:2147483647,
    zoomviewsize:[480,395],
    zoomviewposition:'right',
    zoomviewmargin:10,
    zoomviewborder:'none',
    magnification:1.925
  };

  var imagezoomCursor,imagezoomView,settings,imageWidth,imageHeight,offset;
  var methods = {
    init : function(options){
      $this = $(this),
      imagezoomCursor = $('.imagezoom-cursor'),
      imagezoomView = $('.imagezoom-view'),
      $(document).on('mouseenter',$this.selector,function(e){
        var data = $(this).data();
        settings = $.extend({},defaults,options,data),
        offset = $(this).offset(),
        imageWidth = $(this).width(),
        imageHeight = $(this).height(),
        cursorSize = [(settings.zoomviewsize[0]/settings.magnification),(settings.zoomviewsize[1]/settings.magnification)];
        if(data.imagezoom == true){
          imageSrc = $(this).attr('src');
        }else{
          imageSrc = $(this).get(0).getAttribute('data-imagezoom');
        }

        var posX = e.pageX,posY = e.pageY,zoomViewPositionX;
        $('body').prepend('<div class="imagezoom-cursor">&nbsp;</div><div class="imagezoom-view"><img src="'+imageSrc+'"></div>');

        if(settings.zoomviewposition == 'right'){
          zoomViewPositionX = (offset.left+imageWidth+settings.zoomviewmargin);
        }else{
          zoomViewPositionX = (offset.left-imageWidth-settings.zoomviewmargin);
        }

        $(imagezoomView.selector).css({
          'position':'absolute',
          'left': zoomViewPositionX,
          'top': offset.top,
          'width': cursorSize[0]*settings.magnification,
          'height': cursorSize[1]*settings.magnification,
          'background':'#000',
          'z-index':2147483647,
          'overflow':'hidden',
          'border': settings.zoomviewborder
        });

        $(imagezoomView.selector).children('img').css({
          'position':'absolute',
          'width': imageWidth*settings.magnification,
          'height': imageHeight*settings.magnification,
        });

        $(imagezoomCursor.selector).css({
          'position':'absolute',
          'width':cursorSize[0],
          'height':cursorSize[1],
          'background-color':'rgb('+settings.cursorcolor+')',
          'z-index':settings.zindex,
          'opacity':settings.opacity,
          'cursor':settings.cursor
        });
        $(imagezoomCursor.selector).css({'top':posY-(cursorSize[1]/2),'left':posX});
        $(document).on('mousemove',document.body,methods.cursorPos);
      });
    },
    cursorPos:function(e){
      var posX = e.pageX,posY = e.pageY;
      if(posY < offset.top || posX < offset.left || posY > (offset.top+imageHeight) || posX > (offset.left+imageWidth)){
        $(imagezoomCursor.selector).remove();
        $(imagezoomView.selector).remove();
        return;
      }

      if(posX-(cursorSize[0]/2) < offset.left){
        posX = offset.left+(cursorSize[0]/2);
      }else if(posX+(cursorSize[0]/2) > offset.left+imageWidth){
        posX = (offset.left+imageWidth)-(cursorSize[0]/2);
      }

      if(posY-(cursorSize[1]/2) < offset.top){
        posY = offset.top+(cursorSize[1]/2);
      }else if(posY+(cursorSize[1]/2) > offset.top+imageHeight){
        posY = (offset.top+imageHeight)-(cursorSize[1]/2);
      }

      $(imagezoomCursor.selector).css({'top':posY-(cursorSize[1]/2),'left':posX-(cursorSize[0]/2)});
      $(imagezoomView.selector).children('img').css({'top':((offset.top-posY)+(cursorSize[1]/2))*settings.magnification,'left':((offset.left-posX)+(cursorSize[0]/2))*settings.magnification});

      $(imagezoomCursor.selector).mouseleave(function(){
        $(this).remove();
      });
    }
  };

  $.fn.imageZoom = function(method){
    if(methods[method]){
      return methods[method].apply( this, Array.prototype.slice.call(arguments,1));
    }else if( typeof method === 'object' || ! method ) {
      return methods.init.apply(this,arguments);
    }else{
      $.error(method);
    }
  }

  $(document).ready(function(){
    $('[data-imagezoom]').imageZoom();
  });
})(jQuery);

/****E O Product page image magnifier****/

/**** More and less text wrapping****/

;(function ( $, window, document, undefined ) {
    // Create the defaults once
    var pluginName = 'dolessmore',
        defaults = {
      lHeight : 60
        };
    // The actual plugin constructor
    function Plugin( element, options ) {
        this.element = element;
        this.options = $.extend( {}, defaults, options) ;
        this._defaults = defaults;
        this._name = pluginName;
    this.autoHeight =  $(this.element).height();
        this.init();
    }

    Plugin.prototype.init = function () {
    var el = this.element;
    if(this.autoHeight > this.options.lHeight){
      $(el)
        .addClass('dolessmoreblock')
        .addClass('dlmcontract')
        .height(this.options.lHeight)
        .append('<div class="lm-control"><a href="javascript:void(0)" class="view-details"></a></div>');
      this.lmControl(this.autoHeight);
    }
    };

  Plugin.prototype.lmControl = function(autoHeight){
    var el = this.element,
      lH = this.options.lHeight;
    $(el).find('.lm-control a').click(function(){
      if($(this).hasClass('lmcontract')){ //do less
        $(this)
          .removeClass('lmcontract')
          .removeClass('view-less')
          .addClass('view-details');
        $(el)
          .animate({'height':lH},300)
          .addClass('dlmcontract')
          .removeClass('dlmexpand');
      }else{ //do more
        $(this)
          .addClass('lmcontract')
          .removeClass('view-details')
          .addClass('view-less');
        $(el)
          .animate({'height':autoHeight},300,function(){$(this).css({'height':'auto'})})
          .addClass('dlmexpand')
          .removeClass('dlmcontract');
      }
    });
  }
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName,
                new Plugin( this, options ));
            }
        });
    }
})( jQuery, window, document );

/*view and less button name changes */
$(document).ready(function(){
      $('.dolessmore').dolessmore();
    });

/****E O More and less text wrapping****/

/****Accordion plus minus js****/


$('#accordion1 .panel-collapse').on('hidden.bs.collapse', function(event) {
    event.stopPropagation();
    $(this).prev().find(".more-less").removeClass("glyphicon-minus").addClass("glyphicon-plus");
}).on('shown.bs.collapse', function(event) {
    event.stopPropagation();
    $(this).prev().find(".more-less").removeClass("glyphicon-plus").addClass("glyphicon-minus");
});


	/****Nested Accordion plus minus js****/

	/****E O Acoordion plus minus js****/

	/****Shop page fixed scroll ****/

	$('.leftsidebar').affix({
  offset: { top: $('header').offset().top }
});
	$('.leftsidebar1').affix({
  offset: { top: $('header').offset().top }
});
		/****E O Shop page fixed scroll ****/

		/****User Profile page Popup input ****/
$(document).ready(function(){
    $('#buttonid').click(function(){
        $('.change_home').each(function(){
            var text_classname = $(this).attr('for');
            var value = $(this).text();
            var new_html = ('<input value="' + value + '" name="' + text_classname + '" id= buttonid"' + text_classname + '">' )
			var new_html1=('save')
            $(this).replaceWith(new_html);
        });
$(this).attr('hidden','true');
    })

})
$(document).ready(function(){
    $('#buttonid1').click(function(){
        $('.change_home1').each(function(){
            var text_classname = $(this).attr('for');
            var value = $(this).text();
            var new_html = ('<input value="' + value + '" name="' + text_classname + '" id= buttonid1"' + text_classname + '">' )
            $(this).replaceWith(new_html);
        });
$(this).attr('hidden','true');
    })

})
$(document).ready(function(){
    $('#buttonid2').click(function(){
        $('.change_home2').each(function(){
            var text_classname = $(this).attr('for');
            var value = $(this).text();
            var new_html = ('<input value="' + value + '" name="' + text_classname + '" id= buttonid2"' + text_classname + '">' )
            $(this).replaceWith(new_html);
        });
$(this).attr('hidden','true');
    })

})
$(document).ready(function(){
    $('#buttonid3').click(function(){
        $('.change_home3').each(function(){
            var text_classname = $(this).attr('for');
            var value = $(this).text();
            var new_html = ('<input value="' + value + '" name="' + text_classname + '" id= buttonid3"' + text_classname + '">' )
            $(this).replaceWith(new_html);
        });
$(this).attr('hidden','true');
    })

})
$(document).ready(function(){
    $('#buttonid4').click(function(){
        $('.change_home4').each(function(){
            var text_classname = $(this).attr('for');
            var value = $(this).text();
            var new_html = ('<input value="' + value + '" name="' + text_classname + '" id= buttonid4"' + text_classname + '">' )
            $(this).replaceWith(new_html);
        });
$(this).attr('hidden','true');
    })

})
$(document).ready(function(){
    $('#buttonid5').click(function(){
        $('.change_home5').each(function(){
            var text_classname = $(this).attr('for');
            var value = $(this).text();
            var new_html = ('<input value="' + value + '" name="' + text_classname + '" id= buttonid5 title"' + text_classname + '">' )
            $(this).replaceWith(new_html);
        });
$(this).attr('hidden','true');
    })

})

/****E O User Profile page Popup input****/

$(document).ready(function(){
    $('[data-toggle="popover"]').popover();

});
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();

});
/****** Popover js ends******/



/***Profile page sidebar menu***/

$(function(){

	$('#slide-submenu').on('click',function() {
        $(this).closest('.list-group').fadeOut('slide',function(){
        	$('.mini-submenu').fadeIn();
        });

      });

	$('.mini-submenu').on('click',function(){
        $(this).next('.list-group').toggle('slide');
        $('.mini-submenu').hide();
	})
})

/***End Profile page sidebar menu***/


/**** hover dropdown js ends******/
$(function () {
   $(document).on('shown.bs.tooltip', function (e) {
      setTimeout(function () {
        $(e.target).tooltip('hide');
      }, 1000);
   });


});
$('body').on('hidden.bs.tooltip', function (e) {
    $(e.target).data("bs.tooltip").inState = { click: false, hover: false, focus: false }
});

$("a#changeBtn").click(function(evt) {
    evt.preventDefault();
    // display your menu
    // and do what's required
});
/**** tool tip js ends******/

$('#accordion_cart .panel-collapse').on('hidden.bs.collapse', function(event) {
    event.stopPropagation();
    $(this).prev().find(".more_less_cart").toggleClass("fa-angle-up fa-angle-down");
}).on('shown.bs.collapse', function(event) {
    event.stopPropagation();
    $(this).prev().find(".more_less_cart").toggleClass("fa-angle-down fa-angle-up");
});
/***** cart page accordion ends******/
/*$(document).ready(function(){

   $('#sidebar').stickySidebar({
    topSpacing: 110,
    bottomSpacing: 0,
    containerSelector: '.container',
    innerWrapperSelector: '.sidebar__inner'
   });
  });*/

/*************************stickySidebar ends******/

/******************Navigatione menu overflow option ****************************/

if($(window).width() >= 768){
  
var element = document.querySelector('.pn-ProductNav');
if( (element.offsetHeight < element.scrollHeight) || (element.offsetWidth < element.scrollWidth)){
   // your element have overflow
  $("#pnAdvancerLeft").css("display", "block");
  $("#pnAdvancerRight").css("display", "block");
  $('#pn-ProductNav_Wrapper').addClass('scrollbar');
}
else{
  //your element don't have overflow
   $("#pnAdvancerLeft").css("display", "none");
   $("#pnAdvancerRight").css("display", "none");
}
}

/********************product slider item***********************/

if($(window).width() >= 768){
  
var element = document.querySelector('.product-sec-slide');
if( (element.offsetHeight < element.scrollHeight) || (element.offsetWidth < element.scrollWidth)){
   // your element have overflow
  $(".preb").css("display", "block");
  $(".nexb").css("display", "block");
  $('#pn-ProductNav_Wrapper').addClass('scrollbar');
}
else{
  //your element don't have overflow
   $(".preb").css("display", "none");
  $(".nexb").css("display", "none");
}
}