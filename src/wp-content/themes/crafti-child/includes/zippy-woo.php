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
add_action('woocommerce_before_checkout_form', 'custom_text_before_cart');
add_action('woocommerce_before_cart_table', 'custom_text_before_cart');
function custom_text_before_cart() {
  if (is_cart()) {
        echo '<p class="custom-notification">Sign up now and get FREE 500 points - Click <a href="/my-account">here</a> to register </p>';
    }
}

