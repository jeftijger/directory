<?php

/**
 * dp_admin_ui_settings()
 *
 * Outputs "Directory Settings" admin page.
 *
 */
function dp_admin_ui_settings() { ?>

    <ul class="subsubsub dp-settings">
        <li><h3><a class="<?php if ( isset( $_GET['dp_gen'] ) || ( !isset( $_GET['dp_ss'] ) && !isset( $_GET['dp_ads'] ) ) ) echo 'current'; ?>" href="admin.php?page=dp_main&dp_settings=main&dp_gen"><?php _e('General', 'directory'); ?></a> | </h3></li>
        <li><h3><a class="<?php if ( isset( $_GET['dp_ss'] ) ) echo 'current'; ?>" href="admin.php?page=dp_main&dp_settings=main&dp_ss"><?php _e('Submit Site', 'directory'); ?></a> | </h3></li>
        <li><h3><a class="<?php if ( isset( $_GET['dp_ads'] ) ) echo 'current'; ?>" href="admin.php?page=dp_main&dp_settings=main&dp_ads"><?php _e('Advertising', 'directory'); ?></a></h3></li>
    </ul>

    <?php
    if ( isset( $_GET['dp_gen'] ) || ( !isset( $_GET['dp_ss'] ) && !isset( $_GET['dp_ads'] ) ) ) {
        include_once DP_PLUGIN_DIR . 'ui-admin/settings-general.php';
        $options = get_site_option( 'dp_options' );
        dp_admin_ui_settings_general( $options );
    }
    elseif ( isset( $_GET['dp_ss'] ) ) {
        include_once DP_PLUGIN_DIR . 'ui-admin/settings-submit-site.php';
        $options = get_site_option('dp_options');
        dp_admin_ui_settings_submit_site( $options['submit_site_settings'] );
    }
    elseif ( isset( $_GET['dp_ads'] )) {
        include_once DP_PLUGIN_DIR . 'ui-admin/settings-ads.php';
        $options = get_site_option('dp_options');
        dp_admin_ui_settings_ads( $options['ads'] );
    }
}
?>