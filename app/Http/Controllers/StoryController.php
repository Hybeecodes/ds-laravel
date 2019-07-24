<?php

namespace App\Http\Controllers;

use App\Exceptions\CouldNotUpdateEntityException;
use App\Exceptions\EntityDoesNotExistException;
use App\Exceptions\InvalidTagException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\ValidationFailedException;
use App\Story;
use App\StoryTag;
use App\Tag;
use App\User;
use App\Validators\StoryCreationValidator;
use App\Validators\StoryUpdateValidator;
use http\Env\Response;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    //
    public function createStory(Request $request)
    {
        try{
            // validate input
            StoryCreationValidator::run($request->post());
            $story = [
                "title" => $request->post('title'),
                "body" => $request->post('body'),
                "slug" => Story::makeSlug($request->post('title')),
                "user_id" => $request->user()->id
            ];
            $tags = $request->post('tags');
            // check if tags exists
            if(!empty($tags)){
                foreach ($tags as $tag){
                    if(!Tag::exists($tag)){
                        throw new InvalidTagException("Invalid tags Supplied", 400);
                        break;
                    }
                }
            }
            $user = $request->user();
            $author = User::find($user->id);
            if(!$author){
                throw new UserNotFoundException("Sorry, User doesn't exist", 400);
            }
            $newStory = Story::new($story);
            foreach ($tags as $tag){
                $story_tag = new StoryTag();
                $story_tag->create(['story_id' => $newStory->id, 'tag_id' => $tag]);
            }

            return response()->json($newStory, 201);
        }catch (\Exception $exception){
            return response()->json(["message" => $exception->getMessage()], $exception->getCode());
        }
    }

    public function update(Request $request, $id)
    {
        try{
            StoryUpdateValidator::run($request->post());
            $story = Story::find($id);
            if(!$story){
                throw new EntityDoesNotExistException("Story Entity Does not exist",404);
            }
            $story->fill($request->post());
            dd($story);
            if(!$story->save){
                throw new CouldNotUpdateEntityException("Sorry, Unable to Update Story", 500);
            }
            return response()->json($story, 200);
        }catch(Exception $exception){
//            dd($exception);
            return response()->json($exception->getMessage(), $exception->getCode());
        }

    }

    public function delete(Request $request, $id)
    {
        $story = Story::find($id);
        if($story){
            $story->delete();
            return response()->json([], 200);
        }
    }

    public function getAll(Request $request)
    {
        $stories = Story::with('tags')->get();
        return response()->json($stories, 200);
    }

    public function getOne(Request $request, $id)
    {
        $story = Story::where(['id'=>$id])->with('tags')->get();
        return response()->json($story, 200);
    }

}
