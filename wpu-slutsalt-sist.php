<?php
/**
 * Plugin Name:       WPU Slutsålt sist
 * Plugin URI:        https://wordpressutveckling.se/sortera-slutsalda-produkter-sist-woocommerce/
 * Description:       Sorterar slutsålda produkter sist i butiken, kategorier, sökresultat, kortkoden [products] och Product Collection-blocket, utan att dölja dem.
 * Version:           1.1.0
 * Requires at least: 6.7
 * Requires PHP:      8.2
 * Requires Plugins:  woocommerce
 * Author:            Pihlfelt & Vänner
 * Author URI:        https://pihlfelt.se
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

defined( 'ABSPATH' ) || exit;

// Themes without WooCommerce support, and the [products] shortcode, list products through
// WC_Shortcode_Products. Its query has no wc_query flag, so we add our own.
add_filter( 'woocommerce_shortcode_products_query', 'wpu_out_of_stock_last_flag_shortcode' );
function wpu_out_of_stock_last_flag_shortcode( $query_args ) {
	// Keep a hand-picked order (ids="…" with orderby="post__in").
	if ( 'post__in' !== ( $query_args['orderby'] ?? '' ) ) {
		$query_args['wpu_stock_last'] = true;
	}
	return $query_args;
}

// Priority 20 so it runs after WooCommerce's own orderby clauses (price, popularity) and keeps them as secondary sort.
add_filter( 'posts_clauses', 'wpu_out_of_stock_last', 20, 2 );
function wpu_out_of_stock_last( $clauses, $query ) {
	global $wpdb;

	if ( is_admin() ) {
		return $clauses;
	}

	// WooCommerce marks its catalog main query with wc_query, and the Product Collection block with isProductCollection.
	$is_catalog    = 'product_query' === $query->get( 'wc_query' );
	$is_collection = (bool) $query->get( 'isProductCollection' );
	$is_shortcode  = (bool) $query->get( 'wpu_stock_last' );
	if ( ! $is_catalog && ! $is_collection && ! $is_shortcode ) {
		return $clauses;
	}

	// The lookup table is kept in sync by WooCommerce and is far cheaper to join than postmeta.
	$lookup = $wpdb->prefix . 'wc_product_meta_lookup';
	if ( false === strpos( $clauses['join'], " {$lookup} wpu_stock " ) ) {
		$clauses['join'] .= " LEFT JOIN {$lookup} wpu_stock ON {$wpdb->posts}.ID = wpu_stock.product_id ";
	}

	$stock_first        = "( wpu_stock.stock_status = 'outofstock' ) ASC";
	$clauses['orderby'] = '' === trim( (string) $clauses['orderby'] )
		? $stock_first
		: $stock_first . ', ' . $clauses['orderby'];

	return $clauses;
}
