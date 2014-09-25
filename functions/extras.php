<?php
add_filter('user_can_richedit', '__return_false');
remove_filter('the_content', 'wpautop');

add_filter('show_admin_bar', '__return_false');
