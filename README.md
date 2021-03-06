Casule
===========

Creates token and challenge by some attributes.


Install
-----

Add "kumatch/casule" as a dependency in your project's composer.json file.


    {
      "require": {
        "kumatch/casule": "*"
      }
    }

And install your dependencies.

    $ composer install



Usage
-----

```php
use Kumatch\Casule\Casule;

$attributes = array("foo" => 123, "bar" => "baz");
$salt = 'saltstring';

$casule = new Casule($salt);
$token = $casule->create($attributes);   // 'yBJwijCcdwrT0hXbeSIYvcWgP7U='

$algo = 'sha512';
$casule2 = new Casule($salt, $algo);
$token2 = $casule2->create($attributes);  // 'MoxMmk+ACDlHH/PaRQhgCZHjtrolbOpb5GvpbYHzPMZKwDXelj5x3BfyEMkCsXaPwVx59tlHPTqo1E305NkTDA=='


if ( $casule->challenge($token, $attributes) ) {
   echo 'valid token.';
}
```


License
--------

Licensed under the MIT License.

Copyright (c) 2013 Yosuke Kumakura

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.