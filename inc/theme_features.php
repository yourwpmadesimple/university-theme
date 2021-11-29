<?php
/*
* Themes features
*
*
*/
add_action('after_setup_theme', 'university_features');
function university_features()
{
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_post_type_support('professor', array('thumbnail'));
  add_post_type_support('campus', array('thumbnail'));
  add_image_size('professorLandscape', 400, 260, true);
  add_image_size('professorPortrait', 480, 650, true);
  add_image_size('pageBanner', 1500, 350, true);
}

/**
 * Remove post-formats support from posts.
 */
function wpdocs_remove_post_type_support()
{
  remove_post_type_support('program', 'editor');
}
add_action('init', 'wpdocs_remove_post_type_support', 10);
