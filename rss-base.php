<?php
/*
Plugin Name: RSS Base
Plugin URI: http://wordpress.org/extend/plugins/rss-base/
Description: Changes all relative links to absolute links to fix RSS feeds.
Author: Jon Thysell
Version: 1.1.2
Author URI: http://jon.thysell.us/

	RSS Base

	WordPress plugin converts all relative links to absolute links.

	Copyright (C) 2006, 2008 Jon Thysell

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

$data = array(
	'rssbase_url'		=> '',
	'rssbase_comments_url'	=> ''
);

$rb_flash = '';

// Add options
add_option('rssbase_settings', $data, 'RSS Base Options');
$rssbase_settings = get_option('rssbase_settings');

// Add options page
add_action('admin_menu', 'rb_add_options_page');

// Add filters
add_filter('the_content', 'rb_rssbase');
add_filter('comment_text', 'rb_rssbase_comments');

function rb_add_options_page() {
	if (function_exists('add_options_page')) {
		add_options_page('RSS Base', 'RSS Base', 8, basename(__FILE__), 'rb_options_page');
	}
}

function rb_options_page() {
	global $rb_flash, $rssbase_settings, $_POST;
	
	// Update settings on submit
	if(isset($_POST['rssbase_url']) || isset($_POST['rssbase_comments_url'])) {
		if (isset($_POST['rssbase_url'])) { 
			$rssbase_settings['rssbase_url'] = $_POST['rssbase_url'];
			update_option('rssbase_settings', $rssbase_settings);
			$rb_flash = "Your settings have been saved.";
		}
		if (isset($_POST['rssbase_comments_url'])) { 
			$rssbase_settings['rssbase_comments_url'] = $_POST['rssbase_comments_url'];
			update_option('rssbase_settings', $rssbase_settings);
			$rb_flash = "Your settings have been saved.";
		} 
	}
	
	// Show settings updated after submit
	if ($rb_flash != '') echo '<div id="message" class="updated fade"><p>' . $rb_flash . '</p></div>';
	
	// Options page output
	echo '<div class="wrap">';
	echo '<h2>RSS Base</h2>';
	echo '<p>RSS feeds require <em>absolute</em> URLs to both validate and function properly. This plugin will rewrite all relative link and image tags (&lt;a&gt; and &lt;img&gt;) in RSS feeds to include a base URL, thereby making them absolute.</p>
		<form action="" method="post">
		<ul>
		<li>Enter a base URL into the field below:<br/><input type="text" name="rssbase_url" value="' . htmlentities($rssbase_settings['rssbase_url']) . '" size="45" /></li>
		<li>Optional: If you also want to rewrite your comments feed using RSS Base, enter a base URL below:<br/><input type="text" name="rssbase_comments_url" value="' . htmlentities($rssbase_settings['rssbase_comments_url']) . '" size="45" />
		</ul>
		<p><input type="submit" value="Save" /></p></form>';
	echo '</div>';
}

function rb_rssbase($content) {
	global $rssbase_settings;
	return rb_rssbase_fix($rssbase_settings['rssbase_url'], $content);
}

function rb_rssbase_comments($content) {
	global $rssbase_settings;
	return rb_rssbase_fix($rssbase_settings['rssbase_comments_url'], $content);
}

/*  Uses code from Gerd Riesselmann: http://www.gerd-riesselmann.net/archives/2005/11/rss-doesnt-know-a-base-url/ */
function rb_rssbase_fix($base, $content) {

	// Return unchanged if base URL not set
	if (empty($base))
		return $content;

	// Base URL needs trailing /
	if (substr($base, -1, 1) != "/")
		$base .= "/";

	// Rewrite anchors
	$content = preg_replace("/<a([^>]*) href=\"\/([^\"]*)\"/", "<a\${1} href=\"" . $base . "\${2}\"", $content);

	// Rewrite images
	$content = preg_replace("/<img([^>]*) src=\"\/([^\"]*)\"/", "<img\${1} src=\"" . $base . "\${2}\"", $content);

	return $content;
}

?>
