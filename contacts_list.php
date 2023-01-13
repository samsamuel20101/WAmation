<?php 
session_start();
error_reporting(0);
require_once('Connections/connx.php');
include 'access.php';
include 'customizer_user.php';
$tab = 'list';



$query_Recordset2Country = "SELECT * FROM countries order by country";
$Recordset2Country = mysqli_query($con, $query_Recordset2Country) or die(mysqli_error($con));
$row_Recordset2Country = mysqli_fetch_assoc($Recordset2Country);
$totalRows_Recordset2Country = mysqli_num_rows($Recordset2Country);


$query_Recordset2a = "SELECT * FROM categories where storeid='$_SESSION[StoreID]' order by catname";
$Recordset2a = mysqli_query($con, $query_Recordset2a) or die(mysqli_error());
$row_Recordset2a = mysqli_fetch_assoc($Recordset2a);
$totalRows_Recordset2a = mysqli_num_rows($Recordset2a);



$my  = mysqli_real_escape_string($con,$_GET[my]);
$listid  = mysqli_real_escape_string($con,$_POST[listid]);

$v  = mysqli_real_escape_string($con,$_GET[v]);

$fname  = mysqli_real_escape_string($con,$_POST[fname]);
$email  = mysqli_real_escape_string($con,$_POST[email]);
$lname   = mysqli_real_escape_string($con,$_POST[lname]);
$ccode   = mysqli_real_escape_string($con,$_POST[countrycode]);
$phone   = mysqli_real_escape_string($con,$_POST[phonenumber]);
$phone = ltrim($phone, "0");

$sent_day  = mysqli_real_escape_string($con,$_POST[sent_day]);

if ($v!==''){
    $vs = 'a.dropdownopt="'.$v.'" ';
}
if ($v==''){
  $vs = '1';
}

/*$allcount_query = "SELECT count(*) as allcount FROM contactstest where ".$vs." and listid='$my' and storeid='$_SESSION[StoreID]'";
$allcount_result = mysqli_query($con,$allcount_query);
$allcount_fetch = mysqli_fetch_array($allcount_result);
$allcount = $allcount_fetch['allcount'];


//limit 0,$rowperpage

/*$query_Recordset2 = "SELECT *, a.id as id, a.timestamp as timestamp FROM contactstest a, categoriestest b where a.listid='$my' and a.storeid='$_SESSION[StoreID]' and a.listid=b.id and ".$vs." order by a.id desc ";
$Recordset2 = mysqli_query($con, $query_Recordset2) or die(mysqli_error($con));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

if ($totalRows_Recordset2 =='0'){
    header ("location: index.php");
}*/

$zsetup = $row_Recordset2['zsetup'];

$delete  = mysqli_real_escape_string($con,$_POST[deleteid]);

if (isset($_POST['bulkaction'])){
    $bk  = mysqli_real_escape_string($con,$_POST[bk]);

    
        $userData = explode(',', $_POST["bulkChecked"]);

        for($i=0;$i<count($userData)-1;$i++){
            $id  = $userData[$i];
            $sql="DELETE FROM contacts WHERE id='".$id."'";
            if (!mysqli_query($con,$sql)) {
                die('Error: ' . mysqli_error($con));
            }
        }
    
    header("Location: contacts_list?my=$my&s=ok");
}


