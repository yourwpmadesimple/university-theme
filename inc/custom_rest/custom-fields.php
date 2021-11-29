<?php

/*
* Add Custom Field to Rest API
*
*
*/
add_action('rest_api_init', 'university_custom_rest_field');
function university_custom_rest_field()
{
    register_rest_field('post', 'authorName', array(
        'get_callback' => function () {
            return get_the_author();
        }
    ));
}
