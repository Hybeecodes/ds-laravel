<?php
/**
 * Created by PhpStorm.
 * User: hybeecodes
 * Date: 7/26/19
 * Time: 9:20 PM
 */

namespace App\Validators;

use App\Exceptions\ValidationFailedException;
use Illuminate\Support\Facades\Validator;

class StoryViewValidator extends Validator implements ValidatorInterface
{
    /**
     * @author Ibiniyi Obikoya <obikoya11@gmail.com>
     * @param $data
     * @throws ValidationFailedException
     */
    public static function run($data)
    {
        $validation = Validator::make($data, [
            'user_id' => 'required|integer|unique:users'
        ]);

        if ($validation->fails()) {
            throw new ValidationFailedException($validation->errors(), 400);
        }
    }
}

