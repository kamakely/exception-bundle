If you need to manage complexe exception in your application, this bundle is set for you .
This bundle provides interface to facilitate the customization of the exception rendering in Symfony project.
Each exception that you create has his own handler classe. Your exception will be scalable, maintenable, independent.


## 1 - Installation 
```bash
composer require tounaf/exception-bundle
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
use Tounaf\ExceptionBundle\ExceptionHandlerInterface;

class MyExceptionHandler implements ExceptionHandlerInterface 
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

## 3 - Format Response
Sometimes, your app provides the service that third party can consume:
for example :
```php
/api/users/list returns a json {"data": [{"name":"user1"}, {"name":"user2"}]}

```
but the uri

```php
/admin/users/list renders an html page
```
An HandlerException can provide multiple format of response like html, json, etc.  
By default, this bundle supports html and json for format of response but it is extensible to create custom
format like json-ld, xml etc.  
To do that, you need to implement the interface Tounaf\ExceptionBundle\FormatResponse\FormatResponseCheckerInterface.  
This interface have a method setFormat(FormatResponseInterface $formatResponse) that accepts FormatResponseInterface as argument.

```php
<?php

namespace App\Handler\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tounaf\ExceptionBundle\ExceptionHandlerInterface;
use Tounaf\ExceptionBundle\FormatResponse\FormatResponseCheckerInterface;

class MyExceptionHandler implements ExceptionHandlerInterface, FormatResponseCheckerInterface
{
    private FormatResponseInterface $formatResponse;

    // return an JsonResponse
    public function handleException(\Throwable $throwable): Response
    {
        // your logic
        return $this->formatResponse->render(
            ['message' => $throwable->getMessage()]
        )
    }

    // 
    public function supportsException(\Throwable $throwable): Response
    {
        return $throwable instanceof MyException;
    }

    public function setFormat(FormatResponseInterface $formatResponse): void
    {
        $this->formatResponse = $formatResponse;
    }
}

```

What happen with this code ? As said at the top, this bundle provides two responses by default : html and json. Which of these formats on this code ?
For the URI that match /api/, the response used is json else html is rendered.
