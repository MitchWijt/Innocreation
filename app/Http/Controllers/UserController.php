<?php

namespace App\Http\Controllers;

use App\ConnectRequestLinktable;
use App\CustomTeamPackage;
use App\Emoji;
use App\Expertises;
use App\Expertises_linktable;
use App\Favorite_expertises_linktable;
use App\FavoriteTeamLinktable;
use App\InviteRequestLinktable;
use App\Invoice;
use App\JoinRequestLinktable;
use App\MembershipPackage;
use App\Page;
use App\ServiceReview;
use App\Services\AppServices\MailgunService;
use App\Services\UserAccount\UserAccountPortfolioService;
use App\Services\UserAccount\UserChatsService;
use App\SplitTheBillLinktable;
use App\SupportTicket;
use App\SupportTicketMessage;
use App\Team;
use App\TeamCreateRequest;
use App\TeamReview;
use App\User;
use App\UserChat;
use App\UserFollowLinktable;
use App\UserMessage;
use App\Payments;
use App\UserPortfolio;
use App\TeamPackage;
use App\NeededExpertiseLinktable;
use App\UserWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Middleware\RolesMiddleware;

use App\Services\FeedServices\SwitchUserWork as SwitchUserWork;
use App\Services\AppServices\MailgunService as Mailgun;
use App\Services\AppServices\UnsplashService as Unsplash;
use App\Services\UserAccount\UserExpertises as UserExpertises;
use App\Services\UserAccount\UserPrivacySettingsService as UserPrivacySettings;
use App\Services\UserAccount\EditProfileImage as EditProfileImage;
use App\Services\UserAccount\UserAccountPortfolioService as UserPortfolioService;
use App\Services\AppServices\FfmpegService as FfmpegService;
use App\Services\AppServices\FfprobeService as FfprobeService;
use App\Services\AppServices\StreamService as StreamService;
use App\Services\UserAccount\UserRequestsService as UserRequestsService;


use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Session;

class UserController extends Controller
{

    public function saveUserAccount(Request $request){
        $user_id = $request->input("user_id");
        $user = User::select("*")->where("id", $user_id)->first();
        $user->skype = $request->input("skype");
        $user->motivation = $request->input("motivation_user");
        $user->introduction = $request->input("introduction_user");
        if($request->input("notifications") == "on"){
            $user->notifications = 1;
        } else {
            $user->notifications = 0;
        }
        $user->save();
        return redirect("/my-account/privacy-settings");
    }

    public function editBannerImageAction(Request $request, EditProfileImage $editProfileImage){
        return $editProfileImage->editBannerImage($request);
    }

    public function userAccountExpertises(UserExpertises $userExpertises){
        if($this->authorized()) {
           return $userExpertises->userAccountExpertisesIndex();
        }
    }

    public function saveUserExpertiseAction(Request $request, UserExpertises $userExpertises, Unsplash $unsplash) {
        return $userExpertises->saveUserExpertise($request, $unsplash);
    }

    public function deleteUserExpertiseAction(Request $request, UserExpertises $userExpertises){
        return $userExpertises->deleteUserExpertiseAction($request);
    }


    public function getEditUserExpertiseModalAction(Request $request, UserExpertises $userExpertises, Unsplash $unsplash){
        return $userExpertises->getEditUserExpertiseModalImage($request, $unsplash);
    }

    public function editUserExpertiseImage(Request $request, UserExpertises $userExpertises, Unsplash $unsplash){
        $userExpertises->editUserExpertiseImage($request, $unsplash);
    }

    public function getEditExpertiseModalAction(Request $request, UserExpertises $userExpertises){
       return $userExpertises->getEditExpertiseModal($request);
    }

