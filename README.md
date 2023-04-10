# Antlers Layouts

> Antlers Layouts is a Statamic addon that allows you to extend arbitrary layouts and pass data to your template's layouts.

## Features

This addon:

* Allows you to extend arbitrary layouts from within your Antlers templates;
* Pass data to layouts from templates

## How to Install

You can install this addon by running the following command from your project root:

``` bash
composer require stillat/antlers-layouts
```

## How to Use

The Antlers Layouts addon provides a single `layout` Tag that allows you to extend arbitrary layouts and pass data to your template's layout.
The recommended way to organize multiple layouts within your Statamic project is to create a new folder at the following locations to contain your extra layout templates:

```
resources/views/layouts/
```

Assuming we had a file named `resources/views/layouts/custom-layout.antlers.html`, we could use dynamically swap to this layout by including the following Antlers tag anywhere in our template:

```antlers
{{ layout:layouts/custom-layout }}
```

By including this Tag, Antlers will now utilize the `resources/views/layouts/custom-layout.antlers.html` file as our layout instead of the normal `resources/views/layout.antlers.html` file.

We can use the `layout:share` Tag to pass data to our Antlers layout files:

```antlers
{{ layout:share variable_one="Value One"
                variable_two="Another value"
                :variable_three="title" /}}
```

> It is important to note that the `layout:share` template will only pass custom variables to the standard `layout.antlers.html` template file, and custom layouts located within the `resources/views/layouts/` folder.

Our custom variables created using the `layout:share` Tag will now be available to us in our layout file like any other variable:

```antlers
{{# Inside the layout template. #}}

{{ variable_one }}
{{ variable_two }}
{{ variable_three }}
```

## License

Antlers Layouts is free software released under the MIT License.
