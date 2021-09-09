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

For all non primitive values that not using a simple string you have to use the `:` character as a prefix :

```html
<x-boilerplate::tinymce id="example" name="example" :value="$content" />
```

## Laravel 6

Laravel 6 does not support Blade x components, but you can use the `@component` directive instead :

```html
@component('boilerplate::tinymce') @endcomponent
```