<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Validator;
use App\Models\Member;
class MemberController extends Controller
{
    // public function index()
    // {
    //     return ["name"=>"harry"];
    // }

    // public function show()
    // {
    //     return Member::all();
    // }
    public function save(Request $request)
    {
       $valid = Validator::make($request->all(),[

        'name'=>'required',
         'email'=>'required',

       ]);

       if($valid->fails()){
        return response()->json([
            'error'=>$valid->errors()],401
        );
       }

        $data = new Member;
        $data->name= $request->name;
        $data->email=$request->email;
        $data->phone=$request->phone;
        $data->age=$request->age;
        $result= $data->save();
        if($result){
            return["return"=>"data has been saved .."];
        }
        else{
            return["return"=>"data not save"];
        }
    }

    public function delete($id)
    {
        $member= Member::find($id);
        $result=$member->delete();
        if($result){
            return ["return"=>"delete data"];
        }
        else{
            return ["return"=>"noy delete"];
        }
    }



    public function search(Request $request){

        if(isset($request->value)) {

            $user;
            if(filter_var($request->value, FILTER_VALIDATE_EMAIL)) {

                $user = Member::Where("email","like","%" .$request->value. "%")->orderBy('email', 'DESC')->get();
                return $user;
            } elseif(is_numeric($request->value)) {
                 $user = Member::Where("phone","like","%" .$request->value. "%")->orderBy('phone', 'DESC')->get();
                 return $user;
            } else {
                return response()->json(['error' => 'No valid user match your information']);
            }

        } else {
            return response()->json(['error' => 'Please provide a value to search']);
        }

    }



    public function update(Request $request,$id){


        $data = Member::find($id);
            $data->name=$request->name;
            $data->email=$request->email;
            $data->phone=$request->phone;
            $data->age=$request->age;
            $result=$data->save();



            if($result){
            return["return"=>"data has been updated .."];
        }
        else{
            return["return"=>"not updated"];
        }


    }

}
