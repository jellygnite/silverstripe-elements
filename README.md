# Jellygnite Elements

## Introduction

Useful elemental building blocks.

## Requirements

* silverstripe ^4.0
* dnadesign/silverstripe-elemental ^4.0
* jellygnite/silverstripe-elemental-style ^4.0

## Installation
Add some installation instructions here, having a 1 line composer copy and paste is useful. 
Here is a composer command to create a new module project. Ensure you read the
['publishing a module'](https://docs.silverstripe.org/en/developer_guides/extending/how_tos/publish_a_module/) guide
and update your module's composer.json to designate your code as a SilverStripe module. 

```
composer require jellygnite/silverstripe-elements
```

**Note:** This is not fully functional yet as the templates still need some work.

## Example configuration (optional)
If your module makes use of the config API in SilverStripe it's a good idea to provide an example config
 here that will get the module working out of the box and expose the user to the possible configuration options.

Provide a yaml code example where possible.

```yaml

Page:
  config_option: true
  another_config:
    - item1
    - item2
  
```


### Background Extension

Adds background image or video to an element. 

Add this to your mysite.yml, e.g.
 
```
DNADesign\Elemental\Models\ElementContent:
  extensions:
    - Jellygnite\Elements\Extensions\BackgroundExtension
```