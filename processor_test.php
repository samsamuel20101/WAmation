<html>
<head><title></title>

</head>
<body>
</body>
</html>


<?php
session_start();
error_reporting(0);
//use PHPMailer\PHPMailer\PHPMailer;
//require 'PHPMailer.php';
//require 'SMTP.php';

$time = time();

if (!isset($_SESSION["origURL"])) {
    $_SESSION["origURL"] = $_SERVER["HTTP_REFERER"];
}

//print_r($_POST);
//exit;
require_once 'Connections/connx.php';
require_once __DIR__ . '/vendor/autoload.php';

$stid = mysqli_real_escape_string($con, $_POST[zq]);
$fid = mysqli_real_escape_string($con, $_POST[fid]);

$name = mysqli_real_escape_string($con, $_POST[name]);
$nopfx = mysqli_real_escape_string($con, $_POST[nopfx]);
$wnopfx = mysqli_real_escape_string($con, $_POST[wnopfx]);

$dropdownopt = mysqli_real_escape_string($con, $_POST[dropdownopt]);

$userip = $_SERVER['REMOTE_ADDR'];

//$phone  = mysqli_real_escape_string($con,$_POST[phone]);
$phone = str_replace(" ", "", mysqli_real_escape_string($con, $_POST[phone]));

$waphone_nospace = str_replace(" ", "", mysqli_real_escape_string($con, $_POST[waphone]));

$waphone = ltrim($waphone_nospace, "0");

//$waphone = $waphone_nospace;

$strle = strlen($waphone);
$norm = '10';

$strdiff = $strle - $norm;

//if ($strle > $norm)
//{
//$waphone = substr($waphone, $strdiff);
//}

$email = mysqli_real_escape_string($con, $_POST[email]);

$wa_receiver = $wnopfx . $waphone;

