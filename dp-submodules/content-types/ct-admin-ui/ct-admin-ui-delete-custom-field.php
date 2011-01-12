<?php

/**
 * ct_admin_ui_delete_custom_field()
 *
 * Outputs "Delete Custom Field" admin page.
 *
 * @param array $custom_field The custom field that is about to be deleted
 * with all of its settings.
 */
function ct_admin_ui_delete_custom_field( $custom_field ) {
    $nonce = wp_create_nonce( 'ct_delete_custom_field_verify' ); ?>

    <h3><?php _e('Delete Custom Field', 'content_types'); ?></h3>
    <?php /** @todo
    <div class="updated below-h2" id="message">
        <p><a href=""></a></p>
    </div> */ ?>
    <form name="ct_form_delete_custom_field" action="" method="post" class="ct-form-single-btn">
        <input type="hidden" name="ct_delete_custom_field_secret" value="<?php echo( $nonce ); ?>" />
        <input type="submit" class="button-secondary" name="ct_delete_button" value="<?php _e('Delete Permanently', 'content_types'); ?>" />
    </form>
    <table class="widefat">
        <thead>
            <tr>
                <th><?php _e('Custom Field', 'content_types'); ?></th>
                <th><?php _e('Type', 'content_types'); ?></th>
                <th><?php _e('Description', 'content_types'); ?></th>
                <th><?php _e('Post Types', 'content_types'); ?></th>
                <th><?php _e('Embed Code', 'content_types'); ?></th>
                <?php /** @todo implement required fields
                <th><?php _e('Required', 'content_types'); ?></th>
                 */ ?>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th><?php _e('Custom Field', 'content_types'); ?></th>
                <th><?php _e('Type', 'content_types'); ?></th>
                <th><?php _e('Description', 'content_types'); ?></th>
                <th><?php _e('Post Types', 'content_types'); ?></th>
                <th><?php _e('Embed Code', 'content_types'); ?></th>
                <?php /** @todo implement required fields
                <th><?php _e('Required', 'content_types'); ?></th>
                 */ ?>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <td>
                    <strong>
                        <a href="<?php echo( admin_url( 'admin.php?page=' . $_GET['page'] . '&ct_content_type=custom_field&ct_edit_custom_field=' . $custom_field['field_id'] )); ?>"><?php echo( $custom_field['field_title'] ); ?></a>
                    </strong>
                    <div class="row-actions">
                        <span class="edit">
                            <a title="<?php _e('Edit this custom field', 'content_types'); ?>" href="<?php echo( admin_url( 'admin.php?page=' . $_GET['page'] . '&ct_content_type=custom_field&ct_edit_custom_field=' . $custom_field['field_id'] ) ); ?>"><?php _e('Edit', 'content_types'); ?></a> |
                        </span>
                        <span class="trash">
                            <a class="submitdelete" href="<?php echo( admin_url( 'admin.php?page=' . $_GET['page'] . '&ct_content_type=custom_field&ct_delete_custom_field=' . $custom_field['field_id'] . '&ct_delete_custom_field_secret=' . $nonce ) ); ?>"><?php _e('Delete Permanently', 'content_types'); ?></a>
                        </span>
                    </div>
                </td>
                <td><?php echo( $custom_field['field_type'] ); ?></td>
                <td><?php echo( $custom_field['field_description'] ); ?></td>
                <td>
                    <?php foreach( $custom_field['object_type'] as $object_type ): ?>
                        <?php echo( $object_type ); ?>
                    <?php endforeach; ?>
                </td>
                <?php if ( $custom_field['field_type'] == 'text'|| $custom_field['field_type'] == 'textarea' ):  ?>
                        <td><code>&lt;?php echo get_post_meta( $post->ID, '_ct_<?php echo( $custom_field['field_id'] ); ?>', true ); ?&gt;</code></td>
                    <?php else: ?>
                        <td><code>&lt;?php foreach( get_post_meta( $post->ID, '_ct_<?php echo( $custom_field['field_id'] ); ?>', true ) as $value ) { echo $value . ', '; } ?&gt;</code></td>
                    <?php endif; ?>
                <?php /** @todo implement required fields
                <td>
                    <?php if ( $custom_field['required'] ): ?>
                        <img class="ct-tf-icons" src="<?php echo ( CT_SUBMODULE_URL . 'ct-admin-ui/images/true.png' ); ?>" alt="<?php _e('True', 'content_types'); ?>" title="<?php _e('True', 'content_types'); ?>" />
                    <?php else: ?>
                        <img class="ct-tf-icons" src="<?php echo ( CT_SUBMODULE_URL . 'ct-admin-ui/images/false.png' ); ?>" alt="<?php _e('False', 'content_types'); ?>" title="<?php _e('False', 'content_types'); ?>" />
                    <?php endif; ?>
                </td>
                 */ ?>
            </tr>
        </tbody>
    </table>
    <form name="ct_form_delete_custom_field" action="" method="post" class="ct-form-single-btn">
        <input type="hidden" name="ct_delete_custom_field_secret" value="<?php echo( $nonce ); ?>" />
        <input type="submit" class="button-secondary" name="ct_delete_button" value="<?php _e('Delete Permanently', 'content_types'); ?>" />
    </form> <?php
}
?>