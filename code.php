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
