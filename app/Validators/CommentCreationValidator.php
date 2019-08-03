<?php
/**
 * Created by PhpStorm.
 * User: hybeecodes
 * Date: 7/16/19
 * Time: 9:36 PM
 */
namespace App\Validators;

use App\Exceptions\ValidationFailedException;
use Illuminate\Support\Facades\Validator;

class CommentCreationValidator extends Validator implements ValidatorInterface
{
    /**
     * @author Ibiniyi Obikoya <obikoya11@gmail.com>
     * @param $data
     * @throws ValidationFailedException
     */
    public static function run($data)
    {
        $validation = Validator::make($data, [
            'message' => 'required|string',
            'user_id' => 'required|integer'
        ]);

        if ($validation->fails()) {
            throw new ValidationFailedException($validation->errors(), 400);
        }
    }
}

