<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    //


    public function index(Request $request)
    {
        //!Auth::check() =not logged in
        if (!Auth::check() && $request->path() != 'login') {
            return redirect('/login');
        }

        if (!Auth::check() && $request->path() == 'login') {
            return view('welcome');
        }
        $user = Auth::user();
        if ($user->userType == 'User') {
            return redirect('/login');
        }
        if ($request->path() == 'login') {
            return redirect('/');
        }


       // return true;
        return $this->checkForPermission($user,$request);
//        return view('notfound');
   //     return view('welcome');
        // return $request->path();
    }

    public function checkForPermission($user,  $request)
    {

        $permissions = json_decode($user->role->permission);
        $hasPermisson = false;
        foreach ($permissions as $permission) {
            if ($permission->name == $request->path()) {
                if ($permission->read) {
                    $hasPermisson = true;
              }
            }
        }
        if ($hasPermisson) {
            return view('welcome');
        } else {
            return view('notfound');
        }

      //  echo $permissions[0]->name;
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');

    }

    public function addTag(Request $request)
    {
        //validate request
        $this->validate($request, [
            'tagName' => 'required'
        ]);

        return Tag::create([
            'tagName' => $request->tagName
        ]);
    }

    public function getTag()
    {
        return Tag::orderBy('id', 'desc')->get();
    }

    public function editTag(Request $request)
    {
        $this->validate($request, [
            'tagName' => 'required',
            'id' => 'required'
        ]);

        return Tag::where('id', $request->id)->update([
            'tagName' => $request->tagName
        ]);


        //        return response()->json([
        //            'tagName'=>$request->tagName
        //        ]);
    }

    public function deleteTag(Request $request)
    {
        $this->validate($request, [
            'tagName' => 'required',
            'id' => 'required'
        ]);

        return Tag::where('id', $request->id)->delete();


        //        return response()->json([
        //            'tagName'=>$request->tagName
        //        ]);
    }

    public function getCategory()
    {
        return Category::orderBy('id', 'desc')->get();
    }


    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png',
        ]);

        $picName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }

    public function deleteImage(Request $request)
    {
        $fileName = $request->imageName;
        $this->deleteFileFromServer($fileName, false);
        return 'done';
    }

    public function deleteFileFromServer($fileName, $hasFullPath = false)
    {
        if ($hasFullPath) {
            $filepath = public_path() . $fileName;
        }

        if (file_exists($filepath)) {
            @unlink($filepath);
        }
        return;
    }

    public function addCategory(Request $request)
    {
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required',
        ]);

        return Category::create([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage
        ]);
    }

    public function editCategory(Request $request)
    {
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required',
        ]);

        return Category::where('id', $request->id)->update([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage
        ]);
    }

    public function deleteCategory(Request $request)
    {
        //first delete the original file from server
        $this->deleteFileFromServer($request->iconImage);
        $this->validate($request, [
            'id' => 'required',

        ]);

        return Category::where('id', $request->id)->delete();
    }


    public function getUser()
    {
        # code...
        $user=Auth::user();
      //  return $user->role->roleName;
        if($user->userType =='Manager')
        {
           // $user = User::where('id', $request->id)->update($data);
        //    return "Hello";
          // return $user->id;
            return User::where('created_id',$user->id)->get();
        }
        else
        {
            return User::get();
        }

    }

    public function createUser(Request $request)
    {
        # code...
        $this->validate($request, [
            'fullName' => 'required|min:6',
            'email' => 'bail|required|email|unique:users',
            'password' => 'bail|required|min:6',
            'userType'=>'required',
            'role_id' => 'required',
        ]);


        $password = bcrypt($request->password);

        $created_id=Auth::user()->id;
        $user = User::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' => $password,
            'userType'=>$request->userType,
            'role_id' => $request->role_id,
            'created_id'=>$created_id
        ]);

        return $user;
    }

    public function editUser(Request $request)
    {
        # code...
        $this->validate($request, [
            'fullName' => 'required',
            'email' => "bail|required|email|unique:users,email,$request->id",
            'password' => 'min:6',
            'userType'=>'required',
            'role_id' => 'required',
        ]);

        $data = [
            'fullName' => $request->fullName,
            'email' => $request->email,
            'userType'=>$request->userType,
            'role_id' => $request->role_id,

        ];
        if ($request->password) {
            $password = bcrypt($request->password);
            $data['password'] = $password;
        }


        $user = User::where('id', $request->id)->update($data);

        return $user;
    }


    public function adminLogin(Request $request)
    {
        # code...
        $this->validate($request, [

            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6',

        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            // return $user->role()->roleName;
            //   Log::info($user->role());
            //   return $user->role;
            if ($user->role->isAdmin == 0) {
                Auth::logout();
                return response()->json([
                    'msg' => 'You are not permitted to log in'
                ], 401);
            } else {
                return response()->json([
                    'msg' => 'Logged in successfully',
                    'user' => $user
                ]);
            }
        } else {
            return response()->json([
                'msg' => 'Logged in failed'
            ], 401);
        }
    }


    public function getRole()
    {
        return Role::all();


    }

    public function addRole(Request $request)
    {
        //validate request
        $this->validate($request, [
            'roleName' => 'required'
        ]);

        return Role::create([
            'roleName' => $request->roleName
        ]);


    }

    public function editRole(Request $request)
    {
        //validate request
        $this->validate($request, [
            'roleName' => 'required'
        ]);

        return Role::where('id', $request->id)->update([
            'roleName' => $request->roleName
        ]);


    }

    public function assignRole(Request $request)
    {
        $this->validate($request, [
            'permission' => 'required',
            'id' => 'required'
        ]);

        return Role::where('id', $request->id)->update([
            'permission' => $request->permission
        ]);
    }

    public  function  getProduct(){
        return Product::all();
    }

    public  function  createProduct(Request $request){
        $this->validate($request,[
            'productName'=>'required',
            'productImage'=>'required',
            'price'=>'required',
            'quantity'=>'required',
            'description'=>'required',
//            'brand_id'=>'required',
//            'category_id'=>'required',
//            'supplier_id'=>'required'
        ]);

        return Product::create([
            'productName'=>$request->productName,
            'productImage'=>$request->productImage,
            'price'=>$request->price,
            'quantity'=>$request->quantity,
            'description'=>$request->description,
//            'brand_id'=>$request->productName,
            'category_id'=>'1',
//            'supplier_id'=>$request->productName,

        ]);
    }

    public  function  editProduct(Request $request){
        $this->validate($request,[
            'productName'=>'required',
            'productImage'=>'required',
            'price'=>'required',
            'quantity'=>'required',
            'description'=>'required',
            'brand_id'=>'required',
            'category_id'=>'required',
            'supplier_id'=>'required'
        ]);

        return Product::where('id',$request->id)->update([
            'productName'=>$request->productName,
            'productImage'=>$request->productImage,
            'price'=>$request->price,
            'quantity'=>$request->quantity,
            'description'=>$request->description,
            'brand_id'=>$request->brand_id,
            'category_id'=>$request->category_id,
            'supplier_id'=>$request->supplier_id,

        ]);
    }

    public function getSupplier(){
        return Supplier::all();
    }

    public function getBrand(){
        return Brand::all();
    }
}
