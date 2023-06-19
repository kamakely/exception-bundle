This bundle provides interface to facilitate the customization of the exception rendering in Symfony project.

In Dev mode, 

## 1 - Installation 
```bash
composer require pulse/execption-bundle
```

### 2 - How to work

By default, this bundle handle the http exception in x

## 3 - Create custom execption handler

Create an class that implement the PulseExceptionInteface interface. It contains two methods:

#### ** handleException: This method have Throwble as argument and returns a Symfony Response 
#### ** supportsException: This method have Throwble as argument and return boolean.

```php
<?php

namespace App\Handler\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Pulse\ExceptionBundle\PulseExceptionInterface;

class LockExceptionHandler implements PulseExceptionInterface 
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


<?php

namespace App\Handler\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Pulse\ExceptionBundle\PulseExceptionInterface;

class MyException extends \Exception 
{
}


```

When you throw the MyException, the LockExceptionHandler class is called by thesystem .
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

## 3 - Decorate existing exception handler