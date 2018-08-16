<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/27/18
 * Time: 5:50 PM
 */

namespace App\Http\Controllers;
use Illuminate\Pagination\Paginator;
use App\Projects;
use App\Tasks;
use Illuminate\Http\Request;
use App\User;
use PHPUnit\Framework\Constraint\Count;

class UserController
{
    public function index()
    {

        $name = request()->select;


        $userArr = User::with('projects')
            ->with('tasks')
            ->paginate(7);

        return view('users.index', [
            'userArr' => $userArr
        ]);
    }

    public function search(Request $request){


     $validator = \Validator::make($request->all(), [
        'max' => 'required|regex:/[1-9]/u',

    ]);
        if($validator->fails()){
            $max=0;

        }else{
            $max = $request->max;

        }
        $search = $request->search;
        $select = $request->select;
        $sort = $request->sort;


        $userArr = User::where('users.name', 'LIKE', '%' . $search . '%')
            ->orWhere('users.email', 'LIKE', '%' . $search . '%')->withCount('projects')->having('projects_count', '>', $max)
            ->orderBy($select, $sort)
            ->paginate(5);


        return view('users.index', [
            'userArr' => $userArr
        ]);


//        $arr = User::select('users.*')->where('users.name', 'LIKE', '%kar%')->with('projects')->get();
//        dd(count($arr[0]->projects));
//        return view('users.index', [
//            'userArr' => $arr
//        ]);

    }

    protected function create()
    {
        return view('users.login');
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email|regex:/(^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,3}$)/u',
        ]);
        User::create($request->all());
        return back()->with('success', 'users  added');
    }

    public function destroy($id)
    {
        $userObj = User::findOrFail($id);
        $userObj->delete();
        return redirect('users')->with('success', 'User has been  deleted');
    }
}