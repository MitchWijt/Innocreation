<?php

namespace App\Http\Controllers;

use App\Expertises;
use App\Expertises_linktable;
use App\NeededExpertiseLinktable;
use App\Services\UserAccount\UserExpertises;
use App\Services\UserAccount\UserNotifications;
use App\Team;
use App\UserChat;
use App\UserMessage;
use App\UserPortfolioFile;
use App\UserWork;
use App\WorkspaceShortTermPlannerBoard;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\ServiceReview;
use App\MailMessage;
use App\Payments;
use App\SiteSetting;
use App\TeamPackage;
use App\SplitTheBillLinktable;
use App\Http\Requests;
use Monolog\Handler\SyslogUdp\UdpSocket;
use Spipu\Html2Pdf\Html2Pdf;
use App\Invoice;
use GetStream;
use DateTime;
use GetStream\StreamLaravel\Facades\FeedManager;
use App\Services\AppServices\UnsplashService as Unsplash;
use App\Services\AppServices\MailgunService as Mailgun;
use Session;
use Spipu\Html2Pdf\Tag\Html\Em;

class DebugController extends Controller
{
    /**
     *
     */

    public function test(Request $request, Unsplash $unsplash, Mailgun $mailgunService, UserNotifications $userNotifications) {
        return UserExpertises::getSkillLevel(2);
        die('test');
    }
}
