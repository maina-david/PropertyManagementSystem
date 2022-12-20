<?php
namespace App\Http\Controllers\app\crm\mail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\crm\emails;
use Webklex\IMAP\Client;
//use Webklex\IMAP\Facades\Client;
use Auth;

class mailController extends Controller
{
   public function inbox(){
      $oClient = new Client([
         'host'          => 'mail.bluetreeagency.com',
         'port'          => 993,
         'encryption'    => 'ssl',
         'validate_cert' => false,
         'username'      => 'kisia@bluetreeagency.com',
         'password'      => 'paviliondv77',
         'protocol'      => 'imap'
      ]);

      /* Alternative by using the Facade
      $oClient = Webklex\IMAP\Facades\Client::account('default');
      */

      //Connect to the IMAP Server
      $oClient->connect();

      //Get all Mailboxes
      /** @var \Webklex\IMAP\Support\FolderCollection $aFolder */
      $aFolder = $oClient->getFolders();

      //Loop through every Mailbox
      /** @var \Webklex\IMAP\Folder $oFolder */
      // foreach($aFolder as $oFolder){

      //    //Get all Messages of the current Mailbox $oFolder
      //    /** @var \Webklex\IMAP\Support\MessageCollection $aMessage */
      //    $aMessage = $oFolder->messages()->all()->get();
         
      //    /** @var \Webklex\IMAP\Message $oMessage */
      //    foreach($aMessage as $oMessage){
      //       echo $oMessage->getSubject().'<br />';
      //       echo 'Attachments: '.$oMessage->getAttachments()->count().'<br />';
      //       echo $oMessage->getHTMLBody(true);
            
      //       //Move the current Message to 'INBOX.read'
      //       if($oMessage->moveToFolder('INBOX.read') == true){
      //             echo 'Message has ben moved';
      //       }else{
      //             echo 'Message could not be moved';
      //       }
      //    }
      // }

      return view('app.crm.mail.inbox', compact('aFolder'));
   }

   public function sent()
   {
      $emails = emails::join('customers','customers.id','=','mail.clientID')
                        ->where('mail.businessID',Auth::user()->businessID)
                        ->orderby('mail.id','desc')
                        ->select('*','mail.created_at as sentDate','mail.id as mailID')
                        ->paginate(16);
      $totalEmails = emails::where('businessID',Auth::user()->businessID)->count();

      return view('app.crm.mail.sent', compact('emails','totalEmails'));
   } 

   public function compose()
   {
      return view('app.crm.mail.compose');
   }

   public function details($id){
      $email = emails::join('customers','customers.id','=','mail.clientID')
               ->where('mail.businessID',Auth::user()->businessID)
               ->where('mail.id',$id)
               ->orderby('mail.id','desc')
               ->select('*','mail.created_at as sentDate','mail.id as mailID')
               ->first();

      return view('app.crm.mail.details', compact('email'));
   }

   public function track($code,$businessID,$mailID){
      $track = emails::where('id',$mailID)
                     ->where('tracking_code',$code)
                     ->where('businessID',$businessID)
                     ->first();

      $count = $track->view_count;

      if($track->date_view == ""){
         $track->view_status = 'Read';
         $track->date_view = date("Y-m-d H:i:s");
         $track->view_count = $count + 1;
      }else{
         $track->view_count = $count + 1;
      }
      $track->save();
   }

}
