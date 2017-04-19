<?php namespace VnsModules\Slide;

use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'slug' => 'required',
            'image' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>  __('This is a required field.'),
            'slug.required' =>  __('This is a required field.'),
            'image.required' =>  __('This is a required field.')
        ];
    }

}