<?php

namespace App\Http\Controllers;

use App\Helpers\CircleCINotificationHelper;
use App\Models\WebhookNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CircleCIController extends Controller
{
//    public function getAllNotifications()
//    : JsonResponse {
//
//        return response()->json(WebhookNotification::all());
//    }

//    public function handleNotification(Request $request)
//    : JsonResponse {
//
//        return response()->json([$request->headers->all(), $request->all()]);

//        CircleCINotificationHelper::handle($request);
//
//        return response()
//            ->json(null, Response::HTTP_NO_CONTENT);
//    }


    public function handleNotification(Request $request)
    {
        return response()->json(['message' => 'POST received!']);
    }

    public function getAllNotifications()
    {
        return response()->json(['message' => 'GET request received!']);
    }
}
