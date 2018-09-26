<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseApiFormReq extends FormRequest {

    protected function failedValidation(Validator $validator) {
        $laravel = app();
        $version = $laravel::VERSION;
        if (substr($version, 0, 3) == '5.4') {
            $errors = $validator->messages()->messages();
        } else {
            $errors = (new ValidationException($validator))->errors();
        }

        $transformed = [];
        foreach ($errors as $field => $message) {
            $transformed[] = [
                'field' => $field,
                'message' => $message[0]
            ];
        }
        if ($this->statusCode == 400) {
            $statusResponse = JsonResponse::HTTP_BAD_REQUEST;
        } else {
            $statusResponse = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
        }
        throw new HttpResponseException(response()->json(['status' => 'failed', 'errors' => $transformed
                ], $statusResponse));
    }

}
