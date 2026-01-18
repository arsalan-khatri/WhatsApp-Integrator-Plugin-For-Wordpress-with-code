<?php
if (!defined('ABSPATH')) exit;


// --- Admin Menu ---
add_action('admin_menu', function () {
    add_menu_page(
        'ak_deep_knowledge WhatsApp Settings', // Page Title
        'WhatsApp Integrator',                 // Menu Title
        'manage_options',                      // Capability
        'ak_whatsapp-config',                  // <-- Updated slug
        'ak_deep_knowledge_whatsapp_settings_page', // Callback function
        'dashicons-whatsapp',                  // Icon
        25                                     // Position
    );
});

// --- Register Settings ---
add_action('admin_init', function () {
    $fields = [
        'ak_deep_knowledge_whatsapp_enable',
        'ak_deep_knowledge_whatsapp_number',
        'ak_deep_knowledge_whatsapp_icon',
        'ak_deep_knowledge_whatsapp_hover_text',
        'ak_deep_knowledge_whatsapp_bg_color',
        'ak_deep_knowledge_whatsapp_text_color',
        'ak_deep_knowledge_whatsapp_size',
        'ak_deep_knowledge_whatsapp_right',
        'ak_deep_knowledge_whatsapp_bottom',
        'ak_deep_knowledge_whatsapp_message', // ✅ new field added
        'ak_deep_knowledge_auto_btn_text',
        'ak_deep_knowledge_shortcode_text',
        'ak_deep_knowledge_shortcode_bg_color',
        'ak_deep_knowledge_shortcode_text_color',
        'ak_deep_knowledge_shortcode_icon',
        'ak_deep_knowledge_shortcode_icon_size',
        'ak_deep_knowledge_shortcode_hover_color',

    ];
    foreach ($fields as $f) register_setting('ak_deep_knowledge_whatsapp_settings', $f);
});