if (isset($_POST['bulkmove'])){
    $listid  = mysqli_real_escape_string($con,$_POST[listid]);

    $daynum  = mysqli_real_escape_string($con,$_POST[daynum]);

    $mfrom  = mysqli_real_escape_string($con,$_POST[mfrom]);


    $mto  = mysqli_real_escape_string($con,$_POST[mto]);



    $time = time();



    if ($mfrom!=='')
    {

//echo $mfrom;
//echo '<br>';
//echo $my;
//exit;


        $sql="update contacts set listid='$listid', joinedtime='$time', sent_day='$daynum', timestamp=now() where storeid='$_SESSION[StoreID]' and listid='".$my."' and (id>='".$mto."' and id <='".$mfrom."')";
            if (!mysqli_query($con,$sql)) {
                die('Error: ' . mysqli_error($con));
            }

    header("Location: contacts_list?my=$my&s=ok");
    }



    if ($mfrom=='')
    {
        $userData = $_POST["files2SP"];

        for($i=0;$i<count($userData);$i++){
            $id  = $_POST["files2SP"][$i];
            $num  = $_POST["num"][$i];
            $name  = $_POST["name"][$i];


        $sql="update contacts set listid='$listid', sent_day='$daynum', joinedtime='$time', timestamp=now() WHERE id='$id'";

            if (!mysqli_query($con,$sql)) {
                die('Error: ' . mysqli_error($con));
            }


$query_Recordset4 = "SELECT portnum, apikey, serverip, message, url from whatsapp a, categories b, automationz c  where a.storeid='$_SESSION[StoreID]' and c.storeid='$_SESSION[StoreID]' and a.status='ACTIVE' and a.id=c.wanum and b.id=c.listid and c.listid='$listid' and sendonday='$daynum' and schday='' and c.status='Active'";
$Recordset4 = mysqli_query($con, $query_Recordset4) or die(mysqli_error());
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);

$portnum = $row_Recordset4['portnum'];
$apikey = $row_Recordset4['apikey'];
$serverip = $row_Recordset4['serverip'];


//$smg = $row_Recordset4['smsmessage'];


$messageraw = str_replace("[name]","$name",$row_Recordset4['message']);

$message = str_replace("[phone]","$num",$messageraw);

$message1 = str_replace("[waphone]","$num",$message);

//$message = str_replace("[email]","$email",$message1);




$url = $row_Recordset4['url'];

$ch = curl_init();


curl_setopt($ch, CURLOPT_URL,"".$serverip.":".$portnum."/msg?key=".$apikey."");


$POST = array(
'to' => $num,
'message' => $message,
'url' => $url,
'q' => 1
);
curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($POST));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);

$server_output = curl_exec($ch);

curl_close ($ch);



        }
}

    header("Location: contacts_list?my=$my&s=ok");
}



if (isset($_POST['delete'])){
    $delete  = mysqli_real_escape_string($con,$_POST[deleteid]);
    $sql="DELETE FROM contacts WHERE id='$delete'";

    if (!mysqli_query($con,$sql)) {
        die('Error: ' . mysqli_error($con));
    }
    header("Location: contacts_list?my=$my&s=ok");
}

$archive   = mysqli_real_escape_string($con,$_POST[archive]);

if (isset($_POST['archive'])){
    $vv   = mysqli_real_escape_string($con,$_POST[vv]);
    if ($vv=='0'){
        $showme = '1';
    }

    if ($vv=='1'){
        $showme = '0';
    }
    $sql="update contacts set showme='$showme' WHERE id='$archive' and storeid='$_SESSION[StoreID]'";

    if (!mysqli_query($con,$sql)) {
        die('Error: ' . mysqli_error($con));
    }
    header("Location: contacts_list?my=$my&s=ok");
    mysqli_close($con);
}

$editid  = mysqli_real_escape_string($con,$_POST[editid]);

if (isset($_POST['update'])){
    $sql="update contacts set fname='$fname', email='$email', lname='$lname', countrycode='$ccode', phonenumber='$phone', sent_day='$sent_day', smssent_day='$sent_day' WHERE id='$editid' and storeid='$_SESSION[StoreID]'";

    if (!mysqli_query($con,$sql)) {
        die('Error: ' . mysqli_error($con));
    }
    header("Location: contacts_list?my=$my&s=ok");
}

