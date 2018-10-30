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
use App\Services\AdminServices\AdminExpertiseEditorService as AdminExpertiseEditorService;

use Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function statisticsAction(){
        if($this->authorized(true)){
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            $totalUsers = User::select("*")->get();
            $totalTeams = Team::select("*")->get();
            $totalTasks = WorkspaceShortTermPlannerTask::select("*")->get();
            $totalMessages = UserMessage::select("*")->get();
            $totalInvited = InviteRequestLinktable::select("*")->get();
            $totalRequests = JoinRequestLinktable::select("*")->get();

            $totalExpertises = Expertises::select("*")->get();
            return view("/admin/statistics", compact("user", "totalUsers", "totalInvited" , "totalMessages", "totalRequests", "totalTasks", "totalTeams", "totalExpertises"));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userAccountsListAction(){
        if($this->authorized(true)){
            $users = User::select("*")->where("deleted", 0)->get();
            return view("/admin/userAccountsList", compact("users"));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userEditorAction($id){
        if($this->authorized(true)) {
            $adminUser = User::select("*")->where("id", Session::get("user_id"))->first();
            $user = User::select("*")->where("id", $id)->first();
            $expertiseLinktables = Expertises_linktable::select("*")->where("user_id", $id)->get();
            $countries = Country::select("*")->get();
            $invoices = Invoice::select("*")->where("user_id", $id)->get();
            return view("/admin/userEditor", compact("user", "countries", "expertiseLinktables", "adminUser", "invoices"));
        }
    }

    public function sendUserMessageAction(Request $request){
        $userId = $request->input("user_id");
        $message = $request->input("message");

        $userChat = UserChat::select("*")->where("creator_user_id", 1)->where("receiver_user_id", $userId)->first();
        $userMessage = new UserMessage();
        $userMessage->sender_user_id = 1;
        $userMessage->user_chat_id = $userChat->id;
        $userMessage->time_sent = $this->getTimeSent();
        $userMessage->message = $message;
        $userMessage->created_at = date("Y-m-d H:i:s");
        $userMessage->save();
        return redirect("/admin/messages");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveUserAction(Request $request){
        if($this->authorized(true)) {
            $userId = $request->input("user_id");
            $user = User::select("*")->where("id", $userId)->first();

            $user->firstname = $request->input("firstname");
            if(strlen($request->input("middlename")) > 0) {
                $user->middlename = $request->input("middlename");
            }
            $user->lastname = $request->input("lastname");
            $user->email = $request->input("email");
            $user->city = $request->input("city");
            $user->postalcode = $request->input("postal_code");
            $user->state = $request->input("state");
            $user->phonenumber = $request->input("phonenumber");
            $user->country = $request->input("country");
            $user->motivation = $request->input("user_motivation");
            $user->introduction = $request->input("user_introduction");
            $user->updated_at = date("Y-m-d H:i:s");
            $user->save();
            return redirect($_SERVER["HTTP_REFERER"])->withErrors("test");
        }
    }

    /**
     * Show the form for editing the specifiesd resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveSingleUserExpertiseAction(Request $request){
        if($this->authorized(true)) {
            $expertiseLinktableId = $request->input("expertise_linktable_id");

            $expertiseLinktable = Expertises_linktable::select("*")->where("id", $expertiseLinktableId)->first();
            $expertiseLinktable->description = $request->input("expertise_description");
            $expertiseLinktable->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function teamListAction(){
        if($this->authorized(true)) {
            $teams = Team::select("*")->get();
            return view("/admin/teamList", compact("teams"));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteUserAction(Request $request){
        if ($this->authorized(true)) {
            $admin = User::select("*")->where("id", Session::get("admin_user_id"))->first();
            $userId = $request->input("user_id");
            $password = $request->input("password");
            if (Auth::attempt(['email' => $admin->email, 'password' => $password])) {
                $user = User::select("*")->where("id", $userId)->first();
                if($user->team_id != null){
                    $team = Team::select("*")->where("id", $user->team_id)->first();
                    if($user->id != $team->ceo_user_id && count($user->getJoinedExpertise()) != 0) {
                        $userJoinedExpertise = $user->getJoinedExpertise()->expertises->First()->id;
                        $neededExpertise = NeededExpertiseLinktable::select("*")->where("team_id", $user->team_id)->where("expertise_id", $userJoinedExpertise)->first();
                        $neededExpertise->amount = $neededExpertise->amount + 1;
                        $neededExpertise->save();
                    }
                }
                $user->delete();
                if($user->team_id != null) {
                    if (count($team->getMember()) < 1) {
                        $team->delete();
                    }
                }

                $userExpertisesLinktable = Expertises_linktable::select("*")->where("user_id", $userId)->get();
                foreach($userExpertisesLinktable as $userExpertise){
                    $userExpertise->delete();
                }

                return redirect("/admin/userAccounts")->with("success","User deleted");
            } else {
                return redirect($_SERVER["HTTP_REFERER"])->withErrors("Authentication failed");
            }
        }
    }

    public function switchLoginAction(Request $request){
        if ($this->authorized(true)) {
            $userId = $request->input("user_id");
            $user = User::select("*")->where("id", $userId)->with("team")->first();
            Session::set('user_name', $user->getName());
            Session::set('user_id', $user->id);
            if($user->team_id != null) {
                Session::set('team_id', $user->team_id);
                Session::set("team_name", $user->team->first()->team_name);
            }
            return redirect("/account");
        }
    }

    public function deleteUserProfilePictureAction(Request $request){
        if ($this->authorized(true)) {
            $userId = $request->input("user_id");

            $user = User::select("*")->where("id", $userId)->first();
            $exists = Storage::disk('spaces')->exists("users/" . $user->slug . "/profilepicture/" . $user->profile_picture);
            if ($exists) {
                Storage::disk('spaces')->delete("users/" . $user->slug . "/profilepicture/" . $user->profile_picture);
            }
            $user->profile_picture = "defaultProfilePicture.png";
            $user->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function teamEditorAction($id){
        if ($this->authorized(true)) {
            $admin = User::select("*")->where("id", Session::get("admin_user_id"))->where("role", 1)->first();
            $team = Team::select("*")->where("id", $id)->first();
            return view("/admin/teamEditor", compact("team", "admin"));
        }
    }

    public function saveTeamAction(Request $request){
        if ($this->authorized(true)) {
            $teamId = $request->input("team_id");
            $motivation = $request->input("team_motivation");
            $introduction = $request->input("team_introduction");

            $team = Team::select("*")->where("id", $teamId)->First();
            $team->team_motivation = $motivation;
            $team->team_introduction = $introduction;
            $team->save();
            return redirect($_SERVER["HTTP_REFERER"])->with("success", "Saved");
        }
    }

    public function sendMessageTeamChatAction(Request $request){
        if ($this->authorized(true)) {
            $teamId = $request->input("team_id");
            $sender_user_id = 1;
            $teamMessage = $request->input("message_team_chat");

            $message = new UserMessage();
            $message->sender_user_id = $sender_user_id;
            $message->team_id = $teamId;
            $message->message = $teamMessage;
            $message->time_sent = $this->getTimeSent();
            $message->created_at = date("Y-m-d H:i:s");
            $message->save();
            return redirect($_SERVER["HTTP_REFERER"])->with("success", "Team message sent");
        }
    }

    public function saveNeededExpertiseBackendAction(Request $request){
        if ($this->authorized(true)) {
            $neededExpertiseId = $request->input("needed_expertise_id");
            $description = $request->input("description_needed_expertise");
            $requirements = $request->input("requirements_needed_expertise");
            $amount = $request->input("amount");
            $neededExpertise = NeededExpertiseLinktable::select("*")->where("id", $neededExpertiseId)->first();
            $neededExpertise->description = $description;
            $neededExpertise->requirements = $requirements;
            $neededExpertise->amount = $amount;
            $neededExpertise->save();
            return redirect($_SERVER["HTTP_REFERER"])->with("success", $neededExpertise->Expertises->First()->title . " updated");
        }
    }

    public function deleteTeamProfilePictureAction(Request $request){
        if ($this->authorized(true)) {
            $teamId = $request->input("team_id");
            $team = Team::select("*")->where("id", $teamId)->first();
            $team->team_profile_picture = "defaultProfilePicture.png";
            $team->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function supportTicketsIndexAction(){
        if ($this->authorized(true)) {
            $admin = User::select("*")->where("id", Session::get("admin_user_id"))->first();
            $supportTickets = SupportTicket::select("*")->orderBy("support_ticket_status_id")->get();
            $supportTicketStatusses = SupportTicketStatus::select("*")->get();
            return view("/admin/supportTickets", compact("supportTickets", "supportTicketStatusses", "admin"));
        }
    }

    public function assignHelperToSupportTicketAction(Request $request){
        if ($this->authorized(true)) {
            $userId = $request->input("user_id");
            $ticketId = $request->input("support_ticket_id");

            $supportTicket = SupportTicket::select("*")->where("id", $ticketId)->first();
            $supportTicket->helper_user_id = $userId;
            $supportTicket->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function changeStatusSupportTicketAction(Request $request){
        if ($this->authorized(true)) {
            $statusId = $request->input("status_id");
            $ticketId = $request->input("ticket_id");

            $supportTicket = SupportTicket::select("*")->where("id", $ticketId)->first();
            $supportTicket->support_ticket_status_id = $statusId;
            if($statusId == 3){
                $supportTicket->closed_at = date("Y-m-d H:i:s");
            }
            $supportTicket->save();

            return $supportTicket->supportTicketStatus->status;
        }
    }

    public function messagesIndexAction(){
        if ($this->authorized(true)) {
            $userChats = UserChat::select("*")->where("creator_user_id", 1)->get();
            return view("/admin/messages", compact("userChats"));
        }
    }

    public function forumMainTopicListAction(){
        if ($this->authorized(true)) {
            $forumMainTopics = ForumMainTopic::select("*")->get();
            return view("/admin/forumMainTopicList", compact("forumMainTopics"));
        }
    }

    public function forumMainTopicEditorAction($id = null){
        if ($this->authorized(true)) {
            $forumMainTopicTypes = ForumMainTopicType::select("*")->get();
            if($id){
                $forumMainTopic = ForumMainTopic::select("*")->where("id", $id)->first();
                return view("/admin/forumMainTopicEditor", compact("forumMainTopic", "forumMainTopicTypes"));
            } else {
                return view("/admin/forumMainTopicEditor", compact("forumMainTopicTypes"));
            }
        }
    }

    public function saveForumMainTopicAction(Request $request){
        if ($this->authorized(true)) {
            $forumMainTopicId = $request->input("forum_main_topic_id");
            $title = $request->input("title");
            $description = $request->input("description");
            $newType = $request->input("newForumMainTopicType");

            if($forumMainTopicId){
                $forumMainTopic = ForumMainTopic::select("*")->where("id", $request->input("forum_main_topic_id"))->first();
                $forumMainTopic->published = 1;
            } else {
                $forumMainTopic = new ForumMainTopic();
                $forumMainTopic->published = 0;
            }

            if($newType){
                $forumMainTopicType = new ForumMainTopicType();
                $forumMainTopicType->title = $newType;
                $forumMainTopicType->save();
                $forumMainTopicTypeId = $forumMainTopicType->id;
            } else {
                $forumMainTopicTypeId = $request->input("forumMainTopicType");
            }

            $forumMainTopic->main_topic_type_id = $forumMainTopicTypeId;
            $forumMainTopic->title = $title;
            $forumMainTopic->description = $description;
            $forumMainTopic->save();
            return redirect("/admin/forumMainTopicEditor/$forumMainTopic->id")->with("success", "Saved");
        }
    }

    public function publishForumMainTopicAction(Request $request){
        if ($this->authorized(true)) {
            $forumMainTopicId = $request->input("forum_main_topic_id");
            $forumMainTopic = ForumMainTopic::select("*")->where("id", $forumMainTopicId)->first();
            $forumMainTopic->published = 1;
            $forumMainTopic->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function hideForumMainTopicAction(Request $request){
        if ($this->authorized(true)) {
            $forumMainTopicId = $request->input("forum_main_topic_id");
            $forumMainTopic = ForumMainTopic::select("*")->where("id", $forumMainTopicId)->first();
            $forumMainTopic->published = 0;
            $forumMainTopic->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function deleteForumMainTopicAction(Request $request){
        if ($this->authorized(true)) {
            $forumMainTopicId = $request->input("forum_main_topic_id");
            $forumMainTopic = ForumMainTopic::select("*")->where("id", $forumMainTopicId)->first();
            $forumMainTopic->delete();
            return redirect("/admin/forumMainTopicList")->with("success", "Topic deleted");
        }
    }

    public function forumThreadListAction(){
        if ($this->authorized(true)) {
            $forumThreads = ForumThread::select("*")->get();
            return view("/admin/forumThreadList", compact("forumThreads"));
        }
    }

    public function deleteForumThreadAction(Request $request){
        if ($this->authorized(true)) {
            $forumThreadId = $request->input("forum_thread_id");
            $forumThread = ForumThread::select("*")->where("id", $forumThreadId)->first();
            $forumThread->delete();
            return redirect($_SERVER["HTTP_REFERER"])->with("success", "Thread deleted");
        }
    }

    public function closeForumThreadAction(Request $request){
        if ($this->authorized(true)) {
            $forumThreadId = $request->input("forum_thread_id");
            $forumThread = ForumThread::select("*")->where("id", $forumThreadId)->first();
            $forumThread->closed = 1;
            $forumThread->save();
            return redirect($_SERVER["HTTP_REFERER"])->with("success", "Thread closed");
        }
    }

    public function openForumThreadAction(Request $request){
        if ($this->authorized(true)) {
            $forumThreadId = $request->input("forum_thread_id");
            $forumThread = ForumThread::select("*")->where("id", $forumThreadId)->first();
            $forumThread->closed = 0;
            $forumThread->save();
            return redirect($_SERVER["HTTP_REFERER"])->with("success", "Thread opened");
        }
    }

    public function expertiseListAction(){
        if ($this->authorized(true)) {
            $expertises = Expertises::select("*")->get();
            return view("/admin/expertiseList", compact("expertises"));
        }
    }

    public function deleteExpertiseAction(Request $request){
        if ($this->authorized(true)) {
            $expertiseId = $request->input("expertise_id");
            $expertise = Expertises::select("*")->where("id", $expertiseId)->first();
            $expertise->delete();
            return redirect($_SERVER["HTTP_REFERER"])->with("success", "Expertise deleted");
        }
    }

    public function faqListAction(){
        if ($this->authorized(true)) {
            $faqs = Faq::select("*")->get();
            return view("/admin/faqList", compact("faqs"));
        }
    }

    public function faqEditorAction($id = null){
        $faqTypes = FaqType::select("*")->get();
        if($id){
            $faq = Faq::select("*")->where("id", $id)->first();
            return view("/admin/faqEditor", compact("faq", "faqTypes"));
        } else {
            return view("/admin/faqEditor", compact("faqTypes"));
        }
    }

    public function saveFaqAction(Request $request){
        if ($this->authorized(true)) {
            $faqId = $request->input("faq_id");
            $question = $request->input("question");
            $answer = $request->input("answer");
            $newType = $request->input("newFaqType");

            if($faqId){
                $faq = Faq::select("*")->where("id", $request->input("faq_id"))->first();
                $faq->published = 1;
            } else {
                $faq = new Faq();
                $faq->published = 0;
                $faq->created_at = date("Y-m-d H:i:s");
            }

            if($newType){
                $faqType = new FaqType();
                $faqType->title = $newType;
                $faqType->save();
                $faqTypeId = $faqType->id;
            } else {
                $faqTypeId = $request->input("faqType");
            }

            $faq->faq_type_id = $faqTypeId;
            $faq->question = $question;
            $faq->answer = $answer;
            $faq->save();
            return redirect("/admin/faqEditor/$faq->id")->with("success", "Saved");
        }
    }

    public function publishFaqAction(Request $request){
        if ($this->authorized(true)) {
            $faqId = $request->input("faq_id");

            $faq = Faq::select("*")->where("id", $faqId)->first();
            $faq->published = 1;
            $faq->save();
            return redirect($_SERVER["HTTP_REFERER"])->with("success", "Faq published");
        }
    }

    public function hideFaqAction(Request $request){
        if ($this->authorized(true)) {
            $faqId = $request->input("faq_id");

            $faq = Faq::select("*")->where("id", $faqId)->first();
            $faq->published = 0;
            $faq->save();
            return redirect($_SERVER["HTTP_REFERER"])->with("success", "Faq hidden");
        }
    }

    public function deleteFaqAction(Request $request){
        if ($this->authorized(true)) {
            $faqId = $request->input("faq_id");

            $faq = Faq::select("*")->where("id", $faqId)->first();
            $faq->delete();
            return redirect("/admin/faqList")->with("success", "Faq deleted");
        }
    }

    public function membershipPackagesAction(){
        if ($this->authorized(true)) {
            $membershipPackages = MembershipPackage::select("*")->get();
            return view("/admin/membershipPackagesEditor", compact("membershipPackages"));
        }
    }

    public function saveMembershipPackageAction(Request $request){
        if ($this->authorized(true)) {
            $packageId = $request->input("package_id");
            $title = $request->input("title");
            $price = $request->input("price");
            $members = $request->input("members");
            $planners = $request->input("planners");
            $meetings = $request->input("meetings");
            $dashboard = $request->input("dashboard");
            $newsletter = $request->input("newsletter");
            $description = $request->input("description");

            if($packageId){
                $membershipPackage = MembershipPackage::select("*")->where("id", $packageId)->first();
            } else {
                $membershipPackage = new MembershipPackage();
            }
            $membershipPackage->title = $title;
            $membershipPackage->description = $description;
            $membershipPackage->price = $price;
            $membershipPackage->members = $members;
            $membershipPackage->planners = $planners;
            $membershipPackage->meetings = $meetings;
            $membershipPackage->dashboard = $dashboard;
            $membershipPackage->newsletter = $newsletter;
            $membershipPackage->save();
            return redirect($_SERVER["HTTP_REFERER"])->with("success", "Package $membershipPackage->title saved");
        }
    }

    public function customMembershipPackagesAction(){
        if ($this->authorized(true)) {
            $customMembershipPackageTypes  = CustomMembershipPackageType::select("*")->get();
            return view("/admin/customMembershipPackagesEditor", compact("customMembershipPackageTypes"));
        }
    }

    public function saveCustomMembershipPackageAction(Request $request){
        if ($this->authorized(true)) {
            $packageOption = $request->input("option");
            $packagePrice = $request->input("price");
            $packageId = $request->input("package_id");

            $customPackage = CustomMembershipPackage::select("*")->where("id", $packageId)->first();
            if($packageOption) {
                $customPackage->option = $packageOption;
            } else if($packagePrice) {
                $customPackage->price = $packagePrice;
            }
            $customPackage->save();
            return $customPackage->type;
        }
    }

    public function addOptionCustomMembershipPackageAction(Request $request){
        if ($this->authorized(true)) {
            $typeId = $request->input("type_id");
            $price = $request->input("price");
            $option = $request->input("option");

            $customPackage = new CustomMembershipPackage();
            $customPackage->type = $typeId;
            $customPackage->option = $option;
            $customPackage->price = $price;
            $customPackage->save();
            return redirect($_SERVER["HTTP_REFERER"])->with("success", "Option added");
        }
    }

    public function addCategoryCustomMembershipPackageAction(Request $request){
        if ($this->authorized(true)) {
            $category = $request->input("category");
            $optionsAmount = $request->input("amountOptions");

            $customMembershipPackageType = new CustomMembershipPackageType();
            $customMembershipPackageType->title = $category;
            $customMembershipPackageType->save();

            for($i = 0; $i < $optionsAmount; $i++) {
                $customPackage = new CustomMembershipPackage();
                $customPackage->type = $customMembershipPackageType->id;
                $customPackage->option = null;
                $customPackage->price = null;
                $customPackage->save();
            }
            return redirect($_SERVER["HTTP_REFERER"])->with("success", "Category added");
        }
    }

    public function pageListAction(){
        if ($this->authorized(true)) {
            $pages = Page::select("*")->get();
            return view("/admin/pageList", compact("pages"));
        }
    }

    public function pageEditorAction($id = null){
        if ($this->authorized(true)) {
            $pageTypes = PageType::select("*")->get();
            if($id){
                $page = Page::select("*")->where("id", $id)->first();
                return view("/admin/pageEditor", compact("page", "pageTypes"));
            } else {
                return view("/admin/pageEditor", compact("pageTypes"));
            }
        }
    }

    public function savePageAction(Request $request){
        if ($this->authorized(true)) {
            $pageId = $request->input("page_id");
            $title = $request->input("title");
            $content = $request->input("content");
            $type = $request->input("type");
            if($pageId){
                $page = Page::select("*")->where("id", $pageId)->first();
            } else {
                $page = new Page();
                $page->slug = str_replace(" ", "-", strtolower($title));
            }
            $page->title = $title;
            $page->content = $content;
            $page->page_type_id = $type;
            $page->save();
            return redirect("/admin/pageEditor/$page->id")->with("success", "Page saved");
        }
    }

    public function customerIdeaListAction(){
        if ($this->authorized(true)) {
            $customerIdeas = CustomerIdea::select("*")->get();
            $customerIdeaStatusses = CustomerIdeaStatus::select("*")->get();
            return view("/admin/customerIdeaList", compact("customerIdeas", "customerIdeaStatusses"));
        }
    }

    public function changeStatusCustomerIdeaAction(Request $request){
        if ($this->authorized(true)) {
            $ideaId = $request->input("idea_id");
            $status = $request->input("status");

            $customerIdea = CustomerIdea::select("*")->where("id", $ideaId)->first();
            $customerIdea->customer_idea_status_id = $status;
            $customerIdea->save();


            if($status == 2) {
                $userChat = UserChat::select("*")->where("receiver_user_id", Session::get("user_id"))->where("creator_user_id", 1)->first();

                $userMessage = new UserMessage();
                $userMessage->sender_user_id = 1;
                $userMessage->user_chat_id = $userChat->id;
                $userMessage->time_sent = $this->getTimeSent();
                $userMessage->message = "We are happy to say that we have accepted your idea for Innocreation! Soon we will implement it and you will see your own idea live on Innocreation! - Innocreation";
                $userMessage->created_at = date("Y-m-d H:i:s");
                $userMessage->save();
            }

            if($status == 3){
                $userChat = UserChat::select("*")->where("receiver_user_id", Session::get("user_id"))->where("creator_user_id", 1)->first();

                $userMessage = new UserMessage();
                $userMessage->sender_user_id = 1;
                $userMessage->user_chat_id = $userChat->id;
                $userMessage->time_sent = $this->getTimeSent();
                $userMessage->message = $request->input("message");
                $userMessage->created_at = date("Y-m-d H:i:s");
                $userMessage->save();

                return redirect($_SERVER["HTTP_REFERER"])->with("success", "Rejected idea");
            }
        }
    }

    public function serviceReviewListAction(){
        if ($this->authorized(true)) {
            $serviceReviews = ServiceReview::select("*")->get();
            return view("/admin/serviceReviewList", compact("serviceReviews"));
        }
    }

    public function mailMessageListAction(){
        if ($this->authorized(true)) {
            $mailMessages = MailMessage::select("*")->get();
            return view("/admin/mailMessageList", compact("mailMessages"));
        }
    }

    public function getMailMessageModalDataAction(Request $request){
        if ($this->authorized(true)) {
            $mailMessageId = $request->input("mail_message_id");
            $mailMessage = MailMessage::select("*")->where("id", $mailMessageId)->first();
            return $mailMessage->message;
        }
    }

    public function getSearchResultsUserChatAction(Request $request){
        if ($this->authorized(true)) {
            $searchString = $request->input("searchChatBackend");
            if ($searchString != "") { // checks if the search input is empty
                $userChatIds = [];
                $userChats = UserChat::select("*")->where("creator_user_id", 1)->get();
                foreach ($userChats as $userChat) {
                    if($userChat->receiver_user_id != 1 && $userChat->receiver) {
                        if (strpos($userChat->receiver->getName(), ucfirst($searchString)) !== false) { //gets all the teams which the user searched on
                            array_push($userChatIds, $userChat->id);
                        }
                    }
                }
                $searchedUserChats = UserChat::select("*")->whereIn("id", $userChatIds)->get(); // all the teams where users searched on
                return view("/admin/messages", compact("searchedUserChats"));
            } else {
                return redirect("/admin/messages");
            }
        }
    }

    public function expertiseEditorAction($id){
        if ($this->authorized(true)) {
            $expertise = Expertises::select("*")->where("id", $id)->first();
            return view("/admin/expertises/expertiseEditor", compact("expertise"));
        }
    }

    public function editExpertiseImageAction(AdminExpertiseEditorService $adminExpertiseEditorService, Request $request){
        $adminExpertiseEditorService->editExpertiseImage($request);
    }

    public function saveExpertiseAction(Request $request){
        if ($this->authorized(true)) {
            $expertiseId = $request->input("expertise_id");
            $tags = $request->input("tags");
            $explodeTags = explode(",", $tags);
            $temp = "";
            foreach($explodeTags as $item){
                if($temp == ""){
                    $temp = $item;
                } else {
                    $temp = $temp . ", " . $item;
                }
            }

            $expertise = Expertises::select("*")->where("id", $expertiseId)->first();
            $expertise->tags = $temp;
            $expertise->save();

            return redirect($_SERVER["HTTP_REFERER"])->withSuccess("Tags have been added");
        }
    }
}
