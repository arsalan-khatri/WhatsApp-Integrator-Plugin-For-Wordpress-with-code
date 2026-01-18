# AK WhatsApp Integrator

## Overview

Welcome to the **WhatsApp Integrator** plugin! This plugin allows you to connect your website with WhatsApp for instant communication with your visitors or customers.

Easily get WooCommerce orders via WhatsApp! Add a button using `[ak_whatsapp_button]` on product pages or posts. Customers can send the product link, title, and price directly to your WhatsApp. The plugin is fully customizable from the admin panel.

## Features

* **WooCommerce Integration:** Automatically hooks into product pages to generate dynamic messages containing the product name, price, and permalink.
* **Floating Widget:** A sticky floating button with a "typing" animation effect on hover.
* **Custom Shortcodes:** Flexible shortcode system for placing buttons anywhere on the site.
* **Responsive Design:** Fully responsive CSS ensures the button renders correctly on mobile and desktop devices.

## Setup Instructions

1.  **Enter WhatsApp Number:** Navigate to the settings page and enter your WhatsApp Number. Make sure to include the country code (e.g., 92xxxxxxxxxx).
2.  **Save Settings:** Save the settings by clicking the **Save Changes** button.
3.  **Activation:** Once set, your WhatsApp chat button or integration will start working on the frontend immediately.

## Important Notes

* The plugin will not function if a WhatsApp number is not set.
* This plugin works with standard WordPress pages, posts, and WooCommerce products.
* Make sure your number is active and can receive messages.

## Shortcode Usage

You can place a custom WhatsApp button anywhere using the `[ak_whatsapp_button]` shortcode.

## Technical Details

* **Hooks Used:** `woocommerce_single_product_summary`, `wp_footer`, `admin_menu`.
* **Security:** Implements `check_admin_referer` and `wp_nonce_field` for secure data handling.
* **Performance:** Uses vanilla JavaScript and optimized CSS for minimal footprint.

## Author

**Arsalan Khatri**
* AI Engineer & Full Stack Developer
* Website: [akdeepknowledge.com](https://akdeepknowledge.com/)