if (isset($_POST['add'])){

$query_RecordsetSC = "SELECT * from contacts where storeid='$_SESSION[StoreID]' and listid='$my' and phonenumber = '$ccode$phone'";
$RecordsetSC = mysqli_query($con, $query_RecordsetSC) or die(mysqli_error());
$row_RecordsetSC = mysqli_fetch_assoc($RecordsetSC);
$totalRows_RecordsetSC = mysqli_num_rows($RecordsetSC);

if ($totalRows_RecordsetSC == 0){

$time = time();

$wa_receiver = $ccode.$phone;

  $sql="INSERT INTO contacts (storeid, listid, fname, lname, email, countrycode, phonenumber, timestamp, sent_day, joinedtime) VALUES ('$_SESSION[StoreID]', '$my', '$fname', '$lname', '$email','', '$ccode$phone', now(), '$sent_day', '$time')";

  if (!mysqli_query($con,$sql)) {
    header("Location: contacts_list?my=$my&error");
  }



$query_Recordset4 = "SELECT portnum, apikey, serverip, message, url from whatsapp a, categories b, automationz c  where a.storeid='$_SESSION[StoreID]' and c.storeid='$_SESSION[StoreID]' and a.status='ACTIVE' and a.id=c.wanum and b.id=c.listid and c.listid='$my' and sendonday='0' and schday='' and c.status='Active'";
$Recordset4 = mysqli_query($con, $query_Recordset4) or die(mysqli_error());
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);

$portnum = $row_Recordset4['portnum'];
$apikey = $row_Recordset4['apikey'];
$serverip = $row_Recordset4['serverip'];


//$smg = $row_Recordset4['smsmessage'];


$messageraw = str_replace("[name]","$fname",$row_Recordset4['message']);

$message = str_replace("[phone]","$wa_receiver",$messageraw);

$message1 = str_replace("[waphone]","$wa_receiver",$message);

$message = str_replace("[email]","$email",$message1);




$url = $row_Recordset4['url'];

$ch = curl_init();


curl_setopt($ch, CURLOPT_URL,"".$serverip.":".$portnum."/msg?key=".$apikey."");


$POST = array(
'to' => $wa_receiver,
'message' => $message,
'url' => $url,
'q' => 1
);
curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($POST));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);

$server_output = curl_exec($ch);

curl_close ($ch);

header("Location: contacts_list?my=$my&s=ok");
}

else 
{
header("Location: contacts_list?my=$my&error");
}
     
}





?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
  <!-- BEGIN: Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="WAmation:: WhatsApp Automation For Smart Business Owners!">
    <meta name="keywords" content="whatsapp automation, whatsapp chatbot, whatsapp chat bot, whatsapp autoresponder, whatsapp auto responder, whatsapp auto reply,whatsapp autoreply, whatsapp automation, WAmation">
    <meta name="author" content="WAmation">
    <title>WAmation:: WhatsApp Automation For Smart Business Owners!</title>
    <link rel="apple-touch-icon" href="app-assets/images/logo/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/logo/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/components.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/semi-dark-layout.min.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/pages/app-users.min.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/spinner.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/grt-youtube-popup.css">
    <!-- END: Custom CSS-->


  </head>
  <!-- END: Head-->

  <!-- BEGIN: Body-->
  <body class="vertical-layout vertical-menu-modern 2-columns  navbar-sticky footer-static <?php echo $layout; ?> <?php echo ($menu_collapse == "true") ? 'menu-collapsed' : 'menu-expanded'; ?>" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">


    <!--Spinner [Start]-->
        <div class="overlay">
            <div class="overlay__inner">
                <div class="overlay__content">
                    <span class="spinner"></span>
                    <span class="spinnerText">Fetching.... Please wait....</span>
                </div>
            </div>
        </div>
    <!--Spinner [End]-->


    <!-- BEGIN: Header-->
    <div class="header-navbar-shadow"></div>
    <nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top ">
      <div class="navbar-wrapper">
        <div class="navbar-container content">
          <div class="navbar-collapse" id="navbar-mobile">
            <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
              <ul class="nav navbar-nav">
                <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="javascript:void(0);"><i class="ficon bx bx-menu"></i></a></li>
              </ul>
            </div>
                <?php include 'top.php'; ?>
          </div>
        </div>
      </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mr-auto"><a class="navbar-brand" href="#">
              <div class="brand-logo">
                <img src="app-assets/images/logo/favicon.png">
              </div>
              <h2 class="brand-text mb-0">WAmation</h2></a></li>
          <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 primary"></i><i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary" data-ticon="bx-disc"></i></a></li>
        </ul>
      </div>
      <div class="shadow-bottom"></div>
      <div class="main-menu-content">
