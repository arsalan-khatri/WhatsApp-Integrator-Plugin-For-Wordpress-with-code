<?php
/*
Plugin Name: AK WhatsApp Integrater
Plugin URI: https://akdeepknowledge.com/
Description: WhatsApp Integrator is a WooCommerce-focused plugin that adds a WhatsApp button to product pages using the shortcode <code>[ak_whatsapp_button]</code>. When clicked, customers can send the product link, title, and price directly to your WhatsApp. While optimized for WooCommerce, it can also be used on regular posts and pages. Fully customizable from the admin panel.
Version: 2.1
Author: Arsalan Khatri
Author URI: https://akdeepknowledge.com/
License: GPL2
Text Domain: whatsapp-integrater
*/

if (!defined('ABSPATH')) exit;


// Add "Settings" link in plugins list
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wai_settings_link');
function wai_settings_link($links)
{
    $settings_link = '<a href="' . admin_url('admin.php?page=ak_whatsapp-config') . '">Settings</a>';
    array_unshift($links, $settings_link); // Settings link
    return $links;
}
// paths
define('ak_deep_knowledge_WA_DIR', plugin_dir_path(__FILE__));
define('ak_deep_knowledge_WA_URL', plugin_dir_url(__FILE__));

// --- Reset Defaults Handler ---
add_action('admin_init', function () {
    if (isset($_POST['ak_deep_knowledge_reset_defaults']) && check_admin_referer('ak_deep_knowledge_reset_defaults_action', 'ak_deep_knowledge_reset_defaults_nonce')) {

        if (!defined('ak_deep_knowledge_WA_URL')) {
            define('ak_deep_knowledge_WA_URL', plugin_dir_url(__DIR__));
        }

        $defaults = [
            'ak_deep_knowledge_whatsapp_enable'        => 1,
            'ak_deep_knowledge_whatsapp_number'        => '',
            'ak_deep_knowledge_whatsapp_icon'          => '',
            'ak_deep_knowledge_whatsapp_hover_text'    => 'Chat on WhatsApp',
            'ak_deep_knowledge_whatsapp_bg_color'      => '#25D366',
            'ak_deep_knowledge_whatsapp_text_color'    => '#ffffff',
            'ak_deep_knowledge_whatsapp_size'          => 60,
            'ak_deep_knowledge_whatsapp_right'         => 25,
            'ak_deep_knowledge_whatsapp_bottom'        => 25,
            'ak_deep_knowledge_whatsapp_message'       => 'Hi! I’d like to know more about your products.',
            'ak_deep_knowledge_auto_btn_text'          => 'Chat on WhatsApp',
            'ak_deep_knowledge_shortcode_text'         => 'Message on WhatsApp',
            'ak_deep_knowledge_shortcode_bg_color'     => '#25D366',
            'ak_deep_knowledge_shortcode_hover_color'  => '#128C7E',
            'ak_deep_knowledge_shortcode_text_color'   => '#ffffff',
            'ak_deep_knowledge_shortcode_icon'         => '',
            'ak_deep_knowledge_shortcode_icon_size'    => 24,
        ];

        foreach ($defaults as $key => $value) {
            update_option($key, $value);
        }

        add_action('admin_notices', function () {
            echo '<div class="notice notice-success is-dismissible"><p><strong>✅ All ak_deep_knowledge WhatsApp settings have been reset to default values.</strong></p></div>';
        });

        // Redirect to refresh fields
        wp_redirect(admin_url('admin.php?page=ak_whatsapp-config&reset=1'));
        exit;
    }
});

register_activation_hook(__FILE__, function () {
    // agar option pehle se exist nahi karti, tabhi default set karo
    if (!get_option('ak_deep_knowledge_whatsapp_icon')) {
        update_option('ak_deep_knowledge_whatsapp_icon', ak_deep_knowledge_WA_URL . 'assets/whatsapp-icon.png');
    }
});

// include admin
if (is_admin()) {
    include_once ak_deep_knowledge_WA_DIR . 'admin/settings-page.php';
}

// enqueue css (only frontend)
add_action('wp_enqueue_scripts', function () {
    // ensure ak_deep_knowledge_WA_URL is defined and ends with a slash
    if ( defined( 'ak_deep_knowledge_WA_URL' ) ) {
        wp_enqueue_style('ak_deep_knowledge-whatsapp-style', ak_deep_knowledge_WA_URL . 'assets/style.css',array(), '2.1');
    }
});

