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

The `load_resource` method generates HTML code and returns it as a string. This output can be used directly in your code, either by echoing it or by returning it within a shortcode.

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

This will load the React application from the specified JavaScript file into an HTML container with the ID 'myApp' and the class 'myClass', and pass the specified data to a global JavaScript variable called 'myData'. The admin-ajax.php URL will not be included in the data.

## Methods

The `UI` class provides the following methods:

- `__construct(array $options = [])`: The constructor accepts an array of options. See the Options section for more details.

- `set_param(string $key, mixed $value)`: This method allows you to set a parameter in the data array. The `$key` is the name of the parameter and `$value` is the value of the parameter.

- `get_param(string $key)`: This method allows you to get a parameter from the data array. The `$key` is the name of the parameter. If the parameter does not exist, it returns `null`.

- `load_resource()`: This method loads the React application. It returns a string of HTML that includes the script tag to load the JavaScript file and the div where the React app will be mounted.

Here's an example of how to use these methods:

```php
$loader = new \GeekyCodeLab\WpReactLoader\UI([
    'assets_url' => 'path/to/your/assets',
    'js_file' => 'main.js',
]);

$loader->set_param('api_url', 'https://your-api-url.com');
$loader->set_param('container_id', 'myApp');
$loader->set_param('container_class', 'myClass');
$loader->set_param('include_admin_ajax_url', false);
$loader->set_param('localization_variable', 'myData');

echo $loader->load_resource();
```

This will load the React application from the specified JavaScript file into an HTML container with the ID 'myApp' and the class 'myClass', and pass the specified data to a global JavaScript variable called 'myData'. The admin-ajax.php URL will not be included in the data.

## Method Chaining

The `set_param` method returns the `UI` object, enabling method chaining. Here's an example using the `set_param` method from the `UI` class:

```php
$loader = new \GeekyCodeLab\WpReactLoader\UI([
    'assets_url' => 'path/to/your/assets',
    'js_file' => 'main.js',
]);

$loader->set_param('api_url', 'https://your-api-url.com')
       ->set_param('container_id', 'myApp')
       ->set_param('container_class', 'myClass')
       ->set_param('include_admin_ajax_url', false)
       ->set_param('localization_variable', 'myData');

echo $loader->load_resource();
```

In this example, each call to `set_param` returns the `UI` object itself, allowing another `set_param` call to be made on the same line. This is more concise and often more readable than making each call on a separate line. The final call to `load_resource` is made on a new line because it does not return the `UI` object and therefore cannot be chained.

This explanation should help users of your class understand how they can use method chaining to make their code more concise and readable.