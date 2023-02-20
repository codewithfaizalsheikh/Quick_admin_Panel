<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
// use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersApiController extends Controller
{
    public function index()
    {
        // abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user = User::with(['roles'])->get();
        if($user){
            return response()->json([
                'message'=>'fetch successfully',
                'user'=>$user,  
            ]);
        }
        else {
            return response()->json([
                'message'=>'fetch error',
            ]);
        }
        // $user = User::with(['roles'])->get();

        // if($user){
        //     return (new UserResource($user))->response();
        // }
        //   else{
        //     return response()->json([
        //                 'message'=>'fetch error',
        //              ]);

        //   }
       
      
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);

    }

    public function show(User $user,$id)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource($user->load(['roles']));
        // $user = User::find($id);
        // if($user){
        //     return response()->json(['message'=>'success','user'=>$user]);
        // }else{
        //     return response()->json(['message'=>'something went wrong']);
        // }

        // return view('admin.users.show',compact('user'));

    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);

    }

    public function destroy(User $user, $id)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user = User::find($id);
        $user->delete();
        
        if($user){
               return response()->json(['success'=>'deleted succesfully']);
        }
        else{
            return response()->json(['Error'=>'not delete']);
        }
        return response(null, Response::HTTP_NO_CONTENT);

    }


    public function fetchUser(){
        $user = User::all();
        if($user){
            return response()->json([
                'message'=>'fetch successfully',
                'user'=>$user,
            ]);
        }
        else {
            return response()->json([
                'message'=>'fetch error',
            ]);
        } 
    }


    public function deleteUser($id){

        $user = User::find($id);
        if($user){
            $user->delete();
            return response()->json([
                'message'=>'deleted succesfully',
            ]);
        }
        return response()->json([
            'message'=>'Something went wrong',
        ]);

    }

    function showUser($id){
        $user = User::find($id);
        if($user){
            return response()->json(['message'=>'success','user'=>$user]);
        }else{
            return response()->json(['message'=>'something went wrong']);
        }

        // return view('admin.users.show',compact('user'));
    }

    function editUser($id){
        $user = User::find($id);
        if($user){
            return response()->json(['message'=>'success','user'=>$user]);
        }else{
            return response()->json(['message'=>'something went wrong']);
        }

       function updateUser(Request $request, $id, User $user){
        $user = User::find($id);
        $user->update($request->all());
        if($user){
            return response()->json([
                'message'=>'successfully updated'
            ]);
        }
      else{
        return response()->json([
            'message'=>'something went wrong'
        ]);
      }

       }
    }
    
}
