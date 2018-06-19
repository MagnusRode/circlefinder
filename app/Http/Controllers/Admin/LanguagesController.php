<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Traits\ResourceCrud;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class LanguagesController extends Controller
{
    use ResourceCrud;

    public function __construct()
    {
        $this->model = \App\Language::class;
        $this->indexRoute = 'admin.languages.index';
        $this->trashRoute = 'admin.languages.trash';
        $this->viewFolder = 'admin.languages';

        $this->validationRules = [
            'code' => 'required|alpha_dash|unique:languages,code',
            'title' => 'required',
        ];

        $this->validationRuleIdSuffix = ['code'];

        $this->setupCrud();
    }
}
