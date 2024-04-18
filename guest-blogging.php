<?php

/**
 * Plugin Name: Guest Blogging
 * Plugin URI:  https://subrata6630.github.io
 * Author:      Plugin Author Name
 * Author URI:  https://subrata6630.github.io
 * Description: This plugin does Gust Blogging
 * Version:     0.1.0
 * License:     GPL-2.0+
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: guest-blogging
 */

add_shortcode('ourshortcode', 'call_back_for_our_shortcode');

function call_back_for_our_shortcode(){
    ?>
<form class="our_form" method="POST">
    <input type="text" placeholder="Title" name="title"><br>
    <textarea name="content" id="" cols="30" rows="10">Content</textarea>
    <br>
    <button type="submit" name="submit">Create Post</button>
</form>
<?php

$title = $_POST['title'] ?? '';
$content = $_POST['content'] ?? '';

if (isset($_POST['submit'])) {
    if (!empty($title) && !empty($content)) {
        $our_post_array = [
            'post_title'   => $title,
            'post_content' => $content,
            'post_status'  => 'draft',
            'post_author' => 1,
            'post_type' => 'post',
        ];

        $post_id = wp_insert_post($our_post_array);
        if ($post_id) {
            echo 'Post created';
        } else {
            echo 'Post not created';
        }
    }
}
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');

function my_theme_enqueue_scripts() {
    // Enqueue your scripts and styles here using wp_enqueue_script() and wp_enqueue_style()
    wp_enqueue_style('admin-custom-style', get_template_directory_uri() . '/assets/css/index.css', array(), '1.0');
    wp_enqueue_script('admin-custom-script', get_template_directory_uri() . '/assets/js/index.js', array('jquery'), '1.0', true);
}