if (isset($_POST['name'])) {

//if ($stid=='4131')
    //{
    //    echo 'OK';
    //    exit;
    //}

    $query_Recordset2 = "SELECT list_id, ar, receivingmail, receivingmail, p1, thankyoumsg, typ, emailwelcome, emailsubject, fromheader, replyto, activecampaignlistid, apikey FROM forms where formid='$fid' and storeid='$stid'";
    $Recordset2 = mysqli_query($con, $query_Recordset2) or die(mysqli_error());
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

    $getresponsekey = $row_Recordset2['list_id'];

    $ar = $row_Recordset2['ar'];

    $recmail = $row_Recordset2['receivingmail'];

    $recmailx = explode(",", $row_Recordset2['receivingmail']);
    $recmailx = $recmailx[0];
    $listid = $row_Recordset2['p1'];
    $thankyoumsg = $row_Recordset2['thankyoumsg'];

    $thankyoupage = $row_Recordset2['typ'];

    $emailwelcome = $row_Recordset2['emailwelcome'];

    $subject = $row_Recordset2['emailsubject'];

    $fromheader = $row_Recordset2['fromheader'];

    $replyto = $row_Recordset2['replyto'];

//$sql="DELETE FROM contacts where (storeid = '$stid' AND formid='$fid' AND listid = '$listid' AND phonenumber='$wnopfx$waphone')";

//if (!mysqli_query($con,$sql)) {
    //die('Error: ' . mysqli_error($con));
    //}

    $query_RecordsetSC = "SELECT id from contacts where storeid='$stid' and listid='$listid' and phonenumber = '$wnopfx$waphone'";
    $RecordsetSC = mysqli_query($con, $query_RecordsetSC) or die(mysqli_error());
    $row_RecordsetSC = mysqli_fetch_assoc($RecordsetSC);
    $totalRows_RecordsetSC = mysqli_num_rows($RecordsetSC);

    if ($totalRows_RecordsetSC > 0) {

        //$sql = "update contacts set storeid='0' where (storeid = '$stid' AND listid = '$listid' AND phonenumber='$wnopfx$waphone')";

        $sql = "DELETE FROM contacts where (storeid = '$stid' AND listid = '$listid' AND phonenumber='$wnopfx$waphone')";

        if (!mysqli_query($con, $sql)) {
            die('Error: ' . mysqli_error($con));
        }

    }

    $sql = "INSERT IGNORE INTO contacts (storeid, formid, listid, fname, lname, email, dropdownopt, countrycode, phonenumber, phonenum, sent_day, itsme, joinedtime, timestamp, userip) VALUES ('$stid', '$fid', '$listid', '$name', '', '$email', '$dropdownopt', '', '$wnopfx$waphone', '$wnopfx$waphone', '0', '1', '$time', now(), '$userip')";

    if (!mysqli_query($con, $sql)) {
        die('Error: ' . mysqli_error($con));
    }



  $userData = count($_POST["addedtext"]);
  if ($userData > 0) {
      for ($i=0; $i < $userData; $i++) { 
      $answer   = $_POST["addedtext"][$i];
      $question   = $_POST["addedtexthf"][$i];

      if ($answer!=='')
      {
    $query  = "INSERT INTO  forms_otherfields (storeid, formid, question, answer) VALUES ('$stid','$fid','$question','$answer')";
      $result = mysqli_query($con, $query);
      }
      }
  }


  $sdq="select * from form_select_options where opttype='checkbox' group by position_order ";
  $querysqd=mysqli_query($con, $sdq) or die(mysqli_error($con));

while($resf=mysqli_fetch_assoc($querysqd)){
  $userData = count($_POST["addedchk_".$resf['position_order']]);
  if ($userData > 0) {
      for ($i=0; $i < $userData; $i++) { 
      $answer   = $_POST["addedchk_".$resf['position_order']][$i];
      $question   = $_POST["addedchkhf_".$resf['position_order']][$i];

      if ($answer!=='')
      {
    $query  = "INSERT INTO  forms_otherfields (storeid, formid, question, answer) VALUES ('$stid','$fid','$question','$answer')";
      $result = mysqli_query($con, $query);
      }
      }
  }
}

  $sdq="select * from form_select_options where opttype='radio' group by position_order ";
  $querysqd=mysqli_query($con, $sdq) or die(mysqli_error($con));

  
while($resf=mysqli_fetch_assoc($querysqd)){
  $userData = count($_POST["addedrad_".$resf['position_order']]);
  if ($userData > 0) {
      for ($i=0; $i < $userData; $i++) { 
      $answer   = $_POST["addedrad_".$resf['position_order']][$i];
      $question   = $_POST["addedradhf_".$resf['position_order']][$i];

      if ($answer!=='')
      {
    $query  = "INSERT INTO  forms_otherfields (storeid, formid, question, answer) VALUES ('$stid','$fid','$question','$answer')";
      $result = mysqli_query($con, $query);
      }
      }
  }
}


/**
$optload = $_POST["addedradhf"];
$groupList = $_POST["addedrad"];

$countGl = count($groupList);
$countOl = count($optload)/$countGl;
$j = 0;
foreach($groupList as $gl) {    
    for($i=$j*$countOl; $i<($j+1)*$countOl; $i++) {


      
      $optload   = $_POST["addedradhf"][$i];


      //if ($optload!=='')
      //{
    $query  = "INSERT INTO  forms_otherfields (storeid, formid, question, answer) VALUES ('$stid','$fid','$optload','$g')";
      $result = mysqli_query($con, $query);

    //$query  = "INSERT INTO  form_select_options (storeid, formid, seloptions, optload, optreq, opttype, timestamp) VALUES ('$_SESSION[StoreID]','$formid','$optload','$gl','$optreq','$opttype', now())";
      //$result = mysqli_query($con, $query);
      //}

       //echo $gl.'  '.$optload[$i].'<br>';
    }
    $j++;
}
**/


  $userData = count($_POST["addedtextarea"]);
  if ($userData > 0) {
      for ($i=0; $i < $userData; $i++) { 
      $answer   = $_POST["addedtextarea"][$i];
      $question   = $_POST["addedtextareahf"][$i];

      if ($answer!=='')
      {
    $query  = "INSERT INTO  forms_otherfields (storeid, formid, question, answer) VALUES ('$stid','$fid','$question','$answer')";
      $result = mysqli_query($con, $query);
      }
      }
  }





  $userData = count($_POST["addedselect"]);
  if ($userData > 0) {
      for ($i=0; $i < $userData; $i++) { 
      $answer   = $_POST["addedselect"][$i];
      $question   = $_POST["addedselecthf"][$i];

      if ($answer!=='')
      {
    $query  = "INSERT INTO  forms_otherfields (storeid, formid, question, answer) VALUES ('$stid','$fid','$question','$answer')";
      $result = mysqli_query($con, $query);
      }
      }
  }


//select count for today... if none, insert... if yes, update count+1

/**
$sql = "INSERT INTO wa_msg_count (storeid, wanum, msgcount, timestamp) VALUES

('$_SESSION[StoreID]', '$wanum', '$msgcount' ,now())";

if (!mysqli_query($con, $sql)) {
die('Error: ' . mysqli_error($con));
}
 **/

// and formid_atz='$fid'

    $query_Recordset4 = "SELECT portnum, apikey, serverip, message, url from whatsapp a, categories b, automationz c  where a.storeid='$stid' and c.storeid='$stid' and a.status='ACTIVE' and a.id=c.wanum and b.id=c.listid and c.listid='$listid' and sendonday='0' and schday='' and c.status='Active'";
    $Recordset4 = mysqli_query($con, $query_Recordset4) or die(mysqli_error());
    $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
    $totalRows_Recordset4 = mysqli_num_rows($Recordset4);

if ($totalRows_Recordset4 > 0)
{
    $portnum = $row_Recordset4['portnum'];
    $apikey = $row_Recordset4['apikey'];
    $serverip = $row_Recordset4['serverip'];

//$smg = $row_Recordset4['smsmessage'];

    $messageraw = str_replace("[name]", "$name", $row_Recordset4['message']);

    $message = str_replace("[phone]", "$wa_receiver", $messageraw);

    $message1 = str_replace("[waphone]", "$phone", $message);

    $message = str_replace("[email]", "$email", $message1);

    $urlx = $row_Recordset4['url'];

    // $ch = curl_init();

    // curl_setopt($ch, CURLOPT_URL, "" . $serverip . ":" . $portnum . "/msg?key=" . $apikey . "");

    // $POST = array(
    //     'to' => $wa_receiver,
    //     'message' => $message,
    //     'url' => $url,
    //     'q' => 1,
    // );
    // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($POST));
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);

    // $server_output = curl_exec($ch);

    // curl_close($ch);

    // $payload = http_build_query(array(
    //     'to' => $wa_receiver,
    //      'message' => $message,
    //      'url' => $url,
    //      'q' => 1,
    // ));

    // $options= array( "http" => array( "method" => "POST",
    //             "header" => 'Content-type: application/x-www-form-urlencoded',
    //             "content" => $payload
    //         )
    //     );

    // $context = stream_context_create($options);

    // $data = file_get_contents("" . $serverip . ":" . $portnum . "/msg?key=" . $apikey . "", false, $context);

    $client = new GuzzleHttp\Client();
    $url = "" . $serverip . ":" . $portnum . "/msg?key=" . $apikey . "";

    $promise = $client->postAsync($url, [
        'headers' => ['Accept' => 'application/json'],

        'json' => [
            'to' => $wa_receiver,
            'message' => $message,
            'url' => $urlx,
            'q' => 1,
        ],
    ])->then(
        function ($res) {
            $response = json_decode($res->getBody()->getContents());
            return $response;
        },
        // function ($e) {
        //     $response = [];
        //     $response->data = $e->getMessage();

        //     return $response;
        // }
    );

    $response = $promise->wait();
}
    //echo json_encode($response);

    $to = $email;

    $subject = $subject;

    if ($subject !== '') {
//$from = 'support@snipercrm.io';

// To send HTML mail, the Content-type header must be set
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Create email headers
        $headers .= 'From: ' . $fromheader . ' <support@wamation.com.ng>' . "\r\n" .
        'Reply-To: ' . $replyto . ' ' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

// Compose a simple HTML email message
        $message = $emailwelcome;

// Sending email
        if (mail($to, $subject, $message, $headers)) {
            //echo 'Your mail has been sent successfully.';
        } else {
            //echo 'Unable to send email. Please try again.';
        }
    }

    $customerphone = $wnopfx . $waphone;

    if ($ar == 'GetResponse') {
        $chh = curl_init();

        curl_setopt($chh, CURLOPT_URL, "https://app.getresponse.com/add_subscriber.html?");
        curl_setopt($chh, CURLOPT_POST, 1);
        curl_setopt($chh, CURLOPT_POSTFIELDS,
            "campaign_token=" . $getresponsekey . "&name=" . $name . "&email=" . $email . "&start_day=0");
// Receive server response ...

        curl_setopt($chh, CURLOPT_RETURNTRANSFER, 0);
        curl_setopt($chh, CURLOPT_TIMEOUT_MS, 1);
        $server_output = curl_exec($chh);

        curl_close($chh);
    }

    if ($ar == 'ActiveCampaign') {

        $list_id = $row_Recordset2['activecampaignlistid'];

        $query_Recordset2 = "SELECT apiurl, autokey FROM autoresponders where autoname='ActiveCampaign' and storeid='$stid'";
        $Recordset2 = mysqli_query($con, $query_Recordset2) or die(mysqli_error($con));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

        $url = $row_Recordset2[apiurl];

        $key = $row_Recordset2[autokey];

        require_once "activecampaign/includes/ActiveCampaign.class.php";

        $ac = new ActiveCampaign("" . $url . "", "" . $key . "");

        /*
         * TEST API CREDENTIALS.
         */

        if (!(int) $ac->credentials_test()) {
            //echo "<p>Access denied: Invalid credentials (URL and/or API key).</p>";
            //exit();
        }

        $contact = array(
            "email" => $email,
            "first_name" => $name,
            "phone" => $customerphone,
            "last_name" => "",
            "p[{$list_id}]" => $list_id,
            "status[{$list_id}]" => 1, // "Active" status
        );

        $contact_sync = $ac->api("contact/sync", $contact);

        if (!(int) $contact_sync->success) {
            // request failed
            //echo "<p>Syncing contact failed. Error returned: " . $contact_sync->error . "</p>";
            //exit();
        }

        // successful request
        $contact_id = (int) $contact_sync->subscriber_id;
        //echo "<p>Contact synced successfully (ID {$contact_id})!</p>";

    }

    if ($ar == 'Sendy') {

        $list_id = $row_Recordset2['apikey'];

        $query_Recordset2 = "SELECT apiurl, autokey FROM autoresponders where autoname='Sendy' and storeid='$stid'";
        $Recordset2 = mysqli_query($con, $query_Recordset2) or die(mysqli_error($con));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

        $url = $row_Recordset2[apiurl];

        $key = $row_Recordset2[autokey];

        //-------------------------- You need to set these --------------------------//
        $your_installation_url = $row_Recordset2[apiurl]; //Your Sendy installation (without the trailing slash)
        $list = $list_id; //Can be retrieved from "View all lists" page
        $api_key = $row_Recordset2[autokey]; //Can be retrieved from your Sendy's main settings
        $success_url = ''; //URL user will be redirected to if successfully subscribed
        $fail_url = ''; //URL user will be redirected to if subscribing fails
        //---------------------------------------------------------------------------//

        //POST variables
        $name = $name;
        $email = $email;
        $boolean = 'true';

        //Check fields
        if ($name == '' || $email == '') {
            //echo 'Please fill in all fields.';
            //exit;
        }

        //Subscribe
        $postdata = http_build_query(
            array(
                'name' => $name,
                'email' => $email,
                'list' => $list,
                'api_key' => $api_key,
                'boolean' => 'true',
            )
        );
        $opts = array('http' => array('method' => 'POST', 'header' => 'Content-type: application/x-www-form-urlencoded', 'content' => $postdata));
        $context = stream_context_create($opts);
        $result = file_get_contents($your_installation_url . '/subscribe', false, $context);

        //check result and redirect
        if ($result) {
            //header("Location: $success_url");
        } else {
            //header("Location: $fail_url");
        }

    }

    if ($thankyoupage == '') {
        $typ = 'formframe?formid=' . $fid . '&success=1&out=0';
        header("Location: $typ");
    }

    if ($thankyoupage !== '') {
//header("Location: $thankyoupage");
        $typ = $thankyoupage;

        header("Location: $typ");
    }

//header("Location: $typ");

    mysqli_close($con);

}
?>