<?php

namespace App\Http\Controllers;

use App\Events\MessagePosted;
use App\Events\NewOrder;
use App\Events\OnlineUser;
use App\Listeners\SendNewOrderNotification;
use App\Models\Brand;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Product;
use App\Models\Role;
use App\Models\ShoppingCart;
use App\Models\User;
use Illuminate\Http\Request;
//use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;
use const http\Client\Curl\AUTH_ANY;
use Illuminate\Validation\Validator;
use Illuminate\Broadcasting;

class StoreContoller extends Controller
{
    public function __construct()
    {

        if(Auth::check()){
            $user=Auth::user();
            event(new OnlineUser($user));
        }

    }

    public function login(Request $request)
    {
        //!Auth::check() =not logged in

        $isLoggedIn = false;
//        $pass='uchihaclan1';
//        $password=bcrypt($pass);
//        return $password;
        if (!Auth::check()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $user_id = Auth::id();
                $check = ShoppingCart::where('user_id', $user_id)->count();
                if ($check == 0) {
                    ShoppingCart::create([
                        'user_id' => $user_id
                    ]);
                }
                $isLoggedIn = true;
                $data = [
                    'user' => $user,
                    'isloggedin' => $isLoggedIn
                ];


                event(new OnlineUser($user));
                return $data;
            } else {
                return response()->json(['error' => 'Unauthorised'], 401);
            }
        } else {


            $user = Auth::user();
            $isLoggedIn = true;
            $data = [
                'user' => $user,
                'isloggedin' => $isLoggedIn
            ];

            event(new OnlineUser($user));
            return $data;
        }


    }

    public function logout()
    {
        Auth::logout();
        return redirect('/store');
    }

    public function register(Request $request)
    {

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
            'fullName' => 'required'
        ]);

        $password = bcrypt($request->password);

//        $role=Role::where('roleName','User')->get();
//        $data=json_decode($role);
        $data = null;
        $role = DB::table('roles')->where('roleName','"User"')->select('id', 'roleName')->get();

//        $role=Role::all();
       // return $role;
        foreach ($role as $r) {
            $data = array(
                'id' => $r->id,
                'roleName' => str_replace(array('\'', '"',
                    ',' , ';', '<', '>' ),'',$r->roleName)
            );
        }

     //   return $data['id'];

        //return $request;
        return User::create([
            'email' => $request->email,
            'password' => $password,
            'fullName' => $request->fullName,
            'role_id' => $data['id'],
            'userType' => $data['roleName'],
            'created_id' => '0'
        ]);

    }

    public $successStatus = 200;

    //
    public function index()
    {
//        return true;
        return view('storeWelcome');
    }

    public function getProduct()
    {
        return Product::all();
    }

    public function getProductById(Request $request)
    {
        return Product::where('id', $request->id)->get();
    }

    public function getBrand()
    {
        return Brand::all();
    }

    public function getCategory()
    {
        return Category::all();
    }

    public function getProductByBrandAndCategory(Request $request)
    {
        if (!$request->brand_id && !$request->category_id) {
            return Product::all();
        } else if ($request->brand_id && !$request->category_id) {
            return Product::where([['brand_id', $request->brand_id]])->get();
        } else if (!$request->brand_id && $request->category_id) {
            return Product::where([['category_id', $request->category_id]])->get();
        }
        return Product::where([['brand_id', $request->brand_id], ['category_id', $request->category_id]])->get();
    }

    public function createOrder(Request $request)
    {
        $user = Auth::user();
        $admin = User::where('userType', 'Admin')->first();
        $order = new Order();
        $this->validate($request, [
            'products' => 'required',
            'user_id' => 'required',
            'totalPrice' => 'required'
        ]);


        $newOrder = Order::create([
            'products' => $request->products,
            'user_id' => $request->user_id,
            'totalPrice' => $request->totalPrice
        ]);

        event(new NewOrder($newOrder));
        return ['status' => 'OK'];
    }

    public function getOrder(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required'
        ]);

        return Order::where('user_id', $request->user_id)->get();
    }

    public function getOrderById(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required'
        ]);

        return Order::where('id', $request->order_id)->get();
    }

    public function getMessages()
    {
        $messages = Message::all();
        $users = User::all();


        return ['messages' => $messages, 'users' => $users];
    }

    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'message' => 'required',
            'for_user_id' => 'required'
        ]);

//        $message=Message::create([
//            'user_id'=>$user->id,
//            'message'=>$request->message
//        ]);

        event(new MessagePosted($request->message, $request->for_user_id, $request->user));


        return ['status' => 'OK'];

    }

    public function getNotifications()
    {
        return Notification::all();
    }

    public function createShoppingCart(Request $request)
    {

        $this->validate($request, [
            'user_id' => 'required'
        ]);

        return ShoppingCart::create([
            'user_id' => $request->user_id
        ]);

    }

    public function getShoppingCartById(Request $request)
    {

        $this->validate($request, [
            'user_id' => 'required'
        ]);

        $shoppingCart = ShoppingCart::where('user_id', $request->user_id)->get();
        return $shoppingCart;
    }

    public function getCartItemsByShoppingCartId(Request $request)
    {
        $this->validate($request, [
            'cart_id' => 'required'
        ]);

        $cartitems = CartItem::where('shopping_cart_id', $request->cart_id)->get();
        return $cartitems;
    }

    public function addCartItem(Request $request)
    {

        $this->validate($request, [
            'id' => 'required',
            'shopping_cart_id' => 'required',
            'quantity' => 'required'
        ]);


        //return $request;
        return CartItem::create([
            'product_id' => $request->id,
            'shopping_cart_id' => $request->shopping_cart_id,
            'quantity' => $request->quantity
        ]);
//        return $cartItem;
    }

    public function updateCartItemQuantity(Request $request)
    {

        $this->validate($request, [
            'quantity' => 'required',
            'shopping_cart_id' => 'required',
            'product_id' => 'required'
        ]);


        //return $request;
        return CartItem::where([['shopping_cart_id', $request->shopping_cart_id], ['product_id', $request->product_id]])->update([
            'quantity' => $request->quantity
        ]);

//        return $cartItem;
    }

    public function deleteCartItem(Request $request)
    {

        $this->validate($request, [
            'shopping_cart_id' => 'required',
            'product_id' => 'required'
        ]);


        //return $request;
        return CartItem::where([['shopping_cart_id', $request->shopping_cart_id], ['product_id', $request->product_id]])->delete();

//        return $cartItem;
    }
    //LOGIN API

}
