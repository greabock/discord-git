<?php
/**
 * Created by PhpStorm.
 * User: Greabock
 * Date: 04.09.2016
 * Time: 18:48
 */

namespace App\Http\Requests;


use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Http\FormRequest;

class StoreHandlerRequest extends FormRequest
{
    public function rules(Guard $guard)
    {
        return [
            'channels' => 'required',
            'routes' => 'required',
            'type'     => 'required|in:as is,json',
        ];
    }

    public function authorize()
    {
        return true;
    }
}