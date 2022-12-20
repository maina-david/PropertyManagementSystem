<?php
namespace App\Helpers;
use App\Models\hr\employee_basic_info;
use App\Models\cms\knowledgebase\groups;
use App\Models\cms\knowledgebase\knowledgebase;
use App\Models\cms\pages\pages;
use App\Models\cms\blog\blog;
use App\Models\cms\blog\blog_category;
use App\Models\cms\blog\category;
use App\Models\limitless\settings;
use App\Models\cms\pages\custom_field;
use Auth;
class Cms
{
   /*====================== group ======================*/
   public static function check_group($id){
      $check = groups::where('id',$id)->where('businessID',Auth::user()->businessID)->count();
      return $check;
   }

   public static function group($id){
      $group = groups::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      return $group;
   }

   /*====================== knowledgeable ======================*/
   public static function articles_by_group_count($id){
      $count = knowledgebase::where('groupID',$id)->where('businessID',Auth::user()->businessID)->count();
      return $count;
   }


   /*====================== Pages ======================*/
   // get main pages
   public static function main_page($order){
      $pages = pages::where('parentID',0)
               ->where('publish_status','publish')
               ->where('visibility','public')
               ->OrderBy('page_order',$order)
               ->get();
      return $pages;
   }

   //check main page
   public static function check_main_page($id){
      $check = pages::where('parentID',0)->where('id',$id)->count();
      return $check;
   }

   // get parent page of a child page
   public static function get_main_page($id){
      $main = pages::where('parentID',0)->where('id',$id)->first();
      return $main;
   }

   public static function parent_page($id){
      $parent = pages::find($id);
      return $parent;

   }

   // check child pages
   public static function check_child($id){
      $check = pages::where('parentID',$id)->where('publish_status','publish')->where('visibility','public')->count();
      return $check;
   }

   // get child pages
   public static function child_page($id,$order){
      $children =  pages::where('parentID',$id)->where('publish_status','publish')->where('visibility','public')->orderby('id',$order)->get();
      return $children;
   }

   // get custom field
   public static function check_field($title,$id){
      $count = custom_field::where('pageID',$id)->where('title',$title)->count();
      return $count;
   }

   // get custom field
   public static function field($title,$id){
      $field = custom_field::where('pageID',$id)->where('title',$title)->first()->content;
      return $field;
   }

  //=====================================================================================================================
  //============================================ settings ==================================================================
  //=====================================================================================================================
   /*======== settings =======*/
   public static function check_settings($name){
      $check = settings::where('name',$name)->count();
      return $check;
   }

  /*======== settings =======*/
   public static function settings($name){
      $settings = settings::where('name',$name)->first()->value;
      return $settings;
   }

   //=====================================================================================================================
   //============================================ blog ==================================================================
   //=====================================================================================================================
   /*======== get posts =======*/
   public static function posts(){
      $posts = blog::where('status','publish')->orderby('id','desc')->paginate(5);
      return $posts;
   }

   /*======== get by category =======*/
   public static function post_categories($id){
      $blog = blog_category::join('cms_blog_category','cms_blog_category.category_id','=','cms_category_blogs.id')
               ->where('cms_blog_category.blog_id',$id)
               ->get();
      return $blog;
   }
   
   public static function all_post_categories(){
      $categories = category::get();
      return $categories;
   }

   /*======== latest article =======*/
   public static function latest($id){
      $latest = blog::join('blog_category','blogs.id','=','blog_category.blog_id')
               ->where('blog_category.id',$id)
               ->orderby('blogs.id','desc')
               ->select('*','blogs.created_at as blog_date','blogs.url as blog_url')
               ->limit(5)
               ->get();

      return $latest;
   }




}
