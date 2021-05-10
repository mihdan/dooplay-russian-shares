<?php
/**
 * Plugin Name: Dooplay Russian Shares
 * Author: Mikhail Kobzarev
 * Version: 1.0.0
 * GitHub Plugin URI: https://github.com/mihdan/dooplay-russian-shares
 */

function dooplay_child_theme_social_share( $id ) {
	// Main data
	$count = get_post_meta($id, 'dt_social_count',true);
	$count = ($count >= 1) ? doo_comvert_number($count) : '0';
	$image = get_the_post_thumbnail_url( $id,'large' );
	$slink = get_permalink($id);
	$title = get_the_title($id);
	// Conpose view
	$out = "<div class='sbox dt_social_sbox'><div class='dt_social_single'>";
	$out.= "<span>". __d('Shared') ."<b id='social_count'>{$count}</b></span>";

	$out.= "<a data-id='{$id}' rel='nofollow' href='javascript: void(0);' onclick='window.open(\"https://facebook.com/sharer.php?u={$slink}\",\"facebook\",\"toolbar=0, status=0, width=650, height=450\")' class='facebook dt_social'>";
	$out.= "<i class='fab fa-facebook-f'></i> <b>".__d('Facebook')."</b></a>";

	$out.= "<a data-id='{$id}' rel='nofollow' href='javascript: void(0);' onclick='window.open(\"https://twitter.com/intent/tweet?text={$title}&url={$slink}\",\"twitter\",\"toolbar=0, status=0, width=650, height=450\")' data-rurl='{$slink}' class='twitter dt_social'>";
	$out.= "<i class='fab fa-twitter'></i> <b>".__d('Twitter')."</b></a>";

	$out.= "<a data-id='{$id}' rel='nofollow' href='javascript: void(0);' onclick='window.open(\"https://vk.com/share.php?url={$slink}\",\"vkontakte\",\"toolbar=0, status=0, width=650, height=450\")' class='vkontakte dt_social'>";
	$out.= "<i class='fab fa-vk'></i> <b>".__d('Сохранить')."</b></a>";

	$out.= "<a data-id='{$id}' rel='nofollow' href='javascript: void(0);' onclick='window.open(\"https://connect.ok.ru/offer?url={$slink}&title={$title}&imageUrl={$image}\",\"odnoklassniki\",\"toolbar=0, status=0, width=650, height=450\")' class='odnoklassniki dt_social'>";
	$out.= "<i class='fab fa-odnoklassniki'></i> <b>".__d('Класс')."</b></a>";

	$out.= "</div></div>";

	$out .= "<script>jQuery( function( $ ) { $( '.dt_social' ).click( function() { ym( 76742023, 'reachGoal', 'share_click' ); } ); } );</script>";

	return $out;

}

add_filter(
	'the_content',
	function ( $content ) {

		if ( is_singular() && ! is_feed() ) {
			$post = get_post();
			return $content . dooplay_child_theme_social_share( $post->ID );
		}

		return $content;
	}
);