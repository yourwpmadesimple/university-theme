<?php
/*
* Add Professor Thumbnail title to admin columns
*
*
*/
add_filter('manage_professor_posts_columns', 'professor_thumbnail_columns');
function professor_thumbnail_columns($defaults)
{

  $defaults = array_merge(
    array('professor' => __('Thumbnail')),
    $defaults
  );

  return $defaults;
}

/*
* Add thumbnail image to Thumnail column
*
*
*/
add_action('manage_professor_posts_custom_column', 'professor_thumbnail_custom_columns', 10, 2);
function professor_thumbnail_custom_columns($column_name)
{

  if ($column_name === 'professor') {
    echo the_post_thumbnail(array('150', '150'));
  }
}


/*
* Add Professor Relationship title to admin columns
*
*
*/
add_filter('manage_professor_posts_columns', function ($columns) {
  return array_merge($columns, ['related_programs' => __('Relationship', 'textdomain')]);
});


/*
* Add relationshiip data to Relationship column
*
*
*/
add_action('manage_professor_posts_custom_column', function ($column_key) {
  if ($column_key == 'related_programs') {
    $relatedProgram = get_post_meta(get_the_ID(), 'related_programs', true);

    foreach ($relatedProgram as $program) {
      if ($program == 96) echo 'Biology, ';
      if ($program == 97) echo 'English, ';
      if ($program == 95) echo 'Math, ';
      if ($program == 102) echo 'Science, ';
    }
  }
}, 10, 2);

/*
* Add Professor Relationship title to admin columns
*
*
*/
add_filter('manage_event_posts_columns', function ($columns) {
  return array_merge($columns, ['related_programs' => __('Relationship', 'textdomain')]);
});


/*
* Add relationshiip data to Relationship column
*
*
*/
add_action('manage_event_posts_custom_column', function ($column_key) {
  if ($column_key == 'related_programs') {
    $relatedProgram = get_post_meta(get_the_ID(), 'related_programs', true);
    if ($relatedProgram) {
      foreach ($relatedProgram as $program) {
        if ($program == 96) echo 'Biology, ';
        if ($program == 97) echo 'English, ';
        if ($program == 95) echo 'Math, ';
        if ($program == 102) echo 'Science, ';
      }
    }
  }
}, 10, 2);
