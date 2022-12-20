<?php

namespace App\Http\Controllers\lab;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class mailchimpController extends Controller
{
   public function index()
   {
      $listId = '3560828';

      $mailchimp = new \Mailchimp('5be8e63560448a4f2e0e106c22e2ccd7-us2');

      $campaign = $mailchimp->campaigns->create('regular', [
         'list_id' => $listId,
         'subject' => 'Example Mail',
         'from_email' => 'rajeshgajjar1997@gmail.com',
         'from_name' => 'Rajesh',
         'to_name' => 'Rajesh Subscribers'

      ], [
         'html' => 'aSAsaS',
         'text' => strip_tags('aSAsaS')
      ]);

      //Send campaign
      $mailchimp->campaigns->send($campaign['id']);

      dd('Campaign send successfully.');
   }
}
