<?php

namespace App\Http\Controllers\app\callbacks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class callbacksController extends Controller
{
   public function ipay(){
      return 'woring';
   }

   public function kepler9(){
      $json_data = file_get_contents('php://input');
      $data = json_decode($json_data,true);

      
         return $data;
         
      //get orderID
      $orderID = str_replace("bluetree#","",$data['callback_data']['BillRefNumber']);


      return $orderID;
      
      //get the amount paid 
      $amountPaid = $data['callback_data']['TransAmount'];

      //updated order
      $order = product_orders::where('order_id',$orderID)->first();
      $balance = $order->balance;
      $newBalance = $balance - $amountPaid;

      $order->balance = $newBalance;
      if($newBalance <= 0){
         $order->payment_status = 'paid';
      }
      $order->save();

      //record transaction
      $payments  = new payments();
      $payments->amount = $data['callback_data']['TransAmount'];
      $payments->balance = $newBalance;
      $payments->payment_date = date("Y-m-d");
      $payments->payment_method = 'Kepler9';
      $payments->reference_number = $data['callback_data']['TransID'];
      $payments->order_id = $orderID;
      $payments->user_id = $order->userID;
      $payments->save();

      //get order details
      $user = User::find($order->userID);

      //check order item if digital
      if($order->payment_status == 'paid'){
         //check if order has a digital product
         $checkDigitalProduct = order_items::join('product_information','product_information.id','=','order_items.productID')
                                             ->join('product_media','product_media.productID','=','order_items.productID')
                                             ->where('orderID',$order->id)
                                             ->where('product_information.type','digital')
                                             ->where('product_media.type','download')
                                             ->count();
         if($checkDigitalProduct > 0){

            //digital Item
            $digitalProduct = order_items::join('product_information','product_information.id','=','order_items.productID')
                                             ->where('orderID',$order->id)
                                             ->where('type','digital')
                                             ->select('*','product_information.id as productID')
                                             ->get();

            foreach($digitalProduct as $digiprod){

               $download = new affiliate;

               //tracking code 
               $id = rand(10000,99999);
               $shorturl = base_convert($id,20,36);
               $url = 'https://wingu.juliani.co.ke/storage/digital/'.$shorturl;

               //save 
               $download->long_url = $url;
               $download->short_code = $shorturl; 
               $download->userID = $order->userID; 
               $download->productID = $digiprod->productID;
               $download->save();

               //send download link
               $mail = new PHPMailer(true);
               $mail->SMTPDebug = 1;                                 // Set mailer to use SMTP
               $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
               $mail->SMTPAuth = true;                               // Enable SMTP authentication
               $mail->Username = 'notify@juliani.co.ke';             // SMTP username
               $mail->Password = 'classic2030';                      // SMTP password
               $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
               $mail->Port = 587;                                    // TCP port to connect to

               //Recipients
               $mail->setFrom('notify@juliani.co.ke', 'Juliani');
               $mail->addAddress($user->email);                         // Add
               $mail->addAddress('info@juliani.co.ke', $digiprod->product_name.' Download Link');  // Add

               //Content
               $mail->isHTML(true);                                     // Set email format to HTML
               $mail->Subject = $digiprod->product_name.' Download Link';

               // Compose a simple HTML email message
               $message = '<html><body>';
               $message .= '<h3 style="color:#333;">'.$digiprod->product_name.' Download Link</h3>';
               $message .= '<p style="color:#333;font-size:14px;">Niaje '.$user->name.'</p>';
               $message .= '<p style="color:#333;font-size:14px;">This is your personal '.$digiprod->product_name.' Download Link </p>';
               $message .= '<p style="color:#333;font-size:14px;"><b>Link: <a href="'.$url.'">'.$url.'</a></b></p>';
               $message .= '<p style="color:#333;font-size:14px;">Juliani Music <br> Nairobi | Kenya <br> Email: julianimusik@gmail.com | Website: www.juliani.co.ke</p>';
               $message .= '<p style="color:#333;font-size:14px;text-align:center"> Powered By <a href="https://winguplus.com/">WinguPlus</a></p>';
               $message .= '</body></html>';
               $mail->Body = $message;

               $mail->send();
            }
         }
      }

      //redirect to order page
      $mail = new PHPMailer(true);
      $mail->SMTPDebug = 1;                                 // Set mailer to use SMTP
      $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'notify@juliani.co.ke';             // SMTP username
      $mail->Password = 'classic2030';                      // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 587;                                    // TCP port to connect to

      //Recipients
      $mail->setFrom('notify@juliani.co.ke', 'Juliani');
      $mail->addAddress($user->email, 'Payment Confirmation');                         // Add
      $mail->addAddress('info@juliani.co.ke', 'Payment Confirmation');  // Add

      //Content
      $mail->isHTML(true);                                     // Set email format to HTML
      $mail->Subject = 'Payment Confirmation';

      // Compose a simple HTML email message
      $message = '<html><body>';
      $message .= '<h3 style="color:#333;">Payment Confirmation</h3>';
      $message .= '<p style="color:#333;font-size:14px;">Niaje '.$user->name.'</p>';
      $message .= '<p style="color:#333;font-size:14px;">Thank you for your support, We have received your payment for <b>Order# '.$orderID.'</b> | Amount Recieved <b>ksh '.$data['callback_data']['TransAmount'].'</p>';
      $message .= '<p style="color:#333;font-size:14px;">Juliani Music <br> Nairobi | Kenya <br> Email: julianimusik@gmail.com | Website: www.juliani.co.ke</p>';
      $message .= '<p style="color:#333;font-size:14px;text-align:center"> Powered By <a href="https://winguplus.com/">WinguPlus</a></p>';
      $message .= '</body></html>';
      $mail->Body = $message;

      $mail->send();
   }
}
