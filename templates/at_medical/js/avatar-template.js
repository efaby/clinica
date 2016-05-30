jQuery.noConflict();
(function( $ ){
	// template object
	avatarTemplate = {}
	avatarTemplate.template = { name: '', version: ''}
  	avatarTemplate.url = {}
  	avatarTemplate.menu = {}
  	avatarTemplate.image = {}
  	avatarTemplate.layout = {}
  	avatarTemplate.settingPanel = {}
  	
  	avatarTemplate.url.getVar = function (url) 
  	{
  		var vars = {},
	    	parts = url.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) { vars[key] = value; });
	    return vars;
	}
  	avatarTemplate.image.initEffects = function () {
  		avatarImage.effects.overlay();
  	}
  	avatarTemplate.layout.init = function () {
  		avatarLayout.functions.sameHeightCols($('#avatar-body-middle > div:not(".clearbreak")'));
  	}
	avatarTemplate.settingPanel.init = function () {
		avatarSettingPanel.init();
  		avatarSettingPanel.background.change('#avatar-settings .bg-image .item'); 
  	}
  	
  	
  	// Avatar Image
  	avatarImage = {}
	avatarImage.effects = {}
	avatarImage.effects.overlay = function () 
	{
		$("div[class*='img-']").each(function()
		{
			var wrap = $(this),
			wh = wrap.height();
			ww = wrap.width();	
			wrap.find('img').each(function(){
				var img = $(this);
				ih = img.height();
				iw = img.width();
				img.css({top: (wh - ih)/2 + 'px', left : (ww - iw)/2 + 'px'});
			});
		});
	}
	
	// Template Layout
	avatarLayout = {}
	avatarLayout.functions = {}
	avatarLayout.functions.sameHeightCols = function (els) 
	{
		function calSize() 
		{
			if($(window).width() > 767) 
			{ 
				if(els.length > 0) 
				{
					var $height = 0;
					
					els.each(function()
					{
						$h = $(this).height();				
						if ($h > $height) {
							$height = $h;
						}
					});	
					
					els.each(function(){
						$(this).css('min-height', $height);
					});
				}
			} else {
				els.each(function(){
						$(this).css('min-height', '');
				});
			}
		}
		$(window).load(function () {
			calSize();
		});
		
		$(window).resize(function(){
			calSize();
		});
	}
	
	// Setting Panel
	avatarSettingPanel = {}
	avatarSettingPanel.background = {}
	avatarSettingPanel.header = {}
	avatarSettingPanel.body = {}
	avatarSettingPanel.link = {}
	avatarSettingPanel.showcase = {}
	
	avatarSettingPanel.init = function () 
	{
		var panelSetting = $('#avatar-settings');
		$('#avatar-settings #close').click(function()
		{
			if (panelSetting.css('left') == '0px') {
				panelSetting.animate({ 'left': '-230px'}, 300);	
			} else {
				panelSetting.animate({ 'left': '0px'}, 300);
			}
		});
	}
	
	avatarSettingPanel.reset = function () 
	{
		var allCookies = document.cookie.split(';');
		
		for (var i=0;i<allCookies.length;i++) 
		{
			var cookiePair = allCookies[i].split('=');
			if (cookiePair[0].indexOf(avatarTemplate.template.name) != -1) {
				document.cookie = cookiePair[0] + '=;path=/';
				window.location.reload();
			}
		}
	}
	
	avatarSettingPanel.background.change = function (selector) 
	{
		$(selector).each(function ()
		{
			var self = $(this);
			self.click (function()
			{
				var bg = self.css('background-image');
				
				if (/opera/i.test(navigator.userAgent)){
					bg =  encodeURIComponent(bg);
				}
				
				document.cookie = avatarTemplate.template.name + '-background-image' + '=' + bg + ';path=/';
				$('body').css('background-image', self.css('background-image'));	
			});	
		});	
	}
	
	avatarSettingPanel.header.color = function (selector) 
	{
		$(':header').each (function () {
			$(this).css('color', selector.value);	
		});
		document.cookie = avatarTemplate.template.name + '-header-color' + '=' + selector.value + ';path=/';
	}
	
	avatarSettingPanel.body.color = function (selector) 
	{
		$('body').css('color', selector.value);	
		document.cookie = avatarTemplate.template.name + '-body-color' + '=' + selector.value + ';path=/';
	}
	
	avatarSettingPanel.showcase.change = function (selector) 
  	{
  		var self = avatarTemplate;
  		$('head').append('<link rel="stylesheet" href="' + selector + '">');
		//document.cookie = avatarTemplate.template.name + '-showcase' + '=' + selector + ';path=/';
		//window.location.reload();
   	}
   	
   	// Custom
   	
   	$(document).ready(function() {
   		$('.at-main-menu').atTouchMenuDefine();
	    $(".lazy").lazyload({
	    	effect: "fadeIn",
	    	skip_invisible : true,
	    	failure_limit : 10
	    });
		$('.at-heading-color .at-module-heading').each(function() {
           var h = $(this).html();
           var index = h.indexOf(' ');
           if(index == -1) {
               index = h.length;
           }
           $(this).html('<span class="at-heading-first-word">' + h.substring(0, index) + '</span>' + h.substring(index, h.length));
       });
       	$('.at-accordion-s1 div.panel-heading').addClass("at-icon-plus");
       	$('.at-accordion-s1 div.panel-collapse.in').parent("div.panel").find(".panel-heading").removeClass("at-icon-plus").addClass("at-icon-minus")
		$('.at-accordion-s1 div.panel-heading').on('click', function () {
			$(this).parent("div").parent(".at-accordion-s1").find(".at-icon-minus").removeClass("at-icon-minus").addClass("at-icon-plus");
			$(this).removeClass("at-icon-plus").addClass("at-icon-minus");
			$(this).parent("div.panel").find(".in").parent("div.panel").find("div.panel-heading").removeClass("at-icon-minus").addClass("at-icon-plus");
		});
	});
})( jQuery );