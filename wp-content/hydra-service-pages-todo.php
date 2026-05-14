<?php
/**
 * HYDRA — Remaining 8 Service Page Stubs
 *
 * For each service:
 *  1. Fill in the $cfg array (h1, subheading, body HTML, related, seo_title, meta_desc)
 *  2. Run:  wp eval-file wp-content/hydra-service-pages-todo.php --allow-root
 *
 * The hydra_build_service_page() helper is loaded from mu-plugins automatically.
 */

// ── Service definitions ───────────────────────────────────────────────────────
// Page IDs (from Part 1 setup):
//   7  Validation & Qualification   /services/validation-qualification-services/
//   8  GDP Compliance               /services/gdp-compliance-saudi-arabia/
//   9  Pharma Consulting            /services/pharmaceutical-consulting-saudi-arabia/
//  10  Cold Storage Compliance      /services/cold-storage-compliance/
//  11  Pharma QMS                   /services/pharmaceutical-quality-management-system/
//  12  Thermal Packaging            /services/thermal-packaging-validation/
//  13  Computer System Validation   /services/computer-system-validation-saudi-arabia/
//  14  Cold Chain Solutions         /services/cold-chain-solutions-saudi-arabia/

$services = [

    7 => [
        'slug'      => 'validation-qualification-services',
        'h1'        => 'Validation & Qualification Services Saudi Arabia',
        'subheading'=> 'IQ, OQ, and PQ validation for pharmaceutical equipment, utilities, and facilities. GAMP 5-aligned protocols and SFDA-ready reports.',
        'seo_title' => 'Validation & Qualification Services Saudi Arabia | HYDRA Quality & Compliance',
        'meta_desc' => 'GAMP 5-aligned IQ/OQ/PQ validation for pharmaceutical equipment, utilities, and facilities across Saudi Arabia. SFDA-ready reports.',
        'focus_kw'  => 'validation qualification services Saudi Arabia',
        'related'   => [
            ['icon'=>'🌡️','name'=>'Temperature Mapping',  'desc'=>'Validated chamber, warehouse, vehicle mapping per SFDA/WHO GDP',  'url'=>'/services/temperature-mapping-saudi-arabia/'],
            ['icon'=>'💻','name'=>'Computer System Validation','desc'=>'GAMP 5, 21 CFR Part 11, EU Annex 11','url'=>'/services/computer-system-validation-saudi-arabia/'],
            ['icon'=>'📋','name'=>'GDP Compliance',        'desc'=>'Full WHO/EU GDP consulting for distributors and 3PL',             'url'=>'/services/gdp-compliance-saudi-arabia/'],
        ],
        'body'      => '<p><!-- TODO: add body content --></p>',
    ],

    8 => [
        'slug'      => 'gdp-compliance-saudi-arabia',
        'h1'        => 'GDP Compliance Saudi Arabia',
        'subheading'=> 'Full WHO and EU GDP compliance consulting for pharmaceutical distributors, 3PL operators, and importers across KSA.',
        'seo_title' => 'GDP Compliance Saudi Arabia | HYDRA Quality & Compliance',
        'meta_desc' => 'WHO and EU GDP compliance consulting for pharmaceutical distributors and 3PL across Saudi Arabia. SFDA-aligned gap analysis, SOPs, and audit support.',
        'focus_kw'  => 'GDP compliance Saudi Arabia',
        'related'   => [
            ['icon'=>'🌡️','name'=>'Temperature Mapping',   'desc'=>'Validated chamber, warehouse, vehicle mapping',                   'url'=>'/services/temperature-mapping-saudi-arabia/'],
            ['icon'=>'🏭','name'=>'Cold Storage Compliance','desc'=>'Qualification and compliance for pharma cold stores',             'url'=>'/services/cold-storage-compliance/'],
            ['icon'=>'❄️','name'=>'Cold Chain Solutions',   'desc'=>'End-to-end GDP transport and cold chain compliance',              'url'=>'/services/cold-chain-solutions-saudi-arabia/'],
        ],
        'body'      => '<p><!-- TODO: add body content --></p>',
    ],

    9 => [
        'slug'      => 'pharmaceutical-consulting-saudi-arabia',
        'h1'        => 'Pharmaceutical Consulting Saudi Arabia',
        'subheading'=> 'Regulatory strategy, SFDA dossier support, and quality system consulting for pharma manufacturers and importers in KSA.',
        'seo_title' => 'Pharmaceutical Consulting Saudi Arabia | HYDRA Quality & Compliance',
        'meta_desc' => 'SFDA regulatory consulting, dossier preparation, and pharmaceutical quality strategy for manufacturers and importers in Saudi Arabia.',
        'focus_kw'  => 'pharmaceutical consulting Saudi Arabia',
        'related'   => [
            ['icon'=>'📋','name'=>'GDP Compliance',          'desc'=>'WHO/EU GDP consulting for distributors and 3PL',                'url'=>'/services/gdp-compliance-saudi-arabia/'],
            ['icon'=>'📊','name'=>'Pharma QMS',              'desc'=>'QMS design, SOP writing, CAPA, internal audits',                'url'=>'/services/pharmaceutical-quality-management-system/'],
            ['icon'=>'✅','name'=>'Validation & Qualification','desc'=>'IQ/OQ/PQ for equipment, utilities, facilities',               'url'=>'/services/validation-qualification-services/'],
        ],
        'body'      => '<p><!-- TODO: add body content --></p>',
    ],

    10 => [
        'slug'      => 'cold-storage-compliance',
        'h1'        => 'Cold Storage Compliance Saudi Arabia',
        'subheading'=> 'Qualification, compliance, and ongoing monitoring programmes for pharmaceutical cold stores and refrigerated warehouses in KSA.',
        'seo_title' => 'Cold Storage Compliance Saudi Arabia | HYDRA Quality & Compliance',
        'meta_desc' => 'Pharmaceutical cold store qualification and GDP compliance for 2–8°C and frozen storage facilities across Saudi Arabia.',
        'focus_kw'  => 'cold storage compliance Saudi Arabia',
        'related'   => [
            ['icon'=>'🌡️','name'=>'Temperature Mapping',  'desc'=>'Validated chamber, warehouse, vehicle mapping',                   'url'=>'/services/temperature-mapping-saudi-arabia/'],
            ['icon'=>'❄️','name'=>'Cold Chain Solutions',  'desc'=>'End-to-end GDP transport and cold chain compliance',              'url'=>'/services/cold-chain-solutions-saudi-arabia/'],
            ['icon'=>'📋','name'=>'GDP Compliance',        'desc'=>'Full WHO/EU GDP consulting for distributors and 3PL',             'url'=>'/services/gdp-compliance-saudi-arabia/'],
        ],
        'body'      => '<p><!-- TODO: add body content --></p>',
    ],

    11 => [
        'slug'      => 'pharmaceutical-quality-management-system',
        'h1'        => 'Pharmaceutical Quality Management System Saudi Arabia',
        'subheading'=> 'QMS design, SOP writing, CAPA management, and internal audit programmes for pharma companies operating in Saudi Arabia.',
        'seo_title' => 'Pharmaceutical Quality Management System Saudi Arabia | HYDRA',
        'meta_desc' => 'Pharmaceutical QMS consulting in Saudi Arabia — QMS design, SOP writing, CAPA, deviation management, and internal audits aligned to SFDA and ICH Q10.',
        'focus_kw'  => 'pharmaceutical quality management system Saudi Arabia',
        'related'   => [
            ['icon'=>'🏥','name'=>'Pharma Consulting',    'desc'=>'Regulatory strategy and SFDA dossier support',                    'url'=>'/services/pharmaceutical-consulting-saudi-arabia/'],
            ['icon'=>'💻','name'=>'Computer System Validation','desc'=>'GAMP 5, 21 CFR Part 11, EU Annex 11',                        'url'=>'/services/computer-system-validation-saudi-arabia/'],
            ['icon'=>'✅','name'=>'Validation & Qualification','desc'=>'IQ/OQ/PQ for equipment, utilities, facilities',              'url'=>'/services/validation-qualification-services/'],
        ],
        'body'      => '<p><!-- TODO: add body content --></p>',
    ],

    12 => [
        'slug'      => 'thermal-packaging-validation',
        'h1'        => 'Thermal Packaging Validation Saudi Arabia',
        'subheading'=> 'GDP-qualified thermal packaging validation studies for pharmaceutical shippers, cool boxes, and temperature-controlled containers.',
        'seo_title' => 'Thermal Packaging Validation Saudi Arabia | HYDRA Quality & Compliance',
        'meta_desc' => 'Thermal packaging validation for pharmaceutical shippers and cool boxes in Saudi Arabia. GDP-qualified studies per ISTA, ASTM, and WHO guidelines.',
        'focus_kw'  => 'thermal packaging validation Saudi Arabia',
        'related'   => [
            ['icon'=>'❄️','name'=>'Cold Chain Solutions',   'desc'=>'End-to-end GDP transport and cold chain compliance',             'url'=>'/services/cold-chain-solutions-saudi-arabia/'],
            ['icon'=>'🏭','name'=>'Cold Storage Compliance','desc'=>'Qualification and compliance for pharma cold stores',            'url'=>'/services/cold-storage-compliance/'],
            ['icon'=>'🌡️','name'=>'Temperature Mapping',   'desc'=>'Validated chamber, warehouse, vehicle mapping',                  'url'=>'/services/temperature-mapping-saudi-arabia/'],
        ],
        'body'      => '<p><!-- TODO: add body content --></p>',
    ],

    13 => [
        'slug'      => 'computer-system-validation-saudi-arabia',
        'h1'        => 'Computer System Validation Saudi Arabia',
        'subheading'=> 'GAMP 5-aligned computer system validation (CSV) services for pharmaceutical software, LIMS, ERP, and manufacturing systems in KSA.',
        'seo_title' => 'Computer System Validation Saudi Arabia | HYDRA Quality & Compliance',
        'meta_desc' => 'GAMP 5 computer system validation in Saudi Arabia — CSV for LIMS, ERP, DCS, and manufacturing software per 21 CFR Part 11 and EU Annex 11.',
        'focus_kw'  => 'computer system validation Saudi Arabia',
        'related'   => [
            ['icon'=>'✅','name'=>'Validation & Qualification','desc'=>'IQ/OQ/PQ for equipment, utilities, facilities',               'url'=>'/services/validation-qualification-services/'],
            ['icon'=>'📊','name'=>'Pharma QMS',               'desc'=>'QMS design, SOP writing, CAPA, internal audits',              'url'=>'/services/pharmaceutical-quality-management-system/'],
            ['icon'=>'🏥','name'=>'Pharma Consulting',        'desc'=>'Regulatory strategy and SFDA dossier support',                'url'=>'/services/pharmaceutical-consulting-saudi-arabia/'],
        ],
        'body'      => '<p><!-- TODO: add body content --></p>',
    ],

    14 => [
        'slug'      => 'cold-chain-solutions-saudi-arabia',
        'h1'        => 'Cold Chain Solutions Saudi Arabia',
        'subheading'=> 'End-to-end GDP cold chain compliance for pharmaceutical transport, distribution, and last-mile delivery across Saudi Arabia.',
        'seo_title' => 'Cold Chain Solutions Saudi Arabia | HYDRA Quality & Compliance',
        'meta_desc' => 'GDP cold chain compliance consulting for pharmaceutical transport and distribution across Saudi Arabia — lane qualification, monitoring, and SOP development.',
        'focus_kw'  => 'cold chain solutions Saudi Arabia',
        'related'   => [
            ['icon'=>'🌡️','name'=>'Temperature Mapping',   'desc'=>'Validated chamber, warehouse, vehicle mapping',                  'url'=>'/services/temperature-mapping-saudi-arabia/'],
            ['icon'=>'🏭','name'=>'Cold Storage Compliance','desc'=>'Qualification and compliance for pharma cold stores',            'url'=>'/services/cold-storage-compliance/'],
            ['icon'=>'📦','name'=>'Thermal Packaging',      'desc'=>'GDP-qualified thermal packaging validation',                    'url'=>'/services/thermal-packaging-validation/'],
        ],
        'body'      => '<p><!-- TODO: add body content --></p>',
    ],

];

