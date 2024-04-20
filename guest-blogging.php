<?php

/**
 * Plugin Name: Guest Blogging
 * Plugin URI:  https://subrata6630.github.io
 * Author:      Subrata Debnath
 * Author URI:  https://subrata6630.github.io
 * Description: This plugin does Guest Blogging
 * Version:     0.1.0
 * License:     GPL-2.0+
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: guest-blogging
 */

 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 


add_shortcode('guestbloggingshortcode', 'guest_blogging_shortcode');

function guest_blogging_shortcode(){
    ?>
<div class="container">
    <h1 class="text-center">Guest Blogging</h1>
    <p class="text-center">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Distinctio animi dolorem reiciendis
        assumenda delectus,
        harum cum esse eos labore! Neque minus obcaecati placeat amet laboriosam exercitationem, illo assumenda enim
        reiciendis.</p>

    <form class="our-form" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-75">
                <input type="text" placeholder="Title" name="title">
            </div>
            <div class="col-75">
                <textarea name="content" id="" placeholder="Content" cols="30" rows="10"></textarea>
            </div>
            <div class="col-75">
                <input type="file" name="featured_image" accept="image/*">
            </div>
            <div class="col-75">
                <button class="btn btn-dark" type="submit" name="submit">Create Post</button>
            </div>
        </div>
    </form>
</div>
<?php

    if (isset($_POST['submit'])) {
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $featured_image = $_FILES['featured_image'] ?? null;

        if (!empty($title) && !empty($content) && $featured_image) {
            // Upload the featured image
            $upload = wp_upload_bits($featured_image['name'], null, file_get_contents($featured_image['tmp_name']));
            if (!$upload['error']) {
                $file_path = $upload['file'];

                $our_post_array = [
                    'post_title'   => $title,
                    'post_content' => $content,
                    'post_status'  => 'draft',
                    'post_author' => 1,
                    'post_type' => 'post',
                ];
        
                $post_id = wp_insert_post($our_post_array);
                if ($post_id) {
                    // Set the uploaded image as the featured image
                    $attachment = [
                        'post_mime_type' => $upload['type'],
                        'post_title' => sanitize_file_name($upload['file']),
                        'post_content' => '',
                        'post_status' => 'inherit'
                    ];
                    $attach_id = wp_insert_attachment($attachment, $file_path, $post_id);
                    if (!is_wp_error($attach_id)) {
                        set_post_thumbnail($post_id, $attach_id);
                        echo 'Post created with ID: ' . $post_id;
                    } else {
                        echo 'Failed to set featured image';
                    }
                } else {
                    echo 'Post not created';
                }
            } else {
                echo 'Failed to upload featured image';
            }
        } else {
            echo 'Please fill in title, content, and upload a featured image.';
        }
    }
}


add_action('wp_enqueue_scripts', 'guest_blogging_enqueue_scripts');

function guest_blogging_enqueue_scripts() {
    // Enqueue your scripts and styles 
    wp_enqueue_style('guest-blogging-style', plugin_dir_url(__FILE__) . 'assets/css/index.css', array(), '1.0');
    wp_enqueue_script('guest-blogging-script', plugin_dir_url(__FILE__) . 'assets/js/index.js', array('jquery'), '1.0', true);
    // Enqueue Bootstrap CSS from CDN
    wp_enqueue_style( 'bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css', array(), '4.6.0' );
}