<?php include 'nav.php'; ?>
      </div>
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-overlay"></div>
      <div class="content-wrapper">
        <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                      <div class="row">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">Contacts</h5>
                      </div>
                      
                    </div>
                    </div>
                </div>
            </div>
        <div class="content-body">
            <!-- users list start -->
            <?php if (isset($_GET['s'])) : ?> 
                <div class="alert alert-success alert-dismissible mb-2" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="d-flex align-items-center">
                        <i class="bx bx-like"></i>
                        <span>Success!</span>
                    </div>
                </div>
            <?php endif; ?>

            <div class="alert alert-success alert-dismissible mb-2" role="alert" id="successmsgg" style="display:none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-flex align-items-center">
                    <i class="bx bx-like"></i>
                    <span>Success!</span>
                </div>
            </div>

            <?php if (isset($_GET['error'])) : ?>
                <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="d-flex align-items-center">
                        <span>Contact already exist. Enter a new contact...</span>
                    </div>
                </div>
            <?php endif; ?>

            <section class="users-list-wrapper">
                <div class="users-list-filter px-1">
                    <form id="form_add" method="post">
                        <div class="row border rounded py-2 mb-2">
                            <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
                                <button type="button" class="btn btn-primary btn-block glow users-list-clear mb-0" data-toggle="modal" data-target="#addnew"><i class="bx bx-plus"></i>Add Contact</button>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <button type="button" class="btn btn-primary btn-block glow users-list-clear mb-0" onclick="window.location='exportcontacts?my=<?php echo $my;?>'"><i class="bx bxs-upvote"></i>Export Contacts</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="users-list-table">
                <div class="card">
                    <div class="card-body">
                        <!-- datatable start -->
                        <h4 id="table_header">Contacts On <?php echo $row_Recordset2['catname']; ?> List <?php echo $v; ?> (<?php echo $allcount; ?>)</h4>
                        <div class="table-responsive">
                            <form method="post">
                                <div class="row">
                                    <div class="col-md-1">
                                        <select name="bk" class="form-control" style="width: 200px">
                                            <option value="bulkdelete">Delete</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <input type="button" name="" class="btn btn-primary" value="Go" data-toggle="modal" data-target="#bulkdelete">
                                    </div>&nbsp;&nbsp;&nbsp;
                                    <div class="col-md-2">
                                        <input type="number" name="mfrom" placeholder="from row # (top)" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" name="mto" placeholder="to row # (bottom)" class="form-control">
                                    </div>                                    
                                    <div class="col-md-2" style="display: ">
                                        <input type="button" name="" class="btn btn-primary" value="Move To Another List" data-toggle="modal" data-target="#bulkmove">
                                    </div>
                                    <div class="col-8">
                                    </div>
                                </div>
                                <table id="users-list-datatable-2" class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>
                                                <div class="checkbox checkbox-primary checkbox-glow">
                                                    <input type="checkbox" id="toggleSP" value="" onClick="do_thisSP()" class="btn btn-primary"/>
                                                    <label for="toggleSP"></label>
                                                </div>
                                            </th>
                                            <th style="white-space: nowrap;">Row #</th>
                                            <th style="white-space: nowrap;">Name</th>
                                            <th style="white-space: nowrap;">Phone Number</th>
                                            <th style="white-space: nowrap;">Email</th>
                                            <th style="white-space: nowrap;">Date Joined</th>
                                            <th>Automation Day #</th>
                                            <th style="white-space: nowrap;">Action</th>
                                            <th>Enable/Disable for Automation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php /* $i = 1; do { ?>
                                            <?php if ($totalRows_Recordset2 > 0) :?>
                                                <tr class="post" id="post_<?php echo $row_Recordset2['id']; ?>">
                                                    <td><?php echo $i; $i++; ?></td>
                                                    <td>
                                                        <div class="checkbox">
                                                            <input  name="files2SP[]" id="<?php echo $row_Recordset2['id']; ?>" type="checkbox" value="<?php echo $row_Recordset2['id']; ?>">
                                                            <label for="<?php echo $row_Recordset2['id']; ?>"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php echo $row_Recordset2['fname']; ?>
                                                        <?php if ($row_Recordset2['dropdownopt']!=='') :?>
                                                            <br><br>
                                                            <a href="contacts_list_new?my=<?php echo $my;?>&v=<?php echo $row_Recordset2['dropdownopt']; ?>" title="Sort by <?php echo $row_Recordset2['dropdownopt']; ?>"><?php echo $row_Recordset2['dropdownopt']; ?></a><br>
                                                        <?php endif; ?>
                                                        <input type="hidden" name="hf" value="<?php echo $row_Recordset2['id']; ?>">
                                                    </td>
                                                    <td><?php echo $row_Recordset2['phonenumber']; ?></td>
                                                    <td><?php echo $row_Recordset2['email']; ?></td>
                                                    <td><?php echo date('d M Y, h:i A', strtotime($row_Recordset2['timestamp'])) ?></td>
                                                    <td><?php echo $row_Recordset2['sent_day']; ?></td>
                                                    <td style="white-space: nowrap;">
                                                        <a class="edit-btnx" data-toggle="modal" data-target="#ModalEdit" data-id="<?php echo $row_Recordset2['id']; ?>" href="#"><i class="bx bx-edit-alt"></i></a>
                                                        <a data-toggle="modal" data-target="#ModalCenter" data-id="<?php echo $row_Recordset2['id']; ?>" href="#"><i class="bx bx-trash mr-1"></i></a>
                                                    </td>
                                                    <td>
                                                        <?php if ($row_Recordset2['showme']=='1') :?>
                                                            <a title="Disable for automation" class="dropdown-item" data-toggle="modal" data-target="#Archive" data-id="<?php echo $row_Recordset2['id']; ?>" href="#"><i class="bx bx-hide mr-1"></i></a>
                                                        <?php endif;?>

                                                        <?php if ($row_Recordset2['showme']=='0') :?>
                                                            <a title="Enable for automation" class="dropdown-item"  data-toggle="modal" data-target="#Archive" data-id="<?php echo $row_Recordset2['id']; ?>" href="#">
                                                                <i class="bx bx-show mr-1"></i>
                                                            </a>
                                                        <?php endif;?>
                                                    </td>
                                                    <input type="hidden" id="vv" value="<?php echo $row_Recordset2['showme']; ?>"> 
                                                </tr>
                                            <?php endif; ?>
                                        <?php } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2)); */?>

                                        <input type="hidden" id="start" value="0">
                                        <input type="hidden" id="rowperpage" value="<?= $rowperpage ?>">
                                        <input type="hidden" id="totalrecords" value="<?= $allcount ?>">
                                        <input type="hidden" id="v" value="<?= $v ?>">
                                        <input type="hidden" id="my" value="<?= $my ?>">
                                    </tbody>
                                </table>




                          <form method="post">
