<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Post;

class DeleteBlogPostRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $id = $this->route('id');

        return Post::where('id', $id)
                ->where('author_id', \Auth::id())->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
