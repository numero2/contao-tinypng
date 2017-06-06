Contao TinyPNG
=======================

About
--
Automatically optimizes all uploaded PNG and JPEG images using [tinypng.com](https://tinypng.com)'s image optimizer.

System requirements
--

* [Contao](https://github.com/contao/core) 3.2.5 or newer  / successfully tested with Contao 4.3.9
* [TinyPNG API key](https://tinypng.com/developers)


Installation & Configuration
--

* Create a folder named `tinypng` in `system/modules`
* Clone this repository into the new folder
* Obtain an API key and enter it into the System Settings under `Upload settings`

**Additional step for Contao 4.X:**
Open `app/AppKernel.php` and add the following line to the $bundles array
```php
new Contao\CoreBundle\HttpKernel\Bundle\ContaoModuleBundle('tinypng', $this->getRootDir())
```