<div class="modal fade text-left addmodal" id="bulkmove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary">
                                                            <h4 class="modal-title" id="myModalLabel18">Move Contacts To New List</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <i class="bx bx-x"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                    


<div class="form-group">
                           <select class="form-control" name="listid" required>
<option value="">Select List</option>
<?php do { ?>
                                <option value="<?php echo $row_Recordset2a['id']?>"><?php echo $row_Recordset2a['catname']?></option>
                                        <?php } while ($row_Recordset2a = mysqli_fetch_assoc($Recordset2a));
                                        $rows = mysqli_num_rows($Recordset2a);
                                        if($rows > 0) {
                                          mysqli_data_seek($Recordset2a, 0);
                                          $row_Recordset2a = mysqli_fetch_assoc($Recordset2a);
                                        } ?>
                                      </select>
</div>

<div class="form-group">
                                      <label class="font-weight-semibold" for="">Day Number on Automation</label>
                     <select class="form-control" name="daynum" id="daynum" required=""/>
                                                 <?php
                                              for ($i=0; $i<=500; $i++)
                                            {
                                                ?>
                                          <option value="<?php echo $i;?>" <?php if ($i=='0') echo 'selected'?>>Day <?php echo $i;?></option>
                                            <?php
                                            }
                                            ?>
                                         </select>
</div>

                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                                        <span class="d-none d-sm-block">Cancel</span>
                                                                    </button>
                                                                    <button type="submit" class="btn btn-primary ml-1" name="bulkmove">
                                                                        <i class="bx bx-check d-block d-sm-none"></i>
                                                                        <span class="d-none d-sm-block">Save</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                </div>
                                            </div>
                                          </form>



                                <div class="modal fade text-left" id="bulkdelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger">
                                                <h4 class="modal-title" id="myModalLabel18">Confirmation</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i class="bx bx-x"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body">Are you sure you want to delete the selected contacts?</div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">No</span>
                                                </button>
                                                <form id="bulkAction" method="post">
                                                    <input type = "hidden" name="bulkChecked" value="">
                                                    <button type="submit" class="btn btn-primary ml-1" name="bulkaction">
                                                        <i class="bx bx-check d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Yes</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- datatable ends -->
                    </div>
                </div>
            </div>
        </section>
        <!-- users list ends -->
    </div>