// ------------------ FLOATING ICON (with typing JS + custom admin message) ------------------
add_action('wp_footer', function () {
    $enabled = get_option('ak_deep_knowledge_whatsapp_enable', 1);
    if (!$enabled) return;

    $number = get_option('ak_deep_knowledge_whatsapp_number');
    if (!$number) return;

    // --- Admin customizations ---
    // $icon = get_option('ak_deep_knowledge_whatsapp_icon');
    if (get_option('ak_deep_knowledge_whatsapp_icon') == '') {
        $icon = 'https://cdn-icons-png.flaticon.com/512/733/733585.png';
    } else {
        $icon = get_option('ak_deep_knowledge_whatsapp_icon');
    }

    // $icon = esc_url($icon);
    $hover_text = get_option('ak_deep_knowledge_whatsapp_hover_text', 'Chat on WhatsApp');
    $bg = esc_attr(get_option('ak_deep_knowledge_whatsapp_bg_color', '#25D366'));
    $text_color = esc_attr(get_option('ak_deep_knowledge_whatsapp_text_color', '#ffffff'));
    $size = intval(get_option('ak_deep_knowledge_whatsapp_size', 60));
    $position_right = intval(get_option('ak_deep_knowledge_whatsapp_right', 25));
    $position_bottom = intval(get_option('ak_deep_knowledge_whatsapp_bottom', 25));

    // --- Admin Custom Message (Simple) ---
    $message = get_option('ak_deep_knowledge_whatsapp_message', "Hi! I’d like to know more about your products");

    // URL encode the message
    $encoded_message = urlencode($message);

    // Final WhatsApp URL
    $wa_url = "https://wa.me/{$number}?text={$encoded_message}";

    // $wa_url = "https://wa.me/{$number}?text={$message}";
    $safe_hover = esc_attr($hover_text);

    // --- Output Floating Button ---
    echo '<div class="ak_deep_knowledge-float-wrapper" style="right:' . $position_right . 'px;bottom:' . $position_bottom . 'px;">';
    echo '<a href="' . esc_url($wa_url) . '" target="_blank" rel="noopener noreferrer" class="ak_deep_knowledge-floating-btn"';
    echo ' style="background:' . $bg . ';width:' . $size . 'px;height:' . $size . 'px;color:' . $text_color . ';"';
    echo ' data-ak_deep_knowledge-hover="' . $safe_hover . '">';
    echo '<img src="' . $icon . '" alt="WhatsApp" class="ak_deep_knowledge-icon" />';
    echo '<span class="ak_deep_knowledge-hover-text" aria-hidden="true"></span>';
    echo '</a></div>';

    // --- Typing Hover Animation ---
?>
    <script>
        (function() {
            var wrappers = document.querySelectorAll('.ak_deep_knowledge-floating-btn');
            if (!wrappers.length) return;
            wrappers.forEach(function(btn) {
                var text = btn.getAttribute('data-ak_deep_knowledge-hover') || '';
                var span = btn.querySelector('.ak_deep_knowledge-hover-text');
                var typingInterval = null;
                var idx = 0;

                function typeStart() {
                    if (!span) return;
                    span.textContent = '';
                    idx = 0;
                    clearInterval(typingInterval);
                    typingInterval = setInterval(function() {
                        if (idx <= text.length) {
                            span.textContent = text.slice(0, idx);
                            idx++;
                        } else {
                            clearInterval(typingInterval);
                        }
                    }, 25);
                    span.classList.add('ak_deep_knowledge-show');
                }

                function typeClear() {
                    if (!span) return;
                    clearInterval(typingInterval);
                    span.classList.remove('ak_deep_knowledge-show');
                    setTimeout(function() {
                        span.textContent = '';
                    }, 200);
                }

                btn.addEventListener('mouseenter', typeStart);
                btn.addEventListener('focus', typeStart);
                btn.addEventListener('mouseleave', typeClear);
                btn.addEventListener('blur', typeClear);
            });
        })();
    </script>
<?php
});

