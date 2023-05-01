<?php
// *************************************************************************
// *                                                                       *
// * DEPRIXA BASIC -  Freight Forwarding & Shipping Software Solutions     *
// * Copyright (c) JAOMWEB. All Rights Reserved                            *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: support@jaom.info                                              *
// * Website: https://deprixa.link/documentation/                          *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.                              *
// * If you Purchased from Codecanyon, Please read the full License from   *
// * here- http://codecanyon.net/licenses/standard                         *
// *                                                                       *
// *************************************************************************



require_once('helpers/querys.php');

if (isset($_GET['id'])) {
    $data = cdp_getCourierPrint($_GET['id']);
}

if (!isset($_GET['id']) or $data['rowCount'] != 1) {
    cdp_redirect_to("courier_list.php");
}



$row = $data['data'];

$db->cdp_query("SELECT * FROM cdb_add_order_item WHERE order_id='" . $_GET['id'] . "'");
$order_items = $db->cdp_registros();



$db->cdp_query("SELECT * FROM cdb_met_payment where id= '" . $row->order_pay_mode . "'");
$met_payment = $db->cdp_registro();


$db->cdp_query("SELECT * FROM cdb_courier_com where id= '" . $row->order_courier . "'");
$courier_com = $db->cdp_registro();

$db->cdp_query("SELECT * FROM cdb_category where id= '" . $row->order_item_category . "'");
$category = $db->cdp_registro();

$db->cdp_query("SELECT * FROM cdb_shipping_mode where id= '" . $row->order_service_options . "'");
$shipping_mode = $db->cdp_registro();

$fecha = date("Y-m-d :h:i A", strtotime($row->order_datetime));
$fechadataonly = date("Y-m-d", strtotime($row->order_datetime));

$db->cdp_query("SELECT * FROM cdb_users where id= '" . $row->receiver_id . "'");
$receiver_data = $db->cdp_registro();

$db->cdp_query("SELECT * FROM cdb_users where id= '" . $row->sender_id . "'");
$sender_data = $db->cdp_registro();





$db->cdp_query("SELECT * FROM cdb_address_shipments where order_track='" . $row->order_prefix . $row->order_no . "'");
$address_order = $db->cdp_registro();

