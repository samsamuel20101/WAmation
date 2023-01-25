<?php	
session_start();
error_reporting(0);
//include 'access.php';
require_once('Connections/connx.php');
header('Access-Control-Allow-Origin: *');
//include 'access.php';

$formid    = mysqli_real_escape_string($con,$_GET[formid]);
$success    = mysqli_real_escape_string($con,$_GET[success]);
$outredirect    = mysqli_real_escape_string($con,$_GET[out]);

$query_Recordset2 = "SELECT * FROM forms where formid='$formid'";
$Recordset2 = mysqli_query($con, $query_Recordset2) or die(mysqli_error());
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

if ($totalRows_Recordset2 == '0')
{
  echo 'The form you are trying to load doesnt exit';
header("Location: https://app.wamation.com.ng");
}
$storeid = $row_Recordset2['storeid'];

$sortby = $row_Recordset2['sortby'];


$ccode = $row_Recordset2['ccode'];

$p1 = $row_Recordset2['p1'];
$displayoption  = $row_Recordset2['pqd'];
$producttext  = $row_Recordset2['producttext'];
$productbg  = $row_Recordset2['productbg'];

$displaytop  = $row_Recordset2['pqdtop'];
$labelcolor  = $row_Recordset2['labelcolor'];
$f8show  = $row_Recordset2['f8show'];
$f8  = $row_Recordset2['f8'];
$f8req  = $row_Recordset2['f8req'];
$f9show  = $row_Recordset2['f9show'];
$f9  = $row_Recordset2['f9'];
$f9req  = $row_Recordset2['f9req'];
$f10show  = $row_Recordset2['f10show'];
$f10  = $row_Recordset2['f10'];
$f10req  = $row_Recordset2['f10req'];
$f10yes  = $row_Recordset2['f10yes'];
$f10no  = $row_Recordset2['f10no'];

$f11show  = $row_Recordset2['f11show'];
$f11  = $row_Recordset2['f11'];
$f11req  = $row_Recordset2['f11req'];
$f11a  = $row_Recordset2['f11a'];
$f11b  = $row_Recordset2['f11b'];
$f11c  = $row_Recordset2['f11c'];

$bordrad = $row_Recordset2['bordrad'];
$ffamily = $row_Recordset2['ffamily'];

$formfontsize  = $row_Recordset2['ffs'];
$ffh  = $row_Recordset2['ffh'];
$formwidth  = $row_Recordset2['formwidthnew'];
$f1  = $row_Recordset2['f1'];
$f2  = $row_Recordset2['f2'];
$f3  = $row_Recordset2['f3'];
$f3req  = $row_Recordset2['f3req'];
$f4  = $row_Recordset2['f4'];
$f4req  = $row_Recordset2['f4req'];
$f4show  = $row_Recordset2['f4show'];
$f5  = $row_Recordset2['f5'];
$req5a  = $row_Recordset2['req5a'];
$req5  = $row_Recordset2['req5'];


$f6  = $row_Recordset2['f6'];
$bump = $row_Recordset2['p2'];
$bumpheader = $row_Recordset2['bumpheader'];
$bumptextcolor = $row_Recordset2['bumptextcolor'];
$bumpsub = $row_Recordset2['bumpsub'];
$bumpbg = $row_Recordset2['bumpbg'];
$bumpimage = $row_Recordset2['bumpimage'];
$bumpvideo = $row_Recordset2['bumpvideo'];
$bumpcta1 = $row_Recordset2['bumpcta1'];
$bumpscarcity = $row_Recordset2['bumpscarcity'];
$bumpcta2 = $row_Recordset2['bumpcta2'];
$pretext = $row_Recordset2['pretext'];
$p3 = $row_Recordset2['p3'];
$paystack = $row_Recordset2['paystack'];
$flutterwave = $row_Recordset2['flutterwave'];
$voguepay = $row_Recordset2['voguepay'];
$cashondelivery = $row_Recordset2['cashondelivery'];