// ------------------ WOOCOMMERCE AUTO BUTTON ------------------
add_action('woocommerce_single_product_summary', function () {
    if (!class_exists('WooCommerce')) return;
    global $product;
    if (!$product) return;
    $number = get_option('ak_deep_knowledge_whatsapp_number');
    if (!$number) return;

    $title = sanitize_text_field($product->get_name());
    $price = $product->get_price();
    $currency = html_entity_decode(get_woocommerce_currency_symbol(), ENT_QUOTES, 'UTF-8');
    $link = get_permalink($product->get_id());

    // build safe message (CRLF encoded)
    $message = "Hi! I want to buy this product:\r\n\r\n";
    $message .= "*" . $title . "*\r\n";
    $message .= "Price: " . $currency . " " . number_format($price, 0) . "\r\n";
    $message .= "Link: " . $link . "\r\n\r\n";
    $message .= "Please tell me more about it.";

    $encoded = rawurlencode($message);
    $wa_url = "https://wa.me/" . esc_attr($number) . "?text=" . $encoded;

    echo '<a href="' . esc_url($wa_url) . '" target="_blank" rel="noopener noreferrer" class="ak_deep_knowledge-whatsapp-btn">';
    echo esc_html(get_option('ak_deep_knowledge_auto_btn_text', 'Chat on WhatsApp'));
    echo '</a>';
}, 35);

// ------------------ SHORTCODE BUTTON ------------------
add_shortcode('ak_whatsapp_button', function ($atts) {
    global $product;

    $number = get_option('ak_deep_knowledge_whatsapp_number');
    if (!$number) return '';

    // shortcode-level overrides
    $atts = shortcode_atts(array(
        'text'  => '',
        'bg'    => '',
        'color' => '',
        'hover' => '',
        'icon'  => ''
    ), $atts, 'ak_deep_knowledge_whatsapp_button');

    $text       = $atts['text']  ? sanitize_text_field($atts['text'])  : sanitize_text_field(get_option('ak_deep_knowledge_shortcode_text', 'Message on WhatsApp'));
    $bg         = $atts['bg']    ? esc_attr($atts['bg'])               : esc_attr(get_option('ak_deep_knowledge_shortcode_bg_color', '#25D366'));
    $hover_bg   = $atts['hover'] ? esc_attr($atts['hover'])            : esc_attr(get_option('ak_deep_knowledge_shortcode_hover_color', '#128C7E'));
    $color      = $atts['color'] ? esc_attr($atts['color'])            : esc_attr(get_option('ak_deep_knowledge_shortcode_text_color', '#ffffff'));
    $icon       = $atts['icon']  ? esc_url($atts['icon'])              : esc_url(get_option('ak_deep_knowledge_shortcode_icon', ''));

    // --- WhatsApp message with product details (if WooCommerce product exists) ---
    if ($product && method_exists($product, 'get_name')) {
        $title = sanitize_text_field($product->get_name());
        $price = $product->get_price();
        $currency = html_entity_decode(get_woocommerce_currency_symbol(), ENT_QUOTES, 'UTF-8');
        $link = get_permalink($product->get_id());

        $message  = "Hi! I want to buy this product:\r\n\r\n";
        $message .= "*" . $title . "*\r\n";
        $message .= " " . "Price: " . $currency . " " . number_format($price, 0) . "\r\n";
        $message .= "Link: " . $link . "\r\n\r\n" . " ";
        $message .= "Please tell me more about it.";
    } else {
        $message = "Hi! I want to know more about your products.";
    }

    $encoded_message = rawurlencode($message);
    $wa_url = "https://wa.me/" . esc_attr($number) . "?text=" . $encoded_message;

    // icon size from admin
    $icon_size = intval(get_option('ak_deep_knowledge_shortcode_icon_size', 24));

    // icon HTML
    $icon_html = '';
    if ($icon) {
        $icon_html = '<img src="' . esc_url($icon) . '" alt="" style="width:' . esc_attr($icon_size) . 'px;height:auto;margin-right:8px;display:inline-block;vertical-align:middle;">';
    }

    // unique id for inline hover CSS
    $btn_id = 'ak_deep_knowledge-btn-' . uniqid();

    // inline hover style
    $custom_style = '<style>
        #' . $btn_id . ':hover {
            background:' . $hover_bg . ' !important;
            color:' . $color . ' !important;
        }
    </style>';

    // final button HTML
    $style = 'background:' . $bg . ';color:' . $color . ';padding:10px 18px;border-radius:6px;display:inline-flex;align-items:center;text-decoration:none;transition:0.3s;';
    $button = '<a id="' . $btn_id . '" href="' . esc_url($wa_url) . '" target="_blank" rel="noopener noreferrer" class="ak_deep_knowledge-whatsapp-btn" style="' . esc_attr($style) . '">' . $icon_html . esc_html($text) . '</a>';

    return $custom_style . $button;
});
