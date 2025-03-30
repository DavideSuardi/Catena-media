# WiseRabbit Slots Pages Plugin

**WordPress plugin to manage and display slot entries across multiple sites.**  
Provides a custom post type for slots, custom metadata, and a responsive frontend grid via shortcode.



---

## Features

- Custom post type: `slot`
- Meta fields: Provider, RTP, Min/Max Wager, Star Rating
- Responsive slot grid via `[slot_grid]`
- Basic styling included (`default-style.css`)
- Easily override style or layout per website

---


## Installation

1. Upload the folder `wiserabbit-slots-pages` into `/wp-content/plugins/`
2. Activate the plugin from the **Plugins** menu in WordPress
3. You’ll now see a **"Slots"** section in the WordPress admin
4. Add slot entries, fill out their meta fields, and use shortcodes to display them

---

## Shortcode: `[slot_grid]`

Display a responsive grid of slot entries.

### Attributes

| Attribute | Description                     | Default  |
|-----------|----------------------------------|----------|
| `limit`   | Number of slots to display       | `6`      |
| `order`   | Sorting: `recent` or `random`    | `recent` |

### Example

```
[slot_grid limit="6" order="random"]
```

---

## Styling Overrides (Per-Site Customization)
By default, the plugin loads a general-purpose stylesheet located at:
```
/wiserabbit-slots-pages/public/css/default-style.css
```
This CSS handles layout, spacing, and responsive behavior of the grid and slot detail.

### Option 1: Override styles (per site)
If a site wants to use custom styles instead of the default:

1- Go to the active theme folder of the site:

```
/wp-content/themes/your-theme/
```
2- Create a file named:

```
wiserabbit-slots-override.css
```
3- Add your custom CSS rules inside.

If this file exists, it will automatically replace the plugin’s default-style.css.

### Option 2: Disable all plugin styles completely
If you want total control from the theme or a builder, add this in your theme’s functions.php:

```
add_filter('wr_slots_disable_styles', '__return_true');
```
This prevents the plugin from loading any CSS at all.
