<?php

namespace App\Http\Controllers;

use App\User;
use App\UserMessage;
use App\WorkspaceShortTermPlannerBoard;
use App\WorkspaceShortTermPlannerTask;
use Illuminate\Http\Request;

use App\Http\Requests;

class AlexaController extends Controller{
    public function alexaEndpoint(){

//        $input = file_get_contents('php://input');
//        $post = json_decode($input);
//
//        date_default_timezone_set('UTC');
//
//        $SignatureCertChainUrl = $_SERVER['HTTP_SIGNATURECERTCHAINURL'];
//
//        if ('amzn1.ask.skill.223d97e6-efcb-4b43-9723-d3da7e82c98c' == $post->session->application->applicationId AND $post->request->timestamp > date('Y-m-d\TH:i:s\Z', time()-150) AND preg_match('/https:\/\/s3\.amazonaws\.com(:433)?\/echo\.api\//', $SignatureCertChainUrl)) {
//            $SignatureCertChainUrl_File = md5($SignatureCertChainUrl);
//            $SignatureCertChainUrl_File = $SignatureCertChainUrl_File . '.pem';
//
//            if (!file_exists($SignatureCertChainUrl_File)) {
//                file_put_contents($SignatureCertChainUrl_File, file_get_contents($SignatureCertChainUrl));
//            }
//
//            $SignatureCertChainUrl_Content = file_get_contents($SignatureCertChainUrl_File);
//            $Signature_Content = $_SERVER['HTTP_SIGNATURE'];
//
//            $SignatureCertChainUrl_Content_Array = openssl_x509_parse($SignatureCertChainUrl_Content);
//
//            $Signature_PublicKey = openssl_pkey_get_public($SignatureCertChainUrl_Content);
//            $Signature_PublicKey_Data = openssl_pkey_get_details($Signature_PublicKey);
//            $Signature_Content_Decoded = base64_decode($Signature_Content);
//
////            $Signature_Verify = openssl_verify($original_post, $Signature_Content_Decoded, $Signature_PublicKey_Data['key'], 'sha1');
//
////            if (preg_match('/echo-api\.amazon\.com/', base64_decode($SignatureCertChainUrl_Content)) AND $SignatureCertChainUrl_Content_Array['validTo_time_t'] > time() AND $SignatureCertChainUrl_Content_Array['validFrom_time_t'] < time() AND $Signature_Content AND $Signature_Verify == 1) {
//                header ('Content-Type: application/json');
//
//                $PHP_Output = array('version' => '1.0', 'response' => array('outputSpeech' => array('type' => 'PlainText')));
//
//                $PHP_Output['response']['outputSpeech']['text'] = 'Hello world!';
//
//                echo json_encode($PHP_Output, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
////            }
////            else {
////                http_response_code(400);
////            }
//        }
//        else {
//            http_response_code(400);
//        }
//
//        die();
        /* This is a simple PHP example to host your own Amazon Alexa Skill written in PHP.
In my Case it connects to my smarthome Raspberry pi Cat Feeder with two intents;
1: Dispense Food to the cats.
2: When did the Feeder last time feed the cats? Return a spoken time / date
This Script contains neccessary calls and security to give you a easy to use DIY example.

v2016.12.29
Details in my Blogpost:  https://solariz.de/de/amazon-echo-alexa-meets-catfeeder.htm
*/
        header('Cache-Control: no-cache, must-revalidate');
// SETUP / CONFIG

        $SETUP = array(
            'SkillName' => "Innocreation",
            'SkillVersion' => '1.0',
            'ApplicationID' => 'amzn1.ask.skill.223d97e6-efcb-4b43-9723-d3da7e82c98c', // From your ALEXA developer console like: 'amzn1.ask.skill.45c11234-123a-1234-ffaa-1234567890a'
            'CheckSignatureChain' => true, // make sure the request is a true amazonaws api call
            'ReqValidTime' => 60, // Time in Seconds a request is valid
            'AWSaccount' => '', //If this is != empty the specified session->user->userId is required. This is usefull for account bound private only skills
            'validIP' => false, // Limit allowed requests to specified IPv4, set to FALSE to disable the check.
            'LC_TIME' => "nl_NL"

            // We use german Echo so we want our date output to be german

        );
        setlocale(LC_TIME, $SETUP['LC_TIME']);

// Getting Input

        $rawJSON = file_get_contents('php://input');
        $EchoReqObj = json_decode($rawJSON);


        if (is_object($EchoReqObj) === false) $this->ThrowRequestError();
        $RequestType = $EchoReqObj->request->type;

// Check if Amazon is the Origin

        if (is_array($SETUP['validIP'])) {
            $isAllowedHost = false;
            foreach($SETUP['validIP'] as $ip) {
                if (stristr($_SERVER['REMOTE_ADDR'], $ip)) {
                    $isAllowedHost = true;
                    break;
                }
            }

            if ($isAllowedHost == false) $this->ThrowRequestError(403, "Forbidden, your Host is not allowed to make this request!");
            unset($isAllowedHost);
        }

        // Check if correct requestId

        if (strtolower($EchoReqObj->session->application->applicationId) != strtolower($SETUP['ApplicationID']) || empty($EchoReqObj->session->application->applicationId))
        {
            $this->ThrowRequestError(401, "Forbidden, unkown Application ID!");
        }

        // Check SSL Signature Chain

        if ($SETUP['CheckSignatureChain'] == true) {
            if (preg_match("/https:\/\/s3.amazonaws.com(\:443)?\/echo.api\/*/i", $_SERVER['HTTP_SIGNATURECERTCHAINURL']) == false) {
                $this->ThrowRequestError(403, "Forbidden, unkown SSL Chain Origin!");
            }

            // PEM Certificate signing Check
            // First we try to cache the pem file locally

            $local_pem_hash_file = sys_get_temp_dir() . '/' . hash("sha256", $_SERVER['HTTP_SIGNATURECERTCHAINURL']) . ".pem";
            if (!file_exists($local_pem_hash_file))
            {
                file_put_contents($local_pem_hash_file, file_get_contents($_SERVER['HTTP_SIGNATURECERTCHAINURL']));
            }

            $local_pem = file_get_contents($local_pem_hash_file);
            if (openssl_verify($rawJSON, base64_decode($_SERVER['HTTP_SIGNATURE']) , $local_pem) !== 1) {
                $this->ThrowRequestError(403, "Forbidden, failed to verify SSL Signature!");
            }

            // Parse the Certificate for additional Checks

            $cert = openssl_x509_parse($local_pem);
            if (empty($cert)) $this->ThrowRequestError(424, "Certificate parsing failed!");

            // SANs Check

            if (stristr($cert['extensions']['subjectAltName'], 'echo-api.amazon.com') != true) ThrowRequestError(403, "Forbidden! Certificate SANs Check failed!");

            // Check Certificate Valid Time

            if ($cert['validTo_time_t'] < time()) {
                $this->ThrowRequestError(403, "Forbidden! Certificate no longer Valid!");

                // Deleting locally cached file to fetch a new at next req

                if (file_exists($local_pem_hash_file)) unlink($local_pem_hash_file);
            }

            // Cleanup

            unset($local_pem_hash_file, $cert, $local_pem);
        }

// Check Valid Time

        if (time() - strtotime($EchoReqObj->request->timestamp) > $SETUP['ReqValidTime']) $this->ThrowRequestError(408, "Request Timeout! Request timestamp is to old.");

// Check AWS Account bound, if this is set only a specific aws account can run the skill

        if (!empty($SETUP['AWSaccount'])) {
            if (empty($EchoReqObj->session->user->userId) || $EchoReqObj->session->user->userId != $SETUP['AWSaccount']) {
                $this->ThrowRequestError(403, "Forbidden! Access is limited to one configured AWS Account.");
            }
        }

        $JsonOut = $this->GetJsonMessageResponse($RequestType, $EchoReqObj);
        header('Content-Type: application/json');
        header("Content-length: " . strlen($JsonOut));
        echo $JsonOut;
        exit();
    }

