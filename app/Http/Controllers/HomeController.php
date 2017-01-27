<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\post;
use App\profile;
use App\User;
use App\info;
use App\img;
use App\comment;
use App\follow;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        if(Auth::guest())
        {
            return view('welcome');
        }
        else
        {
            if(Auth::user()->profile == null)
            {
                $profile = new profile();
                $profile->user_id = Auth::user()->id;
                $profile->save();
            }
            $users = User::get();
            $posts = post::orderBy('id', 'DESC')->get();
            return view('home', compact('posts'), compact('users'));   
        }
    }
    
    public function index(Request $request)
    {
        $user = User::find($request->id);
        if($user != null)
        {
            $posts = post::where('profile_id', $user->profile->id)->orderBy('id', 'DESC')->get();
            $follow = follow::where('profile_id', $user->profile->id)->where('user_id', Auth::user()->id)->first();
            $bool = false;
            if($follow)
            {
                $bool = true;
            }
            return view('pages.profile', compact('user') , compact('posts'))->with('follow', $bool);
        }
        return redirect()->route('main');
    }
    
    public function post(Request $request)
    {
        if($request != null)
        {
            $post = new post();
            $user = Auth::user();
            $img = new img();
            if($request->post != null)
            {
                $post->text = $request->post;
            }
            $post->user_id = $user->id;
            if($request->profuser == "admin"){
                $post->profile_id = Auth::user()->profile->id;
            }
            else{
                $post->profile_id = $request->profuser;
            }
            $post->save();
            if($request->file('img') != null)
            {
                $file = $request->file('img');
                if (!is_dir("images/" . $user->id )) {
                    mkdir("images/" . $user->id , 0777, true);
                }
                $request->file('img')->move("images/" . $user->id .'/', $_FILES["img"]["name"]);
                $img->link = "/images/" . $user->id . '/' .$_FILES["img"]["name"];
                $img->user_id = $user->id;
                $img->post_id = $post->id;
                $img->save();
            }
        }
        return back();
    }
    
    public function search(Request $request)
    {
        if($request->key != null)
        {
            $user = User::where('email',$request->key)->first();
            if($user != null)
            {
                return redirect()->route('profile', ['id' => $user->id]);
            }
            else
            {
                $user = User::where('name',$request->key)->first();
                if($user != null)
                {
                return redirect()->route('profile', ['id' => $user->id]);
                }       
            }
        }
        return back();
    }
    
    public function edit(Request $request)
    {
        $this->validate($request,[
            'body' => 'required'    
        ]);
        $post = post::find($request['postid']);
        $post->text = $request['body'];
        $post->update();
        return response()->json(['new_body' => $post->text], 200);
    }
    
    public function delete(Request $request)
    {
        $post = post::find($request['id']);
        $post->delete();
        return back();
    }
    
    public function info(Request $request)
    {
        if($request != null)
        {
            $user = Auth::user();
            if($user->info == null)
            {
                $info = new info();
                $info->user_id = $user->id;
                $info->save();
            }
            if($request->file('img') != null)
            {
                $file = $request->file('img');
                if (!is_dir("images/" . $user->id ."/prof" )) {
                    mkdir("images/" . $user->id ."/prof" , 0777, true);
                }
                $request->file('img')->move("images/" . $user->id . '/prof/' , $_FILES["img"]["name"]);
                $profile = profile::where('user_id', Auth::user()->id)->first();
                if($profile->img)
                {
                    $img = img::where('profile_id',$user->profile->id)->first();
                    $img->profile_id = 0;
                    $img->update();
                }
                $img = new img();
                $img->link = "/images/" . $user->id . '/prof/' . $_FILES["img"]["name"];
                $img->user_id = $user->id;
                $img->profile_id = $profile->id;
                $img->save();
                return back();
            }
            if($request->txt != null){
                $user->info->about = $request->txt;
            }
            if($request->date != null){
                $user->info->date = $request->date;
            }
            if($request->edu != null){
                $user->info->edu = $request->edu;
            }
            $user->info->update();
        }
        return back();
    }
    
    public function prof(Request $request)
    {
        if($request != null)
        {
            $img = img::where('profile_id', Auth::user()->profile->id)->first();
                if($img != null)
                {
                    $img->profile_id = 0;
                    $img->update();
                }   
            $img = img::find($request->id);
            $img->profile_id = Auth::user()->profile->id;
            $img->update();
        }
        return back();
    }
    
    public function follow(Request $request)
    {
        $follow = new follow();
        $follow->profile_id = $request->profile_id;
        $follow->user_id = Auth::user()->id;
        $follow->save();
        return back();
    }
    
    public function unfollow(Request $request)
    {
        $follow = follow::where('profile_id', $request->profile_id)->where('user_id', Auth::user()->id)->first();
        $follow->delete();
        return back();
    }
    
    public function repost(Request $request)
    {
        $oldpost = post::where('id', $request->id)->first();
        $post = $oldpost->replicate();
        $post->user_id = Auth::user()->id;
        $post->profile_id = Auth::user()->profile->id;
        $post->save();
        return back();
    }
    
    public function comment(Request $request)
    {
        $comm = new comment();
        $comm->post_id = $request->postid;
        $comm->user_id = Auth::user()->id;
        $comm->com = $request->comment;
        $comm->save();
        return back();
    }
}













