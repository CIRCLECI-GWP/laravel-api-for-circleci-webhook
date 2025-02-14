<?php

namespace App\Http\Controllers;

use App\Helpers\CircleCINotificationHelper;
use App\Models\WebhookNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CircleCIController extends Controller
{
    public function getAllNotifications()
    : JsonResponse {

        return response()->json(WebhookNotification::all());
    }

    public function handleNotification(Request $request)
    : JsonResponse {

        CircleCINotificationHelper::handle($request);

        return response()
            ->json(null, Response::HTTP_NO_CONTENT);
    }
}
