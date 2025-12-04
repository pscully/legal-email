# Twenty Twenty-Five Child Theme

This is a custom child theme for the Twenty Twenty-Five WordPress theme, specifically designed for the NC Lawyers Advocacy website.

## Features

- **Professional Design**: Clean, professional layout suitable for legal advocacy
- **Constitutional Parchment Background**: Full-width constitutional parchment background image with overlay for readability
- **Typography**: Google Fonts integration with Roboto for headings and Open Sans for body text
- **Color Palette**: 
  - Primary: Navy Blue (#1e3a8a)
  - Secondary: Gray (#64748b)
  - Accent: Gold/Bronze (#d97706)
  - Text: Dark Gray (#1f2937)
- **Responsive Design**: Mobile-first approach with optimizations for all devices
- **Form Styling**: Pre-styled form elements for Paperform integration
- **Performance Optimized**: Includes preconnect links for Google Fonts and removes unnecessary WordPress features

## Installation

1. Upload the `twentytwentyfive-child` folder to `/wp-content/themes/`
2. Add your constitutional parchment background image as `parchment-background.jpg` in the theme directory
3. Activate the theme from WordPress Admin > Appearance > Themes

## Required Files

### Background Image
You need to add a constitutional parchment background image named `parchment-background.jpg` to the theme directory. This should be a high-quality image of constitutional parchment or similar legal document texture.

### Recommended Image Specifications
- **Format**: JPG or WebP
- **Dimensions**: At least 1920x1080px for full coverage
- **File Size**: Optimized for web (under 500KB recommended)
- **Style**: Constitutional parchment, aged paper, or legal document texture

## Customization

### Colors
The color palette can be customized by editing the CSS custom properties in `style.css`. Look for the "Color Palette" section.

### Typography
Fonts can be changed by modifying the Google Fonts URL in `functions.php` and updating the font-family declarations in `style.css`.

### Layout
Content areas include semi-transparent backgrounds and subtle shadows for better readability over the parchment background.

## Form Integration

The theme includes pre-styled form elements optimized for Paperform integration:
- Use the `[form_container]` shortcode to wrap your form
- Form inputs are styled to match the site's design
- Submit buttons use the primary navy blue color

## Browser Support

- Chrome (latest 2 versions)
- Firefox (latest 2 versions)  
- Safari (latest 2 versions)
- Edge (latest 2 versions)
- iOS Safari (latest 2 versions)
- Chrome Mobile (latest 2 versions)

## Performance Features

- Google Fonts preconnect for faster loading
- Optimized CSS delivery
- Removed unnecessary WordPress features
- Mobile-optimized background handling

## Security Features

- Security headers for clickjacking protection
- XSS protection headers
- MIME type sniffing prevention
- Secure referrer policy

## Support

This theme is specifically designed for the NC Lawyers Advocacy website project and follows all specifications from the project documentation.