$db->cdp_query("SELECT order_package, name_pack FROM cdb_add_order where order_no = " . $row->order_prefix . $row->order_no . "' INNER JOIN cdb_packaging ON cdb_add_order.order_package=cdb_packaging.id");
$packaging_method = $db->cdp_registro();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Courier DEPRIXA-Integral Web System" />
    <meta name="author" content="Jaomweb">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assetsNew/uploads/favicon.png">

    <title><?php echo $lang['inv-container37'] ?> - <?php echo $row->order_prefix . $row->order_no; ?></title>

    <!-- Web Fonts
    ======================= -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900' type='text/css'>

    <!-- Stylesheet
    ======================= -->
    <link rel="stylesheet" type="text/css" href="assetsNew/vendor/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assetsNew/vendor/font-awesome/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="assetsNew/dist/css/stylesheet.css" />
    <link rel="stylesheet" href="assetsNew/dist/css/themify-icons.css">
    <!--[if lt IE 8]><!-->
    <link rel="stylesheet" href="assetsNew/dist/css/ie7/ie7.css">
    <style type="text/css" media="print">
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font: 10px/1.4 Helvetica, Arial, sans-serif;
            color: black;
        }

        #page-wrap {
            width: 800px;
            margin: 0 auto;
        }

        textarea {
            border: 0;
            font: 10px Helvetica, Arial, sans-serif;
            overflow: hidden;
            resize: none;
        }

        table {
            border-collapse: collapse;
        }

        table td,
        table th {
            border: 1px solid black;
            padding: 1px;
        }

        tr.noBorder td {
            border: 0;
        }

        td.Border td {
            border: 1px;
        }

        #header {
            height: 15px;
            width: 100%;
            margin: 20px 0;
            background: #222;
            text-align: center;
            color: white;
            font: bold 10px Helvetica, Sans-Serif;
            text-decoration: uppercase;
            letter-spacing: 20px;
            padding: 3px 0px;
        }

        #address {
            width: 250px;
            height: 150px;
            float: left;
        }

        #customer {
            overflow: hidden;
        }

        #logo {
            text-align: right;
            float: right;
            position: relative;
            margin-top: 18px;
            border: 1px solid #fff;
            max-width: 540px;
            overflow: hidden;
        }

        #customer-title {
            font-size: 16px;
            font-weight: bold;
            float: left;
        }

        #meta {
            margin-top: 0px;
            width: 100%;
            float: right;
        }

        #meta td {
            text-align: right;
        }

        #meta td.meta-head {
            text-align: left;
            background: #6c757d;
        }

        #meta tr.meta-head {
            height: 8px;
        }

        #meta td textarea {
            width: 100%;
            height: 10px;
            text-align: right;
        }

        #signing {
            margin-top: 0px;
            width: 100%;
            float: center;
        }

        #signing td {
            text-align: center;
        }

        #signing td.signing-head {
            text-align: center;
            background: #eee;
        }

        #signing td textarea {
            width: 100%;
            height: 20px;
            text-align: center;
        }

        #items {
            clear: both;
            width: 100%;
            margin: 0px 0 0 0;
           
        }

        #items {
            margin-top: 2px;
            width: 100%;
            float: right;
        }

        #items th {
            background: #6c757d;
        }

        #items textarea {
            width: 80px;
            height: 50px;
        }

        #items tr.item-row td {
            vertical-align: top;
        }

        #items td.description {
            width: 300px;
        }

        #items td.item-name {
            width: 175px;
        }

        #items td.description textarea,
        #items td.item-name textarea {
            width: 100%;
        }

        #items td.total-line {
            border-right: 0;
            text-align: right;
        }

        #items td.total-value {
            border-left: 0;
            padding: 3px;
        }

        #items td.total-value textarea {
            height: 20px;
            background: none;
        }

        #items td.balance {
            background: #6c757d;
        }

        #items td.blank {
            border: 0;
        }

        #terms {
            text-align: center;
            margin: 10px 0 0 0;
        }

        #terms h5 {
            text-transform: uppercase;
            font: 13px Helvetica, Sans-Serif;
            letter-spacing: 10px;
            border-bottom: 1px solid black;
            padding: 0 0 8px 0;
            margin: 0 0 8px 0;
        }

        #terms textarea {
            width: 100%;
            text-align: center;
        }

        #sidebar,
        .bsocial,
        #post3,
        #up,
        .btn,
        #migaspan {
            display: none;
        }

        h1 {
            margin: 12px 0 -6px 0;
        }

        h2,
        h3 {
            margin: 0px 0 -6px 0;
        }

        .entry {
            line-height: 24px;
        }
    </style>


</head>

