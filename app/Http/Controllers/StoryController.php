<?php

namespace App\Http\Controllers;

use App\Events\StoryCreated;
use App\Exceptions\CouldNotUpdateEntityException;
use App\Exceptions\EntityDoesNotExistException;
use App\Exceptions\EntityNotCreatedException;
use App\Exceptions\InvalidTagException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\ValidationFailedException;
use App\Notifications\StoryCreatedNotification;
use App\Story;
use App\StoryTag;
use App\StoryView;
use App\Tag;
use App\User;
use App\Validators\StoryCreationValidator;
use App\Validators\StoryUpdateValidator;
use App\Validators\StoryViewValidator;
use http\Env\Response;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    //
    public function create(Request $request)
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
            $eventData = compact( 'newStory');
            event(new StoryCreated($eventData));
            return response()->json($newStory, 201);
        }catch (\Exception $exception){
            dd($exception);
            return response()->json(["message" => $exception->getMessage()], $exception->getCode());
        }
    }

    public function update(Request $request, $id)
    {
        try{
            StoryUpdateValidator::run($request->post());
            $story = Story::find($id);
//            $story->fill($request->post())
            if(!$story){
                throw new EntityDoesNotExistException("Story Entity Does not exist",404);
            }
            $updated = Story::where('id',$id)->update(["title" => $request->post('title'), "body" => $request->post('body')]);
            if(!$updated){
                throw new CouldNotUpdateEntityException("Sorry, Unable to Update Story", 500);
            }
            return response()->json($updated, 200);
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
        $stories = Story::with(['tags', 'author'])->get();
        return response()->json($stories, 200);
    }

    public function getOne(Request $request, $id)
    {
        $story = Story::where(['id'=>$id])->with('tags')->get();
        return response()->json($story, 200);
    }

    public function getStoryWithComment(Request $request, $id)
    {
        $story = Story::where(['id' => $id])->with(['tags', 'comments', 'author'])->get();
        return response()->json($story, 200);
    }

    public function popular(Request $request)
    {

    }

    public function getStoryByTag(Request $request, $tag_id)
    {
        try{
            // check if tag exists
            $tag = Tag::find($tag_id);
            if(!$tag){
                throw new EntityDoesNotExistException("Tag does not exist", 404);
            }
            $stories = $tag->stories;
            return response()->json($stories, 200);
        }catch(EntityDoesNotExistException $exception) {
            dd($exception);
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }

    }

    public function newView(Request $request, $id)
    {
        try{
            StoryViewValidator::run($request->post());
            $story = Story::find($id);
            if(!$story){
                throw new EntityDoesNotExistException("Story does not exist", 404);
            }
            $view = new StoryView($request->post());
            if(!$story->views->save($view)){
                throw new EntityNotCreatedException('Unable to add views', 500);
            }
            return response()->json([], 201);
        }catch(EntityDoesNotExistException $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
    }

    public function getViews(Request $request, $id)
    {
        try{
            $story = Story::where(['id' => $id])->with('views')->get();
            if(!$story){
                throw new EntityDoesNotExistException("Story does not exist", 404);
            }
            return response()->json($story, 200);
        }catch(EntityDoesNotExistException $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
    }

}
