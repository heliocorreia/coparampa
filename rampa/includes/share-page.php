<p class="share-buttons"><?php

$link = (isset($posts->ID)) ? get_the_permalink() : '';
if (empty($link))
{
	$link = get_bloginfo( 'url' );
}

// twitter
echo '<span class="share-twitter"><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></span>';

// facebook
echo '<span class="share-facebook"><iframe src="http://www.facebook.com/plugins/like.php?href=AAA&amp;send=false&amp;layout=button_count&amp;width=200&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:21px;" allowTransparency="true"></iframe></span>'

?></p>