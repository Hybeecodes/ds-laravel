<?php
/**
 * Created by PhpStorm.
 * User: hybeecodes
 * Date: 7/16/19
 * Time: 4:00 PM
 */

namespace App\Validators;

use App\Exceptions\ValidationFailedException;
use Illuminate\Support\Facades\Validator;

class AuthAccountLoginValidator extends Validator implements ValidatorInterface
{
    /**
     * @author Babatunde Otaru <babatunde@platformlead.com>
     * @param $data
     * @throws ValidationFailedException
     */
    public static function run($data)
    {
        $validation = Validator::make($data, [
            'email' => 'required',
            'password' => 'required',
            'remember_me' => 'boolean'
        ]);

        if ($validation->fails()) {
            throw new ValidationFailedException($validation->errors(), 400);
        }
    }
}

