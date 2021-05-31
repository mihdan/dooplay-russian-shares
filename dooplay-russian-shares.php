<?php
/**
 * Plugin Name: Dooplay Russian Shares
 * Plugin URI: https://github.com/mihdan/dooplay-russian-shares
 * Author: Mikhail Kobzarev
 * Author URI: https://www.kobzarev.com
 * Description: Плагин отключает шеры от Dooplay и добавляет такие же, но для русского сегмента.
 * Version: 1.0.2
 * GitHub Plugin URI: https://github.com/mihdan/dooplay-russian-shares
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

add_action(
	'setup_theme',
	function () {
		define( 'DOO_THEME_SOCIAL_SHARE', false );
	}
);

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

		if ( is_singular() && ! is_feed() && ! is_singular( 'mihdan_yandex_turbo_feed' ) ) {
			$post = get_post();
			return $content . dooplay_child_theme_social_share( $post->ID );
		}

		return $content;
	}
);

add_action(
	'wp_head',
	function () {
		?>
		<style>
            .dt_social_sbox {
                padding: 20px 0 !important;
                background-color: transparent !important;
                border: 0 !important;
            }
            .dt_social_single span { padding-left: 0 !important; }
            .dt_social.vkontakte { background-color: #45668e; }
            .dt_social.odnoklassniki { background-color: #ed812b; }
		</style>
		<?php
	}
);