<?php

namespace App\Traits;

use Illuminate\Http\Response;
use App\Handlers\API\V1\ResponseHttpHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

trait ValidatesAndPreparesRequestData
{
    /**
     *  Response to request rejected when using a request in the controller.
     *
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = ResponseHttpHandler::sendError(
            $validator->errors()->first(),
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $validator->errors()
        );
        throw new ValidationException($validator, $response);
    }

    /**
     * Prepares data for validation before validation occurs.
     */
    protected function prepareForValidation(): void
    {
        foreach ($this->prepareForValidationFields() as $field) {
            if ($this->route($field)) {
                $this->merge([$field => $this->route($field)]);
            }
        }
    }

    /**
     * Gets the fields for which data will be prepared for validation.
     *
     * @return array
     */
    abstract protected function prepareForValidationFields(): array;
}
