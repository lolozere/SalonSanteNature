(function( $ ) {
	$.widget( "ui.scrollbox", {
		options: { duration: 1000 },
		_create: function() {
			var widget = this, container = this.element,
				position = { top: container.find('.scroll-inner').position().top, left: container.find('.scroll-inner').position().left },
				size = { width: container.find('.scroll-inner').outerWidth(), height: container.find('.scroll-inner').outerHeight() }
				panel = { width: container.outerWidth(), height: container.outerHeight() };
			
			if (panel.height >= size.height) {
				container.find('.scroll-control').hide();
				container.find('.scroll-inner').css('left', '0');
				container.css('height', 'auto');
			} else {
				container.find('.scroll-control [data-direction="up"]').css('cursor', 'pointer').click(function (e) {
					e.preventDefault(); e.stopPropagation();
					current_position = container.find('.scroll-inner').position();
					if (current_position.top >= 0)
						return;
					height_hidden = -current_position.top;
					height_move = (height_hidden > panel.height)?panel.height:height_hidden;
					container.find('.scroll-inner').animate({'top': (current_position.top+height_move) }, widget.durationScroll(height_move, panel.height));
				});
				container.find('.scroll-control [data-direction="down"]').css('cursor', 'pointer').click(function (e) {
					e.preventDefault(); e.stopPropagation();
					current_position = container.find('.scroll-inner').position();
					height_hidden = size.height - panel.height - current_position.top;
					if ((panel.height-current_position.top) >= size.height)
						return;
					height_move = (height_hidden > panel.height)?panel.height:height_hidden;
					container.find('.scroll-inner').animate({'top': (current_position.top-height_move) }, widget.durationScroll(height_move, panel.height));
				});
			}
		},
		durationScroll: function(size, panel_size) {
			return ((this.options.duration * size) / panel_size);
		}
	});
})( jQuery );