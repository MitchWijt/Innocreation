<?php
    /**
     * Created by PhpStorm.
     * User: mitchelwijt
     * Date: 06/03/2019
     * Time: 18:48
     */

    namespace App\Services\UserAccount;


    use App\Expertises;
    use App\Expertises_linktable;
    use App\NeededExpertiseLinktable;
    use App\Services\AppServices\MailgunService;
    use App\Services\AppServices\MollieService;
    use App\Services\AppServices\StreamService;
    use App\Services\AppServices\UnsplashService;
    use App\Services\TimeSent;
    use App\User;
    use App\UserChat;
    use App\UserMessage;
    use function GuzzleHttp\json_decode;
    use function GuzzleHttp\json_encode;
    use GuzzleHttp\Psr7\Stream;
    use Illuminate\Support\Facades\Mail;
    use Session;
    use Auth;


    class RegisterUserService {
        public function saveUserCredentials($request){
            $firstname = $request->input("firstname");
            $lastname = $request->input("lastname");
            $email = $request->input("email");
            $password = $request->input("password");
            $username = $request->input("username");
            $country = $request->input("country");
            $expertises = $request->input('expertises');

            $existingUser = User::select("*")->where("email", $email)->first();
            if (!$existingUser) {
                $user = New User();
                $user->role = 2;
                $user->firstname = ucfirst($firstname);
                $user->lastname = ucfirst($lastname);
                $user->password = bcrypt($password);
                $user->country_id = $country;
                $user->email = $email;
                $user->slug = str_replace(" ", "_", $username);
                $user->hash = bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
                $user->profile_picture = "defaultProfilePicture.png";
                $user->banner = "banner-default.jpg";
                $user->created_at = date("Y-m-d H:i:s");
                $user->save();

                if (Auth::attempt(['email' => $email, 'password' => $password])) {
                    $user = User::select("*")->where("email", $email)->with("team")->first();
                    Session::set('user_name', $user->getName());
                    Session::set('user_role', $user->role);
                    Session::set('user_id', $user->id);
                }

                self::saveUserExpertises($expertises, $user);

                $stream = new StreamService();
                $token = $stream->generateStreamToken($user);

                $mollie = new MollieService();
                $customer = $mollie->generateNewCustomer($user);
                $newCustomer = User::select("*")->where("id", $user->id)->first();
                $newCustomer->mollie_customer_id = $customer->id;
                $newCustomer->stream_token = $token;
                $newCustomer->save();

                $userChat = new UserChat();
                $userChat->creator_user_id = 1;
                $userChat->receiver_user_id = $user->id;
                $userChat->created_at = date("Y-m-d H:i:s");
                $userChat->save();

                $timeSent = new TimeSent();

                $message = "Hey $user->firstname!<br><br> Welcome to Innocreation! <br> We're very excited to see you taking the step to take action on your dreams and ideas! <br> Here are some tips for you to be noticed even quiker: <br><br> 1. Fill in your motivation and introduction <br> 2. Fill in your work experience with your expertises why are you the best in what you do? <br> 3. Network and connect fellow Innocreatives to perhaps help you create your dream! <br> 4. Reach out to people and teams via the chat system <br> 5. Have fun and be creative! <br><br> If you have any more questions, feel free to ask them! <br><br> Best regards - Innocreation";
                $userMessage = new UserMessage();
                $userMessage->sender_user_id = 1;
                $userMessage->user_chat_id = $userChat->id;
                $userMessage->time_sent = $timeSent->time;
                $userMessage->message = $message;
                $userMessage->created_at = date("Y-m-d H:i:s");
                $userMessage->save();


                $mailgun = new MailgunService();
                $mailgun->saveAndSendEmail($user, "Welcome to Innocreation!", view("/templates/sendWelcomeMail", compact("user")));
                echo json_encode(['slug' => $user->slug]);
                die();
            } else {
                return 0;
            }
        }

        private function saveUserExpertises($expertises, $user){
            $expertisesAll = Expertises::select("*")->get();
            $existingArray = [];
            foreach ($expertisesAll as $existingExpertise) {
                array_push($existingArray, $existingExpertise->title);
            }

            $existingExpertises = Expertises_linktable::select("*")->where("user_id", $user->id)->get();
            $existingExpArray = [];
            foreach ($existingExpertises as $existingExpertise) {
                array_push($existingExpArray, $existingExpertise->expertise_id);
            }

            $chosenExpertisesString = $expertises;
            $chosenExpertises = explode(", ", $chosenExpertisesString);

            $unsplash = new UnsplashService();
            $expertisesArray = [];
            foreach ($chosenExpertises as $expertise) {
                if (!in_array(ucfirst($expertise), $existingArray)) {
                    $new = true;
                    $imageObject = json_decode($unsplash->searchAndGetImageByKeyword($expertise));
                    $newExpertise = New Expertises;
                    $newExpertise->title = ucfirst($expertise);
                    $newExpertise->slug = str_replace(" ", "-",strtolower($expertise));
                    $newExpertise->image = $imageObject->image;
                    $newExpertise->image_link = $imageObject->image_link;
                    $newExpertise->photographer_link = $imageObject->photographer->url;
                    $newExpertise->photographer_name = $imageObject->photographer->name;
                    $newExpertise->save();

                    $imageObject = json_decode($unsplash->searchAndGetImageByKeyword($expertise));
                    $userExpertise = New expertises_linktable;
                    $userExpertise->user_id = $user->id;
                    $userExpertise->expertise_id = $newExpertise->id;
                    $userExpertise->image = $imageObject->image;
                    $userExpertise->image_link = $imageObject->image_link;
                    $userExpertise->photographer_link = $imageObject->photographer->url;
                    $userExpertise->photographer_name = $imageObject->photographer->name;
                    $userExpertise->save();

                } else {
                    $new = false;
                    $expertiseNewUser = Expertises::select("*")->where("title", $expertise)->first();
                    if (!in_array($expertiseNewUser->id, $existingExpArray)) {
                        $imageObject = json_decode($unsplash->searchAndGetImageByKeyword($expertise));
                        $userExpertise = New expertises_linktable;
                        $userExpertise->user_id = $user->id;
                        $userExpertise->expertise_id = $expertiseNewUser->id;
                        $userExpertise->image = $imageObject->image;
                        $userExpertise->image_link = $imageObject->image_link;
                        $userExpertise->photographer_link = $imageObject->photographer->url;
                        $userExpertise->photographer_name = $imageObject->photographer->name;
                        $userExpertise->save();
                    }
                }

                if($new){
                    $expertiseObject = $newExpertise;
                    array_push($expertisesArray, $expertiseObject->id);
                } else {
                    $expertiseObject = $expertiseNewUser;
                    array_push($expertisesArray, $expertiseObject->id);
                }
            }


//            $neededExpertises = NeededExpertiseLinktable::select("*")->whereIn("expertise_id", $expertisesArray)->get();
//            if(isset($neededExpertises)) {
//                foreach ($neededExpertises as $neededExpertise) {
//                    $team = $neededExpertise->teams;
//                    $timeSent = new TimeSent();
//                    if ($team->First()->users->notifications == 1) {
//                        $userChat = UserChat::select("*")->where("receiver_user_id", $team->First()->ceo_user_id)->where("creator_user_id", 1)->first();
//                        $userMessage = new UserMessage();
//                        $userMessage->sender_user_id = 1;
//                        $userMessage->user_chat_id = $userChat->id;
//                        $userMessage->time_sent = $timeSent->time;
//                        $userMessage->message = sprintf('We have good news for you and your team! </br> </br> A new %s has joined Innocreation, since your team is in need of a %s you can invite him or chat with him straight away at the account of <a href="https://innocreation.net%s">%s</a>', $neededExpertise->expertises->First()->title, $neededExpertise->expertises->First()->title, $user->getUrl(), $user->firstname);
//                        $userMessage->created_at = date("Y-m-d H:i:s");
//                        $userMessage->save();
//                    }
//                }
//                foreach ($neededExpertises as $neededExpertise) {
//                    $team = $neededExpertise->teams;
//                    if ($team->First()->users->notifications == 1) {
//                        $user = $team->First()->users;
//                        $mailgun = new MailgunService();
//                        $mailgun->saveAndSendEmail($team->First()->users, 'You have got a message!', view("/templates/sendChatNotification", compact("user")));
//                    }
//                }
//            }
        }
    }