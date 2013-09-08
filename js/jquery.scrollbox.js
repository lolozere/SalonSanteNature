(function( $ ) {
	$.widget( "ui.scrollbox", {
		options: { duration: 1000 },
		_create: function() {
			var widget = this, container = this.element,
				position = { top: container.find('.scroll-inner').position().top, left: container.find('.scroll-inner').position().left },
				size = { width: container.find('.scroll-inner').outerWidth(), height: container.find('.scroll-inner').outerHeight() }
				panel = { width: container.outerWidth(), height: container.outerHeight() };
			
			if (container.attr('data-height') > 0) {
				panel.height = container.attr('data-height');
			}
			container.find('.scroll-control [data-direction="minimize"]').hide();
			if (panel.height >= size.height) {
				container.find('.scroll-control').hide();
				container.find('.scroll-inner').css('left', '0');
				container.css('height', 'auto');
			} else {
				container.find('.scroll-control [data-direction="minimize"]').css('cursor', 'pointer').click(function (e) {
					e.preventDefault(); e.stopPropagation();
					container.removeAttr('style');
					container.find('.scroll-control [data-direction="up"]').show();
					container.find('.scroll-control [data-direction="down"]').show();
					container.find('.scroll-control [data-direction="all"]').show();
					container.find('.scroll-control [data-direction="minimize"]').hide();
					container.find('.scroll-control').removeAttr('style');
				});
				container.find('.scroll-control [data-direction="all"]').css('cursor', 'pointer').click(function (e) {
					e.preventDefault(); e.stopPropagation();
					container.css('height', 'auto');
					container.find('.scroll-control [data-direction="up"]').hide();
					container.find('.scroll-control [data-direction="down"]').hide();
					container.find('.scroll-control [data-direction="all"]').hide();
					container.find('.scroll-control [data-direction="minimize"]').show();
					container.find('.scroll-control').css({ 'position': 'relative', 'top': '0' });
					container.find('.scroll-inner').animate({'top': 0 });
				});
				container.find('.scroll-control [data-direction="up"]').css('cursor', 'pointer').click(function (e) {
					e.preventDefault(); e.stopPropagation();
					current_position = container.find('.scroll-inner').position();
					if (current_position.top >= 0)
						return;
					height_hidden = -current_position.top;
					height_move = (height_hidden > panel.height)?panel.height:height_hidden;
					top_move = (parseInt(current_position.top)+parseInt(height_move));
					container.find('.scroll-inner').animate({'top': top_move }, widget.durationScroll(height_move, panel.height));
				});
				container.find('.scroll-control [data-direction="down"]').css('cursor', 'pointer').click(function (e) {
					e.preventDefault(); e.stopPropagation();
					current_position = container.find('.scroll-inner').position();
					height_hidden = size.height + current_position.top - panel.height;
					height_move = (height_hidden > panel.height)?panel.height:height_hidden;
					top_move = (parseInt(current_position.top)-parseInt(height_move));

					if ((panel.height-current_position.top) >= size.height)
						return;		
					
					container.find('.scroll-inner').animate({'top': top_move }, widget.durationScroll(height_move, panel.height));
				});
			}
		},
		durationScroll: function(size, panel_size) {
			return ((this.options.duration * size) / panel_size);
		}
	});
})( jQuery );