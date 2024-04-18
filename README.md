# WpReactLoader - A Composer Library for WordPress Developers

WpReactLoader is a composer library designed to simplify the process of loading React frontend projects in WordPress and passing data to them, a process known as localizing the script.

WpReactLoader solves the problem where a script may be manipulating the DOM after the page is loaded and you receive an error like this:
```
DOMException: Failed to execute 'removeChild' on 'Node': The node to be removed is not a child of this node.
```

## Features

- Easy loading of React frontend projects in WordPress.
- Simplified data passing (script localization) to the frontend.

## Installation

To install WpReactLoader, you need to have Composer installed on your machine. If you don't have it installed, you can download it from [here](https://getcomposer.org/).

Once you have Composer installed, you can install WpReactLoader by running the following command in your terminal:

```bash
composer GeekyCodeLab/WpReactLoader
```

## Usage
After installing the library, you can use it in your WordPress plugin or theme like this:

```php
$loader = new \GeekyCodeLab\WpReactLoader\UI([
    'assets_url' => 'path/to/your/assets',
    'js_file' => 'main.js',
    'data' => [
        'api_url' => 'https://your-api-url.com',
    ],
]);

echo $loader->load_resource();
```

This will load the React application from the specified JavaScript file and pass the specified data in a global JS variable called gcl_settings.
You can set the global variable name by including 'localization_variable' key in the constructor array.
You can also set, get, and remove data parameters like this:

```php
$loader->set_param('new_param', 'new_value');
echo $loader->get_param('new_param'); // Outputs: new_value
$loader->remove_param('new_param');
```
## Options

When creating a new instance of the `UI` class, you can pass an array of options to the constructor. Here are all the possible options:

- `assets_url` (string): The URL to the directory where your JavaScript file is located. Default is an empty string.
- `js_file` (string): The name of your JavaScript file. Default is an empty string.
- `data` (array): An array of data that you want to pass to your JavaScript file. Default is an empty array.
- `container_id` (string): The ID of the HTML container where your React app will be loaded. Default is 'app'.
- `container_class` (string): The class of the HTML container where your React app will be loaded. Default is an empty string.
- `include_admin_ajax_url` (bool): Whether to include the admin-ajax.php URL in the data passed to the frontend. Default is true.
- `localization_variable` (string): The name of the global JavaScript variable where your data will be stored. Default is 'gcl_settings'.

Here's an example of how to use these options:

```php
$loader = new \GeekyCodeLab\WpReactLoader\UI([
    'assets_url' => 'path/to/your/assets',
    'js_file' => 'main.js',
    'data' => [
        'api_url' => 'https://your-api-url.com',
    ],
    'container_id' => 'myApp',
    'container_class' => 'myClass',
    'include_admin_ajax_url' => false,
    'localization_variable' => 'myData',
]);

echo $loader->load_resource();
```

Here's an additional section for your README.md file that describes all possible options:

## Options

When creating a new instance of the `UI` class, you can pass an array of options to the constructor. Here are all the possible options:

- `assets_url` (string): The URL to the directory where your JavaScript file is located. Default is an empty string.
- `js_file` (string): The name of your JavaScript file. Default is an empty string.
- `data` (array): An array of data that you want to pass to your JavaScript file. Default is an empty array.
- `container_id` (string): The ID of the HTML container where your React app will be loaded. Default is 'app'.
- `container_class` (string): The class of the HTML container where your React app will be loaded. Default is an empty string.
- `include_admin_ajax_url` (bool): Whether to include the admin-ajax.php URL in the data passed to the frontend. Default is true.
- `localization_variable` (string): The name of the global JavaScript variable where your data will be stored. Default is 'gcl_settings'.

Here's an example of how to use these options:

```php
$loader = new \GeekyCodeLab\WpReactLoader\UI([
    'assets_url' => 'path/to/your/assets',
    'js_file' => 'main.js',
    'data' => [
        'api_url' => 'https://your-api-url.com',
    ],
    'container_id' => 'myApp',
    'container_class' => 'myClass',
    'include_admin_ajax_url' => false,
    'localization_variable' => 'myData',
]);

echo $loader->load_resource();
```

This will load the React application from the specified JavaScript file into an HTML container with the ID 'myApp' and the class 'myClass', and pass the specified data to a global JavaScript variable called 'myData'. The admin-ajax.php URL will not be included in the data.