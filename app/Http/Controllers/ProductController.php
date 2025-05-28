<?php

namespace App\Http\Controllers;

use App\Models\Log as ModelsLog;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    //for adding a quantiy for a specific product
    public function add_product(Request $request){
        try{
            $product = new Product();

            $p = json_decode($request->data);

            if(!$p){
                Log::info('data',['data'=>$p]);
                return response()->json(['message'=>'empty']);
            }

            $product->name = $p->name;
            $product->description = $p->description;
            $product->price = (float) $p->price;
            $product->quantity = (int) $p->quantity;

            if($product->save()){
                $log = new ModelsLog();
                $log->note = "You have added a product";
                $log->action = "add product";
                $log->status = "successful";
                $log->save();
                return response()->json(['message'=>'success']);
            }
        }
        catch(\Exception $er){
            $log = new ModelsLog();
            $log->note = "You have added a product";
            $log->action = "add product";
            $log->status = "error";
            $log->save();
            return response()->json(['message'=>$er->getMessage()]);
        }
    }

    //to return all products
    public function return_product(){
        try{
            $products = Product::get();

            return response()->json(['message'=>$products]);
        }
        catch(\Exception $er){
            return response()->json(['message'=>$er->getMessage()]);
        }
    }

    // to edit product
    public function edit_product(Request $request){
        try{

            $product = Product::where('id',$request->id)->first();

            $p = json_decode($request->data);

            if(!$product){
                return response()->json(['message'=>'empty']);
            }

            $product->name = $p->name;
            $product->description = $p->description;
            $product->price = (float) $p->price;
            $product->quantity = (int) $p->quantity;

            if($product->save()){
                $log = new ModelsLog();
                $log->note = "You have edited a product $product->name";
                $log->action = "edit product";
                $log->status = "successful";
                $log->save();
                return response()->json(['message'=>'success']);
            }

        }
        catch(\Exception $er){
                            $log = new ModelsLog();
                $log->note = "You have edited a product $product->name";
                $log->action = "edit product";
                $log->status = "error";
                $log->save();
            return response()->json(['message'=>$er->getMessage()]);
        }
    }

    public function add_quantity(Request $request){
        try{
            //fetch the product using id
            $product = Product::where('id', $request->id)->first();

            if(!$product){
                return response()->json(['message'=>'empty']);
            }

            //store the current quantity
            $quan = $product->quantity;

            //add
            $product->quantity = $quan + $request->new_quantity;

            if($product->save()){
                $log = new ModelsLog();
                $log->note = "You have added stock of $product->name";
                $log->action = "add stock";
                $log->status = "successful";
                $log->save();
                return response()->json(['message'=>'success']);
            }
        }
        catch(\Exception $er){
                            $log = new ModelsLog();
                $log->note = "You have added stock of $product->name";
                $log->action = "add stock";
                $log->status = "error";
                $log->save();
            return response()->json(['message'=>$er->getMessage()]);
        }
    }

    public function delete_product(Request $request){
        try{

            $product = Product::where('id',$request->id)->first();

            if(!$product){
                return response()->json(['message'=>'empty']);
            }

            if($product->delete() == 1){
                $log = new ModelsLog();
                $log->note = "You have deleted an item $product->name";
                $log->action = "delete item";
                $log->status = "successful";
                $log->save();
                return response()->json(['message'=>'success']);
            }
            else{
                $log = new ModelsLog();
                $log->note = "You have deleted an item $product->name";
                $log->action = "delete item";
                $log->status = "error";
                $log->save();
                return response()->json(['message'=>'error']);
            }

        }
        catch(\Exception $er){
                            $log = new ModelsLog();
                $log->note = "You have deleted an item $product->name";
                $log->action = "delete item";
                $log->status = "error";
                $log->save();
            return response()->json(['message'=>$er->getMessage()]);
        }
    }

    public function returnLogs(){
        try{

            $logs = ModelsLog::get();

            return response()->json(['message'=>$logs]);
        }
        catch(\Exception $er){

            return response()->json(['message'=>$er->getMessage()]);
        }
    }

}
