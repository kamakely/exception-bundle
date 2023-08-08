If you need to manage complexe exception in your application, this bundle is set for you .
This bundle provides interface to facilitate the customization of the exception rendering in Symfony project.
Each exception that you create has his own handler classe. Your exception will be scalable, maintenable, independante.


## 1 - Installation 
```bash
composer require tounaf/execption-bundle
```

### 2 - How to work

By default, this bundle handle exception and render a json response but you can customize this behavior with your needs (ex: html)

## 3 - Create custom execption handler

Create an class and implement the PulseExceptionInteface interface. It contains two methods:

#### ** handleException: This method have Throwble as argument and returns a Symfony Response 
#### ** supportsException: This method have Throwble as argument and return boolean.

Example:

First create Exception to handle through the app.

```php
<?php

namespace App\Handler\Exception;

class MyException extends \Exception 
{
}

```
Then create the handler that handle this exception

```php
<?php

namespace App\Handler\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tounaf\ExceptionBundle\ExceptionInterface;

class MyExceptionHandler implements ExceptionInterface 
{
    // return an JsonResponse
    public function handleException(\Throwable $throwable): Response
    {
        // your logic
        return new JsonResponse(['message' => $throwable->getMessage(), 'code' => 12]);
    }

    // 
    public function supportsException(\Throwable $throwable): Response
    {
        return $throwable instanceof MyException;
    }
}

```

When MyException is thrown, the MyExceptionHandler class is called by the system .
For example:


```php

namespace App\Service;

use App\Handler\Exception\MyException;

class MyService
{
    public function someFunction()
    {
        // your logic
        throw new MyException();
    }
}

```