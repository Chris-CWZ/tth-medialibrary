<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UsersService;
use App\Services\ImageOptimizationServices;

class UsersController extends Controller{

  protected $path = 'admin.users.';
  protected $usersService;

  public function __construct(UsersService $usersService, ImageOptimizationServices $imageOptimizationServices){
    $this->usersService = $usersService;
    $this->imageOptimizationServices = $imageOptimizationServices;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request){
    return $this->usersService->index($request);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(User $user){
    return view($this->path . 'edit', ['user' => $user]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id){
    $this->validate($request, array(
      'name' => 'required|string|max:191',
    ));

    $user = User::where('id', $id)->first();

    if ($request->hasFile('avatar') && $request->file('avatar')->isValid()){
      if ( $user->avatar ) {
        if (avatar_picture_exists($user->piavatarcture)) {
          Storage::delete( avatar_storage_path() . $user->avatar );
        }
      }
      $file_unique_name = $this->imageOptimizationServices->optimize('avatars', $request->avatar, 'thumbnail');
      $user->avatar = $file_unique_name;
    }

    $user->name = $request->name;
    $user->save();

    return redirect()->back()->with("success", "Account Has Been Updated Successfully!");
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(User $user){
    return $this->usersService->destroy($user);
  }
}
