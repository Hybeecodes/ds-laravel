<?php
/**
 * Created by PhpStorm.
 * User: hybeecodes
 * Date: 7/22/19
 * Time: 10:34 PM
 */
namespace App\Validators;

use App\Exceptions\ValidationFailedException;
use Illuminate\Support\Facades\Validator;

class StoryUpdateValidator extends Validator implements ValidatorInterface
{
    /**
     * @author Ibiniyi Obikoya <obikoya11@gmail.com>
     * @param $data
     * @throws ValidationFailedException
     */
    public static function run($data)
    {
        $validation = Validator::make($data, [
            'title' => 'required|string|min:5|unique:stories',
            'body' => 'required|string',
            'tags' => 'required|array|min:1'
        ]);

        if ($validation->fails()) {
            throw new ValidationFailedException($validation->errors(), 400);
        }
    }
}

