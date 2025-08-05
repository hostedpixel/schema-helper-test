# Schema Helper WordPress Plugin

A WordPress plugin that removes schema attributes and classes from specific elements and disables Beaver Builder schema.

## Features

- Removes schema attributes (`itemtype`, `itemscope`, `itemprop`) from Simple Author Box plugin elements
- Removes schema-related CSS classes (`hentry`, `hcard`, `vcard`, `fn`)
- Disables Beaver Builder schema when Beaver Builder is active
- GitHub updater support for automatic updates

## Installation

1. Upload the plugin files to `/wp-content/plugins/schema-helper/`
2. Activate the plugin through the 'Plugins' screen in WordPress
3. For automatic updates from GitHub, install the [GitHub Updater](https://github.com/afragen/github-updater) plugin

## GitHub Updates Setup

### Option 1: Using GitHub Updater Plugin (Recommended)

1. Install the [GitHub Updater](https://github.com/afragen/github-updater) plugin
2. Create a GitHub repository for this plugin
3. Update the plugin header in `index.php`:
   ```php
   * GitHub Plugin URI: https://github.com/yourusername/schema-helper
   * GitHub Branch: main
   ```
4. Push your code to GitHub
5. Create a release with a version tag (e.g., `v1.0.1`)

### Option 2: Manual GitHub Integration

The plugin includes built-in GitHub update checking that works without the GitHub Updater plugin:

1. Create a GitHub repository
2. Update the API URL in the `check_github_updates()` method:
   ```php
   $api_url = 'https://api.github.com/repos/yourusername/schema-helper/releases/latest';
   ```
3. Create releases with version tags (e.g., `v1.0.1`)

## GitHub Repository Setup

1. **Create Repository**: Create a new repository on GitHub named `schema-helper`
2. **Push Code**: Upload your plugin files to the repository
3. **Create Release**: 
   - Go to "Releases" in your GitHub repository
   - Click "Create a new release"
   - Tag version: `v1.0.0` (or higher version)
   - Release title: `Version 1.0.0`
   - Add release notes in the description
   - Publish the release

## Version Management

- Update the version in the plugin header: `Version: 1.0.1`
- Create a new GitHub release with the corresponding tag: `v1.0.1`
- The plugin will automatically detect new versions and show update notifications

## Configuration

### Customizing Schema Removal

Edit `assets/schema-helper.js` to modify which elements and attributes are targeted:

```javascript
// Remove attributes from specific elements
removeAttributes('.your-selector', ['itemprop', 'itemscope']);

// Remove classes from elements
removeClass('your-class-name');
```

### Beaver Builder Integration

The plugin automatically detects if Beaver Builder is active and disables its schema output. No additional configuration is needed.

## Changelog

### Version 1.0.0
- Initial release
- Schema attribute removal for Simple Author Box plugin
- Class removal functionality
- Beaver Builder schema disable
- GitHub updater support

## Support

For issues and feature requests, please create an issue on the GitHub repository.

## License

GPL v2 or later 