# WP Swift: Grid Block Gallery

 * Plugin Name: WP Swift: Grid Block Gallery
 * Plugin URI: 
 * Description: An irregular block gallery.
 * Version: 1
 * Author: Gary Swift
 * Author URI: https://github.com/wp-swift-wordpress-plugins
 * License: GPL2

## Usage
How to use with FoundationPress.
## Auto Installation
1) Open plugin directory in terminal
2) Run this command `sh install.sh`

##### Manual Installation
```
npm install magnific-popup --save
touch src/assets/js/lib/magnific-popup.js
mv page-gallery.php ../../themes/M50retailPress/page-templates/page-gallery.php
```

##### Add Files
src/assets/js/app.js
```
import '../../../node_modules/magnific-popup/dist/jquery.magnific-popup.min';
import './lib/magnific-popup';
```

src/assets/scss/app.scss
```
@import '../../../node_modules/magnific-popup/dist/magnific-popup';
```

##### Event Listenter
src/assets/js/lib/magnific-popup.js
```js
/** ref: http://dimsemenov.com/plugins/magnific-popup/ */
jQuery(document).ready(function ($) {
    if (typeof site !== 'undefined') {
        small = '<small>'+site.name+' - '+site.description+'</small>';
    }
    $('.lightbox-gallery').each(function() { // the containers for all your galleries
        $(this).magnificPopup({
            delegate: 'a.lightbox', // the selector for gallery item
            type: 'image',
            gallery: {
              enabled:true
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                titleSrc: function(item) {
                    return item.el.attr('title') + small;
                }
            }        
        });
    }); 
});
```
## Examples
![Dlight](screencapture-dlight-ie-project-jll-2018-06-05-10_37_05.png)

![M50](screencapture-m50honda-ie-gallery-2018-06-05-10_34_55.png)

## Licence
This project is licensed under the MIT license.

Copyright 2017 Gary Swift https://github.com/GarySwift

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

https://opensource.org/licenses/MIT