$fontsize = $row_Recordset2['bfs'];
$buttonbg = $row_Recordset2['bbc'];
$bordercolor = $row_Recordset2['bbcc'];
$textcolor = $row_Recordset2['btc'];
$buttonlabel = $row_Recordset2['btt'];
$thankyouurl = $row_Recordset2['typ'];
$ar = $row_Recordset2['ar'];
$apikey = $row_Recordset2['arlist'];
$morediscount = $row_Recordset2['morediscount'];
$paymentmethod = $row_Recordset2['paymentmethod'];
$grk = $row_Recordset2['list_id'];

$anywebsite = $row_Recordset2['anywebsite'];
$formheadertext = $row_Recordset2['formheadertext'];
$thankyoutext = $row_Recordset2['thankyoutext'];

$productimage = $row_Recordset2['productimage'];
$productvideo = $row_Recordset2['productvideo'];

$coupon = $row_Recordset2['coupon'];
$moretext = $row_Recordset2['moretext'];
//$statesout = $row_Recordset2['statesout'];

$thankyoumsg = $row_Recordset2['thankyoumsg'];

$typ = $row_Recordset2['typ'];

$statesout ="$row_Recordset2[statesout]";
$statesout = "'" . str_replace(",", "','", $statesout) . "'";

$fbpixel = $row_Recordset2['fbpixel'];

$formwidthclass = $row_Recordset2['formwidthnew'];

$areabg = $row_Recordset2['areabg'];

$productbg  = $row_Recordset2['productbgnew'];

$formlabel = $row_Recordset2['formlabel'];

$showccode = $row_Recordset2['showccode'];

$ccode = $row_Recordset2['ccode'];

$beforesubmitbtn = $row_Recordset2['beforesubmitbtn'];

$query_Recordset2Country = "SELECT id, phonecode, country FROM countries order by country";
$Recordset2Country = mysqli_query($con, $query_Recordset2Country) or die(mysqli_error());
$row_Recordset2Country = mysqli_fetch_assoc($Recordset2Country);
$totalRows_Recordset2Country = mysqli_num_rows($Recordset2Country);

if ($sortby=='1')
{
	$orderby = 'seloptions';
}
if ($sortby=='2')
{
	$orderby = 'id';
}

