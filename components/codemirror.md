---
title: CodeMirror
parent: Blade components
permalink: /components/codemirror
---

# CodeMirror

```html
<x-boilerplate::codemirror name="html"><h1>Code example</h1></x-boilerplate::codemirror>
```

Will render

![Toggle](../assets/img/components/codemirror.png)

## Value

The value can be set by using slot or the value attribute

```html
<x-boilerplate::codemirror name="example">
    <h2>CodeMirror demo</h2>
    <p>Lorem ipsum dolor sit amet.</p>
</x-boilerplate::codemirror>
```

or

```html
<x-boilerplate::codemirror name="example" value="<h2>CodeMirror demo</h2><p>Lorem ipsum dolor sit amet.</p>" />
```

## Attributes

Attributes that can be used with this component :

| Option      | Type    | Default | Description                                               |
|-------------|---------|---------|-----------------------------------------------------------|
| name        | string  | null    | Input name (required)                                     |
| label       | string  | name    | Input label, can be a translation string                  |
| help        | string  | null    | Help message that will be displayed under the input field |
| value       | mixed   | null    | Value of input                                            | 
| options     | string  | ""      | CodeMirror initialization options                         |
| js          | array   | []      | Array of additionnal plugins or parsers to load           |
| group-class | string  | null    | Additionnal class that will be added to form-group        | 
| group-id    | string  | null    | ID that will be added to form-group                       |

For all non primitive values that not using a simple string you have to use the `:` character as a prefix :

```html
<x-boilerplate::tinymce id="example" name="example" :value="$content" />
```

## Plugins and options

To add plugins and to set options, use `js` and `options` attributes:

```html
<x-boilerplate::codemirror name="sass" :js="['mode/sass/sass.js']" options="mode:'sass'"></x-boilerplate::codemirror> 
```

## Laravel 6

Laravel 6 does not support Blade x components, but you can use the `@component` directive instead :

```html
@component('boilerplate::tinymce') @endcomponent
```