<?php

namespace Tounaf\ExceptionBundle\Exception;

abstract class AbstractException implements ExceptionHandlerInterface
{
    /**
     * @param \Exception $exception
     *
     * @return array
     */
    protected function getMessageParts(\Exception $exception)
    {
        $message = $exception->getMessage();
        $customResponse = [
            'message' => $message,
        ];
        if (strpos($message, '|') !== false) {
            list($title, $message, ) = explode('|', $message);
            $customResponse['message'] = $message;
            $customResponse['title'] = $title;
        }

        return $customResponse;
    }

}
