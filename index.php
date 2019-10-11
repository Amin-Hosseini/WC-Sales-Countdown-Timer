<?php
/**
 * Plugin Name:       Woocommerce Onsales Products Features
 * Description:       Add special features to the on sale products page
 * Version:           1.0
 * Author:            Amin Hosseini
 */

defined('ABSPATH') or die();

Class wc_onsale_product {
    public function __construct()
    {
        self::inithooks();
    }

    public function inithooks()
    {
        add_filter( 'woocommerce_sale_flash', [$this,'woocommerce_custom_badge'], 10, 3 );
    }

    function woocommerce_custom_badge( $output_html, $post, $product ) {

        // Added compatibility with WC +3
        $regular_price = method_exists( $product, 'get_regular_price' ) ? $product->get_regular_price() : $product->regular_price;
        $sale_price = method_exists( $product, 'get_sale_price' ) ? $product->get_sale_price() : $product->sale_price;

        $saved_price = wc_price( $regular_price - $sale_price );
        $output_html .=' '.'<span class="onsale">' . esc_html__( 'Save', 'woocommerce' ) . ' ' . $saved_price .'</span>';

        return $output_html;
    }
}
new wc_onsale_product;