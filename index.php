<?php
/**
 * Plugin Name: Schema Helper
 * Plugin URI: 
 * Description: Removes schema attributes and classes from specific elements and disables Beaver Builder schema
 * Version: 1.0.0
 * Author: 
 * License: GPL v2 or later
 * Text Domain: schema-helper
 * GitHub Plugin URI: https://github.com/yourusername/schema-helper
 * GitHub Branch: main
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class SchemaHelper {
    
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_script'));
        add_action('init', array($this, 'add_beaver_builder_filter'));
        add_action('init', array($this, 'init_github_updater'));
    }
    
    /**
     * Enqueue the JavaScript script
     */
    public function enqueue_script() {
        wp_enqueue_script(
            'schema-helper',
            plugin_dir_url(__FILE__) . 'assets/schema-helper.js',
            array(),
            $this->get_plugin_version(),
            true
        );
    }
    
    /**
     * Add Beaver Builder filter if Beaver Builder is active
     */
    public function add_beaver_builder_filter() {
        if (class_exists('FLBuilder')) {
            add_filter('fl_theme_disable_schema', '__return_true');
        }
    }
    
    /**
     * Initialize GitHub updater
     */
    public function init_github_updater() {
        // Check if GitHub Updater plugin is active
        if (!class_exists('GitHub_Updater')) {
            add_action('admin_notices', array($this, 'github_updater_notice'));
        }
        
        // Add filter for GitHub Updater
        add_filter('github_updater_pre_set_site_transient_update_plugins', array($this, 'add_github_updater_support'));
    }
    
    /**
     * Add GitHub Updater support
     */
    public function add_github_updater_support($transient) {
        if (empty($transient)) {
            return $transient;
        }
        
        // Plugin file path
        $plugin_file = plugin_basename(__FILE__);
        
        // Check for updates from GitHub
        $github_response = $this->check_github_updates();
        
        if ($github_response && version_compare($github_response['version'], $this->get_plugin_version(), '>')) {
            $transient->response[$plugin_file] = (object) array(
                'slug' => 'schema-helper',
                'new_version' => $github_response['version'],
                'url' => 'https://github.com/yourusername/schema-helper',
                'package' => $github_response['download_url'],
                'requires' => '5.0',
                'requires_php' => '7.4',
                'tested' => '6.0',
                'last_updated' => $github_response['published_at'],
                'sections' => array(
                    'description' => 'Removes schema attributes and classes from specific elements and disables Beaver Builder schema',
                    'changelog' => $github_response['body'] ?? 'No changelog available'
                )
            );
        }
        
        return $transient;
    }
    
    /**
     * Check for updates from GitHub
     */
    private function check_github_updates() {
        $cache_key = 'schema_helper_github_latest';
        $cached_response = get_transient($cache_key);
        
        if ($cached_response !== false) {
            return $cached_response;
        }
        
        $api_url = 'https://api.github.com/repos/yourusername/schema-helper/releases/latest';
        
        $response = wp_remote_get($api_url, array(
            'timeout' => 15,
            'headers' => array(
                'Accept' => 'application/vnd.github.v3+json',
                'User-Agent' => 'WordPress/' . get_bloginfo('version')
            )
        ));
        
        if (is_wp_error($response)) {
            return false;
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        if (empty($data) || !isset($data['tag_name'])) {
            return false;
        }
        
        $release_data = array(
            'version' => ltrim($data['tag_name'], 'v'),
            'download_url' => $data['zipball_url'],
            'published_at' => $data['published_at'],
            'body' => $data['body']
        );
        
        // Cache for 12 hours
        set_transient($cache_key, $release_data, 12 * HOUR_IN_SECONDS);
        
        return $release_data;
    }
    
    /**
     * Get plugin version
     */
    private function get_plugin_version() {
        if (!function_exists('get_plugin_data')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        
        $plugin_data = get_plugin_data(__FILE__);
        return $plugin_data['Version'] ?? '1.0.0';
    }
    
    /**
     * Admin notice for GitHub Updater
     */
    public function github_updater_notice() {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        //echo '<div class="notice notice-warning is-dismissible">';
      //  echo '<p><strong>Schema Helper:</strong> For automatic updates from GitHub, please install the <a href="https://github.com/afragen/github-updater" target="_blank">GitHub Updater</a> plugin.</p>';
      //  echo '</div>';
    }
}

// Initialize the plugin
new SchemaHelper();
