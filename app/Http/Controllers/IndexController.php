<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo as Photo;
use App\Product as Products;
use App\Size as Size;
use App\Color as Color;
use App\Slide as Slide;
use App\Catagorie as Catagory;
use Storage;
use App\Subscriber as Subscriber;
use App\Gbp as GBP;
use App\Catagories_item as Item;
use App\Simple_index as Simple_index;
use App\Sub_catagorie as Sub_catagory;
use App\Request as Links;
use Session;
use App\Delivery_cost as delivery_cost;
use App\Browsed_product as Browse_product;
use Auth;
use App\User as User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PassowrdResetLinkSentMail;
use App\Mail\NewRequestMail;
use App\Admin as Admin;
use App\Mail\NewRequestMailToUser;
use App\Tag as Tags;


class IndexController extends Controller
{
    public function showIndex(){
        $Simple_index = Simple_index::with('simple_belongs')->get();
        $Slide = Slide::all();
        return view('User.homepage' , ['Slide'=>$Slide , 'Simple_index'=>$Simple_index]);
    }

    public function QuantityContainer($id){
        $Size = Products::find(decrypt($id));
        $Size->Size;
        $Quantity_array = array();
        foreach ($Size->Size as $item){
            $Quantity_array[] = array("size"=>$item->size,"quantity"=>$item->quantity);
        }
        return $Quantity_array;
    }

    public function showProductDetail(Request $request){
        if(Auth::user()){
            $history = Browse_product::where(['user_id'=>Auth::user()->id, 'product_id'=>decrypt($request->id)])->get();
            if(sizeof($history)==0){
                $history = new Browse_product();
                $history->user_id = Auth::user()->id;
                $history->product_id = decrypt($request->id);
                $history->save();
            }
        }
        $Product = Products::find(decrypt($request->id));
        $Color = Products::find(decrypt($request->id));
        $Color->Color;
        $Size = Products::find(decrypt($request->id));
        $Size->Size;
        $Photo = Products::find(decrypt($request->id));
        $Photo->Photo;
        $quantity_array = $this->QuantityContainer($request->id);
        $Catagory = Catagory::all();
        $GBP = GBP::all();
        $shipping_cost = delivery_cost::first();
        return view('User.productDetail' , ['Shipping_cost'=>$shipping_cost,'GBP'=>$GBP,'Product' => $Product , 'Color' => $Color , 'Size' => $Size , 'Photo' => $Photo, 'Quantity_array'=>$quantity_array]);
    }

    public function showCart(){
        $Catagory = Catagory::all();
        $GBP = GBP::all();
        $weight = delivery_cost::all();
        return view('User.cart',['weight'=>$weight,'Catagory'=>$Catagory, 'GBP'=>$GBP]);
    }

    public function CatagoryWiseProduct(Request $request){
        $catagory  = Item::select('id')->where(['name' =>$request->catagory])->get();
        //return $catagory[0]->id;
        $Product = Products::with('Photo')->where(['catagories_item_id' => $catagory[0]->id])->paginate(40);
        $shipping_cost = delivery_cost::first();
        //return json_encode($Product[0]->delivery_cost);
        $GBP = GBP::all();
        return view('User.catagoryProducts' , ['Shipping_cost'=>$shipping_cost,'Product' => $Product , 'Catagory'=>$request->catagory , 'GBP'=>$GBP]);
    }

    public function subscriber (Request $request){
        $Subscriber = Subscriber::where(['email' => $request->email])->get();
        if(sizeof($Subscriber)>0){
            Session::flash('subscriber_exist','You are already a subscriber');
            return redirect()->back();
        }
        else{
            $Subscriber = new Subscriber();
            $Subscriber->email = $request->email;
            $Subscriber->save();
            Session::flash('unauth_success_subscriber','You will be updated with the latest offers, products.');
            return redirect()->back();
        }
    }

