<?php

//Register sidebar for website
if (function_exists("register_sidebar")) {
  register_sidebar();
}

function enqueue_wc_cart_fragments()
{
  wp_enqueue_script('wc-cart-fragments');
}
add_action('wp_enqueue_scripts', 'enqueue_wc_cart_fragments');

//function display name category in loop product elementor
function display_product_categories_in_loop() {
    global $product;

    $categories = get_the_terms($product->get_id(), 'product_cat');
	if (!empty($categories) && !is_wp_error($categories)) {
        $first_category = $categories[0];

        echo '<div class="name-category-in-loop"><span>' . esc_html($first_category->name) . '</span></div>';
  
    }
    
}
add_action('woocommerce_before_shop_loop_item', 'display_product_categories_in_loop', 15);

// Add sentence sign up now and get FREE 500 point
add_action('woocommerce_before_checkout_form', 'sentence_signup_get_free_point');
add_action('woocommerce_before_cart_table', 'sentence_signup_get_free_point');

function sentence_signup_get_free_point() {
  echo '<p class="custom-notification">Sign up now and get FREE 500 points - Click <a href="/my-account">here</a> to register </p>';
}

add_action('woocommerce_checkout_billing', 'add_residential_detail_checkout_page');
function add_residential_detail_checkout_page(){
  echo '<h3>Residential details</h3>';
  echo '<p class="form-row form-row-wide" id="residential_field" data-priority="30"><label for="residential" class="">Another Address&nbsp;<span class="optional">(optional)</span></label><span class="woocommerce-input-wrapper"><input type="text" class="input-text " name="residential" id="residential" placeholder="" value="" autocomplete="residential"></span></p>';
}

add_action('woocommerce_checkout_update_order_meta', 'save_residential_field_order_meta');
function save_residential_field_order_meta($order_id) {
    if ( ! empty( $_POST['residential'] ) ) {
        update_post_meta( $order_id, 'residential_detail', sanitize_text_field( $_POST['residential'] ) );
    }
}

// Display the custom field data in the admin order details
add_action('woocommerce_admin_order_data_after_billing_address', 'display_residential_field_in_admin_order', 10, 1);
function display_residential_field_in_admin_order($order){
    $residential_detail = get_post_meta($order->get_id(), 'residential_detail', true);
    if ( ! empty( $residential_detail ) ) {
        echo '<p><strong>Residential Detail:</strong> ' . esc_html($residential_detail) . '</p>';
    }
}


add_filter( 'gettext', 'ahirwp_translate_woocommerce_strings', 999, 3 );
  
function ahirwp_translate_woocommerce_strings( $translated, $untranslated, $domain ) {
 
   if ( ! is_admin() && 'woocommerce' === $domain ) {
 
      switch ( $translated ) {
 
         case 'Ship to a different address?':
 
            $translated = 'Residential Details';
            break;
 
        
         // ETC
       
      }
 
   }   
  
   return $translated;
 
}