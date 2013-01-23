<?php
/*
 * Plugin Name: ブログの勝者
 * Plugin URI: http://blog.popowa.com/
 * Description: ブログの拡散度合いをSNSなどを掛け合わせて勝者を決めます
 * Author: ayakomuro
 * Version: 1.0.0
 * Author URI: http://blog.popowa.com/
 */

add_action('admin_menu', 'inner_winner_admin_menu');

function inner_winner_admin_menu() {
	add_menu_page(
		'ブログの勝者',
		'ブログの勝者一覧',
		'administrator',
		'wordpress-challenger/blog-winner-list.php',
		''
	);
}

?>
