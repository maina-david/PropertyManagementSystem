<?php
namespace App\Http\Controllers\app\finance\products;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\products\product_information;
use App\Models\finance\products\product_inventory; 
use App\Models\finance\products\product_price;
use App\Models\hr\branches;
use Auth;
use Session;
use Hr;
class inventoryController extends Controller{

   public function __construct(){
      $this->middleware('auth');
   }

   /**
    * Display inventory
   *
   * @return \Illuminate\Http\Response
   */
   public function inventory($id){
      $mainBranch = branches::where('businessID',Auth::user()->businessID)->where('main_branch','Yes')->first();

      //product infromation 
      $product = product_information::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

      //get inventory per branch
      $inventories = product_inventory::where('productID',$id)->where('businessID',Auth::user()->businessID)->get();
      
      //outlets
      $outlets = branches::where('businessID',Auth::user()->businessID)->get();

      //default inventory
      $defaultInventory = product_inventory::where('productID',$id)->where('businessID',Auth::user()->businessID)->first();
      $productID = $id;

      return view('app.finance.products.inventory', compact('inventories','productID','product','outlets','mainBranch','mainBranch'));
   }

   /**
   * product inventory settings
   */
   public function inventory_settings(Request $request,$id){
      $product = product_information::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $product->track_inventory = $request->track_inventory;
      $product->same_price = $request->same_price;
      $product->save();
      Session::flash('success','Item inventory successfully updated');

      return redirect()->back();
   }

   /**
   * update product inventory
   *
   * @return \Illuminate\Http\Response 
   */
   public function inventroy_update(Request $request,$id,$productID){
      $product = product_inventory::where('id',$id)->where('productID',$productID)->where('businessID',Auth::user()->businessID)->first();

      $product->current_stock = $request->current_stock;
      $product->reorder_point = $request->reorder_point;
      $product->reorder_qty = $request->reorder_qty;
      $product->expiration_date = $request->expiration_date;
      $product->businessID = Auth::user()->businessID;
      $product->updated_by = Auth::user()->id;
      $product->save();

      if($product->current_stock > $product->reorder_point){
         $update = product_inventory::where('id',$id)->where('productID',$productID)->where('businessID',Auth::user()->businessID)->first();
         $update->notification = 0;
         $update->save();
      }
      
      Session::flash('success','Item inventory successfully updated');

      return redirect()->back();
   }

   /**
   * link outlet to inventory
   */
   public function inventory_outlet_link(Request $request){
      $this->validate($request,[
         'productID' => 'required',
         'outlets' => 'required'
      ]);

      $defaultBranch = branches::where('businessID',Auth::user()->businessID)->where('main_branch','Yes')->first();

      //add category
      $outlets = count(collect($request->outlets));
      if($outlets > 0){
         //upload new category
         for($i=0; $i < count($request->outlets); $i++ ){
            //check if outlet is linked
            if($defaultBranch->id != $request->outlets[$i]){
               $checkOutLet = product_inventory::where('productID',$request->productID)->where('branch_id',$request->outlets[$i])->where('businessID',Auth::user()->businessID)->count();
               if($checkOutLet == 0){
                  $out = new product_inventory;
                  $out->branch_id = $request->outlets[$i];
                  $out->productID = $request->productID;
                  $out->businessID = Auth::user()->businessID;
                  $out->created_by = Auth::user()->id;
                  $out->updated_by = Auth::user()->id;
                  $out->save();
               }

               $checkOutLet = product_price::where('productID',$request->productID)->where('branch_id',$request->outlets[$i])->where('businessID',Auth::user()->businessID)->count();
               if($checkOutLet == 0){
                  //link outlet to price
                  $priceOutlet = new product_price;
                  $priceOutlet->productID = $request->productID;
                  $priceOutlet->branch_id = $request->outlets[$i];
                  $priceOutlet->businessID = Auth::user()->businessID;
                  $priceOutlet->updated_by = Auth::user()->id;
                  $priceOutlet->created_by = Auth::user()->id;
                  $priceOutlet->save();
               }
            }
         }
      }

      Session::flash('success','Item successfully link to outlet');

      return redirect()->back();
   }

   /**
   * Delete inventroy link
   */
   public function delete_inventroy($productID,$branchID){
      $inventroy = product_inventory::where('productID',$productID)->where('branch_id',$branchID)->where('businessID',Auth::user()->businessID)->first();
      if($inventroy->current_stock == "" || $inventroy->current_stock == 0 ){
         product_inventory::where('productID',$productID)->where('branch_id',$branchID)->where('businessID',Auth::user()->businessID)->delete();
         product_price::where('productID',$productID)->where('branch_id',$branchID)->where('businessID',Auth::user()->businessID)->delete();
         Session::flash('success','Product successfully deleted');
         return redirect()->back();
      }else{
         Session::flash('warning','make sure you dont have any item in the location before deleting');

         return redirect()->back();
      }
   }

}
