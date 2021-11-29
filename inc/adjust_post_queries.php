<?php
/*
* Adjust the queries for posts and custom post types
*
*
*/
add_action('pre_get_posts', 'university_adjust_queries');
function university_adjust_queries($query)
{

  if (!is_admin() and is_post_type_archive('campus-location') and $query->is_main_query()) {
    $query->set('posts_per_page', -1);
  }

  if (!is_admin() and is_post_type_archive('program') and $query->is_main_query()) {
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);
  }

  if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
    $today = date('Ymd');
    $query->set('meta_key', 'event_date');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    $query->set('meta_query', array(
      array(
        'key' => 'event_date',
        'compare' => '>=',
        'value' => $today,
        'type' => 'numeric'
      )
    ));
  }
  flush_rewrite_rules();
}