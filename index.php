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

        add_filter( 'woocommerce_single_product_summary', [$this,'woocommerce_onsale_timer']);

        // Added compatibility with WC +3
        $regular_price = method_exists( $product, 'get_regular_price' ) ? $product->get_regular_price() : $product->regular_price;
        $sale_price = method_exists( $product, 'get_sale_price' ) ? $product->get_sale_price() : $product->sale_price;
        $saved_price = wc_price( $regular_price - $sale_price );

        $output_html .=' '.'<span class="onsale">' . esc_html__( 'Save', 'woocommerce' ) . ' ' . $saved_price .'</span>';

        return $output_html;
    }

    function woocommerce_onsale_timer ( ) {
        global $product;
        $saledate = $product->get_date_on_sale_to();
        if ($saledate == null ) return;
        wp_enqueue_script('woo-On-Sale',plugin_dir_url( __FILE__ ).'onsale.js');
        $today = new DateTime();
        $diff = $today->diff($saledate);
        $output_html = '<div class="onSaleFlash">';
        $output_html .=' '.'<span class="onsale"><span id="Day">' . $diff->d .'</span> Days '.'</span>';
        $output_html .=' '.'<span class="onsale"><span id="Hour">' . $diff->h .'</span> Hours '.'</span>';
        $output_html .=' '.'<span class="onsale"><span id="Min">' . $diff->i .'</span> Minutes '.'</span>';
        $output_html .=' '.'<span class="onsale"><span id="Sec">' . $diff->s .'</span> Seconds '.'</span>';
        $output_html .='</div>';
        echo $output_html;
    }

}
new wc_onsale_product;