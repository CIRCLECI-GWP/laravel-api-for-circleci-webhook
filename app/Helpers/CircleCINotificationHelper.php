<?php


namespace App\Helpers;

use App\Models\WebhookNotification;
use Illuminate\Http\{Request, Response};

class CircleCINotificationHelper {

    public static function handle(Request $request)
    : void {

        \Log::info('Received CircleCI Webhook:', $request->all());

        \Log::info('Received CircleCI Webhook:', $request->toArray());


        $circleCISignature = $request->headers->get('circleci-signature');

        if (!$circleCISignature) {
            abort(Response::HTTP_BAD_REQUEST, 'Missing Circleci-Signature header');
        }

        self::validate($circleCISignature, $request->getContent());

        $requestContent = $request->toArray();
        $hasVCSInfo = isset($requestContent['pipeline']['vcs']);

        $notificationType = $requestContent['type'];

        $notificationDetails = [
            'notification_id' => $requestContent['id'],
            'type'            => $notificationType,
            'happened_at'     => $requestContent['happened_at'],
            'workflow_url'    => $requestContent['workflow']['url'],
            'has_vcs_info'    => $hasVCSInfo,
        ];

        if ($hasVCSInfo) {
            $commitDetails = $requestContent['pipeline']['vcs']['commit'];
            $notificationDetails['commit_subject'] = $commitDetails['subject'];
            $notificationDetails['commit_author'] = $commitDetails['author']['name'];
        }

        $notificationDetails['event_status'] = $notificationType === 'job-completed'
            ? $requestContent['job']['status']
            : $requestContent['workflow']['status'];

        $webhookNotification = new WebhookNotification($notificationDetails);

        $webhookNotification->save();
    }

    private static function validate(?string $signature, string $requestContent): void
    {
        if (!$signature) {
            abort(Response::HTTP_BAD_REQUEST, 'Missing Circleci-Signature header');
        }

        // Extract the hash value after "sha256="
        $receivedSignatureParts = explode('=', $signature);
        if (count($receivedSignatureParts) !== 2) {
            abort(Response::HTTP_UNAUTHORIZED, 'Invalid Signature Format');
        }

        $receivedSignature = $receivedSignatureParts[1];

        // Get the secret from .env
        $secret = env('CIRCLE_CI_WEBHOOK_SECRET');
        if (!$secret) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Webhook secret not set in environment');
        }

        // Generate the HMAC signature
        $generatedSignature = hash_hmac('sha256', $requestContent, $secret);

        // Log both received and generated signatures for debugging
        \Log::info('Received Signature: ' . $receivedSignature);
        \Log::info('Generated Signature: ' . $generatedSignature);
        \Log::info('Raw Request Content: ' . $requestContent);

        // Verify the signature
        abort_if(
            !hash_equals($generatedSignature, $receivedSignature),
            Response::HTTP_UNAUTHORIZED,
            'Invalid Signature Provided'
        );
    }


//    private static function validate(string $signature, string $requestContent)
//    : void {
//
//        if (!$signature) {
//            abort(Response::HTTP_BAD_REQUEST, 'Missing Circleci-Signature header');
//        }
//
//        $receivedSignature = explode('=', $signature)[1] ?? null;
//
//        if (!$receivedSignature) {
//            abort(Response::HTTP_UNAUTHORIZED, 'Invalid Signature Format');
//        }
//
//        $generatedSignature = hash_hmac(
//            'sha256',
//            $requestContent,
//            env('CIRCLE_CI_WEBHOOK_SECRET')
//        );
//
//        abort_if(
//            $receivedSignature !== $generatedSignature,
//            Response::HTTP_UNAUTHORIZED,
//            'Invalid Signature Provided'
//        );
//    }
}
