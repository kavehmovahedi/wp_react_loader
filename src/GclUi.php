<?php
namespace Gcl\WpReactLoader;

class UI {
    private const DEFAULT_ASSETS_URL = '';
    private const DEFAULT_JS_FILE = '';
    private const DEFAULT_DATA = [];
    private const DEFAULT_CONTAINER_ID = 'app';
    private const DEFAULT_CONTAINER_CLASS = '';
    private const DEFAULT_INCLUDE_ADMIN_AJAX_URL = true;
    private const DEFAULT_LOCALIZATION_VARIABLE = 'gcl_settings';

    public $assets_url;
    public $js_file;
    public $data;
    public $container_id;
    public $container_class;
    public $include_admin_ajax_url;
    public $localization_variable;
    
    /**
     * Constructor for the GclUi class.
     *
     * @param string|null $assets_url The base URL where the JavaScript file is located.
     * @param string|null $js_file The name of the JavaScript file to load.
     * @param array $data The data to pass to the script.
     * @param string $container_id The ID of the HTML container where the React app will be loaded.
     * @param string $container_class The class of the HTML container where the React app will be loaded.
     * @param bool $include_admin_ajax_url Whether to include the admin-ajax URL in the data.
     * @param string $localization_variable The name of the JavaScript variable to use for localization.
     */
    public function __construct(array $data = []) {
        $defaults = [
            'assets_url' => self::DEFAULT_ASSETS_URL,
            'js_file' => self::DEFAULT_JS_FILE,
            'data' => self::DEFAULT_DATA,
            'container_id' => self::DEFAULT_CONTAINER_ID,
            'container_class' => self::DEFAULT_CONTAINER_CLASS,
            'include_admin_ajax_url' => self::DEFAULT_INCLUDE_ADMIN_AJAX_URL,
            'localization_variable' => self::DEFAULT_LOCALIZATION_VARIABLE,
        ];

        $data = wp_parse_args($data, $defaults);

        $this->assets_url = $data['assets_url'];
        $this->js_file = $data['js_file'];
        $this->data = $data['data'];
        $this->container_id = $data['container_id'];
        $this->container_class = $data['container_class'];
        $this->include_admin_ajax_url = $data['include_admin_ajax_url'];
        $this->localization_variable = $data['localization_variable'];
    }

    /**
     * Sets a parameter in the data array.
     *
     * @param string $key The key of the parameter to set.
     * @param mixed $value The value of the parameter to set.
     * @return $this Returns the current object to allow for method chaining.
     */
    public function set_param( string $key, $value ) {
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * Retrieves a parameter from the data array.
     *
     * @param string $key The key of the parameter to retrieve.
     * @return mixed|null Returns the value of the parameter if it exists, or null if it does not.
     */
    public function get_param( string $key ) {
        return $this->data[$key] ?? null;
    }

    /**
     * Removes a parameter from the data array.
     *
     * @param string $key The key of the parameter to remove.
     * @return $this Returns the current object to allow for method chaining.
     */
    public function remove_param( string $key ) {
        unset( $this->data[$key] );
        return $this;
    }

    /**
     * Prepares the data array for use.
     *
     * @param array|null $data The data array to prepare. If null, the instance's data array is used.
     * @return array Returns the prepared data array.
     */
    private function prepare_data($data = null): array {
        $data = $data ? $data : $this->data;

        if ( $this->include_admin_ajax_url ) {
            $data['admin_ajax_url'] = admin_url('admin-ajax.php');
        }

        $this->data = apply_filters('gcl_react_data', $data);
        return $data;
    }

    /**
     * Retrieves the URL of the file.
     *
     * @param string|null $file_url The URL of the file. If null, the method will generate the URL.
     * @return string Returns the URL of the file. If the URL cannot be generated, returns an empty string.
     */
    private function get_file_url($file_url = null): string {
        if( $file_url ) {
            return $file_url;
        }

        if( empty($this->assets_url) || empty($this->js_file) ) {
            return '';
        }
        elseif( filter_var($this->js_file, FILTER_VALIDATE_URL) ) {
            return $this->js_file;
        }
        else if( strpos( $this->assets_url, '/') != (strlen($this->assets_url) - 1) ) {
            $this->assets_url .= '/';
        }
        return $this->assets_url . $this->js_file;
    }

    /**
     * Loads the resources necessary for the React application.
     *
     * @param string|null $file_url The URL of the JavaScript file to load. If null, the method will generate the URL.
     * @param array|null $data The data to pass to the script. If null, the instance's data array is used.
     * @return string Returns a string of HTML that loads the React application.
     */
    public function load_resource($file_url = null, $data = null ): string {
        $this->prepare_data($data);

        return sprintf(
            '<div id="%s" class="%s"></div>
            <script type="module" src="%s" defer></script>
            <script>window.%s = %s;</script>',
            esc_attr($this->container_id),
            esc_attr($this->container_class),
            esc_url($this->get_file_url($file_url)),
            esc_attr($this->localization_variable),
            json_encode($this->data)
        );
    }
}