<body>
    <!-- Container -->
    <div id="page-wrap">
        <div class="container-fluid invoice-container">
            <!-- Header -->

            <!-- Main Content -->
            <?php for($x = 0; $x < 1; $x++){ ?>
            <main>
                <div >
                    <div >
                        <div class="table-responsive">
                            <table id="items">
                                <tr>
                                    <td class="col-4" style="font-size: 10px;">
                                        <div class="row">
                                            <div class="col-3">
                                                <center><?php echo ($core->logo) ? '<img src="assetsNew/uploads/logo1.png" alt="JD Courier &amp; Cargo Service"  height="45" class="center">' : $core->site_name; ?></center>
                                            </div>
                                            <div class="col-9" >
                                                                 <b><center> J.D. Courier & Cargo Service Pvt. Ltd. </br> Bizulibazar - 10, Kathmandu </br>Ph: 01-4790205 / 9849339329 </br>Email: jdcourier2072@gmail.com</center></b>                           
                                            </div>
                                            
                                        </div>

                                    </td>
                                    <td class="col-8" >
                                        <table style="font-size: 8px;">
                                            <tr>
                                                <td colspan="3" style="width: 54%;">
                                                    <center><b>Pan No.:<?php echo $core->c_nit; ?></b></center>
                                                </td>
                                                <td rowspan="3" style="width: 56%;">
                                                    
                                                    <img style="width: 240px; min-height: 80px; max-height: 80px;" src='https://barcode.tec-it.com/barcode.ashx?data=<?php echo $row->order_prefix . $row->order_no; ?>&code=EANUCC128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0' alt='' />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=" text-center" style="width: 18%;">
                                                    <b>ORIGIN</b>
                                                </td>
                                                <td class="text-center" style="width: 18%;">
                                                    <b>DEST</b>
                                                </td>
                                                <td class="text-center" style="width: 18%;">
                                                    <b>DATE</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=" text-center" style="width: 20%;" style="text-transform: capitalize; text-align:center "> <b><?php echo $address_order->sender_city; ?></b></td>
                                                <td  class=" text-center" style="width: 20%;" style="text-transform: capitalize; text-align:center;"><b><?php echo $address_order->recipient_city; ?></b></td>
                                                <td  class=" text-center" style="width: 20%;" style="text-transform: capitalize; text-align:center;"><b><?php echo $fechadataonly; ?></b> </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <!--1st-->
                                <tr>
                                    <table id="items">
                                        <tr>
                                            <td class="col-1 " style="text-transform: uppercase; font-size: 10px;">
                                              <center><strong><?php echo $lang['inv-shipping5'] ?>:</strong></center>  
                                            </td>
                                            <td class="col-5" style="text-transform: capitalize; font-size: 10px;">
                                                <center>
                                                    <b><?php echo $sender_data->fname . " " . $sender_data->lname; ?><br />
                                                        <?php echo $address_order->sender_address; ?><br><?php echo $sender_data->phone; ?></b>
                                                </center>
                                            </td>
                                            <td class="col-1" style="text-transform: uppercase; font-size: 10px;">
                                                <center><strong><?php echo $lang['inv-shipping20'] ?>:</strong></center>
                                            </td>
                                            <td class="col-5" style="text-transform: capitalize; font-size: 10px;">
                                                <center>
                                                    <b>
                                                        <?php echo $receiver_data->fname . " " . $receiver_data->lname; ?> <br />
                                                        <?php echo $address_order->recipient_address; ?><br><?php echo $receiver_data->phone; ?>
                                                    </b>
                                                </center>

                                            </td>
                                        </tr>
                                    </table>
                                </tr>
                                <!--2st-->
                                <tr>
                                    <table id="items">
                                        <tr>
                                            <td class="text-center" style=" font-size: 10px; width: 15%; ">
                                                <b><?php echo $lang['left213'] ?></b>
                                            </td>

                                            <td class="text-center" style="font-size: 10px; width: 8%;">
                                                <b>Pcs.</b>
                                            </td>
                                            <td class="text-center" style=" font-size: 10px; width: 10%;">
                                                <b>Weight</b>
                                            </td>

                                            <td class="text-center" style=" font-size: 10px; width: 8%;">
                                                <b>By</b>
                                            </td>
                                            <td class="text-center" style=" font-size: 10px; width: 7%;">
                                                <b>Rate</b>
                                            </td>
                                            <td class="text-center" style=" font-size: 10px; width: 13%;">
                                                <b>Fields</b>
                                            </td>
                                            <td class="text-center" style="font-size: 10px; width: 9%;">
                                                <b>Amount Rs.</b>
                                            </td>
                                            <td style=" font-size: 10px; width: 1%;">
                                                <b>Ps.</b>
                                            </td>
                                            <td class="text-center" style="font-size: 12px;">
                                                <b>Received in good Conditons</b>
                                            </td>

                                        </tr>

                                        <?php

                                        $sumador_total = 0;
                                        $sumador_libras = 0;
                                        $sumador_volumetric = 0;
                                        $sumador_valor_declarado = 0;
                                        $max_fixed_charge = 0;
                                        $precio_total = 0;
                                        $total_impuesto = 0;
                                        $total_seguro = 0;
                                        $total_peso = 0;
                                        $total_descuento = 0;
                                        $total_impuesto_aduanero = 0;
                                        $total_valor_declarado = 0;
                                        $subtotal_item = 0;

                                        foreach ($order_items as $row_item) {


                                            $description_item = $row_item->order_item_description;
                                            $category_item = $category->name_item;
                                            $weight_item = $row_item->order_item_weight;

                                            $total_metric = $row_item->order_item_length * $row_item->order_item_width * $row_item->order_item_height / $row->volumetric_percentage;

                                            // calculate weight x price
                                            if ($weight_item > $total_metric) {

                                                $calculate_weight = $weight_item;
                                                $sumador_libras += $weight_item; //Sumador

                                            } else {

                                                $calculate_weight = $total_metric;
                                                $sumador_volumetric += $total_metric; //Sumador
                                            }

                                            $precio_total = $calculate_weight * $row->value_weight;
                                            $precio_total = number_format($precio_total, 2, '.', ''); //Precio total formateado

                                            $sumador_total += $precio_total;
                                            $sumador_valor_declarado += $row_item->order_item_declared_value;
                                            $max_fixed_charge += $row_item->order_item_fixed_value;

                                            $subtotal_item = $sumador_total + $max_fixed_charge;

                                            if ($sumador_total > $core->min_cost_tax) {

                                                $total_impuesto = $sumador_total * $row->tax_value / 100;
                                            }

                                            if ($sumador_valor_declarado > $core->min_cost_declared_tax) {

                                                $total_valor_declarado = $sumador_valor_declarado * $row->declared_value / 100;
                                            }

                                            $total_descuento = $sumador_total * $row->tax_discount / 100;

                                            $total_peso = $sumador_libras + $sumador_volumetric;

                                            $total_seguro = $row->tax_insurance_value * $row->total_insured_value / 100;

                                            $total_impuesto_aduanero = $total_peso * $row->tax_custom_tariffis_value;

                                            $total_envio = ($sumador_total - $total_descuento) + $total_impuesto + $total_seguro + $total_impuesto_aduanero + $total_valor_declarado + $max_fixed_charge + $row->total_reexp;

                                            $sumador_total = number_format($sumador_total, 2, '.', '');
                                            $sumador_libras = number_format($sumador_libras, 2, '.', '');
                                            $sumador_volumetric = number_format($sumador_volumetric, 2, '.', '');
                                            $total_envio = number_format($total_envio, 2, '.', '');
                                            $total_seguro = number_format($total_seguro, 2, '.', '');
                                            $total_peso = number_format($total_peso, 2, '.', '');
                                            $total_impuesto_aduanero = number_format($total_impuesto_aduanero, 2, '.', '');
                                            $total_impuesto = number_format($total_impuesto, 2, '.', '');
                                            $sumador_valor_declarado = number_format($sumador_valor_declarado, 2, '.', '');
                                            $total_valor_declarado = number_format($total_valor_declarado, 2, '.', '');

                                        ?>



                                        <?php } ?>
                                        <tr class="text-center" style=" font-size: 10px; ">
                                            <td style=" font-size: 10px;">
                                                <?php echo $description_item; ?>
                                            </td>

                                            <td style="font-size: 10px;">
                                                <?php echo $row_item->order_item_quantity; ?>
                                            </td>
                                            <td style=" font-size: 10px;">
                                                <?php echo $weight_item; ?>
</td>
                                            <td style=" font-size: 10px;">
                                                <?php if ($category != null) {
                                                    echo $category->name_item;
                                                } ?>
                                            </td>
                                            <td>
                                            <?php echo $row->value_weight; ?>
                                            </td>
                                            <td class="text-center" style=" font-size: 10px;">
                                                Charges
                                            </td>
                                            <td style="font-size: 10px;">
                                                <?php echo $subtotal_item; ?>
                                            </td>
                                            <td style=" font-size: 10px;">

                                            </td>
                                            <td style="font-size: 10px;" rowspan="6" align="left">
                                                <b>Name:</b></br> </br>
                                                <b>Signature:</b></br> </br>
                                                <b>Date:</b></br> </br>
                                                <b>Seal:</b></br> </br>

                                            </td>

                                        </tr>
                                        <tr style=" font-size: 10px;">

                                            <td style=" font-size: 10px;" colspan="5">
                                                <b><?php echo $lang['inv-shipping6'] ?>:</b> <?php echo $met_payment->met_payment; ?>
                                            </td>


                                            <td class="text-center" style=" font-size: 10px;">
                                                Volume:
                                            </td>
                                            <td style="font-size: 10px;">
                                                <?php echo $row_item->order_item_length; ?> x <?php echo $row_item->order_item_width; ?> x <?php echo $row_item->order_item_height; ?>
                                            </td>
                                            <td style=" font-size: 10px;">

                                            </td>


                                        </tr>
                                        <tr style=" font-size: 10px;">
                                            <td colspan="5" class="text-center" style=" text-decoration: underline; font-size: 10px;">
                                                <b>Terms and Conditions</b>
                                            </td>
                                            <td class="text-center" style=" font-size: 10px;">
                                                Weight
                                            </td>
                                            <td style=" font-size: 10px;">
                                                <?php echo $row_item->order_item_weight; ?>
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr style=" font-size: 8px;">
                                            <td rowspan="5" colspan="5" style="align:justify; text-align: justify; text-justify: inter-word;">
                                                <div class="row">
                                                    <div class="col-9">
                                                        <?php echo cdp_cleanOut($core->interms); ?>  
                                                    </div>
                                                    <div class="col-3">
                                                        <center>
                                                                   <img src='https://barcode.tec-it.com/barcode.ashx?data=Tracking:+<?php echo $row->order_prefix . $row->order_no; ?>&code=QRCode&multiplebarcodes=false&translate-esc=false&unit=Fit&dpi=72&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0&eclevel=L' alt='' />
                                                                </center>
                                                    </div>
                                                </div>
                                                   
                                              
                                                
                                             </td>
                                            <td class="text-center">
                                                <?php echo $lang['leftorder24'] ?>
                                            </td>
                                            <td>
                                                <?php echo $total_seguro; ?>

                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        <tr style=" font-size: 10px;">
                                            <td class="text-center">
                                                Sub Total
                                            </td>
                                            <td>
                                                <?php echo $subtotal_item + $total_seguro; ?>
                                            </td>
                                            <td>

                                            </td>




                                        </tr>
                                        <tr style=" font-size: 10px;">


                                            <td class="text-center">
                                                <?php echo $lang['leftorder21'] ?> <?php echo $row_order->tax_discount; ?>
                                            </td>
                                            <td>
                                                <?php echo $total_descuento; ?>
                                            </td>
                                            <td>

                                            </td>




                                        </tr>
                                       
                                        <tr style=" font-size: 10px;">

                                            <td class="text-center">
                                                Govt. Tax.
                                            </td>
                                            <td>
                                                <?php echo $total_impuesto; ?>
                                            </td>
                                            <td>

                                            </td>
                                            <td rowspan="2">
                                                <b>Booked By:
                                                
                                            </td>



                                        </tr>
                                        <tr style=" font-size: 10px;">


                                            <td class="text-center">
                                                <b>Grand Total</b>
                                            </td>
                                            <td >
                                                <?php echo $total_envio; ?>
                                            </td>
                                            <td>

                                            </td>

                                        </tr>

                                    </table>
                                </tr>
                                <tr>
                                    <table id="items">
                                        <tr style="background-color:#0a0a0a;">

                                            <td style=" font-size: 10px; color:white !important; ">
                                                <span style="float:left;  "> <b>
                                                        <center>यस खामभित्र नगद तथा बहुमुल्य सामान भएमा कम्पनी जिम्मेवार हुने छै न।</center>
                                                    </b></span>
                                                <span style="float:right;">Don't put cash in envelop.</span>
                                            </td>

                                        </tr>

                                    </table>




                                </tr>
                                <!--4st-->
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            

            <?php if($x  != 2){
                echo ".....................................................................................................................................................................................................................................................................";
            } }?>
            <footer class="text-center">
                <div class="btn-group btn-group-sm d-print-none">

                    <button class="btn btn-light border text-black-50 shadow-none" onClick="window.print();" style="font-size:16px"><?php echo $lang['inv-shipping19'] ?>&nbsp;&nbsp; <i class="ti-printer"></i></button>
                </div>
            </footer>
        </div>
    </div>
</body>

</html>