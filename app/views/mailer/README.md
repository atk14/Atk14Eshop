# Using MJML e-mail templates

## Workfow
MJML templates are compiled by Gulp from MJML markup to Smarty templates.

For MJML docs see https://documentation.mjml.io/

## Files
All MJML templates are located in mjml folder

*template.mjml* - main template with header, footer, and other optional partials.
*partials* - partials to be included in template.mjml at compile time

## Compiling
Templates are compiled by running task 'gulp mjml' (from root folder). Task is also run when running *gulp* 

## Smarty integration

### Smarty tags in tag attributes
In most cases it is possible to use Smarty tags in tag attributes

### Smarty tags elsewhere
Smarty tags are mostly allowed within tags that have text content allowed, for example mjml-text, mj-navbar-link etc.
In other places Smarty tags must be contained in mj-raw tag (content of mj-raw is left untouched during MJML compilation)

### What to do when Smarty tags cause problems when compiling MJML
In some cases it helps to replace curly brackets with ## (## sequence is auto-replaced with curly brackets after compilation) - for example you may use ##$something## instead of {$something}

