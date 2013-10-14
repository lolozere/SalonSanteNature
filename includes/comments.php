<?php
/**
 * Send an email to exposant when comment approved
 * 
 * @author Laurent
 * 
 */
function ssn_send_comment_alert($comment) {
	global $ssn_emails_orga;
	
	// Get the email attached to post
	$email = get_post_meta( $comment->comment_post_ID, SSN_FICHE_META_PREFIX . "email", true );
	$exposants_sent = false;
	if (!empty($email)) {
		$exposants_sent = true;
		// Send email to exposant
		$message = 'Bonjour,
		
Un nouveau commentaire a été déposé la fiche internet du Salon Santé Nature et vous présentant.
Nous vous invitons à y répondre : ' . get_permalink($comment->comment_post_ID) . '
		
Paix et Joie,
Le Salon Santé Nature';
		
		$headers = '';
		if (!empty($ssn_emails_orga) && is_array($ssn_emails_orga[0])) {
			if (!empty($ssn_emails_orga[0]['name']) && !empty($ssn_emails_orga[0]['email'])) {
				$headers = 'From: ' . $ssn_emails_orga[0]['name'] . ' <'.$ssn_emails_orga[0]['email'].'>' . "\r\n";
			} elseif (!empty($ssn_emails_orga[0]['email'])) {
				$headers = 'From: '.$ssn_emails_orga[0]['email']. "\r\n";
			}
		}
		wp_mail($email, "Salon Santé Nature - Nouveau commentaire sur votre fiche", $message, $headers);
	}
	
	// Send email to orgas
	$message = 'Bonjour #name
	
Un commentaire a été publiée sur le site internet du Salon Santé Nature à l\'adresse suivante : 
' . get_permalink($comment->comment_post_ID) . '
	 ';
	if ($exposants_sent) {
		$message .= '
Un email a été envoyé à ' . $email . ' pour l\'informer afin d\'y répondre.';
	} else {
		$message .= '
Nous vous invitons à y répondre.';
	}
	$message .= '
Paix et Joie,
-- Email envoyé automatiquement par le site suite à l\'approbation du commentaire par le webmaster.';
	
	foreach($ssn_emails_orga as $orga) {
		$headers = 'From: Webmaster Salon <'.get_bloginfo('admin_email', 'raw').'>' . "\r\n";
		if (!empty($orga['name']))
			$message = str_replace('#name', $orga['name'], $message);
		if (!empty($orga['email'])) {
			wp_mail($orga['email'], "Salon Santé Nature - Nouveau commentaire", $message, $headers);
		}
	}
	
}
add_action('comment_unapproved_to_approved', 'ssn_send_comment_alert');