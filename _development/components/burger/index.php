<?php
// ---------------------------------------
// Default args
// ---------------------------------------
$defaults = [
    'class' => '',
    'aria-label' => '',
    'aria-controls' => '',
    'aria-expanded' => ''
];

// ---------------------------------------
// Merge default arguments
// ---------------------------------------
$args = wp_parse_args(
    $args,
    $defaults
);

// ---------------------------------------
// Add required arguments
// ---------------------------------------
$args['class'] = 'burger ' . $args['class'];

// ---------------------------------------
// Generate attributes for the button tag
// ---------------------------------------
$button_args = [
    'class' => esc_attr(trim($args['class'])),
    'type' => 'button'
];


if ($args['aria-controls']!=="") {
    $button_args['aria-controls'] = esc_attr($args['aria-controls']);
}

if ($args['aria-expanded']!=="") {
    $button_args['aria-expanded'] = esc_attr($args['aria-expanded']);
}

$button_string = '';
$button_attributes = [];
foreach ($button_args as $key => $value) {
    $button_attributes[] = $key.'="'.$value.'"';
}

// ---------------------------------------
// Markup
// ---------------------------------------
?>
<button <?php echo implode(' ', $button_attributes); ?>>
    <?php if ($args['aria-label']!=="") { ?>
        <span class="screen-reader-text"><?php echo esc_html($args['aria-label']); ?></span>
    <?php } ?>
    <span class="burger__line burger__line--1"></span>
    <span class="burger__line burger__line--2"></span>
    <span class="burger__line burger__line--3"></span>
</button>
