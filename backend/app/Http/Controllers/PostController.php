<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\CategoryPost;
use App\Models\Category;

class PostController extends Controller
{
    const S3_IMAGES_FOLDER 	= 'images/';
	/**
     * The Post model instance.
     */
	private $post;

	/**
     * The CategoryPost model instance.
     */
	private $categoryPost;

	/**
     * The Category model instance.
     */
	private $category;

	/**
	 * Post constructor.
	 * 
	 * @param Post $post
	 * @param CategoryPost $categoryPost
	 * @param Category $category
	 * 
	 * @return void
	 * 
	 **/
	public function __construct(Post $post, CategoryPost $categoryPost, Category $category)
	{
		$this->post 		= $post;
		$this->categoryPost = $categoryPost;
		$this->category 	= $category;
	}

	/**
     * Show the application create post.
     *
     * @return \Illuminate\View\View
     */
	public function create()
	{
		$categories = $this->category->get();

		return view('users.posts.create')->with('categories', $categories);
	}

	/**
     * Store post to database.
     *
     * @return \Illuminate\View\View
     */
	public function store(Request $request)
	{
		$categories = [];
		$request->validate([
			'category' 		=> 'required|array|between:1,3',
			'description' 	=> 'required|min:1|max:1000',
			'image' 		=> 'required|mimes:jpg,png,jpeg,gif|max:1048'
		]);

		# Create post first to get the post id 
		$post = $this->post->create([
			'user_id' 		=> Auth::user()->id,
			'image' 		=> $this->saveImage($request),
			'description' 	=> $request->description
		]);

		foreach($request->category as $category) {
			$categories[] = [
				'category_id' => $category,
				'post_id' => $post->id,
				'created_at' => NOW(),
				'updated_at' => NOW()
			];
		}

		$this->categoryPost->insert($categories);

		return redirect()->route('index');
	}


	/**
     * Show the application edit post.
     *
     * @param Integer $id
     * @return \Illuminate\View\View
     */
	public function edit($id)
	{
		$post 			= $this->post->findOrFail($id);
		$categoryPosts 	= $post->categoryPost->toArray();
		$categories 	= $this->category->get();

		foreach($post->categoryPost as $categoryPost) {
			$categoryPosts[$categoryPost->category_id] = $categoryPost->category_id;
		}

		return view('users.posts.edit')
				->with('post', $post)
				->with('categoryPosts', $categoryPosts)
				->with('categories', $categories);
	}

	/**
     * Update the resource.
     *
     * @param Integer $id
     * @return \Illuminate\View\View
     */
	public function update($id, Request $request)
	{
		$categories = [];
		$validated = $request->validate([
			'category' 		=> 'required|array|between:1,3',
			'description' 	=> 'required|min:1|max:1000',
			'image' 		=> 'mimes:jpg,png,jpeg,gif|max:1048'
		]);

		# fetch and delete related categories
		$this->categoryPost->where('post_id', $id)->delete();

		# update post
		$post 				= $this->post->findOrFail($id);
		$post->description 	= $request->description;

		if ($request->image) {
			$this->deletePostImage($id);
			$post->image = $this->saveImage($request);
		}

		$post->save();
		
		foreach($request->category as $category) {
			$categories[] = [
				'category_id' => $category,
				'post_id' => $post->id,
				'created_at' => NOW(),
				'updated_at' => NOW()
			];
		}

		$this->categoryPost->insert($categories);

		return redirect()->route('post.show', $id);
	}

	/**
     * Show the form for editing the specified resource.
     *
     * @param  Integer $id
     * @return View
     */
    public function show($id)
    {
        $post = $this->post->findOrFail($id);
        $categories = $post->categoryPost->pluck('category_id')->toArray();
        $comments = $post->comments->sortByDesc('id');

        return view('users.posts.show')
        		->with('post', $post)
				->with('categories', $categories)
				->with('comments', $comments);
    }

	/**
     * Delete the resource.
     *
     * @param Integer $id
     * @return \Illuminate\View\View
     */
	public function delete($id)
	{
		$this->post->findOrFail($id)->delete();

		return redirect()->route('index');
	}

    /**
     * Update and rename image file for saving in local / S3
     *
     * @param Request $request
     * @param Int $postId
     * @return String
     */
    private function saveImage($request, $postId = null)
    {
        # rename the image to remove the risk of overwriting 
        $name 	= time() . '.' . $request->image->extension();

        $request->image->storeAs(self::S3_IMAGES_FOLDER, $name, 's3');

        return $name;
    }

    /**
     * Delete post image when deleting the post
     *
     * @param Integer $postId
     * @return Void
     */
    public function deletePostImage($postId)
    {
        $postImage = $this->post->where('id', $postId)->pluck('image')->first();

        if ($postImage) {
        	$imgPath = elf::S3_IMAGES_FOLDER . $postImage;

            if (Storage::disk('s3')->exists($imgPath)) {
                Storage::disk('s3')->delete($imgPath);
            }
        }
    }
}
