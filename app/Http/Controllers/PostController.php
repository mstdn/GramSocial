<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reply;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ConvertVideoForDownloading;
use App\Jobs\ConvertVideoForStreaming;

class PostController extends Controller
{
    public function index(Post $post, Request $request)
    {
        return Inertia::render('Posts/Index', [
            'posts' => Post::query()       
            ->latest()
            ->paginate(20)
            ->withQueryString()
            ->through(fn($post) => [
                'id'            =>  $post->id,
                'name'          =>  $post->user->name,
                'username'      =>  $post->user->username,
                'title'         =>  $post->title,
                'description'   =>  $post->description,
                'time'          =>  $post->created_at->diffForHumans(),
                'avatar'        =>  $post->user->getProfilePhotoUrlAttribute(),
                'userlink'      =>  '@' . $post->user->username,
                'media'         =>  'storage/' . $post->files,
                'delete'        =>  Auth::user()->id === $post->user_id,
                'status'        =>  $post->status,
                'isliked'       =>  $post->isLikedBy(auth()->user()),
                'likes'         =>  $post->likers()->count(),
                'delete'        =>  Auth::user()->id === $post->user_id || Auth::user()->id === 1,
                'replycount'    =>  $post->replies->count(),
                'downloadready' =>  $post->converted_for_downloading_at,
                'image'         =>  '/storage/' . $post->image,
                'hasimage'              =>  $post->image,
                // 'hlsready'      =>  $post->converted_for_streaming_at,
                'video'         =>  Storage::disk('public')->url('uploads/' . $post->user->id . '/' . 'videos/' . $post->id . '.mp4'),
                // 'hls'           =>  Storage::disk('public')->url('uploads/' . $post->user->id . '/' . 'videos/' . $post->id . '.m3u8')
            ])
        ]);
    }

    public function show(Post $post, Reply $reply)
    {
        if (Auth::user()) {
            $liked = $post->isLikedBy(Auth()->user());
            $delete = Auth::user()->id === $post->user_id || Auth::user()->id === 1;
            $deleteReply = Auth::user()->id === $reply->user_id || Auth::user()->id === 1;
        } else {
            $liked = null;
            $delete = false;
            $deleteReply = false;
        }

        return Inertia::render('Posts/Show', [
            'post' => [
                'id'                =>  $post->id,
                'description'       =>  $post->description,
                'avatar'            =>  $post->user->getProfilePhotoUrlAttribute(),
                'time'              =>  $post->created_at->diffForHumans(),
                'username'          =>  $post->user->username,
                'downloadready'     =>  $post->converted_for_downloading_at,
                // 'hlsready'          =>  $post->converted_for_streaming_at,
                'video'             =>  Storage::disk('public')->url('uploads/' . $post->user->id . '/' . 'videos/' . $post->id . '.mp4'),
                // 'hls'               =>  Storage::disk('public')->url('uploads/' . $post->user->id . '/' . 'videos/' . $post->id . '.m3u8'),
                'status'            =>  $post->status,
                'isliked'           =>  $liked,
                'likes'             =>  $post->likers()->count(),
                'delete'            =>  $delete,
                'replies'           =>  Reply::query()
                                        ->where('post_id', $post->id)
                                        ->latest()
                                        ->paginate(5)
                                        ->map(fn($reply) => [
                                            'id'        =>  $reply->id,
                                            'reply'     =>  $reply->reply,
                                            'time'      =>  $reply->created_at->diffForHumans(),
                                            'username'  =>  $reply->user->username,
                                            'avatar'    =>  $reply->user->getProfilePhotoUrlAttribute(),
                                            'link'      =>  '@' . $reply->user->username,
                                            'delete'    =>  $deleteReply,
                                        ]),
                'replycount'            =>  $post->replies->count(),
                'image'                 =>  '/storage/' . $post->image,
                'hasimage'              =>  $post->image,
                ]
            ]);
    }

    public function store(Request $request)
    {
        $post = $request->validate([
            'description'   =>  'required|min:1|max:500',
            'status'        =>  'required',
            'nsfw'          =>  'nullable|boolean',
            'image'         => ['nullable','mimes:jpg,jpeg,png,gif','max:500048'],
            'video'         =>  'nullable|file|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,video/mpeg,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi|max:10240',
        ]);
        
        $post['user_id'] = auth()->id();
        $storeURL = Str::random(16);

        if($request->hasFile('image')) 
        {
            $post = Post::create([
                'user_id'       =>  auth()->id(),
                'status'        =>  $request->status,
                'is_nsfw'       =>  $request->nsfw,
                'image'         =>  $request->file('image')->store('uploads/images', 'public'),
                'description'   =>  $request->description
            ]);

            return back();
        }

        if($request->hasFile('video')) 
        {
            $post = Post::create([
                'user_id'       =>  auth()->id(),
                'status'        =>  $request->status,
                'is_nsfw'       =>  $request->nsfw,
                'disk'          =>  'public',
                'original_name' =>  $request->file('video')->getClientOriginalName(),
                'path'          =>  $request->file('video')->store('uploads/' . $request['user_id'] . '/' . 'videos/' . $storeURL, 'public'),
                'description'   =>  $request->description
            ]);
            // $this->dispatch(new ConvertVideoForStreaming($attributes));
            $this->dispatch(new ConvertVideoForDownloading($post));

            return back();
        } else {
            $post = Post::create([
                'user_id'       =>  auth()->id(),
                'status'        =>  $request->status,
                'is_nsfw'       =>  $request->nsfw,
                'description'   =>  $request->description
            ]);

            return back();
        }
        
    }

    // Delete item
    public function destroy(Post $post) 
    {
        if (! Gate::allows('delete-post', $post)) {
            abort(403);
        }

        File::delete(public_path('uploads/videos/') . $post->id . '.mp4');

        // Delete the file
        File::delete($post->path);

        $post->delete();
        return redirect('/home')->with('message', 'Post deleted successfully.');
    }

    public function like(Post $post)
    {
        if(auth()->user()->hasLiked($post) ) {
            auth()->user()->unlike($post);
        } else {
       auth()->user()->toggleLike($post);
        }
        return back();
    }

}