</div>
</div>
    <!-- END: Content-->














    <?php include 'customizer.php'; ?>

    <div class="modal fade text-left deletemodal" id="Archive" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title" id="myModalLabel18">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div id="contentnoshow"></div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left deletemodal" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div id="content"></div>
            </div>
        </div>
    </div>

    <form method="post">
        <div class="modal fade text-left updatemodal" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title" id="myModalLabel18">Update Contact</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="contentedit"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>


                          <form method="post">
<div class="modal fade text-left addmodal" id="addnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary">
                                                            <h4 class="modal-title" id="myModalLabel18">Add New Contact</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <i class="bx bx-x"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                        
                            <div class="form-group">
                                      <label class="font-weight-semibold" for="">Name</label>
                     <input type="text" required class="form-control" id="fname" name="fname" placeholder="First Name">
</div>





              <div class="form-group">
<label>Phone Number</label>
<div class="input-group mb-3">
    <div class="input-group-prepend">
      <select class="form-control" name="countrycode" required style="width: 250px">
<option value="">Country Code</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset2Country['phonecode']?>" <?php if($row_Recordset2Country['phonecode']==$row_Recordset2['countrycode']) echo 'selected'; ?>><?php echo $row_Recordset2Country['country']?> (+<?php echo $row_Recordset2Country['phonecode']?>)</option>
        <?php
} while ($row_Recordset2Country = mysqli_fetch_assoc($Recordset2Country));
  $rows = mysqli_num_rows($Recordset2Country);
  if($rows > 0) {
      mysqli_data_seek($Recordset2Country, 0);
      $row_Recordset2Country = mysqli_fetch_assoc($Recordset2Country);
  }
?>
                                            </select>
      </div><input type="number" name="phonenumber" class="form-control" placeholder="" required></div>             
</div>


<div class="form-group">
                                      <label class="font-weight-semibold" for="">Email</label>
                     <input type="text" class="form-control" name="email" value="">
</div>

<div class="form-group">
                                      <label class="font-weight-semibold" for="">Day Number on Automation</label>
                     <input type="number" required class="form-control" name="sent_day" value="0">
</div>

                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                                        <span class="d-none d-sm-block">Cancel</span>
                                                                    </button>
                                                                    <button type="submit" class="btn btn-primary ml-1" name="add">
                                                                        <i class="bx bx-check d-block d-sm-none"></i>
                                                                        <span class="d-none d-sm-block">Save</span>
                                                                    </button>
                                                  <input type="hidden" name="listid" value="<?php echo $row_Recordset2['id']; ?>">
                                                                </div>
                                                            </div>
                                                </div>
                                            </div>
                                          </form>


















<div class="modal fade text-left" id="ModalNoShow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h4 class="modal-title" id="myModalLabel18">Confirmation</h4>
                                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <i class="bx bx-x"></i>
                                                            </button>
                                                        </div>
                                                        

                                                    </div>
                                                </div>
                                            </div>



    <!-- demo chat-->
        <div class="widget-chat-demo"><!-- widget chat demo footer button start -->
