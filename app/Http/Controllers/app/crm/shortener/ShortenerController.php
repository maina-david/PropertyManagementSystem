<?php

namespace App\Http\Controllers\app\cms\shortener;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\cms\short_urls;
use Session;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Redirect;


class ShortenerController extends Controller
{
	public function index(){
		$url = short_urls::orderBy('id','DESC')->get();
		return view('app.cms.shortener.index')->withUrl($url);
	}

	public function store(Request $request){

		$url = new short_urls;

		$id=rand(10000,99999);

		$shorturl=base_convert($id,20,36);

		$url->long_url = $request->url;
		$url->short_code = $shorturl;
		$url->counter = 0;
		$url->user_id = Auth::user()->id;

		$url->save();

		Session::flash('Success','url has been shortend');

        return redirect()->route('url.shortener');
	}

	public function get($code){
		$url = short_urls::where('short_code',$code)->first();

		$count = $url->counter + 1;

		$url->counter = $count;
		$url->save();

		return Redirect::to($url->long_url);
	}

	public function delete($id){
		$url = short_urls::find($id);
		$url->delete();

		return redirect()->back();

	}
}
