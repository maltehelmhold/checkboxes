<?php
/** super awesome checkbox plugin */

/**
 * Plugin Name: Checkbox Plugin
 * Version: 1.0.0
 * Plugin URI: http://www.cmsvideos.de
 * Description: Checkbox Plugin
 * Author: Malte Helmhold
 * Author URI: https://cmsvideos.de
 * Text Domain: checkboxes
 * Domain Path: /languages/
 * License: GPL v3
 *
 *
 * Checkbox Plugin
 * Copyright (C) 2016, by Malte Helmhold
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// Security measure
if ( ! function_exists( 'add_filter' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit();
}


define ('MH_CHECKBOXES_PLUGIN_DIR', plugin_dir_url( __FILE__ ));

/* includes script for the options page */
if(is_admin()) {
    require plugin_dir_path(__FILE__) . 'includes/options.php';
}


/* get color and style option from database and store it in variable which will be used for setup
 * all the checkboxes, especially: setting up file path to correct script, including customized
 * jQuery regarding the option regarding color and style.
 */

$mh_checkbox_style = get_option( 'mh_checkbox_style' );
$mh_checkbox_color = get_option( 'mh_checkbox_color' );
$mh_checkbox_kind = $mh_checkbox_style . "-" . $mh_checkbox_color;


/**
 * add javascript for checkbox customization into header. searches for input and alters style.
 **/

add_action('wp_head', 'mh_checkboxes_in_head');

function mh_checkboxes_in_head(){

    global $mh_checkbox_kind;

    echo "<script>
            jQuery(document).ready(function(){
            jQuery('input').iCheck({
            checkboxClass: 'icheckbox_$mh_checkbox_kind',
            radioClass: 'iradio_$mh_checkbox_kind',
            increaseArea: '20%' // optional'
                });
            });
        </script>";
}


// Add required javascript (iCheck Script) and CSS Style regarding the chosen Style & Cololr

add_action( 'wp_enqueue_scripts', 'mh_checkboxes_script' );

function mh_checkboxes_script(){

    global $mh_checkbox_color, $mh_checkbox_style;

    wp_enqueue_script('mh_checkbox', plugin_dir_url(__FILE__) . '/js/checkbox.min.js', array('jquery'), '1.0');
    wp_enqueue_style('mh_checkbox_style', MH_CHECKBOXES_PLUGIN_DIR . 'skins/' . $mh_checkbox_style . '/' . $mh_checkbox_color . '.css' );
}

