<?php 

namespace App\Services;

use App\User;
use Illuminate\Http\Request;

class UsersService extends TransformerService{

  protected $path = 'admin.users.';  

  public function all(Request $request){
		$sort = $request->sort ? $request->sort : 'id';
    $order = $request->order ? $request->order : 'desc';
    $limit = $request->limit ? $request->limit : 10;
    $offset = $request->offset ? $request->offset : 0;
    $query = $request->search ? $request->search : '';

    $users = User::where('name', 'like', "%{$query}%")->orderBy($sort, $order);
    $listCount = $users->count();
    $users = $users->limit($limit)->offset($offset)->get();

    return respond(['rows' => $this->transformCollection($users), 'total' => $listCount]);
  }

  public function index(Request $request){
    if ($request->wantsJson()) {
      return $this->all($request);
    }else{
      return view($this->path . 'index');
    }
  }

  public function destroy(User $user){
    $user->delete();

    return success();
  }
  
  public function search(Request $request){
    $name = $request->name ?  $request->name:"";

    if($name == ""){
      $users = User::limit(10)->get();
      return respond($this->transformCollection($users));
    }else{
      $users = User::where('name', 'like', "%{$name}%");
      return respond($this->transformCollection($users));
    }
  }

  public function transform($user){
    return [
      'id' => $user->id,
      'role' => $user->role,
      'name' => $user->name,
      'loyalty_points' => $user->loyalty_points,
      'email' => $user->email,
      'avatar' => $user->avatar,
    ];
  }
}