    public function itemFinder(Request $request){
        $Product = Products::with('photo','color','size')->where('title', 'like', '%' . $request->search . '%')->paginate(20);
        $Catagory = Catagory::all();
        return view('User.searchProducts' , ['Catagory'=>$Catagory,'Product' => $Product]);

    }

    public function SubCatagoryWiseProduct(Request $request){
        $sub_catagory = Sub_catagory::find($request->sub_catagory);
        $Product = Products::with('Photo')->where(['sub_catagorie_id' => $sub_catagory->id])->paginate(40);
        $GBP = GBP::all();
        $shipping_cost = delivery_cost::first();
        return view('User.subCatagoryProducts' , ['Shipping_cost'=>$shipping_cost,'Product' => $Product , 'Catagory'=>$sub_catagory , 'GBP'=>$GBP]);
    }

    public function storeLink(Request $request){
        $link = new Links();
        $link->url = $request->url;
        $link->quantity = $request->quantity;
        $link->size = $request->size;
        $link->email = $request->email;
        $link->phone = $request->phone;
        $link->name = $request->name;
        $link->color = $request->color;
        $link->user_name = $request->name;
        $link->user_id = Auth::user()->id;
        $link->save();
        $latest_request = Links::orderBy('id','desc')->first();
        $Admins = Admin::all();
        foreach ($Admins as $item){
           Mail::to($item)->send(new NewRequestMail($latest_request));
        }
        Mail::to(Auth::user())->send(new NewRequestMailToUser($latest_request,Auth::user()));
        Session::flash('success_link_share','We have received your request. We will contact with you soon;');
        return redirect()->back();
    }

     public function search(Request $request){
        $catagory  = Item::select('id')->where(['name' =>$request->catagory])->get();
        $GBP = GBP::all();
        $shipping_cost = delivery_cost::first();
        $Product = Products::with('Photo')
            ->orWhere('title', 'like', '%' . $request->search_item . '%')->get();
        if(sizeof($Product) == 0){
            $array = explode(" ",$request->search_item);
            $new_array = array();
            foreach ($array as $item){
                $array = json_decode(Tags::with('Product','Product.photo')->where('name', 'like', '%' . ($item) . '%')->get());
                foreach ($array as $value) {
                    foreach ($value->product as $product) {
                        $flag = true;
                        foreach ($new_array as $old_product) {
                            if ($old_product->product_id == $product->product_id) {
                                $flag = false;
                            }
                        }
                        if ($flag) {
                            array_push($new_array, $product);
                        }
                    }
                }
            }
            // dd( $new_array);
            return view('User.searchProductsTag' , ['Shipping_cost'=>$shipping_cost,'Product' =>$new_array , 'Catagory'=>$request->catagory , 'GBP'=>$GBP]);

        }
        else{
            return view('User.searchProducts' , ['Shipping_cost'=>$shipping_cost,'Product' => $Product , 'Catagory'=>$request->catagory , 'GBP'=>$GBP]);
        }

    }

    public function activateUser(Request $request){
        $user = User::find($request->id);
        $user->status = "active";
        $user->save();

        if(Auth::loginUsingId($user->id)){
            return redirect()->intended('/');
        }
    }

    public function sendPasswordChangeLink(Request $request){
        $user = User::where(['email' =>$request->email])->get();
        if(sizeof($user)>0){
            Mail::to($user)->send(new PassowrdResetLinkSentMail($user));

            Session::flash('correct_email_reset','We have sent you password reset mail to you.');
            return redirect()->back();
        }
        else{
            Session::flash('false_email_reset','Sorry wrong email provided. Try again');
            return redirect()->back();
        }
    }

    public function showPasswordReset(Request $request){
        $user = User::find(($request->id));
        return view('User.resetPassword',['user'=>$user]);
    }

    public function changePassword(Request $request){
        $user = User::find(decrypt($request->id));
        $user->password = bcrypt(trim($request->password));
        $user->save();
        Session::flash('success_password_reset','Your password has been changed successfully.');
        return redirect('/login');
    }
}
