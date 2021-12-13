<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\User;
use App\Models\UserPosts;
use Illuminate\Support\Facades\Validator;


use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * @author Klejdi Arapi
     *
     * 
     */

    public function index(Request $request)
    {
        /**
         * Fetch all posts from the Database
         */        

            $posts = Posts::all();
            return $posts;
    }

    public function userPost($id)
    {
        /**
         * Fetch all posts for the selected user
         */        

            $posts = Posts::where('user_id', $id)->get();
            return $posts;
    }

    public function sortItems(Request $request)
    {
        /**
         * Sort movies based on their likes,hates,date
         */        

        if($request->input('user_id') != null) {
        $posts = Posts::orderBy($request->input('type'), 'desc')->where('user_id', $request->input('user_id'));
        } else {
        $posts = Posts::orderBy($request->input('type'), 'desc'); 
        }

        return $posts->get();
    }

    public function retractVote(Request $request)
    {
        /**
         * Method use to retract an user voto if detected
         */        

         $id =  $request->input('id');
         $user_id =  $request->input('user_id');
         $type =  $request->input('type');

        $vote = UserPosts::where('post_id', $id)->where('user_id', $user_id);
        
        $vote->delete();

        $likes = count(UserPosts::where('post_id', $id)->where('type', 1)->get());
        $hates = count(UserPosts::where('post_id', $id)->where('type', 0)->get());

        $item = Posts::where('id',$id);

        $item = $item->get();
        
        $post_edit = Posts::find($id);
        
        $post_edit->likes = $likes;
        $post_edit->hates = $hates;

        $post_edit->save();

        } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() { }


     /**
      * 
      *  Store method used to add new movies to the database
      *
      */

    public function store(Request $request)
    {

            $validator = Validator::make($request->all(), [               
                'title' => 'bail|required|string|max:255',
                'description' => 'bail|required|string|max:255',
            ]);

            if ($validator->fails()) {    
                return response()->json(["errors" => "Both fields required!"], 406);
            }

            $posts = new Posts([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'user_id' => $request->input('user_id'),
            'user' => $request->input('username'),

        ]);

        $posts->save();

        return response()->json(' Movie Added!');
    }

    /**
     * Method used to check if a movie post is liked
     */
    public function checkLike(Request $request)
    {
        $post_id = $request->input('id');
        $user_id = $request->input('user_id');

        $liked = UserPosts::where('post_id', $post_id)->where('user_id', $user_id)->get();

        if (count($liked) > 0) {    
            return response()->json(["type" => $liked[0]->type], 200);
        } else {
            return response()->json(["isVoted" => false], 406);
        }
    }

    /**
     * 
     * 
     * 
     */

    public function likeItem(Request $request) 
    {
        $item = UserPosts::where('post_id', [$request->input('post_id')])->where('user_id', $request->input('user_id'));
        
        if(count($item->get()) > 0){
            
            $item = $item->get();

            if($item[0]->type == 0){

                $post_edit = Posts::find($request->input('post_id'));

                $post_edit->hates = $post_edit->hates - 1;

                $post_edit->save();
            }
        } 

        $like = new UserPosts([
            'user_id' => $request->input('user_id'),
            'post_id' => $request->input('post_id'),
            'type' => 1,
        ]);
        

        $post_edit = Posts::find($request->input('post_id'));
        $likes = $post_edit->likes;
        if($likes >= 0) { 
        $post_edit->likes = $post_edit->likes + 1;
        }

        $toDelete = UserPosts::where('post_id', [$request->input('post_id')])->where('user_id', $request->input('user_id'));

        if($toDelete)
        $toDelete->delete();

        $like->save();

        $post_edit->save();
        
    }

    /**
     * 
     * 
     * 
     */

    public function hateItem(Request $request) 
    {
        $item = UserPosts::where('post_id', [$request->input('post_id')])->where('user_id', $request->input('user_id'));

        if(count($item->get()) > 0){

            $item = $item->get();

            if($item[0]->type == 1){
                $post_edit = Posts::find($request->input('post_id'));

                $post_edit->likes = $post_edit->likes - 1;

                $post_edit->save();

                }
        } 

        $like = new UserPosts([
            'user_id' => $request->input('user_id'),
            'post_id' => $request->input('post_id'),
            'type' => 0,
        ]);
        

        $post_edit = Posts::find($request->input('post_id'));
        $hates = $post_edit->hates;
        if($hates >= 0) { 
        $post_edit->hates = $post_edit->hates + 1;
        }

        $toDelete = UserPosts::where('post_id', [$request->input('post_id')])->where('user_id', $request->input('user_id'));

        if($toDelete)
        $toDelete->delete();

        $like->save();

        $post_edit->save();

    }

    /**
     * 
     * 
     * 
     * 
     */

    public function show($id)
    {
        $post = Posts::find($id)->get();

        return $post->toArray();
    }

    /**
     * 
     * 
     * 
     * 
     */
    public function destroy($id)
    {
        $post = Posts::find($id);
        
        $post->delete();
    }
}