if ($req5a=='1')
{
$query_Recordset2x = "SELECT * FROM form_select_options where storeid='$storeid' and formid='$formid' order by $orderby";
$Recordset2x = mysqli_query($con, $query_Recordset2x) or die(mysqli_error($con));
$row_Recordset2x = mysqli_fetch_assoc($Recordset2x);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <base target="_parent">

<?php echo $fbpixel; ?>
    <!-- Title Page-->
    <title>Sign Up</title>

    <!-- Icons font CSS-->
    <link href="https://app.wamation.com.ng/newform/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="https://app.wamation.com.ng/newform/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Vendor CSS-->
    <link href="https://app.wamation.com.ng/newform/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <!--<link href="newform/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">-->

    <!-- Main CSS-->
    <link href="https://app.wamation.com.ng/newform/css/main.css" rel="stylesheet" media="all">
    <style type="text/css">
.col_half1 {
  width: 30%;
  float: left;
}
.col_half2 {
  width: 70%;
  float: left;
}

.myselect {
  width: 100%;
  overflow: hidden;
  text-overflow: ellipsis;
}

.myselect option {
  white-space: nowrap;
  width: 100% border-bottom: 1px #ccc solid;
  /* This doesn't work. */
}
.Radio {
  display: inline-flex;
  align-items: center;
}
.Radio-Input {
  margin: 0 0.5rem 0;
}
.column-lx {
  flex: 1%; line-height: 1.2; margin-bottom: 7px; margin-top: 7px; display: block;
    vertical-align: middle; padding: 0.3em 0; align-items: center;
}
.column-l {
  flex: 60%; line-height: 1.2; margin-bottom: 7px; margin-top: 7px; display: block;
    vertical-align: middle; padding: 0.3em 0; align-items: center;padding-right: 45px;width: fit-content;width: auto;
  min-width: min-content;
  max-width: max-content;
}
.column-r {
  flex: 35%; line-height: 1.2; margin-bottom: 7px; margin-top: 7px; display: block;
    vertical-align: middle; padding: 0.3em 0; align-items: right; text-align: right;
}
.rowx {
  display: flex;
}

.btn--blue {
  background: <?php echo $buttonbg;?>; 
  /*#4272d7;*/
}

.btn--blue:hover {
  background: #3868cd;
}
select {
  color: #000000;
}
.label{
  color: <?php echo $formlabelcolor; ?>;
<?php
if ($formlabel == '0')
{
  echo 'display: none';

}
?>
}
@media screen and (max-width: 600px) {.divresimg {width: 345px;}}@media screen and (max-width: 412px) {.divresimg {width: 150px;}}@media screen and (max-width: 375px) {.divresimg {width: 140px;}}@media screen and (min-width: 601px) {.divresimg {width: 200px;}}@media screen and (min-width: 667px) and (max-width: 667px) {.divresimg {width: 150px;}}@media screen and (min-width: 413px) and (max-width: 666px) {.divresimg {width: 150px;}}@media screen and (max-width: 734) {.divresimg {width: 100px;}}

.divresbump {width: <?php echo $formwidth;?>px;}

@media screen and (max-width: 600px) {.divresbump {width: 345px; margin-left: -12px;}}@media screen and (max-width: 412px) {.divresbump {width: 350px; margin-left: -12px;}}@media screen and (max-width: 375px) {.divresbump {width: 260px; margin-left: -12px;}}@media screen and (min-width: 601px) {.divresbump {width: 590px; margin-left: -12px;}}@media screen and (min-width: 667px) and (max-width: 667px) {.divresbump {width: 280px; margin-left: -12px;}}@media screen and (min-width: 413px) and (max-width: 666px) {.divresbump {width: 480px; margin-left: -12px;}}@media screen and (max-width: 734) {.divresbump {width: 200px; margin-left: -12px;}}

@media screen and (max-width: 600px) {.sbn {padding-right: 20px; padding-left: 20px;}}@media screen and (max-width: 412px) {.sbn {padding-right: 10px; padding-left: 10px;}}@media screen and (max-width: 375px) {.sbn {padding-right: 10px; padding-left: 10px;}}@media screen and (min-width: 601px) {.sbn {padding-right: 40px; padding-left: 40px;}}@media screen and (min-width: 667px) and (max-width: 667px) {.sbn {padding-right: 50px; padding-left: 50px;}}@media screen and (min-width: 413px) and (max-width: 666px) {.sbn {padding-right: 50px; padding-left: 50px;}}@media screen and (max-width: 734px) {.sbn {padding-right: 10px; padding-left: 10px;}}
    </style>

<?php if ($tandc!=='') :?>
<style type="text/css">
/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 15% auto; /* 15% from the top and centered */
  padding: 20px;
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
.hidden {
    display: none;
}
</style>
<?php endif; ?>
</head>

<body>
    <div class="page-wrapper font-poppins">
        <div class="wrapper <?php echo $formwidthclass; ?>">
            <div class="card card-6 sbn" style="background-color: <?php echo $areabg;?>; padding-top: 15px; padding-bottom: 15px;">
                <div class="card-body" style="background-color: <?php echo $productbg;?>; padding: 10px; width: 100%">
		<?php if ($success=='1' && $outredirect=='0') : ?>
      <div style="background-color: #f5ba1a; padding: 15px;"> 
                        <p align="center" style="color: #000000;"><h4>
                                                    <?php
$query_Recordset2x = "SELECT * FROM forms where formid='$formid'";
$Recordset2x = mysqli_query($con, $query_Recordset2x) or die(mysqli_error());
$row_Recordset2x = mysqli_fetch_assoc($Recordset2x);

                                                     echo $row_Recordset2x[thankyoumsg]; ?></h4>
                        </p>
</div>
<br>
<?php endif; ?>

                    <form method="POST" action="https://app.wamation.com.ng/processor_test" id="wamationform" style="display: <?php if ($success=='1' && $outredirect=='0') echo 'none'; ?>">


<p style=""><?php echo $moretext;?></p>



<div class="col-12"><div class="input-group">
<label class="label"><?php echo $f1;?> *</label>
<input class="input--style-4" type="text" name="name" id="name" value="" required placeholder="<?php echo $f1;?> *" style="-moz-border-radius: <?php echo $bordrad;?>px;-webkit-border-radius: <?php echo $bordrad;?>px;border-radius: <?php echo $bordrad;?>px;height: <?php echo $ffh; ?>px;font-size: <?php echo $formfontsize;?>px"/></div></div>



<?php if ($showccode=='0') :?>
<?php
$query_Recordset2y = "SELECT phonecode FROM countries where id='$ccode'";
$Recordset2y = mysqli_query($con, $query_Recordset2y) or die(mysqli_error($con));
$row_Recordset2y = mysqli_fetch_assoc($Recordset2y);
?>
<input type="hidden" name="wnopfx" value="<?php echo $row_Recordset2y['phonecode']; ?>">
<label class="label"><?php echo $f3;?> *</label>
<div class="col-12">
<div class="input-group">
    <input class="input--style-4" type="number" name="waphone" id="waphone" value="" required placeholder="<?php echo $f3;?> *" style="-moz-border-radius: <?php echo $bordrad;?>px;-webkit-border-radius: <?php echo $bordrad;?>px;border-radius: <?php echo $bordrad;?>px;height: <?php echo $ffh; ?>px;font-size: <?php echo $formfontsize;?>px"/></div>
</div>

<?php endif;?>



<?php if ($showccode=='1') :?>
<label class="label"><?php echo $f3;?> *</label>
<div class="row">
 <div class="col_half1">
 <div class="input-group">
 <div class="rs-select2 js-select-simple select--no-search-dx">
  <select name="wnopfx" id="phonewa" style="-moz-border-radius: <?php echo $bordrad;?>px;-webkit-border-radius: <?php echo $bordrad;?>px;border-radius: <?php echo $bordrad;?>px;height: <?php echo $ffh; ?>px;font-size: <?php echo $formfontsize;?>px; width: 200px;" required>
<option value="" <?php if ($ccode=='-1') echo 'selected';?>>Select</option>
<option value="234" <?php if ($ccode=='0') echo 'selected';?>>+234 (Nigeria)</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset2Country['phonecode'];?>" <?php if ($row_Recordset2Country[id]==$ccode) echo 'selected';?>>+<?php echo $row_Recordset2Country['phonecode'];?> (<?php echo $row_Recordset2Country['country'];?>)</option>
        <?php
} while ($row_Recordset2Country = mysqli_fetch_assoc($Recordset2Country));
  $rows = mysqli_num_rows($Recordset2Country);
  if($rows > 0) {
      mysqli_data_seek($Recordset2Country, 0);
      $row_Recordset2Country = mysqli_fetch_assoc($Recordset2Country);
  }
