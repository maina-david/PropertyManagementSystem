<?php

namespace App\Http\Controllers\backend\settings\Language;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\general\languages;
use App\Model\general\language_sections as section;
use App\Model\general\settings;
use DB;
use File;
use Session;
use Auth;
use App\Model\admin\Admin;
class languageController extends Controller
{
   /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(){
      $languages = languages::all();

      $current_language = settings::
               join('languages', 'languages.id', '=', 'settings.language_id')
               ->select('languages.id', 'languages.name', 'languages.short')
               ->where('settings.id', 1)
               ->first();

      return view('modules.settings.language.index')->withLanguages($languages)->withCl($current_language);
   }

   public function defaultLanguage(Request $request){

      $this->validate($request, array(
         'language' => 'required',
      ));
         
      $update                 = settings::find(1);
      $update->language_id    = $request->language;
      $update->save();  

      return redirect()->back();
   }

   public function store(Request $request)
   {
      $this->validate($request, array(
         'name'          => 'required',
         'short_name'    => 'required'
      ));     
      
      $dir = strtolower($request->short_name);
         
      if (!File::exists(resource_path() . '/lang/' . $dir))
      {
         $store              = new languages;
         $store->name        = $request->name;
         $store->short       = $dir;
         $store->save();             
         
         File::copyDirectory( resource_path() . '/lang/_original', resource_path() . '/lang/' . $dir, 0777);
      }

      return redirect()->back();
   }

   public function show($id,$section){
      $data = array(
         'original'   => File::getRequire(resource_path().'/lang/_default/'.$section.'.php'),
         'translated' => File::getRequire(resource_path().'/lang/'.languages::where('id', $id)->first()->short.'/'.$section.'.php')
      );

      $get_language = languages::where('id', $id)->first();

      $sects = section::Orderby('id','desc')->get();

      return view('modules.settings.language.show', $data)->withLanguage($get_language)->withSection($section)->withSects($sects);
   }

   public function post_show(Request $request){

      $data = array(
         'original'      => File::getRequire(resource_path().'/lang/_default/'.$request->section.'.php'),
         'translated'    => File::getRequire(resource_path().'/lang/'.languages::where('id', $request->languageID)->first()->short . '/'.$request->section.'.php')
      );

      $get_language = languages::where('id', $request->languageID)->first();

      $sects = section::Orderby('id','desc')->get();
      
      return view('modules.settings.language.show', $data)->withLanguage($get_language)->withSection($request->section)->withSects($sects);
   }
   
   public function translate(Request $request){

      $dir    = languages::where('id', $request->languageID)->first()->short;
      $words  = $request->words;
      
      $contents = "
      <?php
      return array(";
      
      foreach ($words as $k => $v)
      {
         $contents .='"'.$k.'" => "'.$v.'",';
      }
   
      $contents .= ");";
      
      File::put(resource_path().'/lang/'.$dir.'/'.$request->section.'.php', $contents);

      return redirect()->route('language.show', [$request->languageID, $request->section]);
   }

   public function edit($id){
      $languages = languages::all();
      $current_language = settings::
               join('languages', 'languages.id', '=', 'settings.language_id')
               ->select('languages.id', 'languages.name', 'languages.short')
               ->where('settings.id', 1)
               ->first();
      $get_language = languages::where('id', $id)->first();
      return view('modules.settings.language.edit')->withLanguages($languages)->withCl($current_language)->withEdit($get_language);
   }

   public function update(Request $request, $id){

      $languages = languages::where('id',$id)->first();

      $languages->name = $request->name;
      $languages->short = $request->short;

      $languages->save();

      Session::flash('success','The Language has been successfully updated');

      return redirect()->back();
   }

   public function destroy($id)
   {
      return 'its working';
      // $delete = languages::where('id',$id)->first();
      // $delete->delete();
      
      // Session::flash('success','The Language has been successfully deleted');

      // return redirect()->back();
   }
}
