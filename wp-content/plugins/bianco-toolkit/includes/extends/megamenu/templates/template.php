<?php
/**
 * Ovic Megamenu Form
 *
 * @author   KHANH
 * @category API
 * @package  Ovic_Megamenu_Form
 * @since    1.0.0
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( !function_exists( 'ovic_megamenu_font_icons' ) ) {
	function ovic_megamenu_font_icons()
	{
		$dashicons    = array(
			array( 'dashicons dashicons-menu' => esc_html__( 'Navigation Menu', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-admin-site' => esc_html__( 'Admin Site', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-dashboard' => esc_html__( 'Dashboard', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-admin-post' => esc_html__( 'Pin', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-admin-media' => esc_html__( 'Admin Media', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-admin-links' => esc_html__( 'Admin Link', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-admin-page' => esc_html__( 'Admin Page', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-admin-comments' => esc_html__( 'Admin Comment', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-admin-appearance' => esc_html__( 'Admin Appearance', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-admin-plugins' => esc_html__( 'Admin Plugins', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-admin-users' => esc_html__( 'Admin Users', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-admin-tools' => esc_html__( 'Admin Tools', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-admin-network' => esc_html__( 'Admin Lock Key', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-admin-home' => esc_html__( 'Admin Home', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-admin-generic' => esc_html__( 'Admin Gear', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-admin-collapse' => esc_html__( 'Admin Media Button', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-filter' => esc_html__( 'Admin Filter', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-admin-customizer' => esc_html__( 'Admin Customizer', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-admin-multisite' => esc_html__( 'Admin Multisite', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-welcome-write-blog' => esc_html__( 'Write Blog', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-welcome-add-page' => esc_html__( 'Add Page', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-welcome-view-site' => esc_html__( 'View Site', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-welcome-widgets-menus' => esc_html__( 'Widget Menu', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-welcome-comments' => esc_html__( 'No Comments', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-welcome-learn-more' => esc_html__( 'Graduate Cap', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-format-aside' => esc_html__( 'Format Aside', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-format-image' => esc_html__( 'Format Image', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-format-status' => esc_html__( 'Format status', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-format-quote' => esc_html__( 'Format quote', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-format-chat' => esc_html__( 'Format chat', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-format-audio' => esc_html__( 'Format audio', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-camera' => esc_html__( 'camera', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-images-alt' => esc_html__( 'images-alt', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-images-alt2' => esc_html__( 'images-alt2', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-video-alt' => esc_html__( 'video-alt', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-video-alt2' => esc_html__( 'video-alt2', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-video-alt3' => esc_html__( 'video-alt3', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-media-archive' => esc_html__( 'media-archive', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-media-audio' => esc_html__( 'media-audio', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-media-code' => esc_html__( 'media-code', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-media-default' => esc_html__( 'media-default', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-media-document' => esc_html__( 'media-document', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-media-interactive' => esc_html__( 'media-interactive', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-media-spreadsheet' => esc_html__( 'media-spreadsheet', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-media-text' => esc_html__( 'media-text', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-media-video' => esc_html__( 'media-video', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-playlist-audio' => esc_html__( 'playlist-audio', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-playlist-video' => esc_html__( 'playlist-video', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-controls-play' => esc_html__( 'controls-play', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-controls-pause' => esc_html__( 'controls-pause', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-controls-forward' => esc_html__( 'controls-forward', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-controls-skipforward' => esc_html__( 'controls-skipforward', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-controls-back' => esc_html__( 'controls-back', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-controls-skipback' => esc_html__( 'controls-skipback', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-controls-repeat' => esc_html__( 'controls-repeat', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-controls-volumeon' => esc_html__( 'controls-volumeon', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-controls-volumeoff' => esc_html__( 'controls-volumeoff', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-image-crop' => esc_html__( 'image-crop', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-image-rotate' => esc_html__( 'image-rotate', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-image-rotate-left' => esc_html__( 'image-rotate-left', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-image-rotate-right' => esc_html__( 'image-rotate-right', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-image-flip-vertical' => esc_html__( 'image-flip-vertical', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-image-flip-horizontal' => esc_html__( 'image-flip-horizontal', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-image-filter' => esc_html__( 'image-filter', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-undo' => esc_html__( 'undo', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-redo' => esc_html__( 'redo', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-ul' => esc_html__( 'editor-ul', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-ol' => esc_html__( 'editor-ol', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-quote' => esc_html__( 'editor-quote', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-alignleft' => esc_html__( 'editor-alignleft', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-aligncenter' => esc_html__( 'editor-aligncenter', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-alignright' => esc_html__( 'editor-alignright', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-insertmore' => esc_html__( 'editor-insertmore', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-spellcheck' => esc_html__( 'editor-spellcheck', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-expand' => esc_html__( 'editor-expand', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-contract' => esc_html__( 'editor-contract', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-kitchensink' => esc_html__( 'editor-kitchensink', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-justify' => esc_html__( 'editor-justify', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-paste-word' => esc_html__( 'editor-paste-word', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-paste-text' => esc_html__( 'editor-paste-text', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-removeformatting' => esc_html__( 'editor-removeformatting', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-paste-text' => esc_html__( 'editor-paste-text', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-video' => esc_html__( 'editor-video', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-customchar' => esc_html__( 'editor-customchar', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-outdent' => esc_html__( 'editor-outdent', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-indent' => esc_html__( 'editor-indent', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-help' => esc_html__( 'editor-help', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-indent' => esc_html__( 'editor-indent', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-unlink' => esc_html__( 'editor-unlink', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-rtl' => esc_html__( 'editor-rtl', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-break' => esc_html__( 'editor-break', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-code' => esc_html__( 'editor-code', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-paragraph' => esc_html__( 'editor-paragraph', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-editor-table' => esc_html__( 'editor-table', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-align-left' => esc_html__( 'align-left', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-align-right' => esc_html__( 'align-right', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-align-center' => esc_html__( 'align-center', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-align-none' => esc_html__( 'align-none', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-lock' => esc_html__( 'lock', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-unlock' => esc_html__( 'unlock', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-calendar' => esc_html__( 'calendar', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-calendar-alt' => esc_html__( 'calendar-alt', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-visibility' => esc_html__( 'visibility', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-hidden' => esc_html__( 'hidden', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-post-status' => esc_html__( 'Pin 1', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-edit' => esc_html__( 'Pencil', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-trash' => esc_html__( 'trash', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-sticky' => esc_html__( 'pin 2', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-external' => esc_html__( 'external', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-arrow-up' => esc_html__( 'arrow-up', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-arrow-down' => esc_html__( 'arrow-down', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-arrow-right' => esc_html__( 'arrow-right', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-arrow-left' => esc_html__( 'arrow-left', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-arrow-up-alt' => esc_html__( 'arrow-up 1', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-arrow-down-alt' => esc_html__( 'arrow-down 1', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-arrow-right-alt' => esc_html__( 'arrow-right 1', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-arrow-left-alt' => esc_html__( 'arrow-left 1', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-arrow-up-alt2' => esc_html__( 'arrow-up 2', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-arrow-down-alt2' => esc_html__( 'arrow-down 2', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-arrow-right-alt2' => esc_html__( 'arrow-right 2', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-arrow-left-alt2' => esc_html__( 'arrow-left 2', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-arrow-left-alt2' => esc_html__( 'arrow-left 2', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-sort' => esc_html__( 'sort', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-leftright' => esc_html__( 'leftright', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-randomize' => esc_html__( 'randomize', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-list-view' => esc_html__( 'list-view', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-exerpt-view' => esc_html__( 'exerpt-view', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-grid-view' => esc_html__( 'grid-view', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-move' => esc_html__( 'move', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-share' => esc_html__( 'share', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-share-alt' => esc_html__( 'share-alt', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-share-alt2' => esc_html__( 'share-alt2', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-twitter' => esc_html__( 'twitter', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-rss' => esc_html__( 'rss', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-email' => esc_html__( 'email', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-email-alt' => esc_html__( 'email-alt', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-facebook' => esc_html__( 'facebook', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-facebook-alt' => esc_html__( 'facebook-alt', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-googleplus' => esc_html__( 'googleplus', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-networking' => esc_html__( 'networking', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-hammer' => esc_html__( 'hammer', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-art' => esc_html__( 'art', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-migrate' => esc_html__( 'migrate', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-performance' => esc_html__( 'performance', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-universal-access' => esc_html__( 'universal-access', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-universal-access-alt' => esc_html__( 'universal-access-alt', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-tickets' => esc_html__( 'tickets', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-nametag' => esc_html__( 'nametag', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-clipboard' => esc_html__( 'clipboard', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-heart' => esc_html__( 'heart', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-megaphone' => esc_html__( 'megaphone', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-schedule' => esc_html__( 'schedule', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-wordpress' => esc_html__( 'wordpress', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-wordpress-alt' => esc_html__( 'wordpress-alt', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-pressthis' => esc_html__( 'pressthis', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-update' => esc_html__( 'update', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-screenoptions' => esc_html__( 'screenoptions', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-info' => esc_html__( 'info', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-cart' => esc_html__( 'cart', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-feedback' => esc_html__( 'feedback', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-cloud' => esc_html__( 'cloud', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-translation' => esc_html__( 'translation', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-tag' => esc_html__( 'tag', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-category' => esc_html__( 'category', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-archive' => esc_html__( 'archive', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-tagcloud' => esc_html__( 'tagcloud', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-text' => esc_html__( 'text', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-yes' => esc_html__( 'yes', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-no' => esc_html__( 'no', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-no-alt' => esc_html__( 'no-alt', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-plus' => esc_html__( 'plus', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-plus-alt' => esc_html__( 'plus-alt', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-plus-alt' => esc_html__( 'plus-alt', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-minus' => esc_html__( 'minus', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-dismiss' => esc_html__( 'dismiss', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-marker' => esc_html__( 'marker', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-star-filled' => esc_html__( 'star-filled', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-star-half' => esc_html__( 'star-half', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-star-empty' => esc_html__( 'star-empty', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-flag' => esc_html__( 'flag', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-warning' => esc_html__( 'warning', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-location' => esc_html__( 'location', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-location-alt' => esc_html__( 'location-alt', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-vault' => esc_html__( 'vault', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-shield' => esc_html__( 'shield', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-shield-alt' => esc_html__( 'shield-alt', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-sos' => esc_html__( 'sos', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-search' => esc_html__( 'search', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-slides' => esc_html__( 'slides', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-analytics' => esc_html__( 'analytics', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-chart-pie' => esc_html__( 'chart-pie', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-chart-bar' => esc_html__( 'chart-bar', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-chart-line' => esc_html__( 'chart-line', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-chart-area' => esc_html__( 'chart-area', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-groups' => esc_html__( 'groups', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-businessman' => esc_html__( 'businessman', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-id' => esc_html__( 'id card', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-id-alt' => esc_html__( 'id card-alt', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-awards' => esc_html__( 'awards', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-forms' => esc_html__( 'forms', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-portfolio' => esc_html__( 'portfolio', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-book' => esc_html__( 'book', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-book-alt' => esc_html__( 'book-alt', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-download' => esc_html__( 'download', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-upload' => esc_html__( 'upload', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-backup' => esc_html__( 'backup', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-clock' => esc_html__( 'clock', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-lightbulb' => esc_html__( 'lightbulb', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-microphone' => esc_html__( 'microphone', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-desktop' => esc_html__( 'desktop', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-laptop' => esc_html__( 'laptop', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-tablet' => esc_html__( 'tablet', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-smartphone' => esc_html__( 'smartphone', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-phone' => esc_html__( 'phone', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-index-card' => esc_html__( 'index-card', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-carrot' => esc_html__( 'carrot', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-building' => esc_html__( 'building', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-store' => esc_html__( 'store', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-album' => esc_html__( 'album', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-palmtree' => esc_html__( 'palmtree', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-tickets-alt' => esc_html__( 'tickets-alt', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-money' => esc_html__( 'money', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-thumbs-up' => esc_html__( 'thumbs-up', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-thumbs-down' => esc_html__( 'thumbs-down', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-layout' => esc_html__( 'layout', 'bianco-toolkit' ) ),
			array( 'dashicons dashicons-paperclip' => esc_html__( 'paperclip', 'bianco-toolkit' ) ),
		);
		$font_awesome = array(
			array( 'fa fa-glass' => 'Fa Glass' ),
			array( 'fa fa-music' => 'Fa Music' ),
			array( 'fa fa-search' => 'Fa Search' ),
			array( 'fa fa-envelope-o' => 'Fa Envelope O' ),
			array( 'fa fa-heart' => 'Fa Heart' ),
			array( 'fa fa-star' => 'Fa Star' ),
			array( 'fa fa-star-o' => 'Fa Star O' ),
			array( 'fa fa-user' => 'Fa User' ),
			array( 'fa fa-film' => 'Fa Film' ),
			array( 'fa fa-th-large' => 'Fa Th Large' ),
			array( 'fa fa-th' => 'Fa Th' ),
			array( 'fa fa-th-list' => 'Fa Th List' ),
			array( 'fa fa-check' => 'Fa Check' ),
			array( 'fa fa-remove' => 'Fa Remove' ),
			array( 'fa fa-close' => 'Fa Close' ),
			array( 'fa fa-times' => 'Fa Times' ),
			array( 'fa fa-search-plus' => 'Fa Search Plus' ),
			array( 'fa fa-search-minus' => 'Fa Search Minus' ),
			array( 'fa fa-power-off' => 'Fa Power Off' ),
			array( 'fa fa-signal' => 'Fa Signal' ),
			array( 'fa fa-gear' => 'Fa Gear' ),
			array( 'fa fa-cog' => 'Fa Cog' ),
			array( 'fa fa-trash-o' => 'Fa Trash O' ),
			array( 'fa fa-home' => 'Fa Home' ),
			array( 'fa fa-file-o' => 'Fa File O' ),
			array( 'fa fa-clock-o' => 'Fa Clock O' ),
			array( 'fa fa-road' => 'Fa Road' ),
			array( 'fa fa-download' => 'Fa Download' ),
			array( 'fa fa-arrow-circle-o-down' => 'Fa Arrow Circle O Down' ),
			array( 'fa fa-arrow-circle-o-up' => 'Fa Arrow Circle O Up' ),
			array( 'fa fa-inbox' => 'Fa Inbox' ),
			array( 'fa fa-play-circle-o' => 'Fa Play Circle O' ),
			array( 'fa fa-rotate-right' => 'Fa Rotate Right' ),
			array( 'fa fa-repeat' => 'Fa Repeat' ),
			array( 'fa fa-refresh' => 'Fa Refresh' ),
			array( 'fa fa-list-alt' => 'Fa List Alt' ),
			array( 'fa fa-lock' => 'Fa Lock' ),
			array( 'fa fa-flag' => 'Fa Flag' ),
			array( 'fa fa-headphones' => 'Fa Headphones' ),
			array( 'fa fa-volume-off' => 'Fa Volume Off' ),
			array( 'fa fa-volume-down' => 'Fa Volume Down' ),
			array( 'fa fa-volume-up' => 'Fa Volume Up' ),
			array( 'fa fa-qrcode' => 'Fa Qrcode' ),
			array( 'fa fa-barcode' => 'Fa Barcode' ),
			array( 'fa fa-tag' => 'Fa Tag' ),
			array( 'fa fa-tags' => 'Fa Tags' ),
			array( 'fa fa-book' => 'Fa Book' ),
			array( 'fa fa-bookmark' => 'Fa Bookmark' ),
			array( 'fa fa-print' => 'Fa Print' ),
			array( 'fa fa-camera' => 'Fa Camera' ),
			array( 'fa fa-font' => 'Fa Font' ),
			array( 'fa fa-bold' => 'Fa Bold' ),
			array( 'fa fa-italic' => 'Fa Italic' ),
			array( 'fa fa-text-height' => 'Fa Text Height' ),
			array( 'fa fa-text-width' => 'Fa Text Width' ),
			array( 'fa fa-align-left' => 'Fa Align Left' ),
			array( 'fa fa-align-center' => 'Fa Align Center' ),
			array( 'fa fa-align-right' => 'Fa Align Right' ),
			array( 'fa fa-align-justify' => 'Fa Align Justify' ),
			array( 'fa fa-list' => 'Fa List' ),
			array( 'fa fa-dedent' => 'Fa Dedent' ),
			array( 'fa fa-outdent' => 'Fa Outdent' ),
			array( 'fa fa-indent' => 'Fa Indent' ),
			array( 'fa fa-video-camera' => 'Fa Video Camera' ),
			array( 'fa fa-photo' => 'Fa Photo' ),
			array( 'fa fa-image' => 'Fa Image' ),
			array( 'fa fa-picture-o' => 'Fa Picture O' ),
			array( 'fa fa-pencil' => 'Fa Pencil' ),
			array( 'fa fa-map-marker' => 'Fa Map Marker' ),
			array( 'fa fa-adjust' => 'Fa Adjust' ),
			array( 'fa fa-tint' => 'Fa Tint' ),
			array( 'fa fa-edit' => 'Fa Edit' ),
			array( 'fa fa-pencil-square-o' => 'Fa Pencil Square O' ),
			array( 'fa fa-share-square-o' => 'Fa Share Square O' ),
			array( 'fa fa-check-square-o' => 'Fa Check Square O' ),
			array( 'fa fa-arrows' => 'Fa Arrows' ),
			array( 'fa fa-step-backward' => 'Fa Step Backward' ),
			array( 'fa fa-fast-backward' => 'Fa Fast Backward' ),
			array( 'fa fa-backward' => 'Fa Backward' ),
			array( 'fa fa-play' => 'Fa Play' ),
			array( 'fa fa-pause' => 'Fa Pause' ),
			array( 'fa fa-stop' => 'Fa Stop' ),
			array( 'fa fa-forward' => 'Fa Forward' ),
			array( 'fa fa-fast-forward' => 'Fa Fast Forward' ),
			array( 'fa fa-step-forward' => 'Fa Step Forward' ),
			array( 'fa fa-eject' => 'Fa Eject' ),
			array( 'fa fa-chevron-left' => 'Fa Chevron Left' ),
			array( 'fa fa-chevron-right' => 'Fa Chevron Right' ),
			array( 'fa fa-plus-circle' => 'Fa Plus Circle' ),
			array( 'fa fa-minus-circle' => 'Fa Minus Circle' ),
			array( 'fa fa-times-circle' => 'Fa Times Circle' ),
			array( 'fa fa-check-circle' => 'Fa Check Circle' ),
			array( 'fa fa-question-circle' => 'Fa Question Circle' ),
			array( 'fa fa-info-circle' => 'Fa Info Circle' ),
			array( 'fa fa-crosshairs' => 'Fa Crosshairs' ),
			array( 'fa fa-times-circle-o' => 'Fa Times Circle O' ),
			array( 'fa fa-check-circle-o' => 'Fa Check Circle O' ),
			array( 'fa fa-ban' => 'Fa Ban' ),
			array( 'fa fa-arrow-left' => 'Fa Arrow Left' ),
			array( 'fa fa-arrow-right' => 'Fa Arrow Right' ),
			array( 'fa fa-arrow-up' => 'Fa Arrow Up' ),
			array( 'fa fa-arrow-down' => 'Fa Arrow Down' ),
			array( 'fa fa-mail-forward' => 'Fa Mail Forward' ),
			array( 'fa fa-share' => 'Fa Share' ),
			array( 'fa fa-expand' => 'Fa Expand' ),
			array( 'fa fa-compress' => 'Fa Compress' ),
			array( 'fa fa-plus' => 'Fa Plus' ),
			array( 'fa fa-minus' => 'Fa Minus' ),
			array( 'fa fa-asterisk' => 'Fa Asterisk' ),
			array( 'fa fa-exclamation-circle' => 'Fa Exclamation Circle' ),
			array( 'fa fa-gift' => 'Fa Gift' ),
			array( 'fa fa-leaf' => 'Fa Leaf' ),
			array( 'fa fa-fire' => 'Fa Fire' ),
			array( 'fa fa-eye' => 'Fa Eye' ),
			array( 'fa fa-eye-slash' => 'Fa Eye Slash' ),
			array( 'fa fa-warning' => 'Fa Warning' ),
			array( 'fa fa-exclamation-triangle' => 'Fa Exclamation Triangle' ),
			array( 'fa fa-plane' => 'Fa Plane' ),
			array( 'fa fa-calendar' => 'Fa Calendar' ),
			array( 'fa fa-random' => 'Fa Random' ),
			array( 'fa fa-comment' => 'Fa Comment' ),
			array( 'fa fa-magnet' => 'Fa Magnet' ),
			array( 'fa fa-chevron-up' => 'Fa Chevron Up' ),
			array( 'fa fa-chevron-down' => 'Fa Chevron Down' ),
			array( 'fa fa-retweet' => 'Fa Retweet' ),
			array( 'fa fa-shopping-cart' => 'Fa Shopping Cart' ),
			array( 'fa fa-folder' => 'Fa Folder' ),
			array( 'fa fa-folder-open' => 'Fa Folder Open' ),
			array( 'fa fa-arrows-v' => 'Fa Arrows V' ),
			array( 'fa fa-arrows-h' => 'Fa Arrows H' ),
			array( 'fa fa-bar-chart-o' => 'Fa Bar Chart O' ),
			array( 'fa fa-bar-chart' => 'Fa Bar Chart' ),
			array( 'fa fa-twitter-square' => 'Fa Twitter Square' ),
			array( 'fa fa-facebook-square' => 'Fa Facebook Square' ),
			array( 'fa fa-camera-retro' => 'Fa Camera Retro' ),
			array( 'fa fa-key' => 'Fa Key' ),
			array( 'fa fa-gears' => 'Fa Gears' ),
			array( 'fa fa-cogs' => 'Fa Cogs' ),
			array( 'fa fa-comments' => 'Fa Comments' ),
			array( 'fa fa-thumbs-o-up' => 'Fa Thumbs O Up' ),
			array( 'fa fa-thumbs-o-down' => 'Fa Thumbs O Down' ),
			array( 'fa fa-star-half' => 'Fa Star Half' ),
			array( 'fa fa-heart-o' => 'Fa Heart O' ),
			array( 'fa fa-sign-out' => 'Fa Sign Out' ),
			array( 'fa fa-linkedin-square' => 'Fa Linkedin Square' ),
			array( 'fa fa-thumb-tack' => 'Fa Thumb Tack' ),
			array( 'fa fa-external-link' => 'Fa External Link' ),
			array( 'fa fa-sign-in' => 'Fa Sign In' ),
			array( 'fa fa-trophy' => 'Fa Trophy' ),
			array( 'fa fa-github-square' => 'Fa Github Square' ),
			array( 'fa fa-upload' => 'Fa Upload' ),
			array( 'fa fa-lemon-o' => 'Fa Lemon O' ),
			array( 'fa fa-phone' => 'Fa Phone' ),
			array( 'fa fa-square-o' => 'Fa Square O' ),
			array( 'fa fa-bookmark-o' => 'Fa Bookmark O' ),
			array( 'fa fa-phone-square' => 'Fa Phone Square' ),
			array( 'fa fa-twitter' => 'Fa Twitter' ),
			array( 'fa fa-facebook-f' => 'Fa Facebook F' ),
			array( 'fa fa-facebook' => 'Fa Facebook' ),
			array( 'fa fa-github' => 'Fa Github' ),
			array( 'fa fa-unlock' => 'Fa Unlock' ),
			array( 'fa fa-credit-card' => 'Fa Credit Card' ),
			array( 'fa fa-feed' => 'Fa Feed' ),
			array( 'fa fa-rss' => 'Fa Rss' ),
			array( 'fa fa-hdd-o' => 'Fa Hdd O' ),
			array( 'fa fa-bullhorn' => 'Fa Bullhorn' ),
			array( 'fa fa-bell' => 'Fa Bell' ),
			array( 'fa fa-certificate' => 'Fa Certificate' ),
			array( 'fa fa-hand-o-right' => 'Fa Hand O Right' ),
			array( 'fa fa-hand-o-left' => 'Fa Hand O Left' ),
			array( 'fa fa-hand-o-up' => 'Fa Hand O Up' ),
			array( 'fa fa-hand-o-down' => 'Fa Hand O Down' ),
			array( 'fa fa-arrow-circle-left' => 'Fa Arrow Circle Left' ),
			array( 'fa fa-arrow-circle-right' => 'Fa Arrow Circle Right' ),
			array( 'fa fa-arrow-circle-up' => 'Fa Arrow Circle Up' ),
			array( 'fa fa-arrow-circle-down' => 'Fa Arrow Circle Down' ),
			array( 'fa fa-globe' => 'Fa Globe' ),
			array( 'fa fa-wrench' => 'Fa Wrench' ),
			array( 'fa fa-tasks' => 'Fa Tasks' ),
			array( 'fa fa-filter' => 'Fa Filter' ),
			array( 'fa fa-briefcase' => 'Fa Briefcase' ),
			array( 'fa fa-arrows-alt' => 'Fa Arrows Alt' ),
			array( 'fa fa-group' => 'Fa Group' ),
			array( 'fa fa-users' => 'Fa Users' ),
			array( 'fa fa-chain' => 'Fa Chain' ),
			array( 'fa fa-link' => 'Fa Link' ),
			array( 'fa fa-cloud' => 'Fa Cloud' ),
			array( 'fa fa-flask' => 'Fa Flask' ),
			array( 'fa fa-cut' => 'Fa Cut' ),
			array( 'fa fa-scissors' => 'Fa Scissors' ),
			array( 'fa fa-copy' => 'Fa Copy' ),
			array( 'fa fa-files-o' => 'Fa Files O' ),
			array( 'fa fa-paperclip' => 'Fa Paperclip' ),
			array( 'fa fa-save' => 'Fa Save' ),
			array( 'fa fa-floppy-o' => 'Fa Floppy O' ),
			array( 'fa fa-square' => 'Fa Square' ),
			array( 'fa fa-navicon' => 'Fa Navicon' ),
			array( 'fa fa-reorder' => 'Fa Reorder' ),
			array( 'fa fa-bars' => 'Fa Bars' ),
			array( 'fa fa-list-ul' => 'Fa List Ul' ),
			array( 'fa fa-list-ol' => 'Fa List Ol' ),
			array( 'fa fa-strikethrough' => 'Fa Strikethrough' ),
			array( 'fa fa-underline' => 'Fa Underline' ),
			array( 'fa fa-table' => 'Fa Table' ),
			array( 'fa fa-magic' => 'Fa Magic' ),
			array( 'fa fa-truck' => 'Fa Truck' ),
			array( 'fa fa-pinterest' => 'Fa Pinterest' ),
			array( 'fa fa-pinterest-square' => 'Fa Pinterest Square' ),
			array( 'fa fa-google-plus-square' => 'Fa Google Plus Square' ),
			array( 'fa fa-google-plus' => 'Fa Google Plus' ),
			array( 'fa fa-money' => 'Fa Money' ),
			array( 'fa fa-caret-down' => 'Fa Caret Down' ),
			array( 'fa fa-caret-up' => 'Fa Caret Up' ),
			array( 'fa fa-caret-left' => 'Fa Caret Left' ),
			array( 'fa fa-caret-right' => 'Fa Caret Right' ),
			array( 'fa fa-columns' => 'Fa Columns' ),
			array( 'fa fa-unsorted' => 'Fa Unsorted' ),
			array( 'fa fa-sort' => 'Fa Sort' ),
			array( 'fa fa-sort-down' => 'Fa Sort Down' ),
			array( 'fa fa-sort-desc' => 'Fa Sort Desc' ),
			array( 'fa fa-sort-up' => 'Fa Sort Up' ),
			array( 'fa fa-sort-asc' => 'Fa Sort Asc' ),
			array( 'fa fa-envelope' => 'Fa Envelope' ),
			array( 'fa fa-linkedin' => 'Fa Linkedin' ),
			array( 'fa fa-rotate-left' => 'Fa Rotate Left' ),
			array( 'fa fa-undo' => 'Fa Undo' ),
			array( 'fa fa-legal' => 'Fa Legal' ),
			array( 'fa fa-gavel' => 'Fa Gavel' ),
			array( 'fa fa-dashboard' => 'Fa Dashboard' ),
			array( 'fa fa-tachometer' => 'Fa Tachometer' ),
			array( 'fa fa-comment-o' => 'Fa Comment O' ),
			array( 'fa fa-comments-o' => 'Fa Comments O' ),
			array( 'fa fa-flash' => 'Fa Flash' ),
			array( 'fa fa-bolt' => 'Fa Bolt' ),
			array( 'fa fa-sitemap' => 'Fa Sitemap' ),
			array( 'fa fa-umbrella' => 'Fa Umbrella' ),
			array( 'fa fa-paste' => 'Fa Paste' ),
			array( 'fa fa-clipboard' => 'Fa Clipboard' ),
			array( 'fa fa-lightbulb-o' => 'Fa Lightbulb O' ),
			array( 'fa fa-exchange' => 'Fa Exchange' ),
			array( 'fa fa-cloud-download' => 'Fa Cloud Download' ),
			array( 'fa fa-cloud-upload' => 'Fa Cloud Upload' ),
			array( 'fa fa-user-md' => 'Fa User Md' ),
			array( 'fa fa-stethoscope' => 'Fa Stethoscope' ),
			array( 'fa fa-suitcase' => 'Fa Suitcase' ),
			array( 'fa fa-bell-o' => 'Fa Bell O' ),
			array( 'fa fa-coffee' => 'Fa Coffee' ),
			array( 'fa fa-cutlery' => 'Fa Cutlery' ),
			array( 'fa fa-file-text-o' => 'Fa File Text O' ),
			array( 'fa fa-building-o' => 'Fa Building O' ),
			array( 'fa fa-hospital-o' => 'Fa Hospital O' ),
			array( 'fa fa-ambulance' => 'Fa Ambulance' ),
			array( 'fa fa-medkit' => 'Fa Medkit' ),
			array( 'fa fa-fighter-jet' => 'Fa Fighter Jet' ),
			array( 'fa fa-beer' => 'Fa Beer' ),
			array( 'fa fa-h-square' => 'Fa H Square' ),
			array( 'fa fa-plus-square' => 'Fa Plus Square' ),
			array( 'fa fa-angle-double-left' => 'Fa Angle Double Left' ),
			array( 'fa fa-angle-double-right' => 'Fa Angle Double Right' ),
			array( 'fa fa-angle-double-up' => 'Fa Angle Double Up' ),
			array( 'fa fa-angle-double-down' => 'Fa Angle Double Down' ),
			array( 'fa fa-angle-left' => 'Fa Angle Left' ),
			array( 'fa fa-angle-right' => 'Fa Angle Right' ),
			array( 'fa fa-angle-up' => 'Fa Angle Up' ),
			array( 'fa fa-angle-down' => 'Fa Angle Down' ),
			array( 'fa fa-desktop' => 'Fa Desktop' ),
			array( 'fa fa-laptop' => 'Fa Laptop' ),
			array( 'fa fa-tablet' => 'Fa Tablet' ),
			array( 'fa fa-mobile-phone' => 'Fa Mobile Phone' ),
			array( 'fa fa-mobile' => 'Fa Mobile' ),
			array( 'fa fa-circle-o' => 'Fa Circle O' ),
			array( 'fa fa-quote-left' => 'Fa Quote Left' ),
			array( 'fa fa-quote-right' => 'Fa Quote Right' ),
			array( 'fa fa-spinner' => 'Fa Spinner' ),
			array( 'fa fa-circle' => 'Fa Circle' ),
			array( 'fa fa-mail-reply' => 'Fa Mail Reply' ),
			array( 'fa fa-reply' => 'Fa Reply' ),
			array( 'fa fa-github-alt' => 'Fa Github Alt' ),
			array( 'fa fa-folder-o' => 'Fa Folder O' ),
			array( 'fa fa-folder-open-o' => 'Fa Folder Open O' ),
			array( 'fa fa-smile-o' => 'Fa Smile O' ),
			array( 'fa fa-frown-o' => 'Fa Frown O' ),
			array( 'fa fa-meh-o' => 'Fa Meh O' ),
			array( 'fa fa-gamepad' => 'Fa Gamepad' ),
			array( 'fa fa-keyboard-o' => 'Fa Keyboard O' ),
			array( 'fa fa-flag-o' => 'Fa Flag O' ),
			array( 'fa fa-flag-checkered' => 'Fa Flag Checkered' ),
			array( 'fa fa-terminal' => 'Fa Terminal' ),
			array( 'fa fa-code' => 'Fa Code' ),
			array( 'fa fa-mail-reply-all' => 'Fa Mail Reply All' ),
			array( 'fa fa-reply-all' => 'Fa Reply All' ),
			array( 'fa fa-star-half-empty' => 'Fa Star Half Empty' ),
			array( 'fa fa-star-half-full' => 'Fa Star Half Full' ),
			array( 'fa fa-star-half-o' => 'Fa Star Half O' ),
			array( 'fa fa-location-arrow' => 'Fa Location Arrow' ),
			array( 'fa fa-crop' => 'Fa Crop' ),
			array( 'fa fa-code-fork' => 'Fa Code Fork' ),
			array( 'fa fa-unlink' => 'Fa Unlink' ),
			array( 'fa fa-chain-broken' => 'Fa Chain Broken' ),
			array( 'fa fa-question' => 'Fa Question' ),
			array( 'fa fa-info' => 'Fa Info' ),
			array( 'fa fa-exclamation' => 'Fa Exclamation' ),
			array( 'fa fa-superscript' => 'Fa Superscript' ),
			array( 'fa fa-subscript' => 'Fa Subscript' ),
			array( 'fa fa-eraser' => 'Fa Eraser' ),
			array( 'fa fa-puzzle-piece' => 'Fa Puzzle Piece' ),
			array( 'fa fa-microphone' => 'Fa Microphone' ),
			array( 'fa fa-microphone-slash' => 'Fa Microphone Slash' ),
			array( 'fa fa-shield' => 'Fa Shield' ),
			array( 'fa fa-calendar-o' => 'Fa Calendar O' ),
			array( 'fa fa-fire-extinguisher' => 'Fa Fire Extinguisher' ),
			array( 'fa fa-rocket' => 'Fa Rocket' ),
			array( 'fa fa-maxcdn' => 'Fa Maxcdn' ),
			array( 'fa fa-chevron-circle-left' => 'Fa Chevron Circle Left' ),
			array( 'fa fa-chevron-circle-right' => 'Fa Chevron Circle Right' ),
			array( 'fa fa-chevron-circle-up' => 'Fa Chevron Circle Up' ),
			array( 'fa fa-chevron-circle-down' => 'Fa Chevron Circle Down' ),
			array( 'fa fa-html5' => 'Fa Html5' ),
			array( 'fa fa-css3' => 'Fa Css3' ),
			array( 'fa fa-anchor' => 'Fa Anchor' ),
			array( 'fa fa-unlock-alt' => 'Fa Unlock Alt' ),
			array( 'fa fa-bullseye' => 'Fa Bullseye' ),
			array( 'fa fa-ellipsis-h' => 'Fa Ellipsis H' ),
			array( 'fa fa-ellipsis-v' => 'Fa Ellipsis V' ),
			array( 'fa fa-rss-square' => 'Fa Rss Square' ),
			array( 'fa fa-play-circle' => 'Fa Play Circle' ),
			array( 'fa fa-ticket' => 'Fa Ticket' ),
			array( 'fa fa-minus-square' => 'Fa Minus Square' ),
			array( 'fa fa-minus-square-o' => 'Fa Minus Square O' ),
			array( 'fa fa-level-up' => 'Fa Level Up' ),
			array( 'fa fa-level-down' => 'Fa Level Down' ),
			array( 'fa fa-check-square' => 'Fa Check Square' ),
			array( 'fa fa-pencil-square' => 'Fa Pencil Square' ),
			array( 'fa fa-external-link-square' => 'Fa External Link Square' ),
			array( 'fa fa-share-square' => 'Fa Share Square' ),
			array( 'fa fa-compass' => 'Fa Compass' ),
			array( 'fa fa-toggle-down' => 'Fa Toggle Down' ),
			array( 'fa fa-caret-square-o-down' => 'Fa Caret Square O Down' ),
			array( 'fa fa-toggle-up' => 'Fa Toggle Up' ),
			array( 'fa fa-caret-square-o-up' => 'Fa Caret Square O Up' ),
			array( 'fa fa-toggle-right' => 'Fa Toggle Right' ),
			array( 'fa fa-caret-square-o-right' => 'Fa Caret Square O Right' ),
			array( 'fa fa-euro' => 'Fa Euro' ),
			array( 'fa fa-eur' => 'Fa Eur' ),
			array( 'fa fa-gbp' => 'Fa Gbp' ),
			array( 'fa fa-dollar' => 'Fa Dollar' ),
			array( 'fa fa-usd' => 'Fa Usd' ),
			array( 'fa fa-rupee' => 'Fa Rupee' ),
			array( 'fa fa-inr' => 'Fa Inr' ),
			array( 'fa fa-cny' => 'Fa Cny' ),
			array( 'fa fa-rmb' => 'Fa Rmb' ),
			array( 'fa fa-yen' => 'Fa Yen' ),
			array( 'fa fa-jpy' => 'Fa Jpy' ),
			array( 'fa fa-ruble' => 'Fa Ruble' ),
			array( 'fa fa-rouble' => 'Fa Rouble' ),
			array( 'fa fa-rub' => 'Fa Rub' ),
			array( 'fa fa-won' => 'Fa Won' ),
			array( 'fa fa-krw' => 'Fa Krw' ),
			array( 'fa fa-bitcoin' => 'Fa Bitcoin' ),
			array( 'fa fa-btc' => 'Fa Btc' ),
			array( 'fa fa-file' => 'Fa File' ),
			array( 'fa fa-file-text' => 'Fa File Text' ),
			array( 'fa fa-sort-alpha-asc' => 'Fa Sort Alpha Asc' ),
			array( 'fa fa-sort-alpha-desc' => 'Fa Sort Alpha Desc' ),
			array( 'fa fa-sort-amount-asc' => 'Fa Sort Amount Asc' ),
			array( 'fa fa-sort-amount-desc' => 'Fa Sort Amount Desc' ),
			array( 'fa fa-sort-numeric-asc' => 'Fa Sort Numeric Asc' ),
			array( 'fa fa-sort-numeric-desc' => 'Fa Sort Numeric Desc' ),
			array( 'fa fa-thumbs-up' => 'Fa Thumbs Up' ),
			array( 'fa fa-thumbs-down' => 'Fa Thumbs Down' ),
			array( 'fa fa-youtube-square' => 'Fa Youtube Square' ),
			array( 'fa fa-youtube' => 'Fa Youtube' ),
			array( 'fa fa-xing' => 'Fa Xing' ),
			array( 'fa fa-xing-square' => 'Fa Xing Square' ),
			array( 'fa fa-youtube-play' => 'Fa Youtube Play' ),
			array( 'fa fa-dropbox' => 'Fa Dropbox' ),
			array( 'fa fa-stack-overflow' => 'Fa Stack Overflow' ),
			array( 'fa fa-instagram' => 'Fa Instagram' ),
			array( 'fa fa-flickr' => 'Fa Flickr' ),
			array( 'fa fa-adn' => 'Fa Adn' ),
			array( 'fa fa-bitbucket' => 'Fa Bitbucket' ),
			array( 'fa fa-bitbucket-square' => 'Fa Bitbucket Square' ),
			array( 'fa fa-tumblr' => 'Fa Tumblr' ),
			array( 'fa fa-tumblr-square' => 'Fa Tumblr Square' ),
			array( 'fa fa-long-arrow-down' => 'Fa Long Arrow Down' ),
			array( 'fa fa-long-arrow-up' => 'Fa Long Arrow Up' ),
			array( 'fa fa-long-arrow-left' => 'Fa Long Arrow Left' ),
			array( 'fa fa-long-arrow-right' => 'Fa Long Arrow Right' ),
			array( 'fa fa-apple' => 'Fa Apple' ),
			array( 'fa fa-windows' => 'Fa Windows' ),
			array( 'fa fa-android' => 'Fa Android' ),
			array( 'fa fa-linux' => 'Fa Linux' ),
			array( 'fa fa-dribbble' => 'Fa Dribbble' ),
			array( 'fa fa-skype' => 'Fa Skype' ),
			array( 'fa fa-foursquare' => 'Fa Foursquare' ),
			array( 'fa fa-trello' => 'Fa Trello' ),
			array( 'fa fa-female' => 'Fa Female' ),
			array( 'fa fa-male' => 'Fa Male' ),
			array( 'fa fa-gittip' => 'Fa Gittip' ),
			array( 'fa fa-gratipay' => 'Fa Gratipay' ),
			array( 'fa fa-sun-o' => 'Fa Sun O' ),
			array( 'fa fa-moon-o' => 'Fa Moon O' ),
			array( 'fa fa-archive' => 'Fa Archive' ),
			array( 'fa fa-bug' => 'Fa Bug' ),
			array( 'fa fa-vk' => 'Fa Vk' ),
			array( 'fa fa-weibo' => 'Fa Weibo' ),
			array( 'fa fa-renren' => 'Fa Renren' ),
			array( 'fa fa-pagelines' => 'Fa Pagelines' ),
			array( 'fa fa-stack-exchange' => 'Fa Stack Exchange' ),
			array( 'fa fa-arrow-circle-o-right' => 'Fa Arrow Circle O Right' ),
			array( 'fa fa-arrow-circle-o-left' => 'Fa Arrow Circle O Left' ),
			array( 'fa fa-toggle-left' => 'Fa Toggle Left' ),
			array( 'fa fa-caret-square-o-left' => 'Fa Caret Square O Left' ),
			array( 'fa fa-dot-circle-o' => 'Fa Dot Circle O' ),
			array( 'fa fa-wheelchair' => 'Fa Wheelchair' ),
			array( 'fa fa-vimeo-square' => 'Fa Vimeo Square' ),
			array( 'fa fa-turkish-lira' => 'Fa Turkish Lira' ),
			array( 'fa fa-try' => 'Fa Try' ),
			array( 'fa fa-plus-square-o' => 'Fa Plus Square O' ),
			array( 'fa fa-space-shuttle' => 'Fa Space Shuttle' ),
			array( 'fa fa-slack' => 'Fa Slack' ),
			array( 'fa fa-envelope-square' => 'Fa Envelope Square' ),
			array( 'fa fa-wordpress' => 'Fa Wordpress' ),
			array( 'fa fa-openid' => 'Fa Openid' ),
			array( 'fa fa-institution' => 'Fa Institution' ),
			array( 'fa fa-bank' => 'Fa Bank' ),
			array( 'fa fa-university' => 'Fa University' ),
			array( 'fa fa-mortar-board' => 'Fa Mortar Board' ),
			array( 'fa fa-graduation-cap' => 'Fa Graduation Cap' ),
			array( 'fa fa-yahoo' => 'Fa Yahoo' ),
			array( 'fa fa-google' => 'Fa Google' ),
			array( 'fa fa-reddit' => 'Fa Reddit' ),
			array( 'fa fa-reddit-square' => 'Fa Reddit Square' ),
			array( 'fa fa-stumbleupon-circle' => 'Fa Stumbleupon Circle' ),
			array( 'fa fa-stumbleupon' => 'Fa Stumbleupon' ),
			array( 'fa fa-delicious' => 'Fa Delicious' ),
			array( 'fa fa-digg' => 'Fa Digg' ),
			array( 'fa fa-pied-piper-pp' => 'Fa Pied Piper Pp' ),
			array( 'fa fa-pied-piper-alt' => 'Fa Pied Piper Alt' ),
			array( 'fa fa-drupal' => 'Fa Drupal' ),
			array( 'fa fa-joomla' => 'Fa Joomla' ),
			array( 'fa fa-language' => 'Fa Language' ),
			array( 'fa fa-fax' => 'Fa Fax' ),
			array( 'fa fa-building' => 'Fa Building' ),
			array( 'fa fa-child' => 'Fa Child' ),
			array( 'fa fa-paw' => 'Fa Paw' ),
			array( 'fa fa-spoon' => 'Fa Spoon' ),
			array( 'fa fa-cube' => 'Fa Cube' ),
			array( 'fa fa-cubes' => 'Fa Cubes' ),
			array( 'fa fa-behance' => 'Fa Behance' ),
			array( 'fa fa-behance-square' => 'Fa Behance Square' ),
			array( 'fa fa-steam' => 'Fa Steam' ),
			array( 'fa fa-steam-square' => 'Fa Steam Square' ),
			array( 'fa fa-recycle' => 'Fa Recycle' ),
			array( 'fa fa-automobile' => 'Fa Automobile' ),
			array( 'fa fa-car' => 'Fa Car' ),
			array( 'fa fa-cab' => 'Fa Cab' ),
			array( 'fa fa-taxi' => 'Fa Taxi' ),
			array( 'fa fa-tree' => 'Fa Tree' ),
			array( 'fa fa-spotify' => 'Fa Spotify' ),
			array( 'fa fa-deviantart' => 'Fa Deviantart' ),
			array( 'fa fa-soundcloud' => 'Fa Soundcloud' ),
			array( 'fa fa-database' => 'Fa Database' ),
			array( 'fa fa-file-pdf-o' => 'Fa File Pdf O' ),
			array( 'fa fa-file-word-o' => 'Fa File Word O' ),
			array( 'fa fa-file-excel-o' => 'Fa File Excel O' ),
			array( 'fa fa-file-powerpoint-o' => 'Fa File Powerpoint O' ),
			array( 'fa fa-file-photo-o' => 'Fa File Photo O' ),
			array( 'fa fa-file-picture-o' => 'Fa File Picture O' ),
			array( 'fa fa-file-image-o' => 'Fa File Image O' ),
			array( 'fa fa-file-zip-o' => 'Fa File Zip O' ),
			array( 'fa fa-file-archive-o' => 'Fa File Archive O' ),
			array( 'fa fa-file-sound-o' => 'Fa File Sound O' ),
			array( 'fa fa-file-audio-o' => 'Fa File Audio O' ),
			array( 'fa fa-file-movie-o' => 'Fa File Movie O' ),
			array( 'fa fa-file-video-o' => 'Fa File Video O' ),
			array( 'fa fa-file-code-o' => 'Fa File Code O' ),
			array( 'fa fa-vine' => 'Fa Vine' ),
			array( 'fa fa-codepen' => 'Fa Codepen' ),
			array( 'fa fa-jsfiddle' => 'Fa Jsfiddle' ),
			array( 'fa fa-life-bouy' => 'Fa Life Bouy' ),
			array( 'fa fa-life-buoy' => 'Fa Life Buoy' ),
			array( 'fa fa-life-saver' => 'Fa Life Saver' ),
			array( 'fa fa-support' => 'Fa Support' ),
			array( 'fa fa-life-ring' => 'Fa Life Ring' ),
			array( 'fa fa-circle-o-notch' => 'Fa Circle O Notch' ),
			array( 'fa fa-ra' => 'Fa Ra' ),
			array( 'fa fa-resistance' => 'Fa Resistance' ),
			array( 'fa fa-rebel' => 'Fa Rebel' ),
			array( 'fa fa-ge' => 'Fa Ge' ),
			array( 'fa fa-empire' => 'Fa Empire' ),
			array( 'fa fa-git-square' => 'Fa Git Square' ),
			array( 'fa fa-git' => 'Fa Git' ),
			array( 'fa fa-y-combinator-square' => 'Fa Y Combinator Square' ),
			array( 'fa fa-yc-square' => 'Fa Yc Square' ),
			array( 'fa fa-hacker-news' => 'Fa Hacker News' ),
			array( 'fa fa-tencent-weibo' => 'Fa Tencent Weibo' ),
			array( 'fa fa-qq' => 'Fa Qq' ),
			array( 'fa fa-wechat' => 'Fa Wechat' ),
			array( 'fa fa-weixin' => 'Fa Weixin' ),
			array( 'fa fa-send' => 'Fa Send' ),
			array( 'fa fa-paper-plane' => 'Fa Paper Plane' ),
			array( 'fa fa-send-o' => 'Fa Send O' ),
			array( 'fa fa-paper-plane-o' => 'Fa Paper Plane O' ),
			array( 'fa fa-history' => 'Fa History' ),
			array( 'fa fa-circle-thin' => 'Fa Circle Thin' ),
			array( 'fa fa-header' => 'Fa Header' ),
			array( 'fa fa-paragraph' => 'Fa Paragraph' ),
			array( 'fa fa-sliders' => 'Fa Sliders' ),
			array( 'fa fa-share-alt' => 'Fa Share Alt' ),
			array( 'fa fa-share-alt-square' => 'Fa Share Alt Square' ),
			array( 'fa fa-bomb' => 'Fa Bomb' ),
			array( 'fa fa-soccer-ball-o' => 'Fa Soccer Ball O' ),
			array( 'fa fa-futbol-o' => 'Fa Futbol O' ),
			array( 'fa fa-tty' => 'Fa Tty' ),
			array( 'fa fa-binoculars' => 'Fa Binoculars' ),
			array( 'fa fa-plug' => 'Fa Plug' ),
			array( 'fa fa-slideshare' => 'Fa Slideshare' ),
			array( 'fa fa-twitch' => 'Fa Twitch' ),
			array( 'fa fa-yelp' => 'Fa Yelp' ),
			array( 'fa fa-newspaper-o' => 'Fa Newspaper O' ),
			array( 'fa fa-wifi' => 'Fa Wifi' ),
			array( 'fa fa-calculator' => 'Fa Calculator' ),
			array( 'fa fa-paypal' => 'Fa Paypal' ),
			array( 'fa fa-google-wallet' => 'Fa Google Wallet' ),
			array( 'fa fa-cc-visa' => 'Fa Cc Visa' ),
			array( 'fa fa-cc-mastercard' => 'Fa Cc Mastercard' ),
			array( 'fa fa-cc-discover' => 'Fa Cc Discover' ),
			array( 'fa fa-cc-amex' => 'Fa Cc Amex' ),
			array( 'fa fa-cc-paypal' => 'Fa Cc Paypal' ),
			array( 'fa fa-cc-stripe' => 'Fa Cc Stripe' ),
			array( 'fa fa-bell-slash' => 'Fa Bell Slash' ),
			array( 'fa fa-bell-slash-o' => 'Fa Bell Slash O' ),
			array( 'fa fa-trash' => 'Fa Trash' ),
			array( 'fa fa-copyright' => 'Fa Copyright' ),
			array( 'fa fa-at' => 'Fa At' ),
			array( 'fa fa-eyedropper' => 'Fa Eyedropper' ),
			array( 'fa fa-paint-brush' => 'Fa Paint Brush' ),
			array( 'fa fa-birthday-cake' => 'Fa Birthday Cake' ),
			array( 'fa fa-area-chart' => 'Fa Area Chart' ),
			array( 'fa fa-pie-chart' => 'Fa Pie Chart' ),
			array( 'fa fa-line-chart' => 'Fa Line Chart' ),
			array( 'fa fa-lastfm' => 'Fa Lastfm' ),
			array( 'fa fa-lastfm-square' => 'Fa Lastfm Square' ),
			array( 'fa fa-toggle-off' => 'Fa Toggle Off' ),
			array( 'fa fa-toggle-on' => 'Fa Toggle On' ),
			array( 'fa fa-bicycle' => 'Fa Bicycle' ),
			array( 'fa fa-bus' => 'Fa Bus' ),
			array( 'fa fa-ioxhost' => 'Fa Ioxhost' ),
			array( 'fa fa-angellist' => 'Fa Angellist' ),
			array( 'fa fa-cc' => 'Fa Cc' ),
			array( 'fa fa-shekel' => 'Fa Shekel' ),
			array( 'fa fa-sheqel' => 'Fa Sheqel' ),
			array( 'fa fa-ils' => 'Fa Ils' ),
			array( 'fa fa-meanpath' => 'Fa Meanpath' ),
			array( 'fa fa-buysellads' => 'Fa Buysellads' ),
			array( 'fa fa-connectdevelop' => 'Fa Connectdevelop' ),
			array( 'fa fa-dashcube' => 'Fa Dashcube' ),
			array( 'fa fa-forumbee' => 'Fa Forumbee' ),
			array( 'fa fa-leanpub' => 'Fa Leanpub' ),
			array( 'fa fa-sellsy' => 'Fa Sellsy' ),
			array( 'fa fa-shirtsinbulk' => 'Fa Shirtsinbulk' ),
			array( 'fa fa-simplybuilt' => 'Fa Simplybuilt' ),
			array( 'fa fa-skyatlas' => 'Fa Skyatlas' ),
			array( 'fa fa-cart-plus' => 'Fa Cart Plus' ),
			array( 'fa fa-cart-arrow-down' => 'Fa Cart Arrow Down' ),
			array( 'fa fa-diamond' => 'Fa Diamond' ),
			array( 'fa fa-ship' => 'Fa Ship' ),
			array( 'fa fa-user-secret' => 'Fa User Secret' ),
			array( 'fa fa-motorcycle' => 'Fa Motorcycle' ),
			array( 'fa fa-street-view' => 'Fa Street View' ),
			array( 'fa fa-heartbeat' => 'Fa Heartbeat' ),
			array( 'fa fa-venus' => 'Fa Venus' ),
			array( 'fa fa-mars' => 'Fa Mars' ),
			array( 'fa fa-mercury' => 'Fa Mercury' ),
			array( 'fa fa-intersex' => 'Fa Intersex' ),
			array( 'fa fa-transgender' => 'Fa Transgender' ),
			array( 'fa fa-transgender-alt' => 'Fa Transgender Alt' ),
			array( 'fa fa-venus-double' => 'Fa Venus Double' ),
			array( 'fa fa-mars-double' => 'Fa Mars Double' ),
			array( 'fa fa-venus-mars' => 'Fa Venus Mars' ),
			array( 'fa fa-mars-stroke' => 'Fa Mars Stroke' ),
			array( 'fa fa-mars-stroke-v' => 'Fa Mars Stroke V' ),
			array( 'fa fa-mars-stroke-h' => 'Fa Mars Stroke H' ),
			array( 'fa fa-neuter' => 'Fa Neuter' ),
			array( 'fa fa-genderless' => 'Fa Genderless' ),
			array( 'fa fa-facebook-official' => 'Fa Facebook Official' ),
			array( 'fa fa-pinterest-p' => 'Fa Pinterest P' ),
			array( 'fa fa-whatsapp' => 'Fa Whatsapp' ),
			array( 'fa fa-server' => 'Fa Server' ),
			array( 'fa fa-user-plus' => 'Fa User Plus' ),
			array( 'fa fa-user-times' => 'Fa User Times' ),
			array( 'fa fa-hotel' => 'Fa Hotel' ),
			array( 'fa fa-bed' => 'Fa Bed' ),
			array( 'fa fa-viacoin' => 'Fa Viacoin' ),
			array( 'fa fa-train' => 'Fa Train' ),
			array( 'fa fa-subway' => 'Fa Subway' ),
			array( 'fa fa-medium' => 'Fa Medium' ),
			array( 'fa fa-yc' => 'Fa Yc' ),
			array( 'fa fa-y-combinator' => 'Fa Y Combinator' ),
			array( 'fa fa-optin-monster' => 'Fa Optin Monster' ),
			array( 'fa fa-opencart' => 'Fa Opencart' ),
			array( 'fa fa-expeditedssl' => 'Fa Expeditedssl' ),
			array( 'fa fa-battery-4' => 'Fa Battery 4' ),
			array( 'fa fa-battery' => 'Fa Battery' ),
			array( 'fa fa-battery-full' => 'Fa Battery Full' ),
			array( 'fa fa-battery-3' => 'Fa Battery 3' ),
			array( 'fa fa-battery-three-quarters' => 'Fa Battery Three Quarters' ),
			array( 'fa fa-battery-2' => 'Fa Battery 2' ),
			array( 'fa fa-battery-half' => 'Fa Battery Half' ),
			array( 'fa fa-battery-1' => 'Fa Battery 1' ),
			array( 'fa fa-battery-quarter' => 'Fa Battery Quarter' ),
			array( 'fa fa-battery-0' => 'Fa Battery 0' ),
			array( 'fa fa-battery-empty' => 'Fa Battery Empty' ),
			array( 'fa fa-mouse-pointer' => 'Fa Mouse Pointer' ),
			array( 'fa fa-i-cursor' => 'Fa I Cursor' ),
			array( 'fa fa-object-group' => 'Fa Object Group' ),
			array( 'fa fa-object-ungroup' => 'Fa Object Ungroup' ),
			array( 'fa fa-sticky-note' => 'Fa Sticky Note' ),
			array( 'fa fa-sticky-note-o' => 'Fa Sticky Note O' ),
			array( 'fa fa-cc-jcb' => 'Fa Cc Jcb' ),
			array( 'fa fa-cc-diners-club' => 'Fa Cc Diners Club' ),
			array( 'fa fa-clone' => 'Fa Clone' ),
			array( 'fa fa-balance-scale' => 'Fa Balance Scale' ),
			array( 'fa fa-hourglass-o' => 'Fa Hourglass O' ),
			array( 'fa fa-hourglass-1' => 'Fa Hourglass 1' ),
			array( 'fa fa-hourglass-start' => 'Fa Hourglass Start' ),
			array( 'fa fa-hourglass-2' => 'Fa Hourglass 2' ),
			array( 'fa fa-hourglass-half' => 'Fa Hourglass Half' ),
			array( 'fa fa-hourglass-3' => 'Fa Hourglass 3' ),
			array( 'fa fa-hourglass-end' => 'Fa Hourglass End' ),
			array( 'fa fa-hourglass' => 'Fa Hourglass' ),
			array( 'fa fa-hand-grab-o' => 'Fa Hand Grab O' ),
			array( 'fa fa-hand-rock-o' => 'Fa Hand Rock O' ),
			array( 'fa fa-hand-stop-o' => 'Fa Hand Stop O' ),
			array( 'fa fa-hand-paper-o' => 'Fa Hand Paper O' ),
			array( 'fa fa-hand-scissors-o' => 'Fa Hand Scissors O' ),
			array( 'fa fa-hand-lizard-o' => 'Fa Hand Lizard O' ),
			array( 'fa fa-hand-spock-o' => 'Fa Hand Spock O' ),
			array( 'fa fa-hand-pointer-o' => 'Fa Hand Pointer O' ),
			array( 'fa fa-hand-peace-o' => 'Fa Hand Peace O' ),
			array( 'fa fa-trademark' => 'Fa Trademark' ),
			array( 'fa fa-registered' => 'Fa Registered' ),
			array( 'fa fa-creative-commons' => 'Fa Creative Commons' ),
			array( 'fa fa-gg' => 'Fa Gg' ),
			array( 'fa fa-gg-circle' => 'Fa Gg Circle' ),
			array( 'fa fa-tripadvisor' => 'Fa Tripadvisor' ),
			array( 'fa fa-odnoklassniki' => 'Fa Odnoklassniki' ),
			array( 'fa fa-odnoklassniki-square' => 'Fa Odnoklassniki Square' ),
			array( 'fa fa-get-pocket' => 'Fa Get Pocket' ),
			array( 'fa fa-wikipedia-w' => 'Fa Wikipedia W' ),
			array( 'fa fa-safari' => 'Fa Safari' ),
			array( 'fa fa-chrome' => 'Fa Chrome' ),
			array( 'fa fa-firefox' => 'Fa Firefox' ),
			array( 'fa fa-opera' => 'Fa Opera' ),
			array( 'fa fa-internet-explorer' => 'Fa Internet Explorer' ),
			array( 'fa fa-tv' => 'Fa Tv' ),
			array( 'fa fa-television' => 'Fa Television' ),
			array( 'fa fa-contao' => 'Fa Contao' ),
			array( 'fa fa-500px' => 'Fa 500px' ),
			array( 'fa fa-amazon' => 'Fa Amazon' ),
			array( 'fa fa-calendar-plus-o' => 'Fa Calendar Plus O' ),
			array( 'fa fa-calendar-minus-o' => 'Fa Calendar Minus O' ),
			array( 'fa fa-calendar-times-o' => 'Fa Calendar Times O' ),
			array( 'fa fa-calendar-check-o' => 'Fa Calendar Check O' ),
			array( 'fa fa-industry' => 'Fa Industry' ),
			array( 'fa fa-map-pin' => 'Fa Map Pin' ),
			array( 'fa fa-map-signs' => 'Fa Map Signs' ),
			array( 'fa fa-map-o' => 'Fa Map O' ),
			array( 'fa fa-map' => 'Fa Map' ),
			array( 'fa fa-commenting' => 'Fa Commenting' ),
			array( 'fa fa-commenting-o' => 'Fa Commenting O' ),
			array( 'fa fa-houzz' => 'Fa Houzz' ),
			array( 'fa fa-vimeo' => 'Fa Vimeo' ),
			array( 'fa fa-black-tie' => 'Fa Black Tie' ),
			array( 'fa fa-fonticons' => 'Fa Fonticons' ),
			array( 'fa fa-reddit-alien' => 'Fa Reddit Alien' ),
			array( 'fa fa-edge' => 'Fa Edge' ),
			array( 'fa fa-credit-card-alt' => 'Fa Credit Card Alt' ),
			array( 'fa fa-codiepie' => 'Fa Codiepie' ),
			array( 'fa fa-modx' => 'Fa Modx' ),
			array( 'fa fa-fort-awesome' => 'Fa Fort Awesome' ),
			array( 'fa fa-usb' => 'Fa Usb' ),
			array( 'fa fa-product-hunt' => 'Fa Product Hunt' ),
			array( 'fa fa-mixcloud' => 'Fa Mixcloud' ),
			array( 'fa fa-scribd' => 'Fa Scribd' ),
			array( 'fa fa-pause-circle' => 'Fa Pause Circle' ),
			array( 'fa fa-pause-circle-o' => 'Fa Pause Circle O' ),
			array( 'fa fa-stop-circle' => 'Fa Stop Circle' ),
			array( 'fa fa-stop-circle-o' => 'Fa Stop Circle O' ),
			array( 'fa fa-shopping-bag' => 'Fa Shopping Bag' ),
			array( 'fa fa-shopping-basket' => 'Fa Shopping Basket' ),
			array( 'fa fa-hashtag' => 'Fa Hashtag' ),
			array( 'fa fa-bluetooth' => 'Fa Bluetooth' ),
			array( 'fa fa-bluetooth-b' => 'Fa Bluetooth B' ),
			array( 'fa fa-percent' => 'Fa Percent' ),
			array( 'fa fa-gitlab' => 'Fa Gitlab' ),
			array( 'fa fa-wpbeginner' => 'Fa Wpbeginner' ),
			array( 'fa fa-wpforms' => 'Fa Wpforms' ),
			array( 'fa fa-envira' => 'Fa Envira' ),
			array( 'fa fa-universal-access' => 'Fa Universal Access' ),
			array( 'fa fa-wheelchair-alt' => 'Fa Wheelchair Alt' ),
			array( 'fa fa-question-circle-o' => 'Fa Question Circle O' ),
			array( 'fa fa-blind' => 'Fa Blind' ),
			array( 'fa fa-audio-description' => 'Fa Audio Description' ),
			array( 'fa fa-volume-control-phone' => 'Fa Volume Control Phone' ),
			array( 'fa fa-braille' => 'Fa Braille' ),
			array( 'fa fa-assistive-listening-systems' => 'Fa Assistive Listening Systems' ),
			array( 'fa fa-asl-interpreting' => 'Fa Asl Interpreting' ),
			array( 'fa fa-american-sign-language-interpreting' => 'Fa American Sign Language Interpreting' ),
			array( 'fa fa-deafness' => 'Fa Deafness' ),
			array( 'fa fa-hard-of-hearing' => 'Fa Hard Of Hearing' ),
			array( 'fa fa-deaf' => 'Fa Deaf' ),
			array( 'fa fa-glide' => 'Fa Glide' ),
			array( 'fa fa-glide-g' => 'Fa Glide G' ),
			array( 'fa fa-signing' => 'Fa Signing' ),
			array( 'fa fa-sign-language' => 'Fa Sign Language' ),
			array( 'fa fa-low-vision' => 'Fa Low Vision' ),
			array( 'fa fa-viadeo' => 'Fa Viadeo' ),
			array( 'fa fa-viadeo-square' => 'Fa Viadeo Square' ),
			array( 'fa fa-snapchat' => 'Fa Snapchat' ),
			array( 'fa fa-snapchat-ghost' => 'Fa Snapchat Ghost' ),
			array( 'fa fa-snapchat-square' => 'Fa Snapchat Square' ),
			array( 'fa fa-pied-piper' => 'Fa Pied Piper' ),
			array( 'fa fa-first-order' => 'Fa First Order' ),
			array( 'fa fa-yoast' => 'Fa Yoast' ),
			array( 'fa fa-themeisle' => 'Fa Themeisle' ),
			array( 'fa fa-google-plus-circle' => 'Fa Google Plus Circle' ),
			array( 'fa fa-google-plus-official' => 'Fa Google Plus Official' ),
			array( 'fa fa-fa' => 'Fa Fa' ),
			array( 'fa fa-font-awesome' => 'Fa Font Awesome' ),
			array( 'fa fa-handshake-o' => 'Fa Handshake O' ),
			array( 'fa fa-envelope-open' => 'Fa Envelope Open' ),
			array( 'fa fa-envelope-open-o' => 'Fa Envelope Open O' ),
			array( 'fa fa-linode' => 'Fa Linode' ),
			array( 'fa fa-address-book' => 'Fa Address Book' ),
			array( 'fa fa-address-book-o' => 'Fa Address Book O' ),
			array( 'fa fa-vcard' => 'Fa Vcard' ),
			array( 'fa fa-address-card' => 'Fa Address Card' ),
			array( 'fa fa-vcard-o' => 'Fa Vcard O' ),
			array( 'fa fa-address-card-o' => 'Fa Address Card O' ),
			array( 'fa fa-user-circle' => 'Fa User Circle' ),
			array( 'fa fa-user-circle-o' => 'Fa User Circle O' ),
			array( 'fa fa-user-o' => 'Fa User O' ),
			array( 'fa fa-id-badge' => 'Fa Id Badge' ),
			array( 'fa fa-drivers-license' => 'Fa Drivers License' ),
			array( 'fa fa-id-card' => 'Fa Id Card' ),
			array( 'fa fa-drivers-license-o' => 'Fa Drivers License O' ),
			array( 'fa fa-id-card-o' => 'Fa Id Card O' ),
			array( 'fa fa-quora' => 'Fa Quora' ),
			array( 'fa fa-free-code-camp' => 'Fa Free Code Camp' ),
			array( 'fa fa-telegram' => 'Fa Telegram' ),
			array( 'fa fa-thermometer-4' => 'Fa Thermometer 4' ),
			array( 'fa fa-thermometer' => 'Fa Thermometer' ),
			array( 'fa fa-thermometer-full' => 'Fa Thermometer Full' ),
			array( 'fa fa-thermometer-3' => 'Fa Thermometer 3' ),
			array( 'fa fa-thermometer-three-quarters' => 'Fa Thermometer Three Quarters' ),
			array( 'fa fa-thermometer-2' => 'Fa Thermometer 2' ),
			array( 'fa fa-thermometer-half' => 'Fa Thermometer Half' ),
			array( 'fa fa-thermometer-1' => 'Fa Thermometer 1' ),
			array( 'fa fa-thermometer-quarter' => 'Fa Thermometer Quarter' ),
			array( 'fa fa-thermometer-0' => 'Fa Thermometer 0' ),
			array( 'fa fa-thermometer-empty' => 'Fa Thermometer Empty' ),
			array( 'fa fa-shower' => 'Fa Shower' ),
			array( 'fa fa-bathtub' => 'Fa Bathtub' ),
			array( 'fa fa-s15' => 'Fa S15' ),
			array( 'fa fa-bath' => 'Fa Bath' ),
			array( 'fa fa-podcast' => 'Fa Podcast' ),
			array( 'fa fa-window-maximize' => 'Fa Window Maximize' ),
			array( 'fa fa-window-minimize' => 'Fa Window Minimize' ),
			array( 'fa fa-window-restore' => 'Fa Window Restore' ),
			array( 'fa fa-times-rectangle' => 'Fa Times Rectangle' ),
			array( 'fa fa-window-close' => 'Fa Window Close' ),
			array( 'fa fa-times-rectangle-o' => 'Fa Times Rectangle O' ),
			array( 'fa fa-window-close-o' => 'Fa Window Close O' ),
			array( 'fa fa-bandcamp' => 'Fa Bandcamp' ),
			array( 'fa fa-grav' => 'Fa Grav' ),
			array( 'fa fa-etsy' => 'Fa Etsy' ),
			array( 'fa fa-imdb' => 'Fa Imdb' ),
			array( 'fa fa-ravelry' => 'Fa Ravelry' ),
			array( 'fa fa-eercast' => 'Fa Eercast' ),
			array( 'fa fa-microchip' => 'Fa Microchip' ),
			array( 'fa fa-snowflake-o' => 'Fa Snowflake O' ),
			array( 'fa fa-superpowers' => 'Fa Superpowers' ),
			array( 'fa fa-wpexplorer' => 'Fa Wpexplorer' ),
			array( 'fa fa-meetup' => 'Fa Meetup' ),
		);
		$icons        = array_merge( $dashicons, $font_awesome );
		$icons        = apply_filters( 'ovic_menu_icons_setting', $icons );

		return $icons;
	}
}
?>
<div class="ovic-content-tmp-menu"></div>
<script id="tmpl-ovic-megamenu-content" type="text/template">
	<form id="ovic-menu-item-settings-popup-content-{{data.item_id}}"
		  class="ovic-menu-item-settings-popup-content"
		  method="post">
		<input type="hidden" name="megamenu_content" class="post_id_magamenu"
			   value="0">
		<div class="head">
			<span class="menu-title"><?php esc_html_e( 'Menu: ', 'bianco-toolkit' ); ?>{{data.title}}</span>
			<div class="control">
				<button class="ovic-menu-save-settings button button-primary"
						data-item_id="{{data.item_id}}">
					<?php esc_html_e( 'Save All', 'bianco-toolkit' ); ?>
				</button>
			</div>
		</div>
		<div class="tabs-settings">
			<ul>
				<li class="active">
					<a href=".ovic-menu-tab-settings">
						<span class="icon dashicons dashicons-admin-generic"></span>
						<?php esc_html_e( 'Settings', 'bianco-toolkit' ); ?>
					</a>
				</li>
				<li>
					<a href=".ovic-menu-tab-icons">
						<span class="icon dashicons dashicons-image-filter"></span>
						<?php esc_html_e( 'Icons', 'bianco-toolkit' ); ?>
					</a>
				</li>
				<# if ( data.item_depth == 0 ) { #>
					<li class="ovic-menu-setting-for-depth-0">
						<a class="link-open-menu-buider" href=".ovic-menu-tab-builder">
							<span class="icon dashicons dashicons-welcome-widgets-menus"></span>
							<?php esc_html_e( 'Content', 'bianco-toolkit' ); ?>
						</a>
					</li>
				<# } #>
			</ul>
		</div>
		<div class="tab-container">
			<div class="ovic-menu-tab-content active ovic-menu-tab-settings">
				<div class="vc_col-xs-12 vc_column wpb_el_type_checkbox">
					<div class="wpb_element_label"><?php esc_html_e( 'Top Level Item Settings', 'bianco-toolkit' ); ?></div>
					<# if ( data.item_depth == 0 ) { #>
						<div class="edit_form_line submenu-item-bg ovic-menu-setting-for-depth-0">
							<div class="heading">
								<span class="title">
									<?php esc_html_e( 'Class Megamenu Responsive', 'bianco-toolkit' ); ?>
								</span>
							</div>
							<div class="value">
								<input value="{{data.settings.mega_responsive}}"
									   class="wpb_vc_param_value wpb-textinput el_class textfield"
									   name="mega_responsive" type="text">
								<?php esc_html_e( "Field empty value is default.", 'bianco-toolkit' ); ?>
							</div>
						</div>
						<div class="edit_form_line ovic-menu-setting-for-depth-0">
							<div class="heading">
								<span class="title"><?php esc_html_e( 'Enable Mega', 'bianco-toolkit' ); ?></span>
							</div>
							<div class="value">
								<label class="switch">
									<input data-item_id="{{data.item_id}}" value="1"
										   class="wpb_vc_param_value wpb-textinput enable_mega"
										   name="enable_mega" <# if ( data.settings.enable_mega == 1 ) { #> checked <# } #> type="checkbox">
									<span class="slider round"></span>
								</label>
							</div>
						</div>
					<# } #>
					<div class="edit_form_line">
						<div class="heading">
							<span class="title">
								<?php esc_html_e( 'Hide Title', 'bianco-toolkit' ); ?>
							</span>
							<span class="description">
								<?php esc_html_e( 'Whether to display item without text or not.', 'bianco-toolkit' ); ?>
							</span>
						</div>
						<div class="value">
							<label class="switch">
								<input value="1" class="wpb_vc_param_value wpb-textinput"
									   name="hide_title" <# if ( data.settings.hide_title == 1 ) { #> checked <# } #> type="checkbox">
								<span class="slider round"></span>
							</label>
						</div>
					</div>
					<div class="edit_form_line">
						<div class="heading">
							<span class="title">
								<?php esc_html_e( 'Disable Link', 'bianco-toolkit' ); ?>
							</span>
							<span class="description">
								<?php esc_html_e( 'Whether to disable item hyperlink or not.', 'bianco-toolkit' ); ?>
							</span>
						</div>
						<div class="value">
							<label class="switch">
								<input value="1" class="wpb_vc_param_value wpb-textinput"
									   name="disable_link"  type="checkbox" <# if ( data.settings.disable_link == 1 ) { #> checked <# } #>>
								<span class="slider round"></span>
							</label>
						</div>
					</div>

                    <div class="edit_form_line ">
                        <div class="heading">
                            <span class="title">
                                <?php esc_html_e( 'Mega Type:', 'bianco-toolkit' ); ?>
                            </span>
                            <span class="description">
								<?php esc_html_e( 'This describes the starting position of the megamenu', 'bianco-toolkit' ); ?>
							</span>
                        </div>
                        <div class="value">
                            <select name="mega_type" class="wpb_vc_param_value">
                                <option value="default"
                                <# if ( data.settings.mega_type === 'default' ) { #> selected <# } #>>
                                <?php esc_html_e( 'Default', 'bianco-toolkit' ); ?>
                                </option>
                                <option value="wide"
                                <# if ( data.settings.mega_type === 'wide' ) { #> selected <# } #>>
                                <?php esc_html_e( 'Wide', 'bianco-toolkit' ); ?>
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="edit_form_line">
                        <div class="heading">
							<span class="title">
								<?php esc_html_e( 'Bold Item', 'bianco-toolkit' ); ?>
							</span>
                            <span class="description">
								<?php esc_html_e( 'Whether to display item in bold style', 'bianco-toolkit' ); ?>
							</span>
                        </div>
                        <div class="value">
                            <label class="switch">
                                <input value="1" class="wpb_vc_param_value wpb-textinput"
                                       name="bold_item" <# if ( data.settings.bold_item == 1 ) { #> checked <# } #> type="checkbox">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>

					<# if ( data.item_depth == 0 ) { #>
						<div class="wpb_element_label">
							<?php esc_html_e( 'Sub Menu Item Settings', 'bianco-toolkit' ); ?>
						</div>
						<div class="edit_form_line submenu-item-with ovic-menu-setting-for-depth-0">
							<div class="heading">
								<span class="title">
									<?php esc_html_e( 'Sub menu item width (px only)', 'bianco-toolkit' ); ?>
								</span>
							</div>
							<div class="value">
								<input value="{{data.settings.menu_width}}"
									   class="wpb_vc_param_value wpb-textinput el_class textfield"
									   name="menu_width" type="number">
							</div>
						</div>
						<div class="edit_form_line submenu-item-bg ovic-menu-setting-for-depth-0">
							<div class="heading">
								<span class="title"><?php esc_html_e( 'Menu Background', 'bianco-toolkit' ); ?></span>
							</div>
							<div class="value field-image-select">
                                <div class="preview_thumbnail" style="float: left; margin-right: 10px;">
                                    <img src="{{data.settings.bg_thumbnail}}" width="60px" height="60px"/>
                                </div>
                                <div style="line-height: 60px;">
                                    <input type="hidden" class="process_custom_images" name="menu_bg" value="{{data.settings.menu_bg}}"/>
                                    <button type="button"
                                            class="upload_image_button button">
                                        <?php _e( 'Upload/Add image', 'bianco-toolkit' ); ?>
                                    </button>
                                    <button type="button" class="remove_image_button button" <# if ( data.settings.menu_bg == 0 ) { #> style="display:none;" <# } #>>
                                        <?php _e( 'Remove image', 'bianco-toolkit' ); ?>
                                    </button>
                                </div>
							</div>
						</div>
						<div class="edit_form_line submenu-item-bg ovic-menu-setting-for-depth-0">
							<div class="heading">
								<span class="title">
									<?php esc_html_e( 'Background Position', 'bianco-toolkit' ); ?>
								</span>
							</div>
							<div class="value">
								<select name="bg_position" class="wpb_vc_param_value">
									<option value="center"
									<# if ( data.settings.bg_position === 'center' ) { #> selected <# } #>>
									<?php esc_html_e( 'Center', 'bianco-toolkit' ); ?>
									</option>
									<option value="left"
									<# if ( data.settings.bg_position === 'left' ) { #> selected <# } #>>
									<?php esc_html_e( 'Left', 'bianco-toolkit' ); ?>
									</option>
									<option value="right"
									<# if ( data.settings.bg_position === 'right' ) { #> selected <# } #>>
									<?php esc_html_e( 'Right', 'bianco-toolkit' ); ?>
									</option>
									<option value="top"
									<# if ( data.settings.bg_position === 'top' ) { #> selected <# } #>>
									<?php esc_html_e( 'Top', 'bianco-toolkit' ); ?>
									</option>
									<option value="bottom"
									<# if ( data.settings.bg_position === 'bottom' ) { #> selected <# } #>>
									<?php esc_html_e( 'Bottom', 'bianco-toolkit' ); ?>
									</option>
								</select>
							</div>
						</div>
					<# } #>
				</div>
			</div>
			<div class="ovic-menu-tab-content ovic-menu-tab-icons">
				<div class="wpb_element_label">
					<?php esc_html_e( 'Icon Settings', 'bianco-toolkit' ); ?>
				</div>
				<div class="radio-inline">
					<select class="menu_icon_type" name="menu_icon_type">
						<option
						<# if ( data.menu_icon_type === 'font-icon' ) { #> selected <# } #> value="font-icon">
						<?php esc_html_e( 'Use Font Icon', 'bianco-toolkit' ); ?>
						</option>
						<option
						<# if ( data.menu_icon_type === 'image' ) { #> selected <# } #> value="image">
						<?php esc_html_e( 'Use Image', 'bianco-toolkit' ); ?>
						</option>
					</select>
				</div>

				<div class="edit_form_line field-icon-settings icon-setting-tab"
					<# if ( data.menu_icon_type === 'font-icon' ) { #> style="display: block;" <# } #>>
					<input class="ovic_menu_settings_menu_icon" type="hidden" name="menu_icon"
						   value="{{data.settings.menu_icon}}">
					<div class="selector">
						<span class="selected-icon">
							<i class="{{data.settings.menu_icon}}"></i>
						</span>
						<span class="selector-button remove">
							<i class="fip-fa dashicons dashicons-no-alt"></i>
						</span>
					</div>
					<div class="selector-popup">
						<div class="selector-search">
							<input type="text" class="icons-search-input"
								   placeholder="<?php esc_html_e( 'Search Icon', 'bianco-toolkit' ); ?>"
								   value="" name="">
						</div>
						<div class="fip-icons-container"
							 data-selected="{{data.settings.menu_icon}}">
							<?php
							$icons = ovic_megamenu_font_icons();
							foreach ( $icons as $k => $icon ) :
								foreach ( $icon as $k2 => $icons2 ) : ?>
									<span class="icon"
										  data-value="<?php echo esc_attr( $k2 ); ?>"
										  title="<?php echo esc_attr( $icons2 ); ?>">
											<i class="<?php echo esc_attr( $k2 ); ?>"></i>
										</span>
								<?php endforeach;
							endforeach;
							?>
						</div>
					</div>
				</div>
			<div class="edit_form_line field-image-settings icon-setting-tab field-image-select"
				<# if ( data.menu_icon_type === 'image' ) { #> style="display: block;" <# } #>>
                <div class="preview_thumbnail" style="float: left; margin-right: 10px;">
                    <img src="{{data.settings.icon_image_thumb}}" width="60px" height="60px"/>
                </div>
                <div style="line-height: 60px;">
                    <input type="hidden" class="process_custom_images" name="icon_image" value="{{data.settings.icon_image}}"/>
                    <button type="button"
                            class="upload_image_button button">
                        <?php _e( 'Upload/Add image', 'bianco-toolkit' ); ?>
                    </button>
                    <button type="button" class="remove_image_button button" <# if ( data.settings.icon_image == 0 ) { #> style="display:none;" <# } #>>
                        <?php _e( 'Remove image', 'bianco-toolkit' ); ?>
                    </button>
                </div>
			</div>
			<div class="label-image-settings edit_form_line field-image-select">
				<div class="wpb_element_label"><?php esc_html_e( 'Label Settings', 'bianco-toolkit' ); ?></div>
                <div class="preview_thumbnail" style="float: left; margin-right: 10px;">
                    <img src="{{data.settings.label_image_thumb}}" width="60px" height="60px"/>
                </div>
                <div style="line-height: 60px;">
                    <input type="hidden" class="process_custom_images" name="label_image" value="{{data.settings.label_image}}"/>
                    <button type="button"
                            class="upload_image_button button">
						<?php _e( 'Upload/Add image', 'bianco-toolkit' ); ?>
                    </button>
                    <button type="button" class="remove_image_button button" <# if ( data.settings.label_image == 0 ) { #> style="display:none;" <# } #>>
					    <?php _e( 'Remove image', 'bianco-toolkit' ); ?>
                    </button>
                </div>
			</div>
		</div>
		<# if ( data.item_depth == 0 ) { #>
			<div class="ovic-menu-tab-content ovic-menu-tab-builder ovic-menu-setting-for-depth-0">
				<# if ( data.settings.enable_mega !== 0 ) { #>
					<p style="margin: 50px auto;text-align: center;">
						<a href="{{data.iframe}}"
						   data-post_id="{{data.settings.menu_content_id}}"
						   class="button button-primary button-hero button-updater load-content-iframe">
							<?php echo esc_html__( 'LOAD EDITOR', 'bianco-toolkit' ); ?>
						</a>
					</p>
				<# } else { #>
					<div style="text-align: center; padding: 50px 20px;"><?php esc_html_e( ' Click on "Enable Mega Builder" in  Settings tab before buiding content.', 'bianco-toolkit' ); ?></div>
				<# } #>
			</div>
		<# } #>
		</div>
		<button title="Close (Esc)" type="button" class="content-menu-close">×</button>
	</form>
</script>