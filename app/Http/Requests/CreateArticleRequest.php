<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateArticleRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
          // 使用 | 設定驗證規則
          'title'         => 'required|min:3',
          'body'          => 'required|min:30',

          // 使用陣列設定驗證規則
          'published_at'  => [
            'required',
            'date',
          ]
        ];

        // 其他條件判斷
        if ($condition) {
            $rules['something_else'] = 'required';
        }

        return $rules;
    }
}
