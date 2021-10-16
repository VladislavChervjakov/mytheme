<h1>Mytheme Theme Options</h1>
<?php 
    settings_errors();
    $first_name = esc_attr( get_option( 'first_name' ) );
    $last_name = esc_attr( get_option( 'last_name' ) );
    $fullname = $first_name . ' ' . $last_name;
    $user_description = esc_attr( get_option( 'user_description' ) );

?>
<div class="mytheme-admin-settings-container">
    <form method="post" action="options.php" class="mytheme-general-form">
        <?php settings_fields( 'mytheme_settings_group' ); ?>
        <?php do_settings_sections( 'mytheme' ) ?>
        <?php submit_button(); ?>
    </form>
    <div class="mytheme-sidebar-preview">
        <div class="mytheme-sidebar">
            <h1 class="mytheme-username"><?php echo $fullname ?></h1>
            <h2 class="mytheme-description"><?php echo $user_description ?></h2>
            <div class="icons-wrapper">

            </div>
        </div>
    </div>
</div>