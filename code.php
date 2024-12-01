//This function replaces Listing price with Final price set by Artist, when accepting new booking
add_action( 'woocommerce_before_calculate_totals', 'change_product_price_dynamically' );

function change_product_price_dynamically( $cart ) {
    if ( is_admin() || ! did_action( 'woocommerce_before_calculate_totals' ) ) {
        return;
    }

    // Loop through cart items
    foreach ( $cart->get_cart() as $cart_item ) {
        $booking_id = $cart_item['hp_booking'];
        $new_price = hivepress()->cache->get_post_cache( $booking_id, 'price', 'models/booking' ); // Set your custom price
        $cart_item['data']->set_price( $new_price );
    }
}


//Discourse integration
//Mapping of Wordpress Role to Discourse Group
if ( class_exists( '\WPDiscourse\Discourse\Discourse' ) ) {
    add_filter( 'wpdc_sso_params', 'wpdc_custom_sso_params', 10, 2 );
}

function wpdc_custom_sso_params( $params, $user ) {
    $groups = map_wp_role_to_discourse_group($user);
	
    if ( strlen($groups) > 0 ) {
        $params['add_groups'] = $groups;
    }
    return $params;
}

function map_wp_role_to_discourse_group($user) {
	
	$user = wp_get_current_user();
    // Get user roles from WordPress
    $user_roles = $user->roles;
	
    // Set default role to Family (Subscriber)
    $discourse_group = 'FamilySubscriber';

    // Role mapping logic
    if (in_array('administrator', $user_roles)) {
        $discourse_group = 'Admins';
    } elseif (in_array('contributor', $user_roles)) {
        $discourse_group = 'Hosts';
    } elseif (in_array('subscriber', $user_roles)) {
        $discourse_group = 'FamilySubscriber';
    } elseif (in_array('customer', $user_roles)) {
        $discourse_group = 'Family';
    }

	
    // Return the corresponding Discourse group
    return $discourse_group;
}

//Discourse integration End


//Woocommerce dynamic pricing
//This function replaces existing price with Final price custom price
add_action( 'woocommerce_before_calculate_totals', 'change_product_price_dynamically' );

function change_product_price_dynamically( $cart ) {
    if ( is_admin() || ! did_action( 'woocommerce_before_calculate_totals' ) ) {
        return;
    }

    // Loop through cart items
    foreach ( $cart->get_cart() as $cart_item ) {
        $booking_id = $cart_item['hp_booking'];
        $new_price = hivepress()->cache->get_post_cache( $booking_id, 'price', 'models/booking' ); // Set your custom price
        $cart_item['data']->set_price( $new_price );
    }
}
//Woocommerce dynamic pricing end
