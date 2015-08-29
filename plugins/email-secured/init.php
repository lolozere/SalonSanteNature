<?php
define('STIC_EAMIL_SECURED_VERSION', '1.0.0');

add_filter( 'the_content', 'stic_secure_mail' );
/**
 * Transform email information in link to contact
 *
 * @param string $content
 */
function stic_secure_mail($content) {
	$matches = array();
	// Email link
	if (preg_match_all('/<a.+>([a-z0-9\.-_]+)@([a-z0-9\.-]+)\.([a-z]{2,})<\/a>/i', $content, $matches)) {
		$html_email = array();
		foreach($matches[0] as $i => $email) {
			$email = $matches[1][$i].'@'.$matches[2][$i].'.'.$matches[3][$i];
			$html_email[$i] = '<a href="#" onclick="this.innerHTML = \''.$matches[1][$i].'\'+\'@\'+\''.$matches[2][$i].'\'+\'.\'+\''.$matches[3][$i].'\'; return false;" class="email">'.__("Voir l'email", "stic_email_secured").'</a>';
			$content = preg_replace('/<a.+>'.preg_quote($email).'<\/a>/', $html_email[$i], $content);
		}
	}
	$matches = array();
	// Email alone
	if (preg_match_all('/([a-z0-9\.-_]+)@([a-z\.-]+)\.([a-z]{2,})/i', $content, $matches)) {
		$html_email = array();
		foreach($matches[0] as $i => $email) {
			$html_email[$i] = '<a href="#" onclick="this.innerHTML = \''.$matches[1][$i].'\'+\'@\'+\''.$matches[2][$i].'\'+\'.\'+\''.$matches[3][$i].'\'; return false;" class="email">'.__("Voir l'email", "stic_email_secured").'</a>';
			$content = str_replace($email, $html_email[$i], $content);
		}
	}
	return $content;
}