<?php
namespace App\Http\Controllers\app\finance\products;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\products\product_information;
use App\Models\finance\suppliers\suppliers;
use App\Models\finance\products\product_price;
use App\Models\finance\products\product_inventory;
use App\Models\finance\products\category;
use App\Models\wingu\file_manager;
use App\Models\finance\invoice\invoice_products;
use App\Models\finance\products\tags;
use App\Models\finance\products\attributes;
use App\Models\finance\products\product_tag;
use App\Models\finance\products\product_category_product_information;
use App\Models\finance\products\brand;
use App\Models\hr\branches;
use App\Models\finance\tax;
use Session;
use Helper;
use Input;
use File; 
use Auth;
use Wingu;
use Hr;

class productController extends Controller{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
 * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      // if(Wingu::check_account_payment() == 'due'){
      //    return redirect()->route('account.plan');
      // }

      return view('app.finance.products.index');
   }

   /**
 * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      $categories = category::where('businessID',Auth::user()->businessID)->pluck('name','id');
      $attributes = attributes::where('businessID',Auth::user()->businessID)
                           ->where('parentID',0)
                           ->pluck('name','id')
                           ->prepend('','Choose attribute');
      $tags = tags::where('businessID',Auth::user()->businessID)->orderBy('id','desc')->pluck('name','id');
      $suppliers = suppliers::where('businessID',Auth::user()->businessID)
               ->pluck('supplierName','id')
               ->prepend('choose supplier','');
      $brands = brand::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose brand','');

      return view('app.finance.products.create', compact('categories','tags','suppliers','brands','attributes'));
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {
      $this->validate($request, [
         'product_name' => 'required',
         'code_type' => 'required',
      ]);

      $check = product_information::where('product_name',$request->product_name)->where('businessID',Auth::user()->businessID)->count();
      $product = new product_information;
      $product->product_name = $request->product_name;
      if ($request->code_type == 'Auto') {
         $product->sku_code = Helper::generateRandomString(9);
      }elseif($request->code_type == 'Custom'){
         $product->sku_code = $request->sku_code;
      }
      $product->brandID = $request->brandID;
      $product->product_code = Helper::generateRandomString(10);
      $product->type = $request->type;
      $product->supplierID = $request->supplierID;
      $product->attributeID = $request->attributeID;
      $product->pos_item = $request->pos_item;
      $product->active = $request->status;
      $product->ecommerce_item = $request->ecommerce_item;
      $product->businessID = Auth::user()->businessID;
      $product->created_by = Auth::user()->id;
      if ($check > 1) {
         $product->url = Helper::seoUrl($request->product_name).'-'.Helper::generateRandomString(4);
      }else{
         $product->url = Helper::seoUrl($request->product_name);
      }
      $product->save();

      //product price
      $product_price = new product_price;
      $product_price->productID = $product->id;
      $product_price->default_price = 'Yes';
      $product_price->businessID = Auth::user()->businessID;
      $product_price->created_by = Auth::user()->id;
      $product_price->save();

      //product inventory
      $product_inventory = new product_inventory;
      $product_inventory->productID = $product->id;
      $product_inventory->default_inventory = 'Yes';
      $product_inventory->businessID = Auth::user()->businessID;
      $product_inventory->created_by = Auth::user()->id;
      $product_inventory->save();

      //add category
      $category = count(collect($request->category));
         if($category > 0){
         //upload new category
         for($i=0; $i < count($request->category); $i++ ) {
               $cat = new product_category_product_information;
               $cat->productID = $product->id;
               $cat->categoryID = $request->category[$i];
               $cat->save();
         }
      }

      //add tags
      $tg = count(collect($request->tags));
         if($tg > 0){
         for($i=0; $i < count($request->tags); $i++ ) {
               $tag = new product_tag;
               $tag->product_id = $product->id;
               $tag->tags_id = $request->tags[$i];
               $tag->save();
         }
      }

      Session::flash('success','Item successfully added.');

      return redirect()->route('finance.products.edit', $product->id);
   }

   /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function details($id)
   {
      $details = product_information::join('business','business.id','=','product_information.businessID')
                     ->join('currency','currency.id','=','business.base_currency')
                     ->join('product_inventory','product_inventory.productID','=','product_information.id')
                     ->join('product_price','product_price.productID','=','product_information.id')
                     ->where('type','!=','subscription')
                     ->whereNull('parentID')
                     ->where('product_information.id',$id)
                     ->where('product_information.businessID', Auth::user()->businessID)
                     ->select('*','product_information.id as proID','product_information.created_by as creator')
                     ->orderBy('product_information.id','desc')
                     ->first();

      return view('app.finance.products.details.show', compact('details'));
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {
      $product = product_information::where('product_information.id',$id)
                     ->where('product_information.businessID',Auth::user()->businessID)
                     ->select('*','product_information.id as productID')
                     ->first();

      $attributes = attributes::where('businessID',Auth::user()->businessID)
                           ->where('parentID',0)
                           ->pluck('name','id')
                           ->prepend('Choose attribute','');

      $productID = $id;

      //category
      $category = category::where('businessID',Auth::user()->businessID)->get();
      $joincat = array();
      foreach ($category as $joint) {
         $joincat[$joint->id] = $joint->name;
      }

      //join category
      $getjoint = product_category_product_information::join('product_category','product_category.id', '=' ,'product_category_product_information.categoryID')
                  ->where('productID',$id)
                  ->select('product_category.id as catid')
                  ->get();
      $jointcategories = array();
      foreach($getjoint as $cj){
         $jointcategories[] = $cj->catid;
      }

      //tags
      $tags = tags::where('businessID',Auth::user()->businessID)->get();
      $jointag = array();
      foreach ($tags as $tag) {
         $jointag[$tag->id] = $tag->name;
      }

      //join category
      $gettags = product_tag::join('tags','tags.id', '=' ,'product_tag.tags_id')
                  ->where('product_id',$id)
                  ->select('tags.id as tagsID')
                  ->get();

      $jointtags = array();
      foreach($gettags as $tg){
         $jointtags[] = $tg->tagsID;
      }


      $suppliers = suppliers::where('businessID',Auth::user()->businessID)
               ->pluck('supplierName','id')
               ->prepend('choose supplier','');

      $brands = brand::where('businessID',Auth::user()->businessID)->pluck('name','id')->prepend('Choose brand','0');

      return view('app.finance.products.edit', compact('product','jointcategories','jointtags','joincat','jointag','productID','suppliers','brands','attributes'));
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id)
   {
      $this->validate($request, [
         'product_name' => 'required',
      ]);

      $product = product_information::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

      if($product->product_name != $request->product_name || $product->url == ""){
         $check = product_information::where('product_name',$request->product_name)->count();
         if ($check > 1) {
               $product->url = Helper::seoUrl($request->product_name).'-'.Helper::generateRandomString(4);
         }else{
               $product->url = Helper::seoUrl($request->product_name);
         }
      }
      if($product->product_code == ""){
         $product->product_code = Helper::generateRandomString(10);
      }
      $product->product_name = $request->product_name;
      $product->sku_code = $request->sku_code;
      $product->brandID = $request->brandID;
      $product->supplierID = $request->supplierID;
      $product->attributeID = $request->attributeID;
      $product->pos_item = $request->pos_item;
      $product->active = $request->status;
      $product->ecommerce_item = $request->ecommerce_item;
      $product->type = $request->type;
      $product->businessID = Auth::user()->businessID;
      $product->updated_at = Auth::user()->id;
      $product->save();


      $category = count(collect($request->category));
      //update category
         if($category > 0){
         //delete existing category
         product_category_product_information::where('productID',$id)->delete();

         //upload new category
         for($i=0; $i < count($request->category); $i++ ) {
               $cat = new product_category_product_information;
               $cat->productID = $id;
               $cat->categoryID = $request->category[$i];
               $cat->save();
         }
      }

      $tg = count(collect($request->tags));

      //update category
         if($tg > 0){
         //delete existing category
         $deleteCategory = product_tag::where('product_id',$id)->delete();
         for($i=0; $i < count($request->tags); $i++ ) {
               $tag = new product_tag;
               $tag->product_id = $id;
               $tag->tags_id = $request->tags[$i];
               $tag->save();
         }
      }

      Session::flash('success','Item successfully updated !');

      return redirect()->back();
   }


   /**
    * product description
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function description($id){
      $product = product_information::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $productID = $id;
      return view('app.finance.products.description', compact('product','productID'));
   }


   /**
   * update product description
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function description_update(Request $request,$id){

      $product = product_information::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $product->short_description = $request->short_description;
      $product->description = $request->description;
      $product->businessID = Auth::user()->businessID;
      $product->updated_by = Auth::user()->id;
      $product->save();

      Session::flash('success','Item description updated successfully');

      return redirect()->back();
   }


   /**
 * product price
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function price($id)
   {
      $mainBranch = branches::where('businessID',Auth::user()->businessID)->where('main_branch','Yes')->first();
      $product = product_information::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $defaultPrice = product_price::where('productID', $id)->where('businessID', Auth::user()->businessID)->where('default_price','Yes')->first();
      $prices = product_price::where('productID', $id)->where('businessID', Auth::user()->businessID)->get();
      $taxes = tax::where('businessID',Auth::user()->businessID)->get();
      $outlets = branches::where('businessID',Auth::user()->businessID)->get();
      $productID = $id;

      return view('app.finance.products.price', compact('prices','taxes','productID','product','outlets','defaultPrice','mainBranch'));
   }


   /**
   * Update product price
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function price_update(Request $request, $id)
   {
      $this->validate($request, array(
         'buying_price'=>'required',
         'selling_price'=>'required'
      ));


      $price = product_price::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

      $price->buying_price = $request->input('buying_price');
      $price->taxID = $request->input('taxID');
      $price->selling_price = $request->input('selling_price');
      $price->offer_price = $request->offer_price;

      $price->save();

      session::flash('success','You have successfully edited item price!');

      return redirect()->back();
   }


   /**
 * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function destroy($id)
   {
      //check product in invoice
      $invoice = invoice_products::where('productID',$id)->count();

      if($invoice == 0){
         //delete image from folder/directory
         $check_image = file_manager::where('fileID',$id)->where('businessID', Auth::user()->businessID)->where('folder','products')->count();

         if($check_image > 0){
               //directory
               $directory = base_path().'/storage/files/business/'.Wingu::business(Auth::user()->businessID)->primary_email.'/finance/products/';
               $images = file_manager::where('fileID',$id)->where('businessID', Auth::user()->businessID)->where('folder','products')->get();
               foreach($images as $image){
               if (File::exists($directory)) {
                  unlink($directory.$image->file_name);
               }
               $image->delete();
               }
         }

         product_information::where('id', $id)->where('businessID', Auth::user()->businessID)->delete();
         product_inventory::where('productID', $id)->where('businessID', Auth::user()->businessID)->delete();
         //delete categories
         $categories = product_category_product_information::where('productID',$id)->get();
         foreach($categories as $category){
            product_category_product_information::find($category->id)->delete();
         }

         //delete tags
         $tags = product_tag::where('product_id',$id)->get();
         foreach($tags as $tag){
            product_tag::find($tag->id)->delete();
         }

         //delete price
         product_price::where('productID', $id)->where('businessID', Auth::user()->businessID)->delete();

         Session::flash('success', 'The Item was successfully deleted !');

         return redirect()->back();

      }else{
         Session::flash('error','You have recorded transactions for this product. Hence, this product cannot be deleted.');
         return redirect()->back();
      }
   }

   /**
   * get product price via ajax
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function productPrice(Request $request){
		return json_encode(product_price::where('productID', $request->product)->first());
   }

   public function express_store(Request $request){
      $primary = new customers;
		$primary->customer_name = $request->customer_name;
      $primary->businessID = Auth::user()->businessID;
      $primary->created_by = Auth::user()->id;
		$primary->save();

		$address = new address;
		$address->customerID = $primary->id;
		$address->save();

   }

   public function express_list(Request $request)
   {
      $accounts = product_information::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get(['id', 'product_name as text']);
      return ['results' => $accounts];
   }
}