?></select><div class="select-dropdown"></div></div></div></div>



<div class="col_half2"><div class="input-group">
<input class="input--style-4" type="number" name="waphone" id="waphone" value="" placeholder="<?php echo $f3;?> *" style="-moz-border-radius: <?php echo $bordrad;?>px;-webkit-border-radius: <?php echo $bordrad;?>px;border-radius: <?php echo $bordrad;?>px;height: <?php echo $ffh; ?>px;font-size: <?php echo $formfontsize;?>px" required/></div></div></div>

<?php endif; ?>


<?php if ($f4show=='1'): ?>
<div class="col-12"><div class="input-group">
<label class="label"><?php echo $f4;?> <?php if ($f4req=='1') echo '*'; ?></label>
<input class="input--style-4" type="email" name="email" id="email" placeholder="<?php echo $f4;?> <?php if ($f4req=='1') echo '*'; ?>" style="-moz-border-radius: <?php echo $bordrad;?>px;-webkit-border-radius: <?php echo $bordrad;?>px;border-radius: <?php echo $bordrad;?>px;height: <?php echo $ffh; ?>px;font-size: <?php echo $formfontsize;?>px" <?php if ($f4req=='1') echo 'required'; ?>/></div></div>

<?php endif; ?>


<?php
$query_RecordsetF = "SELECT * FROM form_select_options where formid='$formid' group by opttype, position_order order by position_order";
$RecordsetF = mysqli_query($con, $query_RecordsetF) or die(mysqli_error($con));


