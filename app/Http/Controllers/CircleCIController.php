<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CircleCIController extends Controller
{
    public function getAllNotifications()
    : JsonResponse {

        return response()->json();
    }

    public function handleNotification()
    : JsonResponse {

        return response()
            ->json(null, Response::HTTP_NO_CONTENT);
    }
}