    public function loadMoreExpertises(Request $request, UserExpertises $userExpertises){
        return $userExpertises->loadMoreExpertises($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function teamBenefits()
    {
        if($this->authorized()) {
            $user_id = Session::get("user_id");
            $user = User::select("*")->where("id", $user_id)->first();
            return view("/public/user/teamBenefits", compact("user"));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createNewTeam(Request $request) {
        $team_name = $request->input("team_name");
        $user_id = $request->input("user_id");
        $all_teams = Team::select("*")->where("team_name", $team_name)->get();
        $user = User::select("*")->where("id", $user_id)->first();
        if(count($all_teams) != 0){
            $error = "This name already exists";
            return redirect("/my-account/teamInfo")->withErrors("This name already exists");
        } else {
            $team = new Team;
            $team->team_name = ucfirst($team_name);
            $team->slug = str_replace(" ", "-", strtolower($team_name));
            $team->ceo_user_id = $user_id;
            $team->created_at = date("Y-m-d H:i:s");
            $team->team_profile_picture = "defaultProfilePicture.png";
            $team->save();

            $user->team_id = $team->id;
            $user->save();

            $teamCreateRequests = TeamCreateRequest::select("*")->where("receiver_user_id", $user_id)->where("accepted", 0)->get();
            if(count($teamCreateRequests)){
                foreach($teamCreateRequests as $teamCreateRequest){
                    $teamCreateRequest->accepted = 2;
                    $teamCreateRequest->save();
                }
            }

            Session::set("team_id", $team->id);
            Session::set("team_name", $team->team_name);


            return redirect("/my-team");
        }
    }

    public function favoriteExpertisesUser(){
        if($this->authorized()) {
            $user_id = Session::get("user_id");
            $user = User::select("*")->where("id", $user_id)->first();
            $expertises = Expertises::select("*")->inRandomOrder()->limit("6")->get();
            $favoriteExpertisesUser = Favorite_expertises_linktable::select("*")->where("user_id", $user_id)->with("Users")->with("Expertises")->get();
            return view("/public/user/favoriteExpertisesUser", compact("expertises", "user", "favoriteExpertisesUser"));
        }
    }

    public function saveFavoriteExperisesUser(Request $request, UserExpertises $userExpertisesService){
        return $userExpertisesService->saveFavoriteExperisesUser($request);
    }

    public function deleteFavoriteExpertisesUser(Request $request, UserExpertises $userExpertisesService){
        return $userExpertisesService->deleteFavoriteExpertisesUser($request);
    }

    public function saveUserProfilePictureAction(Request $request, EditProfileImage $editProfileImage){
        return $editProfileImage->editProfilePicture($request);
    }

    public function userAccountPortfolio(){
        if($this->authorized()) {
            $user_id = Session::get("user_id");
            $user = User::select("*")->where("id", $user_id)->first();
            $userPortfolios = UserPortfolio::select("*")->where("user_id", $user_id)->get();
            $amountPortfolios = count($userPortfolios);
            return view("/public/user/portfolio/userAccountPortfolio", compact("userPortfolios", "amountPortfolios", "user"));
        }
    }

    //portfolio
    public function addUserAccountPortfolio(Request $request, UserPortfolioService $userPortfolioService, FfmpegService $ffmpegService, FfprobeService $ffprobeService){
        return $userPortfolioService->saveNewPortfolio($request, $ffmpegService, $ffprobeService);
    }

    public function userPortfolioDetail($slug, UserAccountPortfolioService $userPortfolioService){
        return $userPortfolioService->portfolioDetailPage($slug);
    }

    public function addImagesPortfolio(Request $request, UserAccountPortfolioService $userPortfolioService, FfmpegService $ffmpegService, FfprobeService $ffprobeService){
        return $userPortfolioService->addImagesPortfolio($request, $ffmpegService, $ffprobeService);
    }

    public function editTitlePortfolioImage(Request $request, UserAccountPortfolioService $userPortfolioService){
        $userPortfolioService->editTitleImage($request);
    }

    public function editDescPortfolioImage(Request $request, UserAccountPortfolioService $userPortfolioService){
        $userPortfolioService->editDescImage($request);
    }

    public function removePortfolioImage(Request $request, UserAccountPortfolioService $userPortfolioService){
        return $userPortfolioService->removeImage($request);
    }

    public function deletePortfolio(Request $request, UserAccountPortfolioService $userPortfolioService){
        return $userPortfolioService->deletePortfolio($request);
    }
    
    public function addImageToAudio(Request $request, UserAccountPortfolioService $userPortfolioService){
        return $userPortfolioService->addImageToAudio($request);
    }

    //UserChats
    public function userAccountChats(UserChatsService $userChatsService){
        if($this->authorized()) {
            return $userChatsService->userAccountChatsIndex();
        }
    }

    public function deleteUserChatAction(Request $request, UserChatsService $userChatsService){
        return $userChatsService->deleteChat($request);
    }

    public function searchChatUsers(Request $request, UserChatsService $userChatsService){
        if($this->authorized()) {
            return $userChatsService->searchChats($request);
        }
    }

    public function selectChatUser(Request $request, UserChatsService $userChatsService){
        if($this->authorized()) {
            return $userChatsService->selectChat($request);
        }
    }

    public function sendMessageUserAction(Request $request, StreamService $streamService, UserChatsService $userChatsService, MailgunService $mailgunService){
        if($this->authorized()) {
            return $userChatsService->sendMessage($request, $streamService, $mailgunService);
        }
    }

    public function favoriteTeamAction(Request $request){
        if($this->authorized()) {
            // adds and deletes team to user favorites
            $team_id = $request->input("team_id");
            $user_id = Session::get("user_id");
            $favoriteExists = FavoriteTeamLinktable::select("*")->where("team_id", $team_id)->where("user_id", $user_id)->first();
            if (count($favoriteExists) == 0) {
                $favoriteTeam = new FavoriteTeamLinktable();
                $favoriteTeam->team_id = $team_id;
                $favoriteTeam->user_id = $user_id;
                $favoriteTeam->save();
                return 1;
            } else {
                $favoriteExists->delete();
                return 2;
            }
        }
    }

    public function applyForTeamAction(Request $request, MailgunService $mailgun, UserRequestsService $userRequestsService){
        if($this->authorized()) {
            return $userRequestsService->applyForTeam($request, $mailgun);
        }
    }

    public function userTeamJoinRequestsAction(){
        if($this->authorized()) {
            // gets all the join requests for the user
            $user_id = Session::get("user_id");
            $teamJoinRequests = JoinRequestLinktable::select("*")->where("user_id", $user_id)->get();
            $invites = InviteRequestLinktable::select("*")->where("user_id", $user_id)->get();
            return view("/public/user/userTeamJoinRequests", compact("teamJoinRequests", "invites", "user_id"));
        }
    }

    public function postTeamReviewAction(Request $request){
        if($this->authorized()) {
            // posts team review for team
            // calculates the support points the team gets for the review.
            $team_id = $request->input("team_id");
            $user_id = $request->input("user_id");
            $stars_value = $request->input("star_value");

            $reviewMessage = $request->input("review");
            $title = $request->input("review_title");

            $reviews = TeamReview::select("*")->where("team_id", $team_id)->where("writer_user_id", $user_id)->get();
            $team = Team::select("*")->where("id", $team_id)->first();
            if (count($reviews) == 0 && $user_id != $team->ceo_user_id) {

                $review = new TeamReview();
                $review->team_id = $team_id;
                $review->writer_user_id = $user_id;
                $review->title = $title;
                $review->review = $reviewMessage;
                $review->stars = $stars_value;
                $review->created_at = date("Y-m-d H:i:s");
                $review->save();


                $user = User::select("*")->where("id", $user_id)->first();
                $team->support = $team->calculateSupport($stars_value, $team_id);
                $team->save();

                $message = new UserMessage();
                $message->sender_user_id = $team->ceo_user_id;
                $message->team_id = $team_id;
                $message->message = "$user->firstname has written a new review for this team! go check it out!";
                $message->time_sent = $this->getTimeSent();
                $message->created_at = date("Y-m-d H:i:s");
                $message->save();


                foreach($team->getMembers() as $member) {
                    $this->saveAndSendEmail($member, "New review from $user->firstname!", view("/templates/sendTeamReviewMail", compact("user", "team", "member")));
                }
                return redirect($_SERVER["HTTP_REFERER"]);
            } else {
                return redirect($_SERVER["HTTP_REFERER"])->withErrors("You already wrote a review or you are the leader of this team");
            }
        }
    }

    public function acceptTeamInviteAction(Request $request, UserRequestsService $userRequestsService, Mailgun $mailgunService){
        if($this->authorized()) {
            return $userRequestsService->acceptInvite($request, $mailgunService);
        }
    }

    public function rejectTeamInviteAction(Request $request, UserRequestsService $userRequestsService){
        if($this->authorized()) {
            return $userRequestsService->declineInvite($request);
        }
    }

    public function favoriteTeamsAction(){
        if($this->authorized()) {
            $userId = Session::get("user_id");
            $favoriteTeams = FavoriteTeamLinktable::select("*")->where("user_id", $userId)->get();

            return view("/public/user/favoriteTeams", compact("favoriteTeams"));
        }
    }

    public function paymentDetailsAction(){
        if($this->authorized()) {
            $userId = Session::get("user_id");
            $user = User::select("*")->where("id", $userId)->first();
            $splitTheBillDetails = SplitTheBillLinktable::select("*")->where("user_id", $userId)->get();
            $teamPackage = TeamPackage::select("*")->where("team_id", $user->team_id)->first();

            return view("/public/user/userPaymentDetails", compact("splitTheBillDetails", "teamPackage", "user"));
        }
    }

    public function validateSplitTheBillAction(Request $request){
        if($this->authorized()) {
            $userId = $request->input("user_id");
            $splitTheBillId = $request->input("split_the_bill_linktable_id");
            $termsPayment = $request->input("paymentTermsCheck");
            $termsPrivacy = $request->input("privacyTermsCheck");

            $referenceObject = Payments::select("*")->orderBy("id", "DESC")->first();
            $reference = $referenceObject->reference + 1;

            if($termsPayment == 1 && $termsPrivacy == 1){
                $user = User::select("*")->where("id", $userId)->first();
                $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $user->id)->where("team_id", $user->team_id)->first();
                $splitTheBillLinktable->accepted = 1;
                $splitTheBillLinktable->save();

                if($user->getMostRecentPayment()){
                    $teamPackage = TeamPackage::select("*")->where("team_id", $user->team_id)->first();
                    if ($teamPackage->custom_team_package_id == null) {
                        $description = $teamPackage->title . " for team " . $teamPackage->team->team_name . "2";
                    } else {
                        $description =  " custom package for team " . $teamPackage->team->team_name . "2";
                    }

                    if($teamPackage->payment_preference == "monthly"){
                        $range = "1 months";
                    } else {
                        $range = "12 months";
                    }

                    // no active subscriptions
                    $mollie = $this->getService("mollie");
                    $customer = $mollie->customers->get($user->mollie_customer_id);
                    $mandates = $customer->mandates();
                    if($mandates[0]->status == "valid" || !$user->hasValidSubscription()) {
                        $customer = $mollie->customers->get($user->mollie_customer_id);
                        $customer->createSubscription([
                            "amount" => [
                                "currency" => "EUR",
                                "value" => number_format($splitTheBillLinktable->amount, 2, ".", "."),
                            ],
                            "interval" => "$range",
                            "description" => $description . $reference . "recurring",
                            "webhookUrl" => $this->getWebhookUrl(true),
                        ]);

                    }
                    $subscriptions = $customer->subscriptions();

                    $paymentTable = new Payments();
                    $paymentTable->user_id = $user->id;
                    $paymentTable->team_id = $user->team_id;
                    $paymentTable->payment_url = null;
                    $paymentTable->payment_method = "creditcard";
                    $paymentTable->amount = $user->getMostRecentPayment()->amount;
                    $paymentTable->reference = $reference;
                    $paymentTable->payment_status = "paid";
                    $paymentTable->sub_id = $subscriptions[0]->id;
                    $paymentTable->created_at = date("Y-m-d H:i:s");
                    $paymentTable->save();
                } else {
                    $user = User::select("*")->where("id", $userId)->first();
                    $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $user->id)->where("team_id", $user->team_id)->first();
                    $splitTheBillLinktable->accepted = 1;
                    $splitTheBillLinktable->save();


                    $teamPackage = TeamPackage::select("*")->where("team_id", $user->team_id)->first();
                    $fullDomain = $_SERVER['HTTP_HOST'];
                    $domainExplode = explode(".", $fullDomain);
                    if($domainExplode[0] == "secret") {
                        $redirectUrl = "http://secret.innocreation.net/my-account/payment-details";
                    } else {
                        $redirectUrl = "http://innocreation.net/my-account/payment-details";
                    }
                    if ($teamPackage->custom_team_package_id == null) {
                        $description = $teamPackage->title . " for team " . $user->team->team_name;
                    } else {
                        $description =  " custom package for team " . $user->team->team_name;
                    }

                    $price = number_format($splitTheBillLinktable->amount, 2, ".", ".");
                    $payment = Payments::select("*")->orderBy("id", "DESC")->first();
                    $reference = $payment->reference + 1;

                    $mollie = $this->getService("mollie");
                    $paymentMollie = $mollie->payments->create([
                        "amount" => [
                            "currency" => "EUR",
                            "value" => $price
                        ],
                        "description" => $description,
                        "redirectUrl" => $redirectUrl,
                        "webhookUrl" => $this->getWebhookUrl(),
                        "method" => "creditcard",
                        "sequenceType" => "first",
                        "customerId" => "$user->mollie_customer_id",
                        "metadata" => [
                            "referenceAndUserId" => $reference . "-" . $user->id,
                        ],
                    ]);

                    if($paymentMollie->status == "open") {
                        $payment = new Payments();
                        $payment->user_id = $user->id;
                        $payment->team_id = $user->team_id;
                        $payment->payment_id = $paymentMollie->id;
                        $payment->payment_url = $paymentMollie->_links->checkout->href;
                        $payment->payment_method = $paymentMollie->method;
                        $payment->amount = $price;
                        $payment->reference = $reference;
                        $payment->payment_status = "Open";
                        $payment->created_at = date("Y-m-d H:i:s");
                        $payment->save();
                    }
                    return redirect($payment->payment_url);
                }
                return redirect($_SERVER["HTTP_REFERER"]);

            } else {
                return redirect($_SERVER["HTTP_REFERER"])->withErrors("Agree with the Term to continue");
            }
        }
    }


    public function validateChangeAction(Request $request){
        if($this->authorized()) {
            $userId = $request->input("user_id");
            $splitTheBillId = $request->input("split_the_bill_linktable_id");
            $user = User::select("*")->where("id", $userId)->first();

            $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("id", $splitTheBillId)->first();
            $newPrice = $splitTheBillLinktable->reserved_changed_amount;
            $oldPrice = $splitTheBillLinktable->amount;

            $splitTheBillLinktable->accepted_change = 1;
            $splitTheBillLinktable->membership_package_change_id = null;
            $splitTheBillLinktable->amount = $newPrice;
            $splitTheBillLinktable->reserved_changed_amount = $oldPrice;
            $splitTheBillLinktable->reserved_membership_package_id = null;
            $splitTheBillLinktable->save();

            $mollie = $this->getService("mollie");
            $sub = $user->getMostRecentPayment();
            $customer = $mollie->customers->get($user->mollie_customer_id);
            $subscription = $customer->getSubscription($sub->sub_id);
            $subscription->amount = (object) [
                "currency" => "EUR",
                "value" => number_format($newPrice, 2, ".", "."),
            ];
            $subscription->webhookUrl = $this->getWebhookUrl(true);
            $subscription->startDate = date("Y-m-d", strtotime("+1 month"));
            $subscription->update();

            $teamPackage = TeamPackage::select("*")->where("team_id", $user->team_id)->first();

            $allSplitTheBillLinktables = SplitTheBillLinktable::select("*")->where("team_id", $user->team_id)->where("accepted_change", 1)->get();
            if (count($allSplitTheBillLinktables) >= count($user->team->getMembers())) {
                $userChat = UserChat::select("*")->where("receiver_user_id", $user->team->ceo_user_id)->where("creator_user_id", 1)->first();
                $userMessage = new UserMessage();
                $userMessage->sender_user_id = 1;
                $userMessage->user_chat_id = $userChat->id;
                $userMessage->time_sent = $this->getTimeSent();
                if($teamPackage->changed_payment_settings == 1){
                    $userMessage->message = "The verification to change your payment settings has been succesfuly validated by all your members! everything changed automatically you don't have to do anything :)";
                } else {
                    $userMessage->message = "The verification to change your team package has been succesfuly validated by all your members! You can pursue now. have fun!";
                }
                $userMessage->created_at = date("Y-m-d H:i:s");
                $userMessage->save();

                foreach($allSplitTheBillLinktables as $splitTheBillLinktable){
                    $splitTheBillLinktable->accepted_change = 0;
                    $splitTheBillLinktable->membership_package_change_id = null;
                    $splitTheBillLinktable->reserved_changed_amount = null;
                    $splitTheBillLinktable->reserved_membership_package_id = null;
                    $splitTheBillLinktable->reserved_custom_team_package_id = null;
                    $splitTheBillLinktable->custom_package_change_id = null;
                    $splitTheBillLinktable->save();
                }
                $teamPackage->change_package = 0;
                $teamPackage->changed_payment_settings = 0;
                $teamPackage->save();
            }
            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function billingAction(){
        if($this->authorized()) {
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            $payments = Payments::select("*")->where("user_id", $user->id)->get();
            $userName = $user->getName();

            if(count($payments) > 0){
                $invoices = Invoice::select("*")->where("user_id", $user->id)->where("hash", $user->hash)->get();
                return view("/public/user/userBilling", compact("user", "payments", "invoices"));
            } else {
                return view("/public/user/userBilling", compact("user"));
            }

        }
    }

    public function rejectChangeAction(Request $request){
        if($this->authorized()) {
            $userId = $request->input("user_id");
            $splitTheBillId = $request->input("split_the_bill_linktable_id");
            $user = User::select("*")->where("id", $userId)->first();

            $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("id", $splitTheBillId)->first();
            $splitTheBillLinktable->accepted_change = 0;
            $splitTheBillLinktable->save();


            $teamPackage = TeamPackage::select("*")->where("team_id", $user->team_id)->first();
            if ($teamPackage->changed_payment_settings != 1) {
                if ($splitTheBillLinktable->reserved_custom_team_package_id == null) {
                    $package = MembershipPackage::select("*")->where("id", $splitTheBillLinktable->reserved_membership_package_id)->first();
                    $teamPackage->title = $package->title;
                    $teamPackage->description = $package->description;
                    $teamPackage->membership_package_id = $package->id;
                    $teamPackage->custom_team_package_id = null;
                } else {
                    $package = CustomTeamPackage::select("*")->where("id", $splitTheBillLinktable->reserved_custom_team_package_id)->first();
                    $teamPackage->custom_team_package_id = $package->id;
                    $teamPackage->membership_package_id = null;
                }
                $teamPackage->price = $splitTheBillLinktable->getFullPackagePrice();
            }
            $teamPackage->change_package = 0;
            $teamPackage->changed_payment_settings = 0;
            $teamPackage->save();

            $allSplitTheBillLinktables = SplitTheBillLinktable::select("*")->where("team_id", $user->team_id)->get();
            $userChat = UserChat::select("*")->where("receiver_user_id", $user->team->ceo_user_id)->where("creator_user_id", 1)->first();
            $userMessage = new UserMessage();
            $userMessage->sender_user_id = 1;
            $userMessage->user_chat_id = $userChat->id;
            $userMessage->time_sent = $this->getTimeSent();
            if ($teamPackage->changed_payment_settings == 1) {
                $userMessage->message = $user->getName() . " has rejected the request to change your payment settings. Change has been aborted. still want to change the payment settings? send another request.";
            } else {
                $userMessage->message = $user->getName() . " has rejected the request for the package change. Change has been aborted. still want to change the package? send another request.";
            }
            $userMessage->created_at = date("Y-m-d H:i:s");
            $userMessage->save();

            foreach ($allSplitTheBillLinktables as $splitTheBillLinktable) {
                if($splitTheBillLinktable->accepted_change == 1){
                    $newAmount = $splitTheBillLinktable->reserved_changed_amount;
                    $splitTheBillLinktable->amount = $newAmount;
                    $mollie = $this->getService("mollie");
                    $sub = $splitTheBillLinktable->user->getMostRecentPayment();
                    $customer = $mollie->customers->get($splitTheBillLinktable->user->mollie_customer_id);
                    $subscription = $customer->getSubscription($sub->sub_id);
                    $subscription->amount = (object) [
                        "currency" => "EUR",
                        "value" => number_format($newAmount, 2, ".", "."),
                    ];
                    $subscription->webhookUrl = $this->getWebhookUrl(true);
                    $subscription->update();
                }
                $splitTheBillLinktable->accepted_change = 0;
                $splitTheBillLinktable->membership_package_change_id = null;
                $splitTheBillLinktable->reserved_changed_amount = null;
                $splitTheBillLinktable->reserved_membership_package_id = null;
                $splitTheBillLinktable->reserved_custom_team_package_id = null;
                $splitTheBillLinktable->save();
            }


            return redirect($_SERVER["HTTP_REFERER"])->withSuccess("Successfully rejected request");
        }
    }

    public function rejectSplitTheBillAction(Request $request){
        if($this->authorized()) {
            $userId = $request->input("user_id");
            $teamId = $request->input("team_id");
            $user = User::select("*")->where("id", $userId)->first();
            $allSplitTheBillLinktables = SplitTheBillLinktable::select("*")->where("team_id", $teamId)->get();
            foreach ($allSplitTheBillLinktables as $allSplitTheBillLinktable) {
                $recentPayment = $allSplitTheBillLinktable->user->getMostRecentOpenPayment();
                $recentPayment->payment_status = "Canceled";
                $recentPayment->save();
                $mollie = $this->getService("mollie");
                $mollie->payments->delete($recentPayment->payment_id);

                $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("id", $allSplitTheBillLinktable->id)->first();
                $splitTheBillLinktable->accepted = 0;
                $splitTheBillLinktable->save();
            }

            $team = $team = Team::select("*")->where("id", $user->team_id)->first();
            $team->split_the_bill = 0;
            $team->save();

            $this->saveAndSendEmail($user, "Payment has been rejected", view("/templates/sendSplitTheBillRejected", compact("user", "team")));

            $userChat = UserChat::select("*")->where("receiver_user_id", $team->ceo_user_id)->where("creator_user_id", 1)->first();
            $userMessage = new UserMessage();
            $userMessage->sender_user_id = 1;
            $userMessage->user_chat_id = $userChat->id;
            $userMessage->time_sent = $this->getTimeSent();
            $userMessage->message = "The payment for your team has been rejected because one of your team members rejected the validation request.";
            $userMessage->created_at = date("Y-m-d H:i:s");
            $userMessage->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function cancelSubscriptionAction(Request $request){
        if($this->authorized()) {
            $userId = $request->input("user_id");
            $teamId = $request->input("team_id");

            $team = Team::select("*")->where("id", $teamId)->first();
            $user = User::select("*")->where("id", $userId)->first();
            if($team->split_the_bill == 1) {
                $userName = $user->getName();
                $this->saveAndSendEmail($user, "$userName has left your team", view("/templates/sendMemberStopSubLeaveTeam", compact("user", "team")));
            }
            $user->subscription_canceled = 1;
            $user->team_id = null;
            $user->save();

            if($team->split_the_bill == 1){
                $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $userId)->where("team_id", $teamId)->first();
                $teamLeaderSplitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $team->ceo_user_id)->where("team_id", $teamId)->first();

                $memberAmount =  $splitTheBillLinktable->amount;
                $leaderAmount = $teamLeaderSplitTheBillLinktable->amount;
                $newLeaderPrice = $leaderAmount + $memberAmount;

                $splitTheBillLinktable->delete();

                $mollie = $this->getService("mollie");
                $sub = $teamLeaderSplitTheBillLinktable->user->getMostRecentPayment();
                $customer = $mollie->customers->get($teamLeaderSplitTheBillLinktable->user->mollie_customer_id);
                $subscription = $customer->getSubscription($sub->sub_id);
                $subscription->amount = (object) [
                    "currency" => "EUR",
                    "value" => number_format($newLeaderPrice, 2, ".", "."),
                ];
                $subscription->startDate = date("Y-m-d");
                $subscription->webhookUrl = $this->getWebhookUrl(true);
                $subscription->update();

                $teamLeaderSplitTheBillLinktable->amount = $newLeaderPrice;
                $teamLeaderSplitTheBillLinktable->save();

                $userName = $user->getName();
                $userChat = UserChat::select("*")->where("receiver_user_id", $team->ceo_user_id)->where("creator_user_id", 1)->first();
                $userMessage = new UserMessage();
                $userMessage->sender_user_id = 1;
                $userMessage->user_chat_id = $userChat->id;
                $userMessage->time_sent = $this->getTimeSent();
                $userMessage->message = "We are sorry to say that $userName has decided to stop his/her subscription and to leave your team.";
                $userMessage->created_at = date("Y-m-d H:i:s");
                $userMessage->save();
            }
            $mollie = $this->getService("mollie");
            $customer = $mollie->customers->get($user->mollie_customer_id);
            $customer->cancelSubscription($user->getMostRecentPayment()->sub_id);

            return redirect($_SERVER["HTTP_REFERER"])->withSuccess("Successfully canceled subscription and left team");
        }
    }

    public function joinTeamFromHelperAction(Request $request){
        if($this->authorized()) {
            $userId = $request->input("user_id");
            $user = User::select("*")->where("id", $userId)->first();
            $user->finished_helper = 1;
            $user->save();

            return redirect("/teams");
        }
    }

    public function finishHelperAction(Request $request){
        if($this->authorized()) {
            $userId = $request->input("user_id");
            $user = User::select("*")->where("id", $userId)->first();
            $user->finished_helper = 1;
            $user->save();

            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function passwordForgottenIndex(){
        return view("/public/user/passwordForgotten");
    }

    public function sendPasswordResetLinkAction(Request $request){
        $email = $request->input("email");
        $user = User::select("*")->where("email", $email)->first();
        if($user){
            $user->hash_timestamp = date("Y-m-d H:i:s", strtotime("+1 hour"));
            $user->save();
            $this->saveAndSendEmail($user, "Reset your password", view("/templates/sendResetPassword", compact("user")));

            return redirect($_SERVER["HTTP_REFERER"])->withSuccess("We have sent an email to $email with a password reset link!");
        } else {
            return redirect($_SERVER["HTTP_REFERER"])->withErrors("Couldn't find any account associated with email $email please try again");
        }
    }

    public function resetPasswordIndexAction($hash){
        $user = User::select("*")->where("hash", $hash)->first();
        if($user) {
            $today = date("Y-m-d H");
            $hash_timestamp = date("Y-m-d H", strtotime($user->hash_timestamp));
            if ($today <= $hash_timestamp) {
                return view("/public/user/resetPassword", compact("user"));
            } else {
                return redirect("/login")->withErrors("The password reset link has been expired");
            }
        } else {
            return redirect("/login")->withErrors("Invalid user");
        }
    }

    public function resetPasswordAction(Request $request){
        $userId = $request->input("user_id");
        $password = $request->input("password");
        $confirmPassword = $request->input("confirm_password");

        $user = User::select("*")->where("id", $userId)->first();

        if($password == $confirmPassword){
            $user->password = bcrypt(($request->input("password")));
            $user->hash_timestamp = date("Y-m-d H:i:s", strtotime("-1 hour"));
            $user->save();
            return redirect("/login")->withSuccess("password succesfully changed.You can login now!");
        } else {
            return redirect($_SERVER["HTTP_REFERER"])->withErrors("Passwords don't match");
        }
    }

    public function savePortfolioAsUserWorkAction(Request $request){
        if($this->authorized()){
            $portfolioId = $request->input("portfolio_id");

            $userPortfolio = UserPortfolio::select("*")->where("id", $portfolioId)->first();
            $userPortfolio->posted_as_work = 1;
            $userPortfolio->save();

            $userSlug = $userPortfolio->user->slug;

            $userWork = new UserWork();
            $userWork->user_id = $userPortfolio->user_id;
            $userWork->title = $userPortfolio->title;
            $userWork->description = $userPortfolio->description;
            $userWork->save();

            if($userPortfolio->image != null) {
                Storage::disk('spaces')->copy("users/$userSlug/portfolios/$userPortfolio->image", "users/$userSlug/userworks/$userWork->id/$userPortfolio->image");
                $userWork->content = $userPortfolio->image;
                $userWork->save();
            }

            $userWork->progress = null;
            $userWork->pinned = 0;
            $userWork->upvotes = null;
            $userWork->created_at = date("Y-m-d H:i:s");
            $userWork->save();

            return redirect("/innocreatives/$userWork->id");
        }
    }

    public function declineConnectionAction(Request $request, SwitchUserWork $switch, Mailgun $mailgun, StreamService $streamService){
        return $switch->declineConnection($request, $mailgun, $streamService);
    }

    public function acceptConnectionAction(Request $request, SwitchUserWork $switch, Mailgun $mailgun, StreamService $streamService){
        $switch->acceptConnection($request, $mailgun, $streamService);
        return redirect("/my-account/chats");
    }

    public function removeChatSessionAction(){
        Session::remove("userChatId");
    }

    public function openPrivacySettingsModalAction(Request $request, UserPrivacySettings $userPrivacySettingsService){
        return $userPrivacySettingsService->openSettingsModal();
    }

    public function sendConnectRequestAction(Request $request, SwitchUserWork $switch, StreamService $streamService){
        return $switch->createNewConnectRequest($request, $streamService);
    }
}
