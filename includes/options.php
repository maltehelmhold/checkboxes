<?php
/**
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


add_action( 'admin_menu', 'mh_custom_admin_menu' );

function mh_custom_admin_menu() {
    add_options_page(
        'Checkbox Settings', 'Checkboxes', 'manage_options', 'checkboxes.php', 'mh_checkboxes'
    );
}

function mh_checkboxes() {
    //must check that the user has the required capability
    if (!current_user_can('manage_options'))
    {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    // variables for the field and option names
    $mh_checkbox_color = 'mh_checkbox_color';
    $mh_checkbox_style = 'mh_checkbox_style';
    $hidden_field_name = 'mt_submit_hidden';

    // Read in existing option value from database
    $opt_val_color = get_option( $mh_checkbox_color );
    $opt_val_style = get_option( $mh_checkbox_style );


    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val_color = $_POST[ "color" ];
        $opt_val_style = $_POST[ "style" ];

        // Save the posted value in the database
        update_option( $mh_checkbox_color, $_POST[ "color" ]);
        update_option( $mh_checkbox_style, $_POST[ "style" ]);


        // Put a "settings saved" message on the screen

        ?>
        <div class="updated"><p><strong><?php _e('settings saved.', 'menu-test' ); ?></strong></p></div>
        <?php

    }

    // Now display the settings editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'Menu Test Plugin Settings', 'menu-test' ) . "</h2>";

    // settings form

    ?>

    <form name="form1" method="post" action="">
        <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

        <p><?php _e("Gewählter Style:", 'menu-test' ); ?>
            <input type="text" name="style" value="<?php echo $opt_val_style; ?>" size="20">
        </p>


        <p><?php _e("Gewählte Farbe:", 'menu-test' ); ?>
            <input type="text" name="color" value="<?php echo $opt_val_color; ?>" size="20">
        </p>

        <hr />

        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
        </p>

    </form>
    </div>

    <?php

}