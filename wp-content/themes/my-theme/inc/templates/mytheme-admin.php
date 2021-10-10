<h1>Mytheme Theme Options</h1>
<?php settings_errors(); ?>
<form method="post" action="options.php">
    <?php settings_fields( 'mytheme_settings_group' ); ?>
    <?php do_settings_sections( 'mytheme' ) ?>
    <?php submit_button(); ?>
</form>