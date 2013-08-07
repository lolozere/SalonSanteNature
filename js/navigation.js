!function ($) {
	$(document).ready(function() {
		var elementSelected = $('#site-navigation-menu .menu-rubrique.default');
		var defaultSelected = $('#site-navigation-menu .menu-rubrique.default');
		var selected = 'header-'+ elementSelected.attr('data-rubrique');
		var out = false;
		
		var getIndex = function(e, elt) {
			var offset = elt.offset();
			var mouse = { x: (e.pageX - offset.left), y: (e.pageY - offset.top) };
			
			if (mouse.y >= 100)
				return null;
			if (mouse.x >= 0 && mouse.x < 185) {
				linkPosition = 0;
			} else if (mouse.x >= 185 && mouse.x < 370) {
				linkPosition = 1;
			} else if (mouse.x >= 370 && mouse.x < 555) {
				linkPosition = 2;
			} else if (mouse.x >= 555 && mouse.x < 740) {
				linkPosition = 3;
			} else {
				linkPosition = 4;
			}
			return linkPosition;
		};
		
		$('#site-navigation-menu').each(function() {
			// Mouse
			$(this).mousemove(function(e) {
				out = false;
				linkPosition = getIndex(e, $(this));
				if (linkPosition == null)
					return;
				
				elementSelected = $('#site-navigation-menu li.menu-rubrique:eq('+linkPosition+')');
				
				// Background
				if (! $('#masthead').hasClass('header-'+elementSelected.attr('data-rubrique'))) {
					$('#masthead').removeClass(selected);
					$('#masthead').addClass('header-'+elementSelected.attr('data-rubrique'));
					selected = 'header-'+elementSelected.attr('data-rubrique');
				}
				
				// Changes
				if (!elementSelected.hasClass('off'))
					return;
				
				$('#site-navigation-menu .menu-rubrique:not([class~="off"])').addClass('off');
				elementSelected.removeClass('off');
			});
			$(this).mouseout(function(e) {
				out = true;
				setTimeout(function() {
					if (out && elementSelected.attr('id') != defaultSelected.attr('id')) {
						elementSelected.addClass('off');
						defaultSelected.removeClass('off');
						$('#masthead').removeClass('header-'+elementSelected.attr('data-rubrique'));
						$('#masthead').addClass('header-'+defaultSelected.attr('data-rubrique'));
						selected = 'header-'+defaultSelected.attr('data-rubrique');
					}
				}, 500);
			});
		})
	})
}(window.jQuery);