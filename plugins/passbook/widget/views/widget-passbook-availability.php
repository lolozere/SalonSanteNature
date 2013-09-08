<?php $id = uniqid(); 
?>
<script>
!function ($) {
	$(document).ready(function() {
		var panel = $('#passbook-availability_<?php echo $id;?>');
		// Get data
		var url_proxy = '<? echo get_template_directory_uri();?>/plugins/passbook/proxy.php';
		var request = '<?php echo $api_url;?>/availability?animationsId=<?php echo rawurlencode($animationsId);?>';
		$.getJSON(url_proxy, { csurl: request },  function(data) {
				var availability = data;
				
				// Display
				if (typeof availability == 'object' && availability.length > 0) {
					panel.find(' > div').show();
					for(var i = 0; i<availability.length; i++) {
						// Nb elements
						var propName;
						var numberOfElements = 0;
						for (propName in availability[i].slots) numberOfElements++;
						
						panel.append('<section class="passbook_availability"><header><h4>'+availability[i].name+'</h4></header><div class="scroll" data-toggle="scrollbox" style="height: 150px"><div class="scroll-inner"></div><div class="scroll-control"><i class="icon-arrow-up" data-direction="up"></i><i class="icon-arrow-down" data-direction="down"></i></div></div></section>');
						var section = panel.find('section.passbook_availability:last div.scroll-inner');
						
						if (numberOfElements <= 0) {
							section.append('<p>Aucun créneau horaire</p>');
						} else {
							section.append('<table border="0" cellpadding="1" cellspacing="1"><tbody></tbody></table>');
							$.each(availability[i].slots, function(key, hours) {
								section.find('tbody').append('<tr><td class="passbook_availability_day" colspan="2">'+key+'</td></tr>');
								$.each(hours, function(hour_i, data) {
									section.find('tbody').append('<tr><td class="passbook_availability_notice '+((data.full)?'full':'open')+'"></td><td class="passbook_availability_date">'+data.hour+'</td></tr>');
								});
							});
						}
					}
				} else {
					panel.html('Disponibilité des créneaux horaires non connue');
				}

				// Hide loading
				panel.find('img').hide();
				// Show
				$('.passbook_availability').show();
				$('.passbook_availability [data-toggle="scrollbox"]').each(function() { $(this).scrollbox(); });
				
		}).fail(function( jqxhr, textStatus, error ) {
			var err = textStatus + ', ' + error;
			console.log( "Request Failed: " + err);
		});
	});
}(window.jQuery);
</script>
<div id="passbook-availability_<?php echo $id;?>" class="passbook-availability">
<div style="display: none;">
	<p>
		Avant de prendre rendez-vous, vous devez <a href="http://www.salon-sante-nature.fr/entree-gratuite/#reservation">commander votre e-ticket PASS Bien-être</a>.<br />
		Puis programmez vos rendez-vous sur <a href="http://pass.salon-sante-nature.fr">notre plateforme de réservation.</a>
	</p>
	<p><strong>Légende</strong></p>
	<table border="0" cellpadding="1" cellspacing="1">
		<tbody>
		<tr><td class="passbook_availability_notice open"></td><td>Horaire disponible</td>
		<td class="passbook_availability_notice full"></td><td>Horaire complet</td></tr>
		</tbody>
	</table>
	<p></p>
</div>
<img src="<?php echo get_template_directory_uri() . '/images/loading.gif'; ?>" alt="Chargement en cours" title="Chargement en cours" />
</div>