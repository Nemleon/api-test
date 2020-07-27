<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['name', 'post', 'title'];

    static public function createPost($author, $post, $title)
    {
        return Blog::create(['name' => $author, 'post' => $post, 'title' => $title])
            ->save();
    }

    static public function deletePost($postId)
    {
        return Blog::where('post_id', $postId)
            ->delete();
    }

    static public function getPostsByAuthor($author)
    {
        return Blog::where('name', $author)
            ->get();
    }

    static public function getPostByTitle($title)
    {
        return Blog::where('title', $title)
            ->get();
    }

    static public function updatePost($postId, $updateParams)
    {
        return Blog::where('post_id', $postId)
            ->update(
                $updateParams
            );
    }

}
