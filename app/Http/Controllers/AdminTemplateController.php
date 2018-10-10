<?php

namespace App\Http\Controllers;

use App\Country;
use App\CustomerIdea;
use App\CustomerIdeaStatus;
use App\CustomMembershipPackage;
use App\CustomMembershipPackageType;
use App\Expertises;
use App\Expertises_linktable;
use App\Faq;
use App\FaqType;
use App\ForumMainTopic;
use App\ForumMainTopicType;
use App\ForumThread;
use App\InviteRequestLinktable;
use App\Invoice;
use App\JoinRequestLinktable;
use App\MailMessage;
use App\MailTemplate;
use App\MembershipPackage;
use App\NeededExpertiseLinktable;
use App\Page;
use App\PageType;
use App\ServiceReview;
use App\SupportTicket;
use App\SupportTicketStatus;
use App\Team;
use App\TeamGroupChatLinktable;
use App\User;
use App\UserChat;
use App\UserMessage;
use App\WorkspaceShortTermPlannerTask;
use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AdminTemplateController extends Controller
{
    public function mailTemplateListAction(){
        $mailTemplates = MailTemplate::select("*")->get();
        return view("/admin/templates/mailTemplateList", compact("mailTemplates"));
    }

    public function mailTemplateEditorAction($id = null){
        if ($this->authorized(true)) {
            if($id){
                $mailTemplate = MailTemplate::select("*")->where("id", $id)->first();
                return view("/admin/templates/mailTemplateEditor", compact("mailTemplate"));
            } else {
                return view("/admin/templates/mailTemplateEditor");
            }
        }
    }

    public function saveMailTemplateAction(Request $request){
        $mailTemplateId = $request->input("mail_template_id");
        $subject = $request->input("title");
        $content = $request->input("content");

        if($mailTemplateId){
            $mailTemplate = MailTemplate::select("*")->where("id", $mailTemplateId)->first();
        } else {
            $mailTemplate = new MailTemplate();
            $mailTemplate->created_at = date("Y-m-d H:i:s");
        }

        $mailTemplate->subject = $subject;
        $mailTemplate->content = $content;
        $mailTemplate->save();

        return redirect("/admin/mailTemplateList");
    }
}