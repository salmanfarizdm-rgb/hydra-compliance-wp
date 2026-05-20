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
        '1.2',
        true
    );
} );

// ── Service page slugs ────────────────────────────────────────────────────────
function hydra_service_slugs(): array {
    return [
        'temperature-mapping-saudi-arabia',
        'validation-qualification-services',
        'gdp-compliance-saudi-arabia',
        'monitoring-data-loggers',
        'calibration-services',
        'pharmaceutical-quality-management-system',
        'thermal-packaging',
        'computer-system-validation-saudi-arabia',
        'cold-chain-solutions-saudi-arabia',
        'temperature-data-logger-saudi-arabia',
    ];
}

// ── Add body class on service/product pages ────────────────────────────────────
add_filter( 'body_class', function ( array $classes ): array {
    $obj = get_queried_object();
    if ( $obj instanceof WP_Post && in_array( $obj->post_name, hydra_service_slugs(), true ) ) {
        $classes[] = 'hydra-service-page';
    }
    return $classes;
} );

// ── SVG Visual Hero (after header, service pages only) ───────────────────────
add_action( 'kadence_after_header', 'hydra_render_svg_hero' );

function hydra_render_svg_hero(): void {
    $obj  = get_queried_object();
    $slug = ( $obj instanceof WP_Post ) ? $obj->post_name : '';
    if ( ! in_array( $slug, hydra_service_slugs(), true ) ) {
        return;
    }

    $svg = hydra_get_service_svg( $slug );
    if ( ! $svg ) {
        return;
    }
    ?>
    <style id="hydra-svc-visual-css">
    /* ── Visual Hero ── */
    .hydra-svc-visual {
        background: #0C1E28;
        width: 100%;
        overflow: hidden;
        line-height: 0;
        max-height: 220px;
    }
    .hydra-svc-visual svg {
        width: 100%;
        height: auto;
        max-height: 220px;
        display: block;
    }
    @media (max-width: 767px) {
        .hydra-svc-visual { max-height: 160px; }
        .hydra-svc-visual svg { max-height: 160px; }
    }
    /* ── Gap fix: remove content-area top margin on service pages ── */
    .hydra-service-page .content-area { margin-top: 0 !important; }
    .hydra-service-page .entry-content-wrap { padding-top: 0 !important; }
    /* ── Hide Kadence entry-header (page title) on service pages ── */
    .hydra-service-page .entry-header { display: none !important; }
    /* ── Content classes for service page body ── */
    .egrid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        margin-bottom: 24px;
    }
    .ecard {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #ffffff;
        border: 1px solid #E0EAF0;
        border-radius: 8px;
        padding: 12px 14px;
        font-size: 14px;
        font-weight: 500;
        color: #0C1E28;
        box-shadow: 0 1px 4px rgba(12,30,40,0.06);
    }
    @media (max-width: 480px) { .egrid { grid-template-columns: 1fr; } }
    .cl {
        list-style: none;
        padding: 0;
        margin: 0 0 24px;
    }
    .cl li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 8px 0;
        border-bottom: 1px solid #E8EFF3;
        font-size: 14px;
        color: #3D5460;
        line-height: 1.5;
    }
    .cl li:last-child { border-bottom: none; }
    .chk {
        flex-shrink: 0;
        width: 20px;
        height: 20px;
        background: rgba(1,107,122,0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        color: #016B7A;
        font-weight: 700;
        margin-top: 1px;
    }
    .sptable {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        margin-top: 20px;
        margin-bottom: 24px;
    }
    .sptable td {
        padding: 10px 14px;
        border-bottom: 1px solid #E0EAF0;
        color: #3D5460;
        line-height: 1.5;
    }
    .sptable td:first-child {
        font-weight: 600;
        color: #0C1E28;
        width: 42%;
        white-space: nowrap;
    }
    .sptable tr:last-child td { border-bottom: none; }
    @media (max-width: 480px) { .sptable td:first-child { white-space: normal; } }
    /* ── Sidebar breadcrumb bar ── */
    .hydra-service-page .hydra-breadcrumb-bar { display: none; }
    </style>
    <?php
    echo '<div class="hydra-svc-visual">' . $svg . '</div>';
}

// ── Global footer (all pages) ─────────────────────────────────────────────────
add_action( 'kadence_before_footer', 'hydra_render_global_footer' );

