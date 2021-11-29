<?php
/*
* Redirect user to front end after login
*
*
*/
add_action('admin_init', 'redirectSubsToFrontend');
function redirectSubsToFrontend()
{
    $ourCurrentUser = wp_get_current_user();
    if (count($ourCurrentUser->roles) == 1 && $ourCurrentUser->roles[0] == 'subscriber') {
        wp_redirect(esc_url(site_url('/')));
        exit;
    }
}

/*
* Remove admin bar for subscriber role
*
*
*/
add_action('wp_loaded', 'hideAdminBar');
function hideAdminBar()
{
    $ourCurrentUser = wp_get_current_user();
    if (count($ourCurrentUser->roles) == 1 && $ourCurrentUser->roles[0] == 'subscriber') {
        show_admin_bar(false);
    }
}