<button onclick="window.location='https://wa.me/2348109151624?text=Hello,%20I%20need%20to%20ask%20some%20questions...'" class="btn btn-primary chat-demo-button glow px-1"><i class="livicon-evo"
    data-options="name: comments.svg; style: lines; size: 24px; strokeColor: #fff; autoPlay: true; repeat: loop;"></i></button>

    </div>
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
      <p class="clearfix mb-0"><span class="float-left d-inline-block">2021 &copy; WAmation</span>

        
      </p>
    </footer>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <script src="app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.min.js"></script>
    <script src="app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.min.js"></script>
    <script src="app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
        <script src="app-assets/vendors/js/datatables/pdfmake.min.js"></script>
        <script src="app-assets/vendors/js/datatables/vfs_fonts.js"></script>
        <script src="app-assets/vendors/js/datatables/datatables.min.js"></script>
        <script src="app-assets/vendors/js/datatables/dataTables.checkboxes.min.js"></script>
        <script src="app-assets/vendors/js/pickers/pickadate/picker.js"></script>
        <script src="app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
        <script src="app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
        <script src="app-assets/vendors/js/pickers/pickadate/legacy.js"></script>
        <script src="app-assets/vendors/js/pickers/daterange/moment.min.js"></script>
        <script src="app-assets/vendors/js/pickers/daterange/daterangepicker.js"></script>
        <script src="app-assets/js/scripts/pickers/dateTime/pick-a-datetime.js?var=<?php echo time(); ?>"></script>
        <!-- END: Page Vendor JS-->
        <!-- BEGIN: Theme JS-->
        <script src="app-assets/js/scripts/configs/vertical-menu-light.min.js"></script>
        <script src="app-assets/js/core/app-menu.min.js?var=<?php echo time(); ?>"></script>
        <script src="app-assets/js/core/app.min.js?var=<?php echo time(); ?>"></script>
        <script src="app-assets/js/scripts/components.min.js"></script>
        <script src="app-assets/js/scripts/footer.min.js"></script>
        <script src="app-assets/js/scripts/customizer.min.js?var=<?php echo time(); ?>"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="app-assets/js/scripts/pages/app-users.min.js?var=<?php echo time(); ?>"></script>
    <!-- END: Page JS-->



    <!-- END: Page JS-->
    <script src="assets/js/grt-youtube-popup.js"></script>
    <script>
      $(".youtube-link").grtyoutube({
        autoPlay:true
      });
    </script>

    <script type="text/javascript">
        var table;

        function getList(){
            let v = "<?php echo $v; ?>";
            let fetchUrl = "<?php echo 'ajax_contact_list.php?my='.@$_GET['my'].'&v='.@$_GET['v']; ?>";
            $.get(fetchUrl, function( data ) {
                table.destroy();
                let tableData = JSON.parse(data);
                $('#totalrecords').val(tableData.allcount);
                $('#table_header').html('Contacts On '+tableData.catname+' List '+v+' ('+tableData.allcount+')');
                $('#users-list-datatable-2').find('tbody').html('');
                $.each(tableData.data, function(i, item) {
                    let dropdownopt = '';
                    if(item.dropdownopt != ''){
                        dropdownopt = '<br><br><a href="contacts_list?my=<?php echo $my;?>&v='+item.dropdownopt+'" title="Sort by '+item.dropdownopt+'">'+item.dropdownopt+'></a><br>';
                    }
                    let actionData = '';
                    if (item.showme == '1'){
                        actionData = '<a title="Disable for automation" class="dropdown-item" data-toggle="modal" data-target="#Archive" data-id="'+item.id+'" href="#"><i class="bx bx-hide mr-1"></i></a>';
                    }
                    if (item.showme == '0'){
                        actionData = '<a title="Enable for automation" class="dropdown-item"  data-toggle="modal" data-target="#Archive" data-id="'+item.id+'" href="#"><i class="bx bx-show mr-1"></i></a>';
                    }


                    var html = '<tr class="post" id="post_'+item.id+'">'
                    + '<td>'+(i+1)+'</td>'
                    + '<td>'
                        + '<div class="checkbox">'
                            + '<input  name="files2SP[]" id="'+item.id+'" type="checkbox" value="'+item.id+'">'
                            + '<label for="'+item.id+'"></label>'
                        + '</div>'
                    + '</td>'
                    + '<td>'+item.id+'</td>'
                    + '<td>'+item.fname+dropdownopt+'<input type="hidden" name="hf" value="'+item.id+'"></td>'
                    + '<td>'+item.phonenumber+'</td>'
                    + '<td>'+item.email+'</td>'
                    + '<td>'+item.timestampFormatted+'</td>'
                    + '<td>'+item.sent_day+'</td>'
                    + '<td style="white-space: nowrap;">'
                        + '<a class="edit-btnx" data-toggle="modal" data-target="#ModalEdit" data-id="'+item.id+'" href="#"><i class="bx bx-edit-alt"></i></a>'
                        + '<a data-toggle="modal" data-target="#ModalCenter" data-id="'+item.id+'" href="#"><i class="bx bx-trash mr-1"></i></a>'
                    + '</td>'
                    + '<td>'+actionData+'</td>'
                    + '<input type="hidden" id="vv" value="'+item.showme+'">'
                    + '<input type="hidden" id="" name="num[]" value="'+item.phonenumber+'">'
                    + '<input type="hidden" id="" name="name[]" value="'+item.fname+'">'
                    + '</tr>';

                    $("table#users-list-datatable-2 > tbody").append(html);
                    
                });
                table = $('#users-list-datatable-2').DataTable();
                $('.overlay').hide();
            });
        }

        $(document).ready(function(){
            table = $('table#users-list-datatable-new').DataTable();
            getList();
            $("form#bulkAction").submit(function(){
                let bulkChecked = '';
                var checkboxes = document.getElementsByName('files2SP[]');
                for (var i in checkboxes){
                    
                    if (checkboxes[i].checked == true)
                        bulkChecked += `${checkboxes[i].value},`;
                }
                $("input[name='bulkChecked']").val(bulkChecked);
                
            });
        });

    </script>
    


