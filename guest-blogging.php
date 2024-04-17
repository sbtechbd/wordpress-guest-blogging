<?php


/**
 * Plugin Name: Plugin Name
 * Plugin URI:  Plugin URL Link
 * Author:      Plugin Author Name
 * Author URI:  Plugin Author Link
 * Description: This plugin does wonders
 * Version:     0.1.0
 * License:     GPL-2.0+
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: prefix-plugin-name
*/


add_action('ourshortcode', 'call_back_for_our_shortcode');  


function call_back_for_our_shortcode(){
    ?>
<from class="our_from" method="POST">
    <input type="text" placeholder="Title" name="title"><br>
    <textarea name="content" id="" cols="30" rows="10">content</textarea>
    <br>
    <button type="submit" name="submit">create post</button>
</from>
<?php

$titel= $_POST['title'] ?? '';
$content= $_POST['content'] ??'';

if (isset($_POST['submit'])) {

            if (!empty($titel) && !empty('$content')) {
                $our_post_array = [
                    'post-title'   => $title,
                    'post-content' => $content,
                    'post-status'  => 'draft',
                    'post-author' => 1,
                    'post_type' => 'post',
                ];

                $post_id = wp_insert_post($our_post_array);
                if ($post_id) {
                    echo 'post created';
                } 
                else{
                    echo 'post not created';
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