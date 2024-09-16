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

// Add sentence sign up now and get FREE $5
add_action('woocommerce_before_checkout_form', 'sentence_signup_get_free_point');
add_action('woocommerce_before_cart_table', 'sentence_signup_get_free_point');

function sentence_signup_get_free_point() {
   if(!is_user_logged_in()){
      echo '<p class="custom-notification">Sign up now and get FREE $5 Credits - Click <a href="/my-account">here</a> to register </p>';
   }else{
      return;
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

function custom_flat_rate_shipping( $rates, $package ) {
   // Get the cart total
   $cart_total = WC()->cart->subtotal;

   if($cart_total >= 50 ){
      unset( $rates['flat_rate:2']);
   }
   var_dump($cart_total);
   return $rates;
}
add_filter( 'woocommerce_package_rates', 'custom_flat_rate_shipping', 10, 2 );
