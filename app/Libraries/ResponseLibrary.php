<?php

namespace App\Libraries;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * ResponseLibrary untuk mempermudah response API.
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Models
 * @copyright  (c) 2019, Odenktools Technology
 */
class ResponseLibrary
{
    private $errorMessages = null;

    public function successResponse()
    {
        $return = [];
        $return['meta']['code'] = 200;
        $return['meta']['message'] = trans('message.api.success');
        return $return;
    }

    public function createResponse($code, array $data = [], $message = null)
    {
        $return = [];
        $return['meta']['code'] = $code;
        $return['meta']['message'] = $message === null ? trans('message.api.success') : $message;
        $return['results'][] = $data;
        return $return;
    }

    public function errorResponse(\Exception $e)
    {
        $return = [];
        $return['meta']['code'] = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
        $return['meta']['message'] = trans('message.api.error');
        $return['meta']['error'] = $e->getMessage();
        return $return;
    }

    public function failResponse($code, $errors)
    {
        $return = [];
        $return['meta']['code'] = $code;
        $return['meta']['message'] = trans('message.api.error');
        $return['meta']['errors'] = $errors;
        $return['data'] = [];
        return $return;
    }

    public function validationFailResponse($errors)
    {
        $return = [];
        $return['meta']['code'] = 422;
        $return['meta']['message'] = trans('message.api.error');
        $return['meta']['errors'] = $errors;
        $return['data'] = [];
        return $return;
    }

    public function setErrorMessage($message)
    {
        $this->errorMessages = $message;
        $return = [];
        $return['meta']['code'] = 400;
        $return['meta']['message'] = $this->errorMessages;
        $return['data'] = [];
        return $return;
    }

    public function getErrorMessage()
    {
        return $this->errorMessages;
    }
}
