<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Checks if a request is empty or not
     * @param Request $request
     * @return bool
     */
    public function empty(Request $request)
    {
        if ($request->has('_token')) {
            return count($request->all()) <= 1;
        } else {
            return count($request->all()) == 0;
        }
    }
}
