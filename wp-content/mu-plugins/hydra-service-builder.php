<?php
/**
 * HYDRA Service Page Builder
 *
 * Provides hydra_build_service_page( $cfg ) which generates Gutenberg block
 * markup for any HYDRA service page from a config array.  Call it via WP-CLI:
 *
 *   wp eval 'require WPMU_PLUGIN_DIR . "/hydra-service-builder.php";
 *            $content = hydra_build_service_page( $cfg );
 *            wp_update_post(["ID"=>PAGE_ID,"post_content"=>$content]);' --allow-root
 *
 * Or use the individual /tmp/hydra-svc-*.php builder scripts.
 */

if ( ! function_exists( 'hydra_build_service_page' ) ) :

function hydra_build_service_page( array $cfg ): string {

    $form_id  = get_option( 'hydra_quote_form_id', 45 );
    $h1       = esc_html( $cfg['h1'] ?? '' );
    $sub      = esc_html( $cfg['subheading'] ?? '' );
    $body     = $cfg['body'] ?? '';          // raw HTML, already escaped
    $related  = $cfg['related'] ?? [];
    $phone    = $cfg['phone'] ?? '+966 — — — — —';

    ob_start(); ?>

<!-- ── SECTION 1: BREADCRUMB ──────────────────────────────────────────────── -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#132533"},"spacing":{"padding":{"top":"12px","bottom":"12px","left":"24px","right":"24px"}}},"layout":{"type":"constrained","contentSize":"1100px"}} -->
<div class="wp-block-group alignfull has-background hydra-breadcrumb-bar" style="background-color:#132533;padding-top:12px;padding-bottom:12px;padding-left:24px;padding-right:24px">
<!-- wp:shortcode -->[rank_math_breadcrumb]<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->

<!-- ── SECTION 2: SERVICE HERO ───────────────────────────────────────────── -->
<!-- wp:group {"align":"full","className":"hydra-svc-hero","style":{"color":{"background":"#0C1E28"},"spacing":{"padding":{"top":"72px","bottom":"72px","left":"24px","right":"24px"}}},"layout":{"type":"constrained","contentSize":"1100px"}} -->
<div class="wp-block-group alignfull hydra-svc-hero has-background" style="background-color:#0C1E28;padding-top:72px;padding-bottom:72px;padding-left:24px;padding-right:24px">
<!-- wp:heading {"level":1,"style":{"color":{"text":"#ffffff"},"typography":{"fontSize":"38px","fontFamily":"'DM Serif Display',serif","fontWeight":"400","lineHeight":"1.2"},"spacing":{"margin":{"top":"0","bottom":"16px"}}}} -->
<h1 class="wp-block-heading" style="color:#ffffff;font-family:'DM Serif Display',serif;font-size:38px;font-weight:400;line-height:1.2;margin-top:0;margin-bottom:16px"><?php echo $h1; ?></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"color":{"text":"rgba(255,255,255,0.62)"},"typography":{"fontSize":"15px","lineHeight":"1.75"},"spacing":{"margin":{"top":"0","bottom":"32px"}}}} -->
<p style="color:rgba(255,255,255,0.62);font-size:15px;line-height:1.75;margin-top:0;margin-bottom:32px"><?php echo $sub; ?></p>
<!-- /wp:paragraph -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left"},"style":{"spacing":{"blockGap":"14px"}}} -->
<div class="wp-block-buttons">
<!-- wp:button {"style":{"color":{"background":"#016B7A","text":"#ffffff"},"border":{"radius":"6px"},"spacing":{"padding":{"top":"12px","bottom":"12px","left":"28px","right":"28px"}},"typography":{"fontSize":"14px","fontWeight":"600"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/contact/" style="background-color:#016B7A;color:#fff;border-radius:6px;padding:12px 28px;font-size:14px;font-weight:600">Get a free quote</a></div>
<!-- /wp:button -->
<!-- wp:button {"style":{"color":{"text":"#ffffff"},"border":{"color":"rgba(255,255,255,0.45)","width":"2px","radius":"6px"},"spacing":{"padding":{"top":"12px","bottom":"12px","left":"28px","right":"28px"}},"typography":{"fontSize":"14px"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="tel:<?php echo preg_replace('/[^+\d]/', '', $phone); ?>" style="color:#fff;border:2px solid rgba(255,255,255,0.45);border-radius:6px;padding:12px 28px;font-size:14px;background:transparent"><?php echo esc_html( $phone ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- ── SECTION 3: CONTENT + SIDEBAR ─────────────────────────────────────── -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#F5F8F9"},"spacing":{"padding":{"top":"64px","bottom":"64px","left":"24px","right":"24px"}}},"layout":{"type":"constrained","contentSize":"1100px"}} -->
<div class="wp-block-group alignfull has-background" style="background-color:#F5F8F9;padding-top:64px;padding-bottom:64px;padding-left:24px;padding-right:24px">
<!-- wp:columns {"isStackedOnMobile":true,"style":{"spacing":{"blockGap":"48px"}}} -->
<div class="wp-block-columns">

<!-- LEFT: main content -->
<!-- wp:column {"width":"65%"} -->
<div class="wp-block-column hydra-svc-content" style="flex-basis:65%">
<?php echo $body; ?>
</div>
<!-- /wp:column -->

<!-- RIGHT: sidebar -->
<!-- wp:column {"width":"35%","className":"hydra-svc-sidebar"} -->
<div class="wp-block-column hydra-svc-sidebar" style="flex-basis:35%">

<!-- Quote card -->
<!-- wp:group {"className":"hydra-quote-card","style":{"color":{"background":"#ffffff"},"border":{"radius":"12px"},"spacing":{"padding":{"top":"28px","bottom":"28px","left":"28px","right":"28px"}},"shadow":"0 4px 24px rgba(12,30,40,0.10)"}} -->
<div class="wp-block-group hydra-quote-card has-background" style="background-color:#ffffff;border-radius:12px;padding:28px;box-shadow:0 4px 24px rgba(12,30,40,0.10)">
<!-- wp:heading {"level":3,"style":{"color":{"text":"#0C1E28"},"typography":{"fontSize":"20px","fontFamily":"'DM Serif Display',serif","fontWeight":"400"},"spacing":{"margin":{"top":"0","bottom":"6px"}}}} -->
<h3 class="wp-block-heading" style="color:#0C1E28;font-family:'DM Serif Display',serif;font-size:20px;font-weight:400;margin-top:0;margin-bottom:6px">Get a free quote</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"color":{"text":"#5E7580"},"typography":{"fontSize":"13px"},"spacing":{"margin":{"top":"0","bottom":"20px"}}}} -->
<p style="color:#5E7580;font-size:13px;margin-top:0;margin-bottom:20px">Tell us about your facility. Quote within 24 hours.</p>
<!-- /wp:paragraph -->
<!-- wp:shortcode -->[wpforms id="<?php echo $form_id; ?>"]<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->

<!-- wp:spacer {"height":"24px"} --><div style="height:24px" aria-hidden="true" class="wp-block-spacer"></div><!-- /wp:spacer -->

<!-- Contact card -->
<!-- wp:group {"className":"hydra-contact-card","style":{"color":{"background":"#ffffff"},"border":{"radius":"12px","color":"#E0EAF0","style":"solid","width":"1px"},"spacing":{"padding":{"top":"24px","bottom":"24px","left":"24px","right":"24px"}}}} -->
<div class="wp-block-group hydra-contact-card has-background" style="background-color:#ffffff;border-radius:12px;border:1px solid #E0EAF0;padding:24px">
<!-- wp:html -->
<ul class="hydra-contact-list">
  <li><span>📍</span> Jeddah, Saudi Arabia</li>
  <li><span>📞</span> <?php echo esc_html( $phone ); ?></li>
  <li><span>✉️</span> info@hydratl.com</li>
  <li><span>⏱</span> Response within 24 hours</li>
</ul>
<!-- /wp:html -->
</div>
<!-- /wp:group -->

</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- ── SECTION 4: RELATED SERVICES ───────────────────────────────────────── -->
<?php if ( ! empty( $related ) ) : ?>
<!-- wp:group {"align":"full","style":{"color":{"background":"#ffffff"},"spacing":{"padding":{"top":"64px","bottom":"64px","left":"24px","right":"24px"}}},"layout":{"type":"constrained","contentSize":"1100px"}} -->
<div class="wp-block-group alignfull has-white-background-color has-background" style="background-color:#ffffff;padding-top:64px;padding-bottom:64px;padding-left:24px;padding-right:24px">
<!-- wp:heading {"level":2,"style":{"color":{"text":"#0C1E28"},"typography":{"fontSize":"clamp(22px,3vw,32px)","fontFamily":"'DM Serif Display',serif","fontWeight":"400"},"spacing":{"margin":{"top":"0","bottom":"40px"}}}} -->
<h2 class="wp-block-heading" style="color:#0C1E28;font-family:'DM Serif Display',serif;font-size:clamp(22px,3vw,32px);font-weight:400;margin-top:0;margin-bottom:40px">You may also need</h2>
<!-- /wp:heading -->
<!-- wp:html -->
<div class="hydra-related-grid">
<?php foreach ( $related as $svc ) : ?>
<div class="hydra-related-card">
  <div class="hydra-related-icon"><?php echo $svc['icon']; ?></div>
  <h3><?php echo esc_html( $svc['name'] ); ?></h3>
  <p><?php echo esc_html( $svc['desc'] ); ?></p>
  <a href="<?php echo esc_url( $svc['url'] ); ?>">Learn more →</a>
</div>
<?php endforeach; ?>
</div>
<!-- /wp:html -->
</div>
<!-- /wp:group -->
<?php endif; ?>

<!-- ── SECTION 5: CTA BANNER ─────────────────────────────────────────────── -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#016B7A"},"spacing":{"padding":{"top":"72px","bottom":"72px","left":"24px","right":"24px"}}},"layout":{"type":"constrained","contentSize":"800px"}} -->
<div class="wp-block-group alignfull has-background" style="background-color:#016B7A;padding-top:72px;padding-bottom:72px;padding-left:24px;padding-right:24px;text-align:center">
<!-- wp:heading {"level":2,"textAlign":"center","style":{"color":{"text":"#ffffff"},"typography":{"fontSize":"clamp(24px,4vw,36px)","fontFamily":"'DM Serif Display',serif","fontWeight":"400"},"spacing":{"margin":{"top":"0","bottom":"12px"}}}} -->
<h2 class="wp-block-heading has-text-align-center" style="color:#ffffff;font-family:'DM Serif Display',serif;font-size:clamp(24px,4vw,36px);font-weight:400;margin-top:0;margin-bottom:12px">Ready to get started?</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","style":{"color":{"text":"rgba(255,255,255,0.8)"},"typography":{"fontSize":"15px"},"spacing":{"margin":{"top":"0","bottom":"32px"}}}} -->
<p class="has-text-align-center" style="color:rgba(255,255,255,0.8);font-size:15px;margin-top:0;margin-bottom:32px">Free consultation · Jeddah · Riyadh · Dammam · all of KSA</p>
<!-- /wp:paragraph -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons">
<!-- wp:button {"style":{"color":{"background":"#ffffff","text":"#016B7A"},"border":{"radius":"6px"},"spacing":{"padding":{"top":"16px","bottom":"16px","left":"40px","right":"40px"}},"typography":{"fontWeight":"700","fontSize":"15px"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/contact/" style="background-color:#fff;color:#016B7A;border-radius:6px;padding:16px 40px;font-weight:700;font-size:15px">Get a free quote →</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- ── FOOTER (global – rendered by theme) ───────────────────────────────── -->
<?php

    return trim( ob_get_clean() );
}

endif; // function_exists
