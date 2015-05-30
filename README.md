#CSS reader and writer

##Introduction
Crossjoin\Css can read CSS from different sources and write it in different formats. It supports different at-rules like media queries, comments, value optimization, and already supports parts of CSS4.

##Installation
This is a composer package. See the [composer website](https://getcomposer.org/) for basic installation information.

Add the following line to your `composer.json` file:
```javascript
{
    "require": {
        "crossjoin/css": "1.0.*-dev"
    }
}
```

##Features
- Supports nearly all at-rules with unlimited level of nesting
- Can read CSS4 media queries (are converted to CSS3 media queries)
- Can handle large, compressed CSS files
- Supports CSS comments
- Integrated checks for invalid CSS
- ...

##Basic usage

###Reading CSS
You can read the CSS information from different sources.

```php
// Read CSS file
$cssFileName = "path/to/file.css";
$reader = new \Crossjoin\Css\Reader\CssFile($cssFileName);

// Read CSS string
$cssString = "body { background:red; }";
$reader = new \Crossjoin\Css\Reader\CssFile($cssString);

// Extract CSS from <style> tags in a HTML file
// (multiple tags are merges to one style sheet)
$htmlFileName = "path/to/file.html";
$reader = new \Crossjoin\Css\Reader\HtmlFile($htmlFileName);

// Extract CSS from <style> tags in a HTML string
// (multiple tags are merges to one style sheet)
$htmlString = "<html><head><style>body{color:red;}</style></head><body></body></html>";
$reader = new \Crossjoin\Css\Reader\HtmlFile($htmlString);
```

###Charset detection
The charset of the CSS file is detected automatically (depending on Byte-Order-Markers or a charset rule within the CSS) and defaults to "UTF-8". You can change the default value by setting the environment encoding.

```php
// Sets the environment encoding of the referencing (!) document, e.g. if defined 
// in a link tag of an HTML page.
// This is used as a fall back value to determine the charset of the CSS file.
$reader->setEnvironmentEncoding("UTF-8");
```

###Writing CSS
The writer can create CSS in different formats.

```php
// Gets the CSS content in compact format (no comments, no line breaks,...)
$writer = new \Crossjoin\Css\Writer\Compact($reader->getStyleSheet());
$cssContent = $writer->getContent();

// Gets the CSS content in prettified format
// (with comments, line breaks, indentations,...)
$writer = new \Crossjoin\Css\Writer\Pretty($reader->getStyleSheet());
$cssContent = $writer->getContent();
```

##Advanced usage
TODO

##To Do
- Additional checks for valid CSS rules, properties and values
- Additional optimizations of CSS properties and values
- Support for [CSS Paged Media Module Level 3](http://dev.w3.org/csswg/css-page-3/#at-page-rule) (page type selectors, margin at-rules)
- Support for "supports" in import at-rule ([not final](http://dev.w3.org/csswg/css-cascade-4/#at-ruledef-import))