while ($row_RecordsetG = mysqli_fetch_assoc($RecordsetF)) 
{ 
//echo $row_RecordsetG[opttype] . ' ,';

if ($row_RecordsetG[opttype]=='text')
    {
    echo '
     <label class="label">'.$row_RecordsetG[optload].' '.(($row_RecordsetG[optreq]=='1')?'*':"").'</label>
     <div class="col-12">
<div class="input-group">
    <input class="input--style-4" type="text" name="addedtext[]" value="" placeholder="'.$row_RecordsetG[optload].' '.(($row_RecordsetG[optreq]=='1')?'*':"").'" style="-moz-border-radius: '.$bordrad.'px;-webkit-border-radius: '.$bordrad.'px;border-radius: '.$bordrad.'px;height: '.$ffh.'px;font-size: '.$formfontsize.'px" '.(($row_RecordsetG[optreq]=='1')?'required="required"':"").'/><input type="hidden" name="addedtexthf[]" value="'.$row_RecordsetG['optload'].'"></div>
</div>
    ';	

	}

	if ($row_RecordsetG[opttype]=='checkbox'){ 

echo '<label>'.$row_RecordsetG['optload'].' '.(($row_RecordsetG[optreq]=='1')?'*':"").'</label><br>';

$sdq="select * from form_select_options where optload='$row_RecordsetG[optload]' ";
        $querysqd=mysqli_query($con, $sdq) or die(mysqli_error($con));

        
                    while($resf=mysqli_fetch_assoc($querysqd)){
                    $name = 'addedchk_'.$resf['position_order'].'[]';
                    $namehf = 'addedchkhf_'.$resf['position_order'].'[]';
        echo '<label class="checkbox-container">'.$resf['seloptions'].' <input type="checkbox" name="'.$name.'" '.(($row_RecordsetG[optreq]=='1')?'required="required"':"").' value="'.$resf['seloptions'].'"><span class="checkmark"></span></label><input type="hidden" name="'.$namehf.'" value="'.$row_RecordsetG['optload'].'"><br>';
                    }
                    echo '<br>';
   }






if ($row_RecordsetG[opttype]=='radio'){ 

echo '<label>'.$row_RecordsetG['optload'].' '.(($row_RecordsetG[optreq]=='1')?'*':"").'</label><br>';

$sdq="select * from form_select_options where optload='$row_RecordsetG[optload]' ";
        $querysqd=mysqli_query($con, $sdq) or die(mysqli_error($con));
	

        
                    while($resf=mysqli_fetch_assoc($querysqd)){
$name = 'addedrad_'.$resf['position_order'].'[]';
$namehf = 'addedradhf_'.$resf['position_order'].'[]';
        echo '<label class="radio-container">'.$resf['seloptions'].' <input type="radio" name="'.$name.'"  value="'.$resf['seloptions'].'" id="'.$resf['seloptions'].'"><span class="checkmark"></span></label><input type="hidden" name="'.$namehf.'" value="'.$row_RecordsetG['optload'].'"><br>';
                    }
                    echo '<br>';

 }




if ($row_RecordsetG[opttype]=='textarea'){ 

 echo '
<label class="label">'.$row_RecordsetG[optload].' '.(($row_RecordsetG[optreq]=='1')?'*':"").'</label>
<div class="col-12">
<div class="input-group">
    <textarea class="input--style-4" name="addedtextarea[]" placeholder="'.$row_RecordsetG[optload].' '.(($row_RecordsetG[optreq]=='1')?'*':"").'" style="width: 100%; -moz-border-radius: '.$bordrad.'px;-webkit-border-radius: '.$bordrad.'px;border-radius: '.$bordrad.'px;height: 120px;font-size: '.$formfontsize.'px" '.(($row_RecordsetG[optreq]=='1')?'required="required"':"").'/></textarea><input type="hidden" name="addedtextareahf[]" value="'.$row_RecordsetG['optload'].'"></div>
</div>';
 }



if ($row_RecordsetG[opttype]=='select'){ 

echo '
<label class="label">'.$row_RecordsetG['optload'].' '.(($row_RecordsetG[optreq]=='1')?'*':"").'</label>';

$sdq="select * from form_select_options where optload='$row_RecordsetG[optload]' ";
        $querysqd=mysqli_query($con, $sdq) or die(mysqli_error($con));
	

echo'
<div class="rs-select2 js-select-simple select--no-search-dx">
<select name="addedselect[]" style="-moz-border-radius: '.$bordrad.'px;-webkit-border-radius: '.$bordrad.'px;border-radius: '.$bordrad.'px;height: '.$ffh.'px;font-size: '.$formfontsize.'px; font-family: '.$ffamily.'" '.(($row_RecordsetG[optreq]=='1')?'required="required"':"").'>
	<option value="" selected>'.$row_RecordsetG['optload'].' '.(($row_RecordsetG[optreq]=='1')?'*':"").'</option>';

        
                    while($resf=mysqli_fetch_assoc($querysqd)){

                        echo '<option value="'.$resf['seloptions'].'">'.$resf['seloptions'].'</option>';
                    }
        
echo '</select><div class="select-dropdown"></div></div><input type="hidden" name="addedselecthf[]" value="'.$row_RecordsetG['optload'].'"><br>';
}



}
?>