<script>
        
        checkWindowSize();

        // Check if the page has enough content or not. If not then fetch records
        function checkWindowSize(){
            if($(window).height() >= $(document).height()){
                  // Fetch records
                  fetchData();
            }
        }

        // Fetch records
        function fetchData(){
             var start = Number($('#start').val());
             var allcount = Number($('#totalrecords').val());
             var rowperpage = Number($('#rowperpage').val());
             start = start + rowperpage;

             if(start <= allcount){
                  $('#start').val(start);

                  $.ajax({
                       url:"contact_list_ajax.php",
                       type: 'post',
                       data: {start:start,rowperpage: rowperpage, v: v, my: my},
                       success: function(response){

                            // Add
                            $(".post:last").after(response).show().fadeIn("slow");

                            // Check if the page has enough content or not. If not then fetch records
                            checkWindowSize();
                       }
                  });
             }
        }

        $(document).on('touchmove', onScroll); // for mobile
       
        function onScroll(){

             if($(window).scrollTop() > $(document).height() - $(window).height()-100) {

                   fetchData(); 
             }
        }

        $(window).scroll(function(){

             var position = $(window).scrollTop();
             var bottom = $(document).height() - $(window).height();

             if( position == bottom ){
                   fetchData(); 
             }

        });

        </script>



<script type="text/javascript">
    function do_thisSP(){

        var checkboxes = document.getElementsByName('files2SP[]');
        var button = document.getElementById('toggleSP');

        if(button.value == 'Select All'){
            for (var i in checkboxes){
                checkboxes[i].checked = '';
            }
            button.value = 'Deselect All'
        }else{
            for (var i in checkboxes){
                checkboxes[i].checked = 'FALSE';
            }
            button.value = 'Select All';
        }
    }
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('#ModalCenter').on('show.bs.modal', function (e) {
        var dataid = $(e.relatedTarget).data('id');
        var dataString = 'dataid=' + dataid;
        $.ajax({
            type: "POST",
            url: "contact_del.php",
            data: dataString,
            cache: false,
            success: function(data){
                $("#content").html(data);
            }
        });
     });
});
</script>



<script type="text/javascript">
$(document).ready(function(){
    $('#ModalEdit').on('show.bs.modal', function (e) {
        var dataid = $(e.relatedTarget).data('id');
        var dataString = 'dataedit=' + dataid;
        $.ajax({
            type: "POST",
            url: "contact_edit.php",
            data: dataString,
            cache: false,
            success: function(data){
                $("#contentedit").html(data);
            }
        });
     });
});
</script>


<script type="text/javascript">
$(document).ready(function(){
    $('#Archive').on('show.bs.modal', function (e) {
        var dataid = $(e.relatedTarget).data('id');
        //var vv = $("#vv").val();
        var dataString = 'datanoshow=' + dataid;
        $.ajax({
            type: "POST",
            url: "contact_edit_noshow.php",
            //data: {datanoshow: datanoshow, vv: vv},
            data: dataString,
            cache: false,
            success: function(data){
                $("#contentnoshow").html(data);
            }
        });
     });
});
</script>
  </body>
  <!-- END: Body-->
</html>