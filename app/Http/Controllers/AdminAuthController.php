<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use Session;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    public function login(){
        return view("auth.login");
    }

    public function addadmin(){
        return view("auth.addadmin");
    }


    public function saveadmin(Request $request){

        $find = Admin::where('email' , $request->email)->first();

        if(!empty($find)){
            return back()->with('success', 'Email Id Already Registered');

        }else{

        
            $admin = new Admin();

            $admin->firstname = $request->firstname;
            $admin->lastname = $request->lastname;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);

            $res =  $admin->save();

            if($res){
                 return back()->with('success', 'You have succcessfully Added');
            }else{
                return back()->with('fail', 'Something went wrong');
            }
        }


        

    }


    public function loginAdmin(Request $request){

        $find = Admin::where('email' , $request->email)->first();

            if(!empty($find)){

                if(Hash::check($request->password,$find->password)){

                    $request->session()->put('loginId', $find->id);

                    return redirect('dashboard');

                    return back()->with('success', 'Email Id Already Registered');


                }else{
                    return back()->with('fail', 'Password Not Matching');
                }
                
            }else{

            
                return back()->with('fail', 'This Email Id is not Registered');
            }
    }

    public function dashboard(Request $request){

         $alldata = Admin::get();

        
        return view('dashboard.index' , compact('alldata') );
    }


    public function logout(Request $request){


        if(Session::has('loginId')){

            Session::pull('loginId');

            return redirect('/');
        }
         
    }


    public function edit($id){

        $data = Admin::where('id',$id)->first();

        return view("dashboard.edit" ,compact('data'));
    }

    public function store(Request $request ,$id){

        
        $admin = Admin::find($id);

        $admin->firstname = $request->firstname;
        $admin->lastname = $request->lastname;
        $admin->email = $request->email;

        if(!empty($request->password)){

            $admin->password = Hash::make($request->password);

        }else{
            $admin->password = $admin->password;
        }
        

        $res =  $admin->save();

        if($res){
             return back()->with('success', 'Succcessfully Updated ');
        }else{
            return back()->with('fail', 'Something went wrong');
        }
    }

     public function delete($id){

        
        $admin = Admin::find($id)->delete();

        

        if(empty($admin)){
             return back()->with('success', 'Succcessfully Deleted');
        }else{
            return back()->with('fail', 'Something went wrong');
        }


    }

}
