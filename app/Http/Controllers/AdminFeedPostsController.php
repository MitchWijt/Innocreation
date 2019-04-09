<?php

namespace App\Http\Controllers;

use App\Services\AdminServices\AdminFeedPostsService;
use App\Services\AppServices\MailgunService;
use App\Services\AppServices\StreamService;
use App\Services\FeedServices\UserworkPost;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminFeedPostsController extends Controller
{
    public function indexAction(AdminFeedPostsService $adminFeedPostsService){
        return $adminFeedPostsService->index();
    }

    public function approvePostAction(Request $request, AdminFeedPostsService $adminFeedPostsService, StreamService $streamService, MailgunService $mailgunService, UserworkPost $userworkPost){
        return $adminFeedPostsService->approvePost($request, $streamService, $mailgunService, $userworkPost);
    }

    public function declinePostAction(Request $request, AdminFeedPostsService $adminFeedPostsService, StreamService $streamService, MailgunService $mailgunService, UserworkPost $userworkPost){
        return $adminFeedPostsService->declinePost($request, $streamService, $mailgunService, $userworkPost);
    }
}