<div style="font-size: <?php echo $formfontsize;?>px; color: <?php echo $labelcolor;?>; font-family: <?php echo $ffamily;?>" align="center"><strong> <?php echo $beforesubmitbtn; ?></strong></div>

<?php if ($tandc!=='') :?>
<label class="radio-container m-r-45"><input type="checkbox" name="" required="" style="margin-top: 14px;"/> I have read and agree to the website's <a href="#" id="myBtn"><u>terms and conditions *</u></a><span class="checkmark"></span></label>
<?php endif; ?>


<div id="errorMessageDiv" class="hidden" style="color: #ff0000"><b>Please, fill all the fields above...</b></div>


<div class="p-t-15" align="center">
                            <button id="sniperbutton" class="btn btn--radius-2 btn--blue" type="submit" style="width: auto;font-size:<?php echo $fontsize;?>px;border-color: <?php echo $bordercolor;?>;color: <?php echo $textcolor;?>;font-weight: bold;-moz-border-radius: <?php echo $bordrad;?>px;-webkit-border-radius: <?php echo $bordrad;?>px;border-radius: <?php echo $bordrad;?>px;font-family: <?php echo $ffamily;?>" name="submit"><?php echo $buttonlabel;?></button>
</div>




<input type="hidden" name="zq" id="zq" value="<?php echo $storeid;?>"><input type="hidden" name="fid" value="<?php echo $formid;?>"><input type="hidden" name="p1" value="<?php echo $p1;?>"><input type="hidden" name="usp" value="<?php echo $p3;?>"><input type="hidden" name="grk" value="<?php echo $grk;?>">




                        
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="https://app.wamation.com.ng/newform/vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="https://app.wamation.com.ng/newform/vendor/select2/select2.min.js"></script>
    <script src="https://app.wamation.com.ng/newform/vendor/datepicker/moment.min.js"></script>
    <script src="https://app.wamation.com.ng/newform/vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="https://app.wamation.com.ng/newform/js/global.js"></script>






<script type="text/javascript" src="https://app.wamation.com.ng/assets/js/btn.js"></script>

<script type="text/javascript" src="https://app.wamation.com.ng/assets/js/radioclick.js"></script>

<script type="text/javascript" src="https://app.wamation.com.ng/assets/js/btnfxnew.js"></script>

<script type="text/javascript" src="https://app.wamation.com.ng/js/iframeResizer.contentWindow.min.js" defer></script>

<script src="https://app.wamation.com.ng/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
  <script src='https://use.fontawesome.com/4ecc3dbb0b.js'></script>


<?php if ($tandc!=='') :?>
<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p><?php echo nl2br($row_Recordset2['tandc']);?></p>
    <br>

  </div>
</div>
<script src="https://app.wamation.com.ng/app-assets/js/scripts/modal.js"></script>
<?php endif; ?>


</body>

</html>