function hydra_render_global_footer(): void {
    ?>
    <footer class="hydra-global-footer" aria-label="Site footer">
    <div class="hgf-inner">
        <div class="hgf-cols">

            <!-- Col 1: Brand -->
            <div class="hgf-col hgf-col--brand">
                <div class="hgf-logo"><span class="hgf-hy">hy</span><span class="hgf-name">Hydra.</span></div>
                <p class="hgf-desc">Pharmaceutical compliance consultants based in Jeddah, Saudi Arabia. Temperature mapping, validation, GDP compliance, calibration, and monitoring solutions across the Kingdom.</p>
                <ul class="hgf-contact">
                    <li>📍 Jeddah, Saudi Arabia</li>
                    <li>✉️ info@hydratl.com</li>
                    <li>🌐 hydracompliance.com</li>
                </ul>
            </div>

            <!-- Col 2: Services -->
            <div class="hgf-col">
                <h4 class="hgf-heading">Services</h4>
                <ul class="hgf-links">
                    <li><a href="/services/temperature-mapping-saudi-arabia/">Temperature Mapping</a></li>
                    <li><a href="/services/validation-qualification-services/">Validation &amp; Qualification</a></li>
                    <li><a href="/services/gdp-compliance-saudi-arabia/">GDP Compliance</a></li>
                    <li><a href="/services/calibration-services/">Calibration Services</a></li>
                    <li><a href="/services/pharmaceutical-quality-management-system/">Pharma QMS</a></li>
                    <li><a href="/services/computer-system-validation-saudi-arabia/">Computer System Validation</a></li>
                    <li><a href="/services/cold-chain-solutions-saudi-arabia/">Cold Chain Solutions</a></li>
                </ul>
            </div>

            <!-- Col 3: Products + Company -->
            <div class="hgf-col">
                <h4 class="hgf-heading">Products</h4>
                <ul class="hgf-links">
                    <li><a href="/products/monitoring-data-loggers/">Monitoring &amp; Data Loggers</a></li>
                    <li><a href="/products/temperature-data-logger-saudi-arabia/">Temperature Data Logger</a></li>
                    <li><a href="/products/thermal-packaging/">Thermal Packaging</a></li>
                </ul>
                <h4 class="hgf-heading" style="margin-top:24px">Company</h4>
                <ul class="hgf-links">
                    <li><a href="/about/">About HYDRA</a></li>
                    <li><a href="/contact/">Contact us</a></li>
                </ul>
            </div>

            <!-- Col 4: Standards -->
            <div class="hgf-col">
                <h4 class="hgf-heading">Standards</h4>
                <ul class="hgf-links hgf-links--standards">
                    <li>SFDA GDP guidelines</li>
                    <li>WHO GDP 2010</li>
                    <li>ISO 17025:2017</li>
                    <li>21 CFR Part 11</li>
                    <li>GAMP 5</li>
                    <li>EU GMP Annex 11</li>
                    <li>ICH Q9 / Q10</li>
                </ul>
            </div>

        </div>

        <div class="hgf-bar">
            <span>© 2026 HYDRA Quality &amp; Compliance · Jeddah, Saudi Arabia</span>
            <span>hydracompliance.com</span>
        </div>
    </div>
    </footer>

    <style id="hydra-global-footer-css">
    /* ── Hide Kadence site-footer (replaced by hydra-global-footer) ── */
    .site-footer { display: none !important; }
    /* ── Hide Kadence credit everywhere ── */
    .site-info, .kadence-credit, a[href*="kadencewp.com"], .footer-credit { display: none !important; }

    /* ── Global footer ── */
    .hydra-global-footer {
        background: #0C1E28;
        font-family: 'DM Sans', sans-serif;
    }
    .hgf-inner {
        max-width: 1100px;
        margin: 0 auto;
        padding: 64px 5% 0;
    }
    .hgf-cols {
        display: grid;
        grid-template-columns: 2fr 1.5fr 1fr 1fr;
        gap: 48px;
        padding-bottom: 48px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    .hgf-logo {
        font-size: 22px;
        font-weight: 700;
        letter-spacing: -0.5px;
        margin-bottom: 14px;
    }
    .hgf-hy   { color: #016B7A; }
    .hgf-name { color: #ffffff; }
    .hgf-desc {
        font-size: 13px;
        line-height: 1.7;
        color: rgba(255,255,255,0.42);
        margin: 0 0 16px;
    }
    .hgf-contact {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .hgf-contact li {
        font-size: 13px;
        color: rgba(255,255,255,0.38);
        padding: 4px 0;
    }
    .hgf-heading {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.45);
        margin: 0 0 16px;
    }
    .hgf-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .hgf-links li, .hgf-links a {
        font-size: 13px;
        color: rgba(255,255,255,0.52);
        line-height: 1.5;
        padding: 4px 0;
        display: block;
        text-decoration: none;
        transition: color 0.15s;
    }
    .hgf-links a:hover { color: rgba(255,255,255,0.85); }
    .hgf-links--standards li { color: rgba(255,255,255,0.35); }
    .hgf-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 0;
        font-size: 11px;
        color: rgba(255,255,255,0.22);
    }
    @media (max-width: 991px) {
        .hgf-cols { grid-template-columns: 1fr 1fr; gap: 32px; }
        .hgf-col--brand { grid-column: 1 / -1; }
    }
    @media (max-width: 600px) {
        .hgf-cols { grid-template-columns: 1fr; gap: 28px; }
        .hgf-inner { padding: 48px 16px 0; }
        .hgf-bar { flex-direction: column; gap: 6px; text-align: center; }
    }
    </style>
    <?php
}

function hydra_get_service_svg( string $slug ): string {
    switch ( $slug ) {

        case 'temperature-mapping-saudi-arabia': return '
<svg viewBox="0 0 900 220" width="100%" height="auto" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <pattern id="tm-grid" width="45" height="45" patternUnits="userSpaceOnUse">
      <path d="M 45 0 L 0 0 0 45" fill="none" stroke="rgba(255,255,255,0.04)" stroke-width="1"/>
    </pattern>
  </defs>
  <rect width="900" height="220" fill="#0C1E28"/>
  <rect width="900" height="220" fill="url(#tm-grid)"/>
  <!-- Zone fills -->
  <rect x="80"  y="35" width="220" height="140" rx="6" fill="rgba(1,107,122,0.12)"  stroke="#016B7A" stroke-width="1" stroke-dasharray="5,3"/>
  <rect x="330" y="25" width="240" height="110" rx="6" fill="rgba(255,255,255,0.04)" stroke="rgba(255,255,255,0.15)" stroke-width="1" stroke-dasharray="5,3"/>
  <rect x="600" y="45" width="210" height="140" rx="6" fill="rgba(1,107,122,0.07)"  stroke="rgba(255,255,255,0.12)" stroke-width="1" stroke-dasharray="5,3"/>
  <!-- Zone labels -->
  <text x="190" y="50" text-anchor="middle" font-size="9" fill="rgba(1,107,122,0.8)" font-family="DM Sans,sans-serif">ZONE A</text>
  <text x="450" y="38" text-anchor="middle" font-size="9" fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif">ZONE B</text>
  <text x="705" y="60" text-anchor="middle" font-size="9" fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif">ZONE C</text>
  <!-- Connection lines -->
  <line x1="175" y1="95"  x2="390" y2="80"  stroke="#016B7A" stroke-width="1.5" stroke-opacity="0.7"/>
  <line x1="390" y1="80"  x2="650" y2="100" stroke="#016B7A" stroke-width="1.5" stroke-opacity="0.7"/>
  <line x1="175" y1="95"  x2="200" y2="145" stroke="#016B7A" stroke-width="1"   stroke-opacity="0.4"/>
  <line x1="650" y1="100" x2="680" y2="150" stroke="#016B7A" stroke-width="1"   stroke-opacity="0.4"/>
  <line x1="390" y1="80"  x2="500" y2="115" stroke="#016B7A" stroke-width="1"   stroke-opacity="0.4"/>
  <!-- Sensors -->
  <circle cx="175" cy="95"  r="14" fill="rgba(1,107,122,0.25)" stroke="#016B7A" stroke-width="1.5"/>
  <circle cx="175" cy="95"  r="5"  fill="white"/>
  <text x="175" y="79"  text-anchor="middle" font-size="9" fill="rgba(255,255,255,0.5)" font-family="DM Sans,sans-serif">T1</text>
  <circle cx="390" cy="80"  r="14" fill="rgba(1,107,122,0.25)" stroke="#016B7A" stroke-width="1.5"/>
  <circle cx="390" cy="80"  r="5"  fill="white"/>
  <text x="390" y="64"  text-anchor="middle" font-size="9" fill="rgba(255,255,255,0.5)" font-family="DM Sans,sans-serif">T2</text>
  <circle cx="650" cy="100" r="14" fill="rgba(1,107,122,0.25)" stroke="#016B7A" stroke-width="1.5"/>
  <circle cx="650" cy="100" r="5"  fill="white"/>
  <text x="650" y="84"  text-anchor="middle" font-size="9" fill="rgba(255,255,255,0.5)" font-family="DM Sans,sans-serif">T3</text>
  <circle cx="200" cy="145" r="10" fill="rgba(1,107,122,0.15)" stroke="rgba(1,107,122,0.6)" stroke-width="1"/>
  <circle cx="200" cy="145" r="4"  fill="rgba(255,255,255,0.8)"/>
  <text x="200" y="162" text-anchor="middle" font-size="9" fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif">T4</text>
  <circle cx="680" cy="150" r="10" fill="rgba(1,107,122,0.15)" stroke="rgba(1,107,122,0.6)" stroke-width="1"/>
  <circle cx="680" cy="150" r="4"  fill="rgba(255,255,255,0.8)"/>
  <text x="680" y="167" text-anchor="middle" font-size="9" fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif">T5</text>
  <circle cx="500" cy="115" r="10" fill="rgba(1,107,122,0.15)" stroke="rgba(1,107,122,0.6)" stroke-width="1"/>
  <circle cx="500" cy="115" r="4"  fill="rgba(255,255,255,0.8)"/>
  <text x="500" y="132" text-anchor="middle" font-size="9" fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif">T6</text>
  <!-- Readout card -->
  <rect x="795" y="30" width="90" height="64" rx="6" fill="rgba(1,107,122,0.2)" stroke="#016B7A" stroke-width="1"/>
  <text x="840" y="52"  text-anchor="middle" font-size="13" fill="white"               font-family="DM Sans,sans-serif" font-weight="600">2–8°C</text>
  <text x="840" y="68"  text-anchor="middle" font-size="10" fill="rgba(255,255,255,0.5)" font-family="DM Sans,sans-serif">PASS ✓</text>
  <text x="840" y="82"  text-anchor="middle" font-size="8"  fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif">ISO TRACEABLE</text>
  <!-- Bottom label -->
  <text x="450" y="208" text-anchor="middle" font-size="11" fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif" letter-spacing="2">SFDA · WHO GDP · ISPE</text>
</svg>';

        case 'validation-qualification-services': return '
<svg viewBox="0 0 900 220" width="100%" height="auto" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">
  <rect width="900" height="220" fill="#0C1E28"/>
  <!-- Phase boxes -->
  <rect x="120" y="60" width="160" height="100" rx="8" fill="rgba(1,107,122,0.18)" stroke="#016B7A" stroke-width="1.5"/>
  <rect x="370" y="60" width="160" height="100" rx="8" fill="rgba(1,107,122,0.18)" stroke="#016B7A" stroke-width="1.5"/>
  <rect x="620" y="60" width="160" height="100" rx="8" fill="rgba(1,107,122,0.18)" stroke="#016B7A" stroke-width="1.5"/>
  <!-- Phase labels -->
  <text x="200" y="93"  text-anchor="middle" font-size="22" fill="#016B7A" font-family="DM Serif Display,serif">IQ</text>
  <text x="450" y="93"  text-anchor="middle" font-size="22" fill="#016B7A" font-family="DM Serif Display,serif">OQ</text>
  <text x="700" y="93"  text-anchor="middle" font-size="22" fill="#016B7A" font-family="DM Serif Display,serif">PQ</text>
  <text x="200" y="110" text-anchor="middle" font-size="9"  fill="rgba(255,255,255,0.45)" font-family="DM Sans,sans-serif">Installation</text>
  <text x="200" y="122" text-anchor="middle" font-size="9"  fill="rgba(255,255,255,0.45)" font-family="DM Sans,sans-serif">Qualification</text>
  <text x="450" y="110" text-anchor="middle" font-size="9"  fill="rgba(255,255,255,0.45)" font-family="DM Sans,sans-serif">Operational</text>
  <text x="450" y="122" text-anchor="middle" font-size="9"  fill="rgba(255,255,255,0.45)" font-family="DM Sans,sans-serif">Qualification</text>
  <text x="700" y="110" text-anchor="middle" font-size="9"  fill="rgba(255,255,255,0.45)" font-family="DM Sans,sans-serif">Performance</text>
  <text x="700" y="122" text-anchor="middle" font-size="9"  fill="rgba(255,255,255,0.45)" font-family="DM Sans,sans-serif">Qualification</text>
  <!-- Checkmarks (gold) -->
  <text x="200" y="148" text-anchor="middle" font-size="18" fill="#C8922A" font-family="DM Sans,sans-serif">✓</text>
  <text x="450" y="148" text-anchor="middle" font-size="18" fill="#C8922A" font-family="DM Sans,sans-serif">✓</text>
  <text x="700" y="148" text-anchor="middle" font-size="18" fill="#C8922A" font-family="DM Sans,sans-serif">✓</text>
  <!-- Arrows between boxes -->
  <line x1="280" y1="110" x2="368" y2="110" stroke="#016B7A" stroke-width="1.5" stroke-opacity="0.6"/>
  <polygon points="366,106 376,110 366,114" fill="#016B7A" fill-opacity="0.6"/>
  <line x1="530" y1="110" x2="618" y2="110" stroke="#016B7A" stroke-width="1.5" stroke-opacity="0.6"/>
  <polygon points="616,106 626,110 616,114" fill="#016B7A" fill-opacity="0.6"/>
  <!-- DQ box top -->
  <rect x="388" y="12" width="124" height="34" rx="6" fill="rgba(200,146,42,0.15)" stroke="#C8922A" stroke-width="1"/>
  <text x="450" y="34" text-anchor="middle" font-size="10" fill="#C8922A" font-family="DM Sans,sans-serif" font-weight="600">DQ · Design Qual.</text>
  <line x1="450" y1="46" x2="450" y2="60" stroke="#C8922A" stroke-width="1" stroke-dasharray="3,2"/>
  <!-- Bottom label -->
  <text x="450" y="208" text-anchor="middle" font-size="11" fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif" letter-spacing="2">IQ / OQ / PQ Protocol</text>
</svg>';

        case 'gdp-compliance-saudi-arabia': return '
<svg viewBox="0 0 900 220" width="100%" height="auto" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">
  <rect width="900" height="220" fill="#0C1E28"/>
  <!-- Road line -->
  <line x1="50" y1="160" x2="850" y2="160" stroke="rgba(255,255,255,0.08)" stroke-width="12"/>
  <line x1="50" y1="160" x2="850" y2="160" stroke="rgba(255,255,255,0.12)" stroke-width="1" stroke-dasharray="20,12"/>
  <!-- Warehouse (left) -->
  <rect x="40"  y="75"  width="180" height="85" rx="4" fill="rgba(255,255,255,0.04)" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
  <polygon points="40,75 130,30 220,75" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
  <rect x="100" y="115" width="30" height="45" rx="2" fill="rgba(255,255,255,0.06)" stroke="rgba(255,255,255,0.3)" stroke-width="1"/>
  <rect x="65"  y="100" width="25" height="20" rx="2" fill="rgba(255,255,255,0.06)" stroke="rgba(255,255,255,0.25)" stroke-width="1"/>
  <rect x="145" y="100" width="25" height="20" rx="2" fill="rgba(255,255,255,0.06)" stroke="rgba(255,255,255,0.25)" stroke-width="1"/>
  <text x="130" y="170" text-anchor="middle" font-size="9" fill="rgba(255,255,255,0.35)" font-family="DM Sans,sans-serif">WAREHOUSE</text>
  <!-- GDP Shield (center) -->
  <path d="M 450 40 L 490 55 L 490 105 Q 490 140 450 155 Q 410 140 410 105 L 410 55 Z" fill="rgba(1,107,122,0.25)" stroke="#016B7A" stroke-width="2"/>
  <text x="450" y="90"  text-anchor="middle" font-size="11" fill="#016B7A" font-family="DM Sans,sans-serif" font-weight="700">GDP</text>
  <text x="450" y="110" text-anchor="middle" font-size="20" fill="#C8922A" font-family="DM Sans,sans-serif">✓</text>
  <text x="450" y="128" text-anchor="middle" font-size="8"  fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif">CERTIFIED</text>
  <!-- Truck (right) -->
  <rect x="660" y="105" width="180" height="55" rx="4" fill="rgba(255,255,255,0.04)" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
  <rect x="800" y="90"  width="60"  height="70" rx="4" fill="rgba(255,255,255,0.06)" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
  <circle cx="700" cy="165" r="12" fill="#0C1E28" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
  <circle cx="700" cy="165" r="5"  fill="rgba(255,255,255,0.2)"/>
  <circle cx="830" cy="165" r="12" fill="#0C1E28" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
  <circle cx="830" cy="165" r="5"  fill="rgba(255,255,255,0.2)"/>
  <rect x="672" y="112" width="60" height="30" rx="3" fill="rgba(1,107,122,0.15)" stroke="rgba(1,107,122,0.4)" stroke-width="1"/>
  <text x="702" y="132" text-anchor="middle" font-size="8" fill="rgba(255,255,255,0.5)" font-family="DM Sans,sans-serif">2–8°C</text>
  <text x="750" y="170" text-anchor="middle" font-size="9" fill="rgba(255,255,255,0.35)" font-family="DM Sans,sans-serif">GDP TRANSPORT</text>
  <!-- Connecting arrows -->
  <line x1="222" y1="140" x2="408" y2="115" stroke="rgba(255,255,255,0.2)" stroke-width="1.5" stroke-dasharray="6,4"/>
  <polygon points="406,111 414,118 406,122" fill="rgba(255,255,255,0.2)"/>
  <line x1="492" y1="115" x2="658" y2="130" stroke="rgba(255,255,255,0.2)" stroke-width="1.5" stroke-dasharray="6,4"/>
  <polygon points="656,126 664,133 656,137" fill="rgba(255,255,255,0.2)"/>
  <!-- Bottom label -->
  <text x="450" y="208" text-anchor="middle" font-size="11" fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif" letter-spacing="2">WHO GDP · EU GDP · SFDA</text>
</svg>';

        case 'monitoring-data-loggers': return '
<svg viewBox="0 0 900 220" width="100%" height="auto" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">
  <rect width="900" height="220" fill="#0C1E28"/>
  <!-- Sensor 1 (cx=100) -->
  <rect x="50" y="85" width="100" height="70" rx="6" fill="rgba(200,146,42,0.1)" stroke="#C8922A" stroke-width="1.5"/>
  <text x="100" y="110" text-anchor="middle" font-size="9" fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif">SENSOR 1</text>
  <text x="100" y="127" text-anchor="middle" font-size="13" fill="#C8922A" font-family="DM Sans,sans-serif" font-weight="600">4.8°C</text>
  <text x="100" y="142" text-anchor="middle" font-size="8" fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif">LIVE</text>
  <line x1="100" y1="85" x2="100" y2="63" stroke="#C8922A" stroke-width="1.5"/>
  <path d="M 86 67 Q 100 51 114 67" fill="none" stroke="#C8922A" stroke-width="1" stroke-opacity="0.6"/>
  <path d="M 78 75 Q 100 41 122 75" fill="none" stroke="#C8922A" stroke-width="1" stroke-opacity="0.3"/>
  <!-- Sensor 2 (cx=270) -->
  <rect x="220" y="85" width="100" height="70" rx="6" fill="rgba(200,146,42,0.1)" stroke="#C8922A" stroke-width="1.5"/>
  <text x="270" y="110" text-anchor="middle" font-size="9" fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif">SENSOR 2</text>
  <text x="270" y="127" text-anchor="middle" font-size="13" fill="#C8922A" font-family="DM Sans,sans-serif" font-weight="600">5.2°C</text>
  <text x="270" y="142" text-anchor="middle" font-size="8" fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif">LIVE</text>
  <line x1="270" y1="85" x2="270" y2="63" stroke="#C8922A" stroke-width="1.5"/>
  <path d="M 256 67 Q 270 51 284 67" fill="none" stroke="#C8922A" stroke-width="1" stroke-opacity="0.6"/>
  <path d="M 248 75 Q 270 41 292 75" fill="none" stroke="#C8922A" stroke-width="1" stroke-opacity="0.3"/>
  <!-- Sensor 3 (cx=440) -->
  <rect x="390" y="85" width="100" height="70" rx="6" fill="rgba(200,146,42,0.1)" stroke="#C8922A" stroke-width="1.5"/>
  <text x="440" y="110" text-anchor="middle" font-size="9" fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif">SENSOR 3</text>
  <text x="440" y="127" text-anchor="middle" font-size="13" fill="#C8922A" font-family="DM Sans,sans-serif" font-weight="600">3.9°C</text>
  <text x="440" y="142" text-anchor="middle" font-size="8" fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif">LIVE</text>
  <line x1="440" y1="85" x2="440" y2="63" stroke="#C8922A" stroke-width="1.5"/>
  <path d="M 426 67 Q 440 51 454 67" fill="none" stroke="#C8922A" stroke-width="1" stroke-opacity="0.6"/>
  <path d="M 418 75 Q 440 41 462 75" fill="none" stroke="#C8922A" stroke-width="1" stroke-opacity="0.3"/>
  <!-- Connection lines to dashboard -->
  <line x1="492" y1="120" x2="570" y2="120" stroke="rgba(200,146,42,0.3)" stroke-width="1" stroke-dasharray="4,3"/>
  <!-- Dashboard card -->
  <rect x="570" y="45" width="270" height="150" rx="8" fill="rgba(200,146,42,0.08)" stroke="#C8922A" stroke-width="1.5"/>
  <text x="705" y="67" text-anchor="middle" font-size="10" fill="rgba(255,255,255,0.5)" font-family="DM Sans,sans-serif" font-weight="600">LIVE DASHBOARD</text>
  <line x1="585" y1="75" x2="825" y2="75" stroke="rgba(255,255,255,0.08)" stroke-width="1"/>
  <!-- Graph axes -->
  <line x1="592" y1="170" x2="820" y2="170" stroke="rgba(255,255,255,0.15)" stroke-width="1"/>
  <line x1="592" y1="90"  x2="592" y2="170" stroke="rgba(255,255,255,0.15)" stroke-width="1"/>
  <!-- Graph line (gold) -->
  <polyline points="592,155 632,130 672,145 712,110 752,125 792,90 820,100" fill="none" stroke="#C8922A" stroke-width="2"/>
  <circle cx="792" cy="90" r="4" fill="#C8922A"/>
  <!-- Y-axis labels -->
  <text x="588" y="94"  text-anchor="end" font-size="8" fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif">8°</text>
  <text x="588" y="134" text-anchor="end" font-size="8" fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif">5°</text>
  <text x="588" y="174" text-anchor="end" font-size="8" fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif">2°</text>
  <!-- Bottom label -->
  <text x="450" y="208" text-anchor="middle" font-size="10" fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif" letter-spacing="1.5">Real-time · SFDA compliant · WASL registered</text>
</svg>';

        case 'calibration-services': return '
<svg viewBox="0 0 900 220" width="100%" height="auto" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">
  <rect width="900" height="220" fill="#0C1E28"/>
  <!-- Main gauge circle -->
  <circle cx="320" cy="110" r="90" fill="rgba(255,255,255,0.02)" stroke="rgba(255,255,255,0.3)" stroke-width="2"/>
  <circle cx="320" cy="110" r="75" fill="none" stroke="rgba(255,255,255,0.08)" stroke-width="1"/>
  <!-- Tick marks: 12 major at 30° intervals, 24 minor in between -->
  <line x1="320" y1="20"  x2="320" y2="35"  stroke="rgba(255,255,255,0.6)" stroke-width="2"/>
  <line x1="365" y1="32"  x2="358" y2="44"  stroke="rgba(255,255,255,0.6)" stroke-width="2"/>
  <line x1="398" y1="57"  x2="388" y2="66"  stroke="rgba(255,255,255,0.6)" stroke-width="2"/>
  <line x1="410" y1="110" x2="395" y2="110" stroke="rgba(255,255,255,0.6)" stroke-width="2"/>
  <line x1="398" y1="163" x2="388" y2="154" stroke="rgba(255,255,255,0.6)" stroke-width="2"/>
  <line x1="365" y1="188" x2="358" y2="176" stroke="rgba(255,255,255,0.6)" stroke-width="2"/>
  <line x1="320" y1="200" x2="320" y2="185" stroke="rgba(255,255,255,0.6)" stroke-width="2"/>
  <line x1="275" y1="188" x2="282" y2="176" stroke="rgba(255,255,255,0.6)" stroke-width="2"/>
  <line x1="242" y1="163" x2="252" y2="154" stroke="rgba(255,255,255,0.6)" stroke-width="2"/>
  <line x1="230" y1="110" x2="245" y2="110" stroke="rgba(255,255,255,0.6)" stroke-width="2"/>
  <line x1="242" y1="57"  x2="252" y2="66"  stroke="rgba(255,255,255,0.6)" stroke-width="2"/>
  <line x1="275" y1="32"  x2="282" y2="44"  stroke="rgba(255,255,255,0.6)" stroke-width="2"/>
  <!-- Minor ticks -->
  <line x1="342" y1="21"  x2="339" y2="28"  stroke="rgba(255,255,255,0.25)" stroke-width="1"/>
  <line x1="381" y1="39"  x2="377" y2="46"  stroke="rgba(255,255,255,0.25)" stroke-width="1"/>
  <line x1="407" y1="69"  x2="402" y2="75"  stroke="rgba(255,255,255,0.25)" stroke-width="1"/>
  <line x1="409" y1="134" x2="401" y2="132" stroke="rgba(255,255,255,0.25)" stroke-width="1"/>
  <line x1="384" y1="178" x2="379" y2="172" stroke="rgba(255,255,255,0.25)" stroke-width="1"/>
  <line x1="343" y1="197" x2="340" y2="190" stroke="rgba(255,255,255,0.25)" stroke-width="1"/>
  <line x1="297" y1="197" x2="300" y2="190" stroke="rgba(255,255,255,0.25)" stroke-width="1"/>
  <line x1="256" y1="178" x2="261" y2="172" stroke="rgba(255,255,255,0.25)" stroke-width="1"/>
  <line x1="231" y1="134" x2="239" y2="132" stroke="rgba(255,255,255,0.25)" stroke-width="1"/>
  <line x1="233" y1="69"  x2="238" y2="75"  stroke="rgba(255,255,255,0.25)" stroke-width="1"/>
  <line x1="259" y1="39"  x2="263" y2="46"  stroke="rgba(255,255,255,0.25)" stroke-width="1"/>
  <line x1="298" y1="21"  x2="301" y2="28"  stroke="rgba(255,255,255,0.25)" stroke-width="1"/>
  <!-- Gauge arc (active range) -->
  <path d="M 240 170 A 90 90 0 1 1 400 170" fill="none" stroke="#016B7A" stroke-width="4" stroke-opacity="0.4" stroke-linecap="round"/>
  <!-- Needle -->
  <line x1="320" y1="110" x2="375" y2="55" stroke="#E74C3C" stroke-width="3" stroke-linecap="round"/>
  <circle cx="320" cy="110" r="8" fill="#E74C3C"/>
  <circle cx="320" cy="110" r="4" fill="rgba(255,255,255,0.8)"/>
  <!-- ISO text inside circle -->
  <text x="320" y="125" text-anchor="middle" font-size="11" fill="white" font-family="DM Sans,sans-serif" font-weight="600">ISO 17025:2017</text>
  <text x="320" y="142" text-anchor="middle" font-size="9"  fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif">ACCREDITED</text>
  <!-- Instrument list (right side) -->
  <rect x="460" y="38" width="390" height="150" rx="8" fill="rgba(255,255,255,0.03)" stroke="rgba(255,255,255,0.1)" stroke-width="1"/>
  <text x="480" y="62" font-size="10" fill="rgba(255,255,255,0.45)" font-family="DM Sans,sans-serif" font-weight="600">CALIBRATED INSTRUMENTS</text>
  <text x="480" y="85"  font-size="9" fill="rgba(255,255,255,0.35)" font-family="DM Sans,sans-serif">· Temperature &amp; Humidity Sensors</text>
  <text x="480" y="100" font-size="9" fill="rgba(255,255,255,0.35)" font-family="DM Sans,sans-serif">· Pressure Gauges</text>
  <text x="480" y="115" font-size="9" fill="rgba(255,255,255,0.35)" font-family="DM Sans,sans-serif">· pH Meters</text>
  <text x="480" y="130" font-size="9" fill="rgba(255,255,255,0.35)" font-family="DM Sans,sans-serif">· Balances &amp; Scales</text>
  <text x="480" y="145" font-size="9" fill="rgba(255,255,255,0.35)" font-family="DM Sans,sans-serif">· Flow Meters</text>
  <text x="480" y="160" font-size="9" fill="rgba(255,255,255,0.35)" font-family="DM Sans,sans-serif">· Autoclaves &amp; Ovens</text>
  <text x="480" y="175" font-size="9" fill="rgba(255,255,255,0.35)" font-family="DM Sans,sans-serif">· Incubators &amp; Fridges</text>
  <!-- Bottom label -->
  <text x="450" y="208" text-anchor="middle" font-size="11" fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif" letter-spacing="2">SFDA · ISO 17025 · TRACEABLE CERTIFICATES</text>
</svg>';

        case 'pharmaceutical-quality-management-system': return '
<svg viewBox="0 0 900 220" width="100%" height="auto" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">
  <rect width="900" height="220" fill="#0C1E28"/>
  <!-- Top QMS box -->
  <rect x="360" y="18" width="180" height="44" rx="6" fill="rgba(1,107,122,0.2)" stroke="#016B7A" stroke-width="1.5"/>
  <text x="450" y="36" text-anchor="middle" font-size="11" fill="white" font-family="DM Sans,sans-serif" font-weight="600">QMS FRAMEWORK</text>
  <text x="450" y="51" text-anchor="middle" font-size="9"  fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif">ISO 9001 · SFDA Quality System</text>
  <!-- Vertical connector -->
  <line x1="450" y1="62" x2="450" y2="84" stroke="#016B7A" stroke-width="1.5" stroke-opacity="0.6"/>
  <!-- Second row: SOP + CAPA -->
  <rect x="160" y="84" width="160" height="44" rx="6" fill="rgba(1,107,122,0.15)" stroke="#016B7A" stroke-width="1.5"/>
  <text x="240" y="103" text-anchor="middle" font-size="11" fill="white" font-family="DM Sans,sans-serif" font-weight="600">SOP Library</text>
  <text x="240" y="118" text-anchor="middle" font-size="9"  fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif">150+ Procedures</text>
  <rect x="390" y="84" width="120" height="44" rx="6" fill="rgba(1,107,122,0.15)" stroke="#016B7A" stroke-width="1.5"/>
  <text x="450" y="103" text-anchor="middle" font-size="11" fill="white" font-family="DM Sans,sans-serif" font-weight="600">CAPA</text>
  <text x="450" y="118" text-anchor="middle" font-size="9"  fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif">Corrective Actions</text>
  <rect x="580" y="84" width="160" height="44" rx="6" fill="rgba(1,107,122,0.15)" stroke="#016B7A" stroke-width="1.5"/>
  <text x="660" y="103" text-anchor="middle" font-size="11" fill="white" font-family="DM Sans,sans-serif" font-weight="600">Risk Mgmt</text>
  <text x="660" y="118" text-anchor="middle" font-size="9"  fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif">ICH Q9 / Q10</text>
  <!-- Branch lines from QMS -->
  <line x1="450" y1="84" x2="240" y2="84" stroke="#016B7A" stroke-width="1" stroke-opacity="0.4"/>
  <line x1="450" y1="84" x2="660" y2="84" stroke="#016B7A" stroke-width="1" stroke-opacity="0.4"/>
  <!-- Third row: Audit -->
  <line x1="240" y1="128" x2="240" y2="150" stroke="#016B7A" stroke-width="1" stroke-opacity="0.4"/>
  <line x1="450" y1="128" x2="450" y2="150" stroke="#016B7A" stroke-width="1" stroke-opacity="0.4"/>
  <line x1="660" y1="128" x2="660" y2="150" stroke="#016B7A" stroke-width="1" stroke-opacity="0.4"/>
  <line x1="240" y1="150" x2="660" y2="150" stroke="#016B7A" stroke-width="1" stroke-opacity="0.4"/>
  <line x1="450" y1="150" x2="450" y2="158" stroke="#016B7A" stroke-width="1.5" stroke-opacity="0.6"/>
  <rect x="340" y="158" width="220" height="44" rx="6" fill="rgba(200,146,42,0.15)" stroke="#C8922A" stroke-width="1.5"/>
  <text x="450" y="177" text-anchor="middle" font-size="11" fill="#C8922A" font-family="DM Sans,sans-serif" font-weight="600">Internal Audit</text>
  <text x="450" y="192" text-anchor="middle" font-size="9"  fill="rgba(255,255,255,0.35)" font-family="DM Sans,sans-serif">SFDA Inspection Ready</text>
  <!-- Bottom label -->
  <text x="450" y="214" text-anchor="middle" font-size="10" fill="rgba(255,255,255,0.25)" font-family="DM Sans,sans-serif" letter-spacing="1.5">ISO 9001 · SFDA Quality System</text>
</svg>';

        case 'thermal-packaging': return '
<svg viewBox="0 0 900 220" width="100%" height="auto" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">
  <rect width="900" height="220" fill="#0C1E28"/>
  <!-- Insulated box (left) -->
  <rect x="55"  y="50"  width="170" height="140" rx="8" fill="rgba(255,255,255,0.04)" stroke="rgba(255,255,255,0.5)" stroke-width="2"/>
  <!-- Inner insulation layer -->
  <rect x="68"  y="63"  width="144" height="114" rx="5" fill="rgba(1,107,122,0.08)"  stroke="rgba(1,107,122,0.4)" stroke-width="1" stroke-dasharray="3,2"/>
  <!-- Temperature label on box -->
  <text x="140" y="115" text-anchor="middle" font-size="18" fill="#016B7A" font-family="DM Serif Display,serif">2–8°C</text>
  <text x="140" y="133" text-anchor="middle" font-size="9"  fill="rgba(255,255,255,0.5)" font-family="DM Sans,sans-serif">Validated</text>
  <text x="140" y="162" text-anchor="middle" font-size="8"  fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif">GDP Compliant</text>
  <!-- Lid / top flap -->
  <rect x="55"  y="38"  width="170" height="16" rx="4" fill="rgba(255,255,255,0.08)" stroke="rgba(255,255,255,0.4)" stroke-width="1"/>
  <!-- Dashed arrow (gold) -->
  <line x1="228" y1="120" x2="530" y2="120" stroke="#C8922A" stroke-width="2" stroke-dasharray="10,6"/>
  <polygon points="528,114 542,120 528,126" fill="#C8922A"/>
  <!-- Speed/temp icons along arrow -->
  <text x="320" y="110" text-anchor="middle" font-size="9" fill="rgba(200,146,42,0.6)" font-family="DM Sans,sans-serif">✈ Air · 🚚 Road</text>
  <!-- Destination box (right) -->
  <rect x="545" y="50" width="210" height="140" rx="8" fill="rgba(1,107,122,0.1)" stroke="rgba(255,255,255,0.35)" stroke-width="1.5"/>
  <text x="650" y="80" text-anchor="middle" font-size="10" fill="rgba(255,255,255,0.5)" font-family="DM Sans,sans-serif" font-weight="600">PRODUCTS HANDLED</text>
  <line x1="560" y1="88" x2="740" y2="88" stroke="rgba(255,255,255,0.1)" stroke-width="1"/>
  <text x="568" y="106" font-size="9" fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif">· Vaccines &amp; Biologics</text>
  <text x="568" y="124" font-size="9" fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif">· Blood Samples</text>
  <text x="568" y="142" font-size="9" fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif">· Pharma Products</text>
  <text x="568" y="160" font-size="9" fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif">· Gene Therapies</text>
  <text x="568" y="178" font-size="9" fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif">· Diagnostics</text>
  <!-- Bottom label -->
  <text x="450" y="208" text-anchor="middle" font-size="11" fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif" letter-spacing="2">GDP compliant · Saudi Arabia &amp; GCC</text>
</svg>';

        case 'computer-system-validation-saudi-arabia': return '
<svg viewBox="0 0 900 220" width="100%" height="auto" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">
  <rect width="900" height="220" fill="#0C1E28"/>
  <!-- Compliance badges (left) -->
  <rect x="40" y="30"  width="200" height="44" rx="6" fill="rgba(1,107,122,0.15)" stroke="rgba(1,107,122,0.5)" stroke-width="1"/>
  <text x="60" y="48"  font-size="11" fill="white" font-family="DM Sans,sans-serif" font-weight="600">GAMP 5</text>
  <text x="60" y="62"  font-size="9"  fill="rgba(255,255,255,0.35)" font-family="DM Sans,sans-serif">GMP Compliant</text>
  <line x1="240" y1="52" x2="360" y2="110" stroke="rgba(1,107,122,0.35)" stroke-width="1" stroke-dasharray="4,3"/>
  <rect x="40" y="88"  width="200" height="44" rx="6" fill="rgba(1,107,122,0.15)" stroke="rgba(1,107,122,0.5)" stroke-width="1"/>
  <text x="60" y="106" font-size="11" fill="white" font-family="DM Sans,sans-serif" font-weight="600">21 CFR Part 11</text>
  <text x="60" y="120" font-size="9"  fill="rgba(255,255,255,0.35)" font-family="DM Sans,sans-serif">Electronic Records</text>
  <line x1="240" y1="110" x2="360" y2="110" stroke="rgba(1,107,122,0.35)" stroke-width="1" stroke-dasharray="4,3"/>
  <rect x="40" y="146" width="200" height="44" rx="6" fill="rgba(1,107,122,0.15)" stroke="rgba(1,107,122,0.5)" stroke-width="1"/>
  <text x="60" y="164" font-size="11" fill="white" font-family="DM Sans,sans-serif" font-weight="600">EU Annex 11</text>
  <text x="60" y="178" font-size="9"  fill="rgba(255,255,255,0.35)" font-family="DM Sans,sans-serif">Computerised Systems</text>
  <line x1="240" y1="168" x2="360" y2="110" stroke="rgba(1,107,122,0.35)" stroke-width="1" stroke-dasharray="4,3"/>
  <!-- Monitor -->
  <rect x="362" y="35" width="350" height="200" rx="10" fill="rgba(1,107,122,0.1)" stroke="#016B7A" stroke-width="2"/>
  <rect x="374" y="47" width="326" height="176" rx="6" fill="rgba(0,0,0,0.3)"/>
  <!-- Code content -->
  <text x="392" y="72"  font-size="11" fill="#016B7A" font-family="monospace">// Validation Protocol</text>
  <text x="392" y="90"  font-size="10" fill="rgba(255,255,255,0.5)" font-family="monospace">function validate() {</text>
  <text x="404" y="106" font-size="10" fill="#C8922A" font-family="monospace">  iqTest()  // PASS ✓</text>
  <text x="404" y="122" font-size="10" fill="#C8922A" font-family="monospace">  oqTest()  // PASS ✓</text>
  <text x="404" y="138" font-size="10" fill="#C8922A" font-family="monospace">  pqTest()  // PASS ✓</text>
  <text x="392" y="154" font-size="10" fill="rgba(255,255,255,0.5)" font-family="monospace">}</text>
  <text x="392" y="174" font-size="10" fill="rgba(1,107,122,0.8)" font-family="monospace">→ System Validated ✓</text>
  <!-- Monitor stand -->
  <rect x="510" y="215" width="60" height="8" rx="3" fill="rgba(255,255,255,0.1)"/>
  <line x1="537" y1="210" x2="537" y2="215" stroke="rgba(255,255,255,0.15)" stroke-width="6"/>
  <!-- Status bar right side -->
  <rect x="730" y="35" width="130" height="130" rx="8" fill="rgba(255,255,255,0.03)" stroke="rgba(255,255,255,0.1)" stroke-width="1"/>
  <text x="795" y="57"  text-anchor="middle" font-size="9" fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif" font-weight="600">VALIDATION STATUS</text>
  <text x="750" y="75"  font-size="10" fill="#C8922A" font-family="DM Sans,sans-serif">IQ ✓</text>
  <text x="750" y="93"  font-size="10" fill="#C8922A" font-family="DM Sans,sans-serif">OQ ✓</text>
  <text x="750" y="111" font-size="10" fill="#C8922A" font-family="DM Sans,sans-serif">PQ ✓</text>
  <text x="750" y="129" font-size="10" fill="#C8922A" font-family="DM Sans,sans-serif">UAT ✓</text>
  <text x="750" y="147" font-size="10" fill="#C8922A" font-family="DM Sans,sans-serif">Go-Live ✓</text>
  <!-- Bottom label -->
  <text x="560" y="208" text-anchor="middle" font-size="11" fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif" letter-spacing="2">GAMP 5 · 21 CFR Part 11 · EU Annex 11</text>
</svg>';

        case 'cold-chain-solutions-saudi-arabia': return '
<svg viewBox="0 0 900 220" width="100%" height="auto" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">
  <rect width="900" height="220" fill="#0C1E28"/>
  <!-- Flow step boxes -->
  <!-- Box 1: GDP Transport -->
  <rect x="30"  y="75" width="170" height="70" rx="8" fill="rgba(1,107,122,0.15)"  stroke="#016B7A" stroke-width="2"/>
  <text x="115" y="103" text-anchor="middle" font-size="12" fill="#016B7A" font-family="DM Sans,sans-serif" font-weight="700">GDP Transport</text>
  <text x="115" y="119" text-anchor="middle" font-size="9"  fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif">WHO GDP · SFDA</text>
  <text x="115" y="133" text-anchor="middle" font-size="9"  fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif">Compliant Logistics</text>
  <!-- Arrow 1 -->
  <line x1="200" y1="110" x2="248" y2="110" stroke="rgba(255,255,255,0.25)" stroke-width="1.5" stroke-dasharray="5,3"/>
  <polygon points="246,105 258,110 246,115" fill="rgba(255,255,255,0.25)"/>
  <!-- Box 2: Audit Ready -->
  <rect x="258" y="75" width="170" height="70" rx="8" fill="rgba(200,146,42,0.12)"  stroke="#C8922A" stroke-width="2"/>
  <text x="343" y="103" text-anchor="middle" font-size="12" fill="#C8922A" font-family="DM Sans,sans-serif" font-weight="700">Audit Ready</text>
  <text x="343" y="119" text-anchor="middle" font-size="9"  fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif">Documentation</text>
  <text x="343" y="133" text-anchor="middle" font-size="9"  fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif">Full Traceability</text>
  <!-- Arrow 2 -->
  <line x1="428" y1="110" x2="476" y2="110" stroke="rgba(255,255,255,0.25)" stroke-width="1.5" stroke-dasharray="5,3"/>
  <polygon points="474,105 486,110 474,115" fill="rgba(255,255,255,0.25)"/>
  <!-- Box 3: Gap Assessment -->
  <rect x="486" y="75" width="170" height="70" rx="8" fill="rgba(24,95,165,0.15)"  stroke="#185FA5" stroke-width="2"/>
  <text x="571" y="103" text-anchor="middle" font-size="12" fill="#5B9BD5" font-family="DM Sans,sans-serif" font-weight="700">Gap Assessment</text>
  <text x="571" y="119" text-anchor="middle" font-size="9"  fill="rgba(255,255,255,0.4)" font-family="DM Sans,sans-serif">Risk Analysis</text>
  <text x="571" y="133" text-anchor="middle" font-size="9"  fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif">Remediation Plan</text>
  <!-- Arrow 3 -->
  <line x1="656" y1="110" x2="704" y2="110" stroke="rgba(255,255,255,0.25)" stroke-width="1.5" stroke-dasharray="5,3"/>
  <polygon points="702,105 714,110 702,115" fill="rgba(255,255,255,0.25)"/>
  <!-- Box 4: SFDA Compliant (final, teal fill) -->
  <rect x="714" y="68" width="170" height="84" rx="8" fill="rgba(1,107,122,0.25)" stroke="#016B7A" stroke-width="2.5"/>
  <text x="799" y="103" text-anchor="middle" font-size="12" fill="white" font-family="DM Sans,sans-serif" font-weight="700">SFDA Compliant</text>
  <text x="799" y="122" text-anchor="middle" font-size="22" fill="#C8922A" font-family="DM Sans,sans-serif">✓</text>
  <text x="799" y="142" text-anchor="middle" font-size="9"  fill="rgba(255,255,255,0.5)" font-family="DM Sans,sans-serif">Inspection Ready</text>
  <!-- Bottom label -->
  <text x="450" y="208" text-anchor="middle" font-size="11" fill="rgba(255,255,255,0.3)" font-family="DM Sans,sans-serif" letter-spacing="2">Cold Chain Solutions Saudi Arabia</text>
</svg>';

        case 'temperature-data-logger-saudi-arabia': return '
<svg width="100%" height="100%" viewBox="0 0 900 220" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">
  <rect width="900" height="220" fill="#0C1E28"/>
  <!-- Data logger device left -->
  <rect x="80" y="60" width="60" height="100" rx="6" fill="none" stroke="#016B7A" stroke-width="1.5" opacity=".8"/>
  <rect x="90" y="75" width="40" height="25" rx="3" fill="rgba(1,107,122,0.2)" stroke="#016B7A" stroke-width="1"/>
  <text x="110" y="92" text-anchor="middle" font-size="9" fill="rgba(255,255,255,.7)" font-family="DM Sans,sans-serif">-20°C</text>
  <circle cx="110" cy="130" r="8" fill="none" stroke="#C8922A" stroke-width="1.5"/>
  <text x="110" y="155" text-anchor="middle" font-size="9" fill="rgba(255,255,255,.5)" font-family="DM Sans,sans-serif">USB</text>
  <!-- Second logger -->
  <rect x="180" y="60" width="60" height="100" rx="6" fill="none" stroke="#016B7A" stroke-width="1.5" opacity=".8"/>
  <rect x="190" y="75" width="40" height="25" rx="3" fill="rgba(1,107,122,0.2)" stroke="#016B7A" stroke-width="1"/>
  <text x="210" y="92" text-anchor="middle" font-size="9" fill="rgba(255,255,255,.7)" font-family="DM Sans,sans-serif">+4°C</text>
  <path d="M210 120 Q220 115 230 120 Q220 125 210 120" fill="none" stroke="#C8922A" stroke-width="1.5"/>
  <text x="210" y="155" text-anchor="middle" font-size="9" fill="rgba(255,255,255,.5)" font-family="DM Sans,sans-serif">Wireless</text>
  <!-- Arrow to certificate -->
  <line x1="260" y1="110" x2="320" y2="110" stroke="#016B7A" stroke-width="2" stroke-dasharray="5,3"/>
  <polygon points="318,106 326,110 318,114" fill="#016B7A"/>
  <!-- ISO Certificate card -->
  <rect x="330" y="55" width="130" height="110" rx="8" fill="rgba(1,107,122,0.15)" stroke="#016B7A" stroke-width="1.5"/>
  <text x="395" y="80" text-anchor="middle" font-size="11" fill="rgba(255,255,255,.9)" font-family="DM Sans,sans-serif" font-weight="bold">ISO 17025</text>
  <text x="395" y="96" text-anchor="middle" font-size="9" fill="rgba(255,255,255,.5)" font-family="DM Sans,sans-serif">Calibration Certificate</text>
  <line x1="350" y1="106" x2="440" y2="106" stroke="rgba(255,255,255,.1)" stroke-width="1"/>
  <text x="395" y="122" text-anchor="middle" font-size="9" fill="rgba(255,255,255,.5)" font-family="DM Sans,sans-serif">Traceable to Saudi</text>
  <text x="395" y="134" text-anchor="middle" font-size="9" fill="rgba(255,255,255,.5)" font-family="DM Sans,sans-serif">national standards</text>
  <text x="395" y="150" text-anchor="middle" font-size="10" fill="#C8922A" font-family="DM Sans,sans-serif">✓ SFDA accepted</text>
  <!-- Specs panel right -->
  <rect x="510" y="45" width="160" height="130" rx="8" fill="rgba(255,255,255,.04)" stroke="rgba(255,255,255,.1)" stroke-width="1"/>
  <text x="590" y="68" text-anchor="middle" font-size="10" fill="rgba(255,255,255,.4)" font-family="DM Sans,sans-serif" letter-spacing="1">SPECIFICATIONS</text>
  <text x="525" y="90" font-size="9" fill="rgba(255,255,255,.4)" font-family="DM Sans,sans-serif">Range</text>
  <text x="655" y="90" text-anchor="end" font-size="9" fill="rgba(255,255,255,.75)" font-family="DM Sans,sans-serif">-40°C to +85°C</text>
  <line x1="525" y1="97" x2="655" y2="97" stroke="rgba(255,255,255,.06)" stroke-width="1"/>
  <text x="525" y="113" font-size="9" fill="rgba(255,255,255,.4)" font-family="DM Sans,sans-serif">Accuracy</text>
  <text x="655" y="113" text-anchor="end" font-size="9" fill="rgba(255,255,255,.75)" font-family="DM Sans,sans-serif">±0.3°C / ±2% RH</text>
  <line x1="525" y1="120" x2="655" y2="120" stroke="rgba(255,255,255,.06)" stroke-width="1"/>
  <text x="525" y="136" font-size="9" fill="rgba(255,255,255,.4)" font-family="DM Sans,sans-serif">Compliance</text>
  <text x="655" y="136" text-anchor="end" font-size="9" fill="rgba(255,255,255,.75)" font-family="DM Sans,sans-serif">21 CFR Part 11</text>
  <line x1="525" y1="143" x2="655" y2="143" stroke="rgba(255,255,255,.06)" stroke-width="1"/>
  <text x="525" y="159" font-size="9" fill="rgba(255,255,255,.4)" font-family="DM Sans,sans-serif">Models</text>
  <text x="655" y="159" text-anchor="end" font-size="9" fill="rgba(255,255,255,.75)" font-family="DM Sans,sans-serif">USB · Wireless · PDF</text>
  <text x="450" y="205" text-anchor="middle" font-size="11" fill="rgba(255,255,255,.25)" font-family="DM Sans,sans-serif">Temperature Data Logger Saudi Arabia · ISO 17025 Calibrated</text>
</svg>';

        default: return '';
    }
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