    private function ThrowRequestError($code = 400, $msg = 'Bad Request'){
        $userMessage = UserMessage::select("*")->where("id", 660)->first();
        $userMessage->message = $msg;
        $userMessage->save();
        GLOBAL $SETUP;
        http_response_code($code);
        echo "Error " . $code . "<br />\n" . $msg;
        error_log("/var/www/secret/public/alexa/" . $SETUP['SkillName'] . ":\t" . $msg, 0);
        exit();
    }

    private function GetJsonMessageResponse($RequestMessageType, $EchoReqObj){
        GLOBAL $SETUP;
        $RequestId = $EchoReqObj->request->requestId;
        $ReturnValue = "";
        if ($RequestMessageType == "LaunchRequest") {
            $return_defaults = array(
                'version' => $SETUP['SkillVersion'],
                'sessionAttributes' => array(
                    'countActionList' => array(
                        'read' => true,
                        'category' => true
                    )
                ) ,
                'response' => array(
                    'outputSpeech' => array(
                        'type' => "PlainText",
                        'text' => "Welcome at Innocreation"
                    ) ,
                    'card' => array(
                        'type' => "Simple",
                        'title' => "CatFeeder",
                        'content' => "Test Content"
                    ) ,
                    'reprompt' => array(
                        'outputSpeech' => array(
                            'type' => "PlainText",
                            'text' => "How can i help you?"
                        )
                    )
                ) ,
                'shouldEndSession' => true
            );
            $ReturnValue = json_encode($return_defaults);
        } else if ($RequestMessageType == "SessionEndedRequest") {
            $ReturnValue = json_encode(array(
                'type' => "SessionEndedRequest",
                'requestId' => $RequestId,
                'timestamp' => date("c") ,
                'reason' => "USER_INITIATED"
            ));
        } else if ($RequestMessageType == "IntentRequest") {
            if ($EchoReqObj->request->intent->name == "innoCreateTask"){// Alexa Intent name
                $accessToken = $EchoReqObj->context->System->user->accessToken;
                $user = User::select("*")->where("access_token", $accessToken)->first();
                $board = WorkspaceShortTermPlannerBoard::select("*")->where("id", 1)->first();
                $task = new WorkspaceShortTermPlannerTask();
                $task->creator_user_id = $user->id;
                $task->short_term_planner_board_id = $board->id;
                $task->title = "Alexa task!";
                $task->category = "1:00AM";
                $task->created_at = date("Y-m-d H:i:s");
                $task->save();
                $speakPhrase = "Your task with title Alexa task has been created";
                // do what ever your intent should do here. In my Case I call home to my raspberry pi, see function comment for more info.
                //CREATE A TASK

            } else if ($EchoReqObj->request->intent->name == "innoSendMessage") {// 2nd Alexa Intent name{
                $speakPhrase = "Message has been sent";
                // do what ever your intent should do here. In my Case I call home to my raspberry pi, see function comment for more info.
            }

            $ReturnValue = json_encode(array(
                'version' => $SETUP['SkillVersion'],
                'sessionAttributes' => array(
                    'countActionList' => array(
                        'read' => true,
                        'category' => true
                    )
                ) ,
                'response' => array(
                    'outputSpeech' => array(
                        'type' => "PlainText",
                        'text' => $speakPhrase
                    ) ,
                    'card' => array(
                        'type' => "Simple",
                        'title' => "Inno",
                        'content' => $speakPhrase
                    )
                ) ,
                'shouldEndSession' => true
            ));
        } else {
            $this->ThrowRequestError();
        }

        return $ReturnValue;
    }
}
