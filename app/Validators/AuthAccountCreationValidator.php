<?php


namespace App\Validators;

use App\Exceptions\ValidationFailedException;
use Illuminate\Support\Facades\Validator;

class AuthAccountCreationValidator extends Validator implements ValidatorInterface
{
    /**
     * @author Babatunde Otaru <babatunde@platformlead.com>
     * @param $data
     * @throws ValidationFailedException
     */
    public static function run($data)
    {
        $validation = Validator::make($data, [
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:7',
            'name' => 'required|string|min:3'
        ]);

        if ($validation->fails()) {
            throw new ValidationFailedException($validation->errors(), 400);
        }
    }
}
