Using MJML e-mail templates
===========================

Workfow
-------

MJML templates are compiled by Gulp from MJML markup to Smarty templates. After compilation, all occurences of ##...## sequence are replaced with {...} sequence. After compilation, **_master_template.tpl** file is ready for mailing. This template contains {placeholder} Smarty tag for placing content and markup for rendering order overview table. If you need more different templates, simply create a copy of _master_template.mjml in mjml folder and edit it.

For MJML docs see https://documentation.mjml.io/

Files
-----

All MJML templates are located in mjml folder

  **_master_template.mjml** - main template with header, footer, and other optional partials.
  **partials**- folder containing partials to be included in template.mjml at compile time. Each partial file (except those witn names starting with _ underscore) is a component usable in main template file.

Compiling
---------

Templates are compiled by running task **gulp mjml** (from root folder). Task is also run when running **gulp** or **gulp serve**

Smarty integration
------------------

### Smarty tags in tag attributes
In most cases it is possible to use Smarty tags in tag attributes

### Smarty tags elsewhere
Smarty tags are mostly allowed within tags that have text content allowed, for example **mjml-text**, **mj-navbar-link** etc.
In other places Smarty tags must be contained in **mj-raw** tag (content of mj-raw is left untouched during MJML compilation)

### What to do when Smarty tags cause problems when compiling MJML
In some cases (like in CSS styles inside mj-style tag or in html style attribute) it helps to replace curly brackets with ## (## sequence is auto-replaced with curly brackets after compilation) - for example you may use ##$something## instead of {$something}

