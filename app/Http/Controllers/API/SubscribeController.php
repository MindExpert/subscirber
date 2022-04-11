<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SubscribeController extends Controller
{
    public function __invoke(Request $request, int $id)
    {
        /** @var User $user */
        $user = Auth::loginUsingId(1);

        /** @var Website $website */
        $website = Website::query()->findOrFail($id);

        $user->websites()->sync($website);

        return response()->json([
            'message' => "succesfully subscrbed to website {$website->name}",
        ],Response::HTTP_CREATED);
    }
}
