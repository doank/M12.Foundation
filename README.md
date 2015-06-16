# M12.Foundation: Zurb Foundation components for Neos CMS
[![Circle CI](https://circleci.com/gh/million12/M12.Foundation.svg?style=svg)](https://circleci.com/gh/million12/M12.Foundation)

M12.Foundation aims to implement majority of [Zurb Foundation](http://foundation.zurb.com/) components, in the best possible way, inside [Neos CMS](http://neos.io/).

# Features

### Implemented Zurb Foundation components

* Accordion
* Alert and Panel
* Button
* Dropdown (with links or any content)
* Flex Video
* Font Icon (based on [Font Awesome](http://fontawesome.io/) icons)
* Form elements: Form Container, Fieldset, Label (incl. pre/postfix labels), Input, Checkbox, Radio, Select, Textarea
* Grid: Block Grid, Grid Row with Grid Column, simple Container
* Navigation: TopBar
* Navigation: Side Nav, Sub Nav
* Navigation: Magellan Sticky Navigation support
* Orbit Slider
* Reveal Modal
* Tabs
* Tooltips

### Other features

* Semantic tags: ability to define custom, semantic tag (e.g. `section` instead of `div`) for most components
* Ability to define several Foundation common-use classes like `rounded`, `radius`, floats, text-align to almost all components (or where applicable)
* Tooltips: ability to use them with many components, incl. default Neos compnents (e.g. Headline)
* Font Icon: ability to add it to components where it make sense (i.e. Button)

... and many more.

Check the [issue tracker](issues) to see what current work in progress or future plans.

## Usage

The best way is to install it together with [M12.FoundationSite](https://github.com/million12/M12.FoundationSite) site package, which has all CSS/JS in it, including all JS code to work around Neos (e.g. re-initialising Foundation components as soon as they're added to the page).

Note: pay attention to release notes to match the right version with your Neos version.

Include in your main `composer.json` the `m12/neos-foundation` and `m12/neos-foundation-site` dependencies:  
``` json
    "require": {
        "other-dependenies-here...": "*",
        "m12/neos-foundation": "dev-master",
        "m12/neos-foundation-site": "dev-master"
    },
```  
and run `composer install`

## Usage with `neos-typostrap-distribution`

You can try this plugin with ready-to-use, working out-of-the-box [neos-typostrap-distribution](https://github.com/million12/neos-typostrap-distribution). This is an open-source Neos distribution created for Typostrap.io project and it has `M12.Foundation` and `M12.FoundationSite` plugins installed and configured. If you're familiar with Docker, there's also Docker image with the whole package, so it's very easy to try. See the instructions in the README there.


## Author(s)

* Marcin Ryzycki marcin@m12.io  
* Samuel Ryzycki samuel@m12.io
* Dmitri Pisarev dimaip@gmail.com

Licensed under: The MIT License (MIT)

**Sponsored by** [Typostrap.io - the new prototyping tool](http://typostrap.io/) for building highly-interactive prototypes of your website or web app. Built on top of TYPO3 Neos CMS and Zurb Foundation framework.
