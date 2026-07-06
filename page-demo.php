<?php
/**
 * Template Name: Get a Demo
 * Template Post Type: page
 *
 * Demo request lead form. Assign this template to the WordPress Page
 * mapped to /demo/ (or /request-a-demo/).
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$signup_url = 'https://wholesale.thesmokedrop.com/register';
$submitted  = false;
$error      = '';

if ( isset( $_POST['sdn_demo_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sdn_demo_nonce'] ) ), 'sdn_demo_request' ) ) {
	$name     = isset( $_POST['sdn_name'] ) ? sanitize_text_field( wp_unslash( $_POST['sdn_name'] ) ) : '';
	$email    = isset( $_POST['sdn_email'] ) ? sanitize_email( wp_unslash( $_POST['sdn_email'] ) ) : '';
	$store    = isset( $_POST['sdn_store'] ) ? sanitize_text_field( wp_unslash( $_POST['sdn_store'] ) ) : '';
	$platform = isset( $_POST['sdn_platform'] ) ? sanitize_text_field( wp_unslash( $_POST['sdn_platform'] ) ) : '';
	$message  = isset( $_POST['sdn_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['sdn_message'] ) ) : '';

	if ( $name && is_email( $email ) ) {
		$to      = get_option( 'admin_email' );
		$subject = 'New Demo Request — ' . $name;
		$body    = "Name: $name\nEmail: $email\nStore/Site: $store\nPlatform: $platform\n\nMessage:\n$message";
		wp_mail( $to, $subject, $body, array( 'Reply-To: ' . $email ) );
		$submitted = true;
	} else {
		$error = 'Please enter your name and a valid email address.';
	}
}
?>

<main>
    <section class="page-hero">
      <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
      <div class="ph-inner center">
        <p class="eyebrow reveal" style="justify-content:center;">Get a Demo</p>
        <h1 class="display reveal reveal-d1" style="margin:24px 0;">See SmokeDrop<br><span class="italic gradient-text">in action.</span></h1>
        <p class="lede reveal reveal-d2" style="max-width:560px;margin:0 auto;">Request a demo to learn more about what SmokeDrop can do for your business.</p>
      </div>
    </section>

    <section class="sec" style="padding-top:0;">
      <div class="wrap wrap-tight">
        <?php if ( $submitted ) : ?>
          <div class="form-success reveal">Thanks &mdash; we've got your request. A SmokeDrop team member will reach out shortly.</div>
        <?php else : ?>
          <?php if ( $error ) : ?>
            <p class="form-error reveal"><?php echo esc_html( $error ); ?></p>
          <?php endif; ?>
          <form class="sdn-form reveal" method="post">
            <?php wp_nonce_field( 'sdn_demo_request', 'sdn_demo_nonce' ); ?>
            <div class="frow">
              <div><label for="sdn_name">Name</label><input type="text" id="sdn_name" name="sdn_name" required></div>
              <div><label for="sdn_email">Email</label><input type="email" id="sdn_email" name="sdn_email" required></div>
            </div>
            <div class="frow">
              <div><label for="sdn_store">Store / website</label><input type="text" id="sdn_store" name="sdn_store" placeholder="yourstore.com"></div>
              <div>
                <label for="sdn_platform">Platform</label>
                <select id="sdn_platform" name="sdn_platform">
                  <option value="">Select one</option>
                  <option>Shopify</option>
                  <option>WooCommerce</option>
                  <option>BigCommerce</option>
                  <option>Other / not sure yet</option>
                </select>
              </div>
            </div>
            <div><label for="sdn_message">What are you looking to sell?</label><textarea id="sdn_message" name="sdn_message"></textarea></div>
            <button type="submit" class="btn btn-lime btn-lg btn-block">Request a Demo</button>
            <p class="form-note">Prefer to jump right in? <a href="<?php echo esc_url( $signup_url ); ?>" style="color:var(--green-xl);">Start your 7-day free trial instead</a>.</p>
          </form>
        <?php endif; ?>
      </div>
    </section>
</main>

<?php
get_footer();