// --- Settings Page HTML ---
function ak_deep_knowledge_whatsapp_settings_page()
{ ?>
    <div class="wrap">
        <h1>WhatsApp Integrator Settings</h1>
        <p>Welcome to the <strong>WhatsApp Integrator</strong> plugin! This plugin allows you to connect your website with WhatsApp for instant communication with your visitors or customers.</p>
        <p>Easily get WooCommerce orders via WhatsApp! Add a button using <code>[ak_whatsapp_button]</code> on product pages or posts. Customers can send the product link, title, and price directly to your WhatsApp. Fully customizable from the admin panel.</p>
        <h2>Setup Instructions</h2>
        <ol>
            <li>Enter your <strong>WhatsApp Number</strong> below. Make sure to include the country code (e.g., 92xxxxxxxxxx).</li>
            <li>Save the settings by clicking the <strong>Save Changes</strong> button.</li>
            <li>Once set, your WhatsApp chat button or integration will start working on the frontend.</li>
        </ol>

        <h2>Important Notes</h2>
        <ul>
            <li>The plugin will not function if a WhatsApp number is not set.</li>
            <li>This plugin works with standard WordPress pages, posts, and WooCommerce products.</li>
            <li>Make sure your number is active and can receive messages.</li>
        </ul>



        <form method="post" action="options.php">
            <?php settings_fields('ak_deep_knowledge_whatsapp_settings'); ?>

            <h2>💬 Floating Button</h2>
            <table class="form-table">
                <tr>
                    <th>Enable Floating</th>
                    <td><input type="checkbox" name="ak_deep_knowledge_whatsapp_enable" value="1" <?php checked(1, get_option('ak_deep_knowledge_whatsapp_enable', 1)); ?>></td>
                </tr>
                <tr>
                    <th>WhatsApp Number</th>
                    <td><input type="text" name="ak_deep_knowledge_whatsapp_number" value="<?php echo esc_attr(get_option('ak_deep_knowledge_whatsapp_number')); ?>" placeholder="923456789012">
                        <p>Type your number and click save changes button for show floting whatsapp icon and shortcode whatsapp button</p>
                        <p>Type your number here like <strong>(923456789012)</strong> with country code <strong>without plus (+) sign</strong></p>
                    </td>
                </tr>
                <tr>
                    <th>Hover Text (typing)</th>
                    <td><input type="text" name="ak_deep_knowledge_whatsapp_hover_text" value="<?php echo esc_attr(get_option('ak_deep_knowledge_whatsapp_hover_text', 'Chat on WhatsApp')); ?>"></td>
                </tr>
                <tr>
                    <th>Default Message</th>
                    <td>
                        <textarea name="ak_deep_knowledge_whatsapp_message" rows="3" cols="50" class="regular-text"><?php
                                                                                                                    echo esc_textarea(get_option('ak_deep_knowledge_whatsapp_message', 'Hi! I’d like to know more about your products on ak_deep_knowledge Nosta.'));
                                                                                                                    ?></textarea>
                        <p class="description">This message will be sent when users click the floating WhatsApp icon.</p>
                    </td>
                </tr>
                <tr>
                    <th>Background Color</th>
                    <td><input type="color" name="ak_deep_knowledge_whatsapp_bg_color" value="<?php echo esc_attr(get_option('ak_deep_knowledge_whatsapp_bg_color', '#25D366')); ?>"></td>
                </tr>
                <tr>
                    <th>Text Color</th>
                    <td><input type="color" name="ak_deep_knowledge_whatsapp_text_color" value="<?php echo esc_attr(get_option('ak_deep_knowledge_whatsapp_text_color', '#ffffff')); ?>"></td>
                </tr>
                <tr>
                    <th>Button Size (px)</th>
                    <td><input type="number" name="ak_deep_knowledge_whatsapp_size" value="<?php echo esc_attr(get_option('ak_deep_knowledge_whatsapp_size', 60)); ?>" min="40" max="120"></td>
                </tr>
                <tr>
                    <th>Floating Icon URL (optional) </th>
                    <td>
                        <input type="text" placeholder="Recommended: 40x40 PNG or SVG (transparent) icon URL." id="ak_deep_knowledge_whatsapp_icon" name="ak_deep_knowledge_whatsapp_icon" value="https://cdn-icons-png.flaticon.com/512/733/733585.png" style="width:60%;">
                        <!--<input type="button" class="button" id="ak_deep_knowledge_upload_icon_btn" value="Upload Icon">-->
                        <p class="description"> Upload icon(svg/png) your wordpress media and copy URL and past input field given above.</p>
                    </td>
                </tr>
                <tr>
                    <th>Position (right px)</th>
                    <td><input type="number" name="ak_deep_knowledge_whatsapp_right" value="<?php echo esc_attr(get_option('ak_deep_knowledge_whatsapp_right', 25)); ?>"></td>
                </tr>
                <tr>
                    <th>Position (bottom px)</th>
                    <td><input type="number" name="ak_deep_knowledge_whatsapp_bottom" value="<?php echo esc_attr(get_option('ak_deep_knowledge_whatsapp_bottom', 25)); ?>"></td>
                </tr>
            </table>

            <hr>
            <h2>🧩 WooCommerce Auto Button</h2>
            <table class="form-table">
                <tr>
                    <th>Auto Button Text</th>
                    <td><input type="text" name="ak_deep_knowledge_auto_btn_text" value="<?php echo esc_attr(get_option('ak_deep_knowledge_auto_btn_text', 'Chat on WhatsApp')); ?>"></td>
                </tr>
            </table>

            <hr>
            <h2>🔗 Shortcode Button</h2>
            <table class="form-table">
                <tr>
                    <th>Button Text</th>
                    <td><input type="text" name="ak_deep_knowledge_shortcode_text" value="<?php echo esc_attr(get_option('ak_deep_knowledge_shortcode_text', 'Message on WhatsApp')); ?>"></td>
                </tr>
                <tr>
                    <th>Icon Size (px)</th>
                    <td>
                        <input type="number" name="ak_deep_knowledge_shortcode_icon_size"
                            value="<?php echo esc_attr(get_option('ak_deep_knowledge_shortcode_icon_size', 24)); ?>"
                            min="12" max="100">
                        <p class="description">Control the icon size inside shortcode button.</p>
                    </td>
                </tr>

                <tr>
                    <th>Background Color</th>
                    <td><input type="color" name="ak_deep_knowledge_shortcode_bg_color" value="<?php echo esc_attr(get_option('ak_deep_knowledge_shortcode_bg_color', '#25D366')); ?>"></td>
                </tr>
                <tr>
                    <th>Hover Background Color</th>
                    <td><input type="color" name="ak_deep_knowledge_shortcode_hover_color" value="<?php echo esc_attr(get_option('ak_deep_knowledge_shortcode_hover_color', '#128C7E')); ?>"></td>
                </tr>

                <tr>
                    <th>Text Color</th>
                    <td><input type="color" name="ak_deep_knowledge_shortcode_text_color" value="<?php echo esc_attr(get_option('ak_deep_knowledge_shortcode_text_color', '#ffffff')); ?>"></td>
                </tr>
                <tr>
                    <th>Icon (optional) URL</th>
                    <td>
                        <input type="text" placeholder="Recommended: 40x40 PNG or SVG (transparent) icon URL." id="ak_deep_knowledge_shortcode_icon" name="ak_deep_knowledge_shortcode_icon" value="<?php echo esc_attr(get_option('ak_deep_knowledge_shortcode_icon')); ?>" style="width:60%;">
                        <!--<input type="button" class="button" id="ak_deep_knowledge_upload_shortcode_icon" value="Upload Icon">-->
                        <p class="description"> Upload icon(svg/png) your wordpress media and copy URL and past input field given above.</p>
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>
            <hr style="margin:30px 0;">


            <?php wp_nonce_field('ak_deep_knowledge_reset_defaults_action', 'ak_deep_knowledge_reset_defaults_nonce'); ?>
            <p>
                <input type="submit" name="ak_deep_knowledge_reset_defaults" class="button button-secondary"
                    value="Reset All to Default"
                    onclick="return confirm('Are you sure you want to reset all settings to default?');">
            </p>


        </form>

        <form method="post">
            <!--<?php wp_nonce_field('ak_deep_knowledge_reset_defaults_action', 'ak_deep_knowledge_reset_defaults_nonce'); ?>-->
            <!--<p>-->
            <!--    <input type="submit" name="ak_deep_knowledge_reset_defaults" class="button button-secondary" -->
            <!--           value="Reset All to Default"-->
            <!--           onclick="return confirm('Are you sure you want to reset all settings to default?');">-->
            <!--</p>-->
        </form>


    </div>

    <script>
        jQuery(document).ready(function($) {
            function openMedia(target) {
                var frame = wp.media({
                    title: 'Select or Upload Icon',
                    library: {
                        type: ['image', 'svg+xml']
                    },
                    button: {
                        text: 'Use this'
                    },
                    multiple: false
                });
                frame.on('select', function() {
                    var att = frame.state().get('selection').first().toJSON();
                    $(target).val(att.url);
                });
                frame.open();
            }

            $('#ak_deep_knowledge_upload_icon_btn').on('click', function(e) {
                e.preventDefault();
                openMedia('#ak_deep_knowledge_whatsapp_icon');
            });
            $('#ak_deep_knowledge_upload_shortcode_icon').on('click', function(e) {
                e.preventDefault();
                openMedia('#ak_deep_knowledge_shortcode_icon');
            });
        });
    </script>
<?php }
?>