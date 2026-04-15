# Log de modificaciones en el Core

[IMPORTANT!]
- El contenido de core/adminer/externals debe ser directamente descargado porque el repo original lo enlaza con git submodule.

## v5.3.0
- core/adminer/adminer/include/adminer.inc.php
    - permanentLogin
- core/adminer/adminer/index.php
```php
namespace Adminer;

if(!defined('_DEV_MODE_')){
	define('_DEV_MODE_', false);
}
```
- core/adminer/compile.php
```php
//[Line 358]
$filename = __DIR__ . "../../../adminer.php";
```
## v5.4.2

- Sin modificaciones al core adicionales.
