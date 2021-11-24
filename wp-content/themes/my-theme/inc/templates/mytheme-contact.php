<h1>Mytheme Theme Support</h1>
<?php 
    settings_errors();
    //$first_name = esc_attr( get_option( 'first_name' ) );
?>
<div class="mytheme-admin-settings-container">
    <form method="post" action="options.php" class="mytheme-general-form">
        <?php settings_fields( 'mytheme_contact_options' ); ?>
        <?php do_settings_sections( 'mytheme_theme_contact' ) ?>
        <?php submit_button(); ?>
    </form>
</div>