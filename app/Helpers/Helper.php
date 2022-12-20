<?php

namespace App\Helpers;
class Helper
{
   public static function get_timeago( $ptime ){
      $estimate_time = time() - $ptime;

      if( $estimate_time < 1 )
      {
         return 'less than 1 second ago';
      }

      $condition = array(
                  12 * 30 * 24 * 60 * 60  =>  'year',
                  30 * 24 * 60 * 60       =>  'month',
                  24 * 60 * 60            =>  'day',
                  60 * 60                 =>  'hr',
                  60                      =>  'min',
                  1                       =>  'sec'
      );

      foreach( $condition as $secs => $str )
      {
         $d = $estimate_time / $secs;

         if( $d >= 1 )
         {
               $r = round( $d );
               return $r . ' ' . $str . ( $r > 1 ? '' : '' ) . ' ago';
         }
      }
   }

   public static function seoUrl($string) {
      //Lower case everything
      $string = strtolower($string);
      //Make alphanumeric (removes all other characters)
      $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
      //Clean up multiple dashes or whitespaces
      $string = preg_replace("/[\s-]+/", " ", $string);
      //Convert whitespaces and underscore to dash
      $string = preg_replace("/[\s_]/", "-", $string);
      return $string;
   }

   public static function generateRandomString($length = 6) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
         $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
   }

   /*======== get client ip =======*/
   public static function get_client_ip()
   {
      $ipaddress = '';
      if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
      else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
      else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
      else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
      else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
      else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
      else
            $ipaddress = 'UNKNOWN';

      return $ipaddress;
   }

   /*======== like match =======*/
   public static function like_match($pattern, $subject)
   {
      $pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
      return (bool) preg_match("/^{$pattern}$/i", $subject);
   }

   /*======== date difference =======*/
   public static function date_difference($enddate,$startdate){
      // Declare two dates
      $start_date = strtotime($startdate);
      $end_date = strtotime($enddate);

      // Get the difference and divide into
      // total no. seconds 60/60/24 to get
      // number of days
      $difference = ($end_date - $start_date)/60/60/24;

      if($difference == 0){
         $difference = 1;
      }

      return $difference;
   }
}
