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

add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_script(
        'hydra-frontend',
        plugins_url( 'hydra-frontend.js', __FILE__ ),
        [],
        '1.1',
        true
    );
} );

// ── Page Toggle Bar + SEO Keywords Bar ────────────────────────────────────────

add_action( 'kadence_after_header', 'hydra_render_page_bars' );

function hydra_render_page_bars(): void {

    // Page definitions: slug => [ label, url, h1_chips[], h2_chips[] ]
    $pages = [
        'temperature-mapping-saudi-arabia' => [
            'label' => '1·Temp Mapping',
            'url'   => '/services/temperature-mapping-saudi-arabia/',
            'h1'    => [ 'temperature mapping services Saudi Arabia' ],
            'h2'    => [ 'warehouse temperature mapping' ],
        ],
        'validation-qualification-services' => [
            'label' => '2·Validation',
            'url'   => '/services/validation-qualification-services/',
            'h1'    => [ 'validation and qualification services Saudi Arabia' ],
            'h2'    => [ 'cold chain validation services' ],
        ],
        'gdp-compliance-saudi-arabia' => [
            'label' => '3·GDP Compliance',
            'url'   => '/services/gdp-compliance-saudi-arabia/',
            'h1'    => [ 'GDP compliance Saudi Arabia' ],
            'h2'    => [ 'SFDA GDP compliance' ],
        ],
        'monitoring-data-loggers' => [
            'label' => '4·Monitoring',
            'url'   => '/services/monitoring-data-loggers/',
            'h1'    => [ 'real time temperature monitoring system' ],
            'h2'    => [ 'cold chain monitoring system', 'temperature data logger' ],
        ],
        'calibration-services' => [
            'label' => '5·Calibration',
            'url'   => '/services/calibration-services/',
            'h1'    => [ 'calibration services Saudi Arabia' ],
            'h2'    => [],
        ],
        'pharmaceutical-quality-management-system' => [
            'label' => '6·QMS',
            'url'   => '/services/pharmaceutical-quality-management-system/',
            'h1'    => [ 'pharma QMS Saudi Arabia' ],
            'h2'    => [ 'QMS implementation' ],
        ],
        'thermal-packaging' => [
            'label' => '7·Thermal Pack.',
            'url'   => '/services/thermal-packaging/',
            'h1'    => [ 'thermal packaging' ],
            'h2'    => [ 'temperature controlled shipping' ],
        ],
        'computer-system-validation-saudi-arabia' => [
            'label' => '8·CSV',
            'url'   => '/services/computer-system-validation-saudi-arabia/',
            'h1'    => [ 'computer system validation services' ],
            'h2'    => [ 'GAMP 5 validation' ],
        ],
        'cold-chain-solutions-saudi-arabia' => [
            'label' => '9·Cold Chain Sol.',
            'url'   => '/services/cold-chain-solutions-saudi-arabia/',
            'h1'    => [ 'cold chain solutions Saudi Arabia' ],
            'h2'    => [ 'GDP transport solutions' ],
        ],
    ];

    // Detect current page
    $obj          = get_queried_object();
    $current_slug = ( $obj instanceof WP_Post ) ? $obj->post_name : '';

    // Only render on the 9 service/product pages
    if ( ! array_key_exists( $current_slug, $pages ) ) {
        return;
    }

    $current = $pages[ $current_slug ];

    // Toggle buttons list (Home, 9 pages, About, Contact)
    $toggle_buttons = array_merge(
        [ [ 'label' => 'Home',    'url' => '/' ] ],
        array_map( fn( $p ) => [ 'label' => $p['label'], 'url' => $p['url'] ], array_values( $pages ) ),
        [
            [ 'label' => 'About',   'url' => '/about/' ],
            [ 'label' => 'Contact', 'url' => '/contact/' ],
        ]
    );

    ?>
    <style id="hydra-page-bars-css">
    /* ── Page Toggle Bar ── */
    .hydra-pg-bar {
        background: #0C1E28;
        padding: 9px 5%;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
        position: relative;
        z-index: 50;
    }
    .hydra-pg-label {
        font-size: 10px;
        color: rgba(255,255,255,0.35);
        letter-spacing: 0.8px;
        margin-right: 4px;
        white-space: nowrap;
        font-family: 'DM Sans', sans-serif;
    }
    .hydra-pg-btn {
        font-size: 11px;
        padding: 4px 11px;
        border-radius: 4px;
        border: 1px solid rgba(255,255,255,0.15);
        background: transparent;
        color: rgba(255,255,255,0.52);
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        text-decoration: none;
        display: inline-block;
        white-space: nowrap;
        line-height: 1.4;
    }
    .hydra-pg-btn:hover {
        color: rgba(255,255,255,0.85);
        border-color: rgba(255,255,255,0.35);
    }
    .hydra-pg-btn.is-active {
        background: #016B7A;
        color: #ffffff;
        border-color: #016B7A;
    }
    /* ── SEO Keywords Bar ── */
    .hydra-kw-bar {
        background: #132533;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        padding: 10px 5%;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .hydra-kw-label {
        font-size: 10px;
        color: rgba(255,255,255,0.35);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        white-space: nowrap;
        font-family: 'DM Sans', sans-serif;
    }
    .hydra-kw-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        align-items: center;
    }
    .hydra-kw-chip {
        display: inline-flex;
        align-items: center;
        gap: 0;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
        padding: 3px 10px 3px 6px;
        line-height: 1.4;
        white-space: nowrap;
        text-decoration: none;
    }
    .hydra-kw-chip .hydra-kw-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
        margin-right: 5px;
    }
    .hydra-kw-chip.h1 {
        background: #E0F4F7;
        color: #014F59;
        border: 1px solid #b0dfe5;
    }
    .hydra-kw-chip.h1 .hydra-kw-dot { background: #016B7A; }
    .hydra-kw-chip.h2 {
        background: #F5F8F9;
        color: #5E7580;
        border: 1px solid #dde5e8;
    }
    .hydra-kw-chip.h2 .hydra-kw-dot { background: #aabdc4; }
    /* ── Mobile: horizontal scroll ── */
    @media (max-width: 767px) {
        .hydra-pg-bar {
            flex-wrap: nowrap;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            -ms-overflow-style: none;
            padding: 9px 16px;
        }
        .hydra-pg-bar::-webkit-scrollbar { display: none; }
        .hydra-kw-bar {
            flex-wrap: nowrap;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            -ms-overflow-style: none;
            padding: 10px 16px;
        }
        .hydra-kw-bar::-webkit-scrollbar { display: none; }
        .hydra-kw-chips { flex-wrap: nowrap; }
    }
    </style>

    <div class="hydra-pg-bar" role="navigation" aria-label="Page navigation">
        <span class="hydra-pg-label">Pages:</span>
        <?php foreach ( $toggle_buttons as $btn ) :
            $is_active = rtrim( $btn['url'], '/' ) === rtrim( $current['url'], '/' );
        ?>
        <a href="<?php echo esc_url( home_url( $btn['url'] ) ); ?>"
           class="hydra-pg-btn<?php echo $is_active ? ' is-active' : ''; ?>"
           <?php if ( $is_active ) echo 'aria-current="page"'; ?>>
            <?php echo esc_html( $btn['label'] ); ?>
        </a>
        <?php endforeach; ?>
    </div>

    <div class="hydra-kw-bar" aria-label="SEO target keywords">
        <span class="hydra-kw-label">SEO Target Keywords</span>
        <div class="hydra-kw-chips">
            <?php foreach ( $current['h1'] as $kw ) : ?>
            <span class="hydra-kw-chip h1">
                <span class="hydra-kw-dot"></span>H1: <?php echo esc_html( $kw ); ?>
            </span>
            <?php endforeach; ?>
            <?php foreach ( $current['h2'] as $kw ) : ?>
            <span class="hydra-kw-chip h2">
                <span class="hydra-kw-dot"></span>H2: <?php echo esc_html( $kw ); ?>
            </span>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

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