// ── Build all pages ───────────────────────────────────────────────────────────
foreach ( $services as $page_id => $svc ) {
    $cfg = [
        'h1'         => $svc['h1'],
        'subheading' => $svc['subheading'],
        'phone'      => '+966 — — — — —',
        'body'       => $svc['body'],
        'related'    => $svc['related'],
    ];

    $content = hydra_build_service_page( $cfg );
    $result  = wp_update_post([
        'ID'           => $page_id,
        'post_content' => $content,
        'post_status'  => 'publish',
    ]);
    echo is_wp_error( $result )
        ? "ERROR page $page_id: " . $result->get_error_message() . "\n"
        : "Page $page_id ({$svc['slug']}) updated\n";

    update_post_meta( $page_id, 'rank_math_title',        $svc['seo_title'] );
    update_post_meta( $page_id, 'rank_math_description',  $svc['meta_desc'] );
    update_post_meta( $page_id, 'rank_math_focus_keyword',$svc['focus_kw'] );
    update_post_meta( $page_id, '_kad_post_layout',       'fullwidth' );
    update_post_meta( $page_id, '_kad_post_title',        'hide' );
    update_post_meta( $page_id, '_kad_post_header',       'hide' );
    update_post_meta( $page_id, '_kad_post_footer',       'hide' );
}

echo "\nDone — 8 service page shells created.\n";
echo "Next step: replace <!-- TODO: add body content --> in each \$services entry above with the real body HTML.\n";
