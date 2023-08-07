<?php

namespace Tounaf\ExceptionBundle\Exception;

abstract class AbstractException implements ExceptionInterface
{
    /**
     * @param \Exception $exception
     *
     * @return array
     */
    protected function getMessageParts(\Exception $exception)
    {
        $message = $exception->getMessage();
        $customResponse = array(
            'message' => $message,
        );
        if (strpos($message, '|') !== false) {
            list($title, $message, ) = explode('|', $message);
            $customResponse['message'] = $message;
            $customResponse['title'] = $title;
        }

        return $customResponse;
    }

}
