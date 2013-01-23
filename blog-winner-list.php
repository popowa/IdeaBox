<?php
include('Challenger.php');
$users = get_users();
echo '<h2>ブログの勝者</h2>';
echo  <<<END
<table border="1">
	<tr>
		<td>名前 (ID)</td>
		<td>投稿数</td>
		<td>投稿タイトル</td>
		<td><img src="http://3.bp.blogspot.com/-vkR5y9Ezzlw/UP9cqH2YhzI/AAAAAAAAWO0/IASobGoiIuw/s1600/like.png"></td>
		<td><img src="http://4.bp.blogspot.com/-7OxRYu0ys4o/UP9dBiRmniI/AAAAAAAAWPM/XTO3RkdRbTQ/s1600/share.png"></td>
		<td><img src="http://3.bp.blogspot.com/-SpLwBe0zRvw/UP9cqLm8RhI/AAAAAAAAWO4/Kx5EujwqbUk/s1600/hatena.png"></td>
		<td><img src="http://2.bp.blogspot.com/-Yf1oHxHl_1A/UP9cqDE2lwI/AAAAAAAAWO8/prAkKoRt7xo/s1600/twitter.png"></td>
</tr>

END;
for ($i = 0; $i < count($users); $i++) {
	$challenger = new Challenger($users[$i]->data->ID);
		echo '<tr>';
		echo '<td rowspan="' . $challenger->post_count() . '">'. $users[$i]->data->user_nicename . '(' .$users[$i]->data->ID . ')</td>';
		echo '<td rowspan="' . $challenger->post_count() . '">' . $challenger->post_count() . '</td>';
		while ( $challenger->postData()->have_posts() ) : $challenger->postData()->the_post();
			echo '<td><a href=" ' . $challenger->urlReplace(get_permalink()) . '"/>' . get_the_title()  . '</a></td>';
			$fb = $challenger->facebook(); 
			echo '<td>' . $fb->like_count() . '</td>';
			echo '<td>' . $fb->share_count() . '</td>';
			echo '<td>' . $challenger->hatena() . '</td>';
			echo '<td>' . $challenger->twitter()->tweet_count();
			if($challenger->twitter()->tweet_count() > 0){
			echo '<span id="tweet_show">●</span><div style="display:none;" id="tweet_all">';
				foreach($challenger->twitter()->tweets() as $tweet){
				echo  '<li>' . $tweet->text . '</li>';
				}
				echo '</div>';
			}
 		echo '</td>';
		echo '</tr>';
		endwhile;
	}

echo '</table>';
?>
