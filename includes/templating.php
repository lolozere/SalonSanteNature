<?php
/**
 * Return true if is full page
 * 
 * @return bool
 */
function ssn_is_full_page() {
	return (is_page() && preg_match('/full\-width/', get_page_template()));
}
/**
 * Return true if is full page
 *
 * @return bool
 */
function ssn_is_two_columns() {
	return (is_page() && preg_match('/two\-columns/', get_page_template()));
}