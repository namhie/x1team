<?php

/**
 * Offcanvas Login / Registration and User Dashboard
 */

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

?>

<?php if (is_user_logged_in()) { ?>

  <div class="account-salution">
    <p class="h2">
      <?php esc_html_e('Hello', 'bootscore'); ?> <?php global $current_user;
                                                  wp_get_current_user();
                                                  echo '' . $current_user->display_name . "\n";
                                                  ?>
    </p>
    <p><?php esc_html_e('Here you can view your recent orders, manage your shipping and billing addresses, and edit your password and account details.', 'bootscore'); ?></p>
  </div>
  <div class="woocommerce">
    <div class="navigation">
      <nav class="woocommerce-MyAccount-navigation" role="navigation">
        <div class="list-group mb-4">
          <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>

            <?php
              $menu_href = esc_url(wc_get_account_endpoint_url($endpoint));

              if ( $endpoint == 'sales') {
                ?>
                  <p class="list-group-item list-group-item-action" style="margin: unset;"><?php echo esc_html($label); ?></p>
                <?php
              } else if (  in_array( $endpoint, ['ads', 'ads_add', 'sales-orders'] ) ) {
                ?>
                  <a href="<?php echo $menu_href ?>" class="list-group-item list-group-item-action" style="margin: unset; padding-left:45px;"><?php echo esc_html($label); ?></a>
                <?php
              } else {
                ?>
                  <a href="<?php echo $menu_href ?>" class="list-group-item list-group-item-action"><?php echo esc_html($label); ?></a>
                <?php
              }


            ?>
          <?php endforeach; ?>
        </div>
      </nav>
    </div>
    <div class="woocommerce-MyAccount-content">
      <?php
      /**
       * My Account content.
       *
       * @since 2.6.0
       */
      do_action('woocommerce_account_content');
      ?>
    </div>
  </div>

<?php } else { ?>

  <?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

    <div id="customer_login_1">

      <div class="login">
  <?php endif; ?>

      <?php
        if ( function_exists( 'wptelegram_login' ) ) {
            wptelegram_login();
        }
      ?>
      <!-- <h5 class="fw-bold text-center mb-3"><?php esc_html_e('Login', 'woocommerce'); ?></h5> -->

      <div class="col mt-3">

        <form class="mb-3" method="post">

          <?php do_action('woocommerce_login_form_start'); ?>

          <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide mb-3">

            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" placeholder="логин, ник игрока, телефон, email" name="username" id="username_1" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine
                                                                                                                                                                                                                                                                        ?>
          </div>
          <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide position-relative mb-3">
            <input class="woocommerce-Input woocommerce-Input--text input-text form-control" type="password" name="password" id="password_1" autocomplete="current-password" />
            <span class="offcanvas-password show-password-input"></span>
          </div>

          <?php do_action('woocommerce_login_form'); ?>

          <p class="form-check mb-3">
            <input name="rememberme" type="checkbox" class="form-check-input" id="rememberme_1" value="forever" />
            <label class="form-check-label" for="rememberme_1"><?php _e('Remember me', 'woocommerce'); ?></label>
          </p>

          <p class="text-center mb-2">
            <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
            <button type="submit" class="woocommerce-form-login__submit btn btn-primary" name="login" value="<?php esc_attr_e('Log in', 'woocommerce'); ?>"><?php esc_html_e('Log in', 'woocommerce'); ?></button>
          </p>
          <p class="woocommerce-LostPassword lost_password form-text text-center">
            <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
          </p>

          <?php do_action('woocommerce_login_form_end'); ?>

        </form>

      </div>

      <?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

      </div>

      <div class="register">

        <h5 class="fw-bold text-center mb-3"><?php esc_html_e('Register', 'woocommerce'); ?></h5>

        <div class="card mt-3">

          <form method="post" class="card-body" <?php do_action('woocommerce_register_form_tag'); ?>>

            <?php do_action('woocommerce_register_form_start'); ?>

            <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

              <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_username_1"><?php esc_html_e('Username', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="username" id="reg_username_1" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine                                                                                                                                                                                                                                                               ?>
              </p>

            <?php endif; ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
              <label for="reg_email_1"><?php esc_html_e('Email address', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
              <input type="email" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="email" id="reg_email_1" autocomplete="email" value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine                                                                                                                                                                                                                                                              ?>
            </p>

            <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

              <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide mb-3 position-relative">
                <label for="reg_password_1"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="password" id="reg_password_1" autocomplete="new-password" />
                <span class="offcanvas-password show-password-input"></span>
              </p>

            <?php else : ?>

              <p><?php esc_html_e('A link to set a new password will be sent to your email address.', 'woocommerce'); ?></p>

            <?php endif; ?>

            <?php do_action('woocommerce_register_form'); ?>

            <p class="woocommerce-form-row form-row mb-0">
              <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
              <button type="submit" class="btn btn-outline-primary woocommerce-form-register__submit" name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
            </p>

            <?php do_action('woocommerce_register_form_end'); ?>

          </form>

        </div>

      </div>

    </div>
  <?php endif; ?>

  <?php do_action('woocommerce_after_customer_login_form'); ?>

<?php } ?>

<style>

  .logged-in.woocommerce-account .woocommerce {
      display: flex;
      flex-direction: row;
      gap: 5%;
  }
  .woocommerce-account .woocommerce::after, .woocommerce-account .woocommerce::before {
      display: none;
  }
  .col-lg-4 {
    width: 90%;
  }

</style>