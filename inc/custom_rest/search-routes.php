<?php
/*
* Add Custom Search Route
*
*
*/
add_action('rest_api_init', 'university_register_search');
function university_register_search()
{
    register_rest_route('university/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE, //  this method is equivelant to the GET method
        'callback' => 'universitySearchResults'
    )); // takes 3 arguments (namespage, route, array of actions)
}
function universitySearchResults($data)
{
    $campusLocation = 'campus-location';
    $mainQuery = new WP_Query(array(
        'post_type' => array('page', 'post', 'event', 'program', 'professor', $campusLocation,),
        'posts_per_page' => -1,
        's' => sanitize_text_field($data['term'])
    ));
    $results = array(
        'generalInfo' => array(),
        'professors' => array(),
        'programs' => array(),
        'events' => array(),
        'campuses' => array()
    );

    while ($mainQuery->have_posts()) {
        $mainQuery->the_post();
        if (get_post_type() == 'post' || get_post_type() == 'page') {
            array_push($results['generalInfo'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'content' => get_the_content(),
                'type' => get_post_type(),
                'authorName' => get_the_author(),
            ));
        }
        if (get_post_type() == 'professor') {
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'content' => get_the_content(),
                'type' => get_post_type(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'professorLandscape')
            ));
        }
        if (get_post_type() == 'program') {
            array_push($results['programs'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'content' => get_the_content(),
                'type' => get_post_type(),
                'id' => get_the_ID()
            ));
        }
        if (get_post_type() == 'professor') {
            $relatedCampuses = get_field('related_campus');

            if ($relatedCampuses) {
                foreach ($relatedCampuses as $campus) {
                    array_push($results['campuses'], array(
                        'title' => get_the_title($campus),
                        'permalink' => get_the_permalink($campus),
                    ));
                }
            }

            array_push($results['professors'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'content' => get_the_content(),
                'type' => get_post_type(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'professorLandscape')
            ));
        }
        if (get_post_type() == 'event') {
            $eventDate = new DateTime(get_field('event_date'));
            array_push($results['events'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'content' => get_the_content(),
                'description' => wp_trim_words(get_the_content(), 15),
                'type' => get_post_type(),
                'month' => $eventDate->format('M'),
                'day' => $eventDate->format('d')
            ));
        }
        if (get_post_type() == $campusLocation) {
            array_push($results['campuses'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'content' => get_the_content(),
                'type' => get_post_type()
            ));
        }
    }

    if ($results['programs']) {
        $programsMetaQuery = array('relation' => 'OR');

        foreach ($results['programs'] as $item) {
            array_push($programsMetaQuery, array(
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"' . $item['id'] . '"'
            ));
        }

        $programRelationShipQuery = new WP_Query(array(
            'post_type' => array('professor', 'event'),
            'posts_per_page' => -1,
            'meta_query' => $programsMetaQuery
        ));

        while ($programRelationShipQuery->have_posts()) {
            $programRelationShipQuery->the_post();

            if (get_post_type() == 'professor') {
                array_push($results['professors'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'content' => get_the_content(),
                    'type' => get_post_type(),
                    'image' => get_the_post_thumbnail_url(get_the_ID(), 'professorLandscape')
                ));
            }
            if (get_post_type() == 'event') {
                $eventDate = new DateTime(get_field('event_date'));
                array_push($results['events'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'content' => get_the_content(),
                    'description' => wp_trim_words(get_the_content(), 15),
                    'type' => get_post_type(),
                    'month' => $eventDate->format('M'),
                    'day' => $eventDate->format('d')
                ));
            }
        }

        $results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));
        $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
    }

    return $results;
}
