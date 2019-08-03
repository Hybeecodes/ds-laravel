<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Exceptions\EntityDoesNotExistException;
use App\Exceptions\EntityNotCreatedException;
use App\Exceptions\ValidationFailedException;
use App\Story;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Validators\CommentCreationValidator;

class CommentController extends Controller
{
    //
    public function new(Request $request, $id)
    {
        try {
            // validate data
            CommentCreationValidator::run($request->post());
//            return 'hfjjf';
            // check if story is exists
            $story = Story::find($id);
            $user = User::find($request->post('user_id'));
            if(!$story || !$user){
                throw new EntityDoesNotExistException("Invalid comment Data", 404);
            }
            $commentData = new Comment([
                'message' => $request->post('message'),
                'user_id' => $request->post('user_id')
            ]);
            $newComment = $story->comments()->save($commentData);
            if(!$newComment){
                throw new EntityNotCreatedException("Sorry, an error occurred", 500);
            }
            return response()->json($newComment, 200);
        } catch (EntityDoesNotExistException $exception) {
            //throw $th;
            return response()->json(['message'=> $exception->getMessage()], $exception->getCode());
        }catch (EntityNotCreatedException $exception) {
            //throw $th;
            return response()->json(['message'=> $exception->getMessage()], $exception->getCode());
        }catch(ValidationFailedException $exception) {
            return response()->json(['message'=> $exception->getMessage()], $exception->getCode());
        }
    }

}
