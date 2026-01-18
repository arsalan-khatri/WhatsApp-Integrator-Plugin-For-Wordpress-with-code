# AK WhatsApp Integrator

AK WhatsApp Integrator is a lightweight, customizable WordPress plugin designed to bridge the gap between site visitors and business owners. While optimized for WooCommerce to facilitate direct product inquiries, it functions seamlessly across standard WordPress posts and pages.

This solution provides a floating contact button and embeddable shortcodes, allowing users to send pre-filled messages containing product details (Title, Price, URL) directly to a specified WhatsApp number.

## Features

* **WooCommerce Integration:** Automatically hooks into product pages to generate dynamic messages containing the product name, price, and permalink.
* **Floating Widget:** A sticky floating button with a "typing" animation effect on hover to increase user engagement.
* **Custom Shortcodes:** Flexible shortcode system `[ak_whatsapp_button]` to place WhatsApp buttons anywhere on the site with custom styles.
* **Admin Dashboard:** Comprehensive settings page to control colors, positioning, default messages, and visibility.
* **Responsive Design:** Fully responsive CSS ensures the button renders correctly on mobile and desktop devices.
* **Performance:** Minimal resource footprint using vanilla JavaScript and optimized CSS.

## Installation

1.  Download the plugin folder or ZIP file.
2.  Upload the `whatsapp` folder to the `/wp-content/plugins/` directory.
3.  Activate the plugin through the **Plugins** menu in WordPress.
4.  Navigate to **WhatsApp Integrator** in the admin sidebar to configure your settings.

## Configuration

To configure the plugin, navigate to the **WhatsApp Integrator** menu in your WordPress dashboard.

### General Settings
* **WhatsApp Number:** Enter the target phone number with the country code (e.g., 923001234567).
* **Enable Floating:** Toggle the visibility of the sticky floating button.
* **Positioning:** Adjust the `Right` and `Bottom` offset values (in pixels) to prevent overlap with other elements.

### Visual Customization
* **Colors:** Customize the background, text, and hover colors to match your brand identity.
* **Icons:** Provide a custom URL for the button icon (supports PNG/SVG).
* **Typing Effect:** Set the hover text that appears with a typing animation (e.g., "Chat on WhatsApp").

## Shortcode Usage

You can place a custom WhatsApp button anywhere using the `[ak_whatsapp_button]` shortcode. This shortcode accepts several attributes for inline customization.

**Basic Usage:**
[ak_whatsapp_button] shortcode

**Advanced Usage with Attributes:**

### Supported Attributes

| Attribute | Description | Default |
| :--- | :--- | :--- |
| `text` | The label text inside the button. | Message on WhatsApp |
| `bg` | Background color (Hex code). | #25D366 |
| `hover` | Hover background color (Hex code). | #128C7E |
| `color` | Text font color (Hex code). | #ffffff |
| `icon` | URL to a custom icon image. | (Empty) |

## Technical Details

* **Hooks Used:**
    * `woocommerce_single_product_summary`: For injecting buttons into product pages.
    * `wp_footer`: For rendering the floating widget and scripts.
    * `admin_menu` & `register_setting`: For the native WordPress options API implementation.
* **Security:** Implements `check_admin_referer` and `wp_nonce_field` for secure settings updates and sanitation functions for all user inputs.
* **JavaScript:** Uses an isolated IIFE (Immediately Invoked Function Expression) to prevent global namespace pollution.

## Author

**Arsalan Khatri**
* AI Engineer & Full Stack Developer
* Website: [akdeepknowledge.com](https://akdeepknowledge.com/)
