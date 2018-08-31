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
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController
{

    public function index()

    {
        $query=User::with('projects')->with('tasks')
            ->where('users.name','LIKE','%'.request()->get("searchName").'%')
            ->orWhere('users.email', 'LIKE', '%' . request()->get('searchName') . '%')
            ->withCount('projects');

        if (request()->filled('more_than')) {
            $query->having('projects_count', '>', request()->get('more_than'));
        }
        if (request()->filled('less_than')) {
        $query->having('projects_count', '<', request()->get('less_than'));
        }


           $userArr =$query->orderBy(request()->input('select','name'), request()->get('sort'))
            ->get();

//       $userArr=$this->paginate($query)->setPath('http://blog-test.loc/api/custom');

        return  $userArr;
}


//
//         $validator = \Validator::make(request()->all(), [
//            'more_Than' => 'required|regex:/^[0-9]+$/',
//            'less_Than' => 'required|regex:/^[0-9]+$/'
//        ]);
//
//        $query = User::with('projects')
//            ->with('tasks')->where('users.name', 'LIKE', '%' . request()->get('searchName') . '%')
//            ->orWhere('users.email', 'LIKE', '%' . request()->get('searchName') . '%')
//            ->groupBy('users.id')->withCount('projects');
//
//        if (request()->filled('more_Than')) {
//            $query->having('projects_count', '>', request()->get('more_Than'));
//        }
//        if (request()->filled('less_Than')) {
//            $query->having('projects_count', '<', request()->get('less_Than'));
//        }
//        $query=$query->orderBy(request()->input('select', 'name'), request()->get('sortBy'))->get();
//
//
//
//        return response()->json($query);



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

    public function edit($id)
    {

        $userObj = User::findOrFail($id);
        return $userObj->only(['id','name','email']);

    }

    public function update(Request $request)
    {
        $validator = \Validator::make($request->data, [
            'name' => 'required',
            'email' => 'required|email|regex:/(^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,3}$)/u',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {

            User::findOrFail($request->data['id'])->update($request->data);
            return response()->json(" users success update");
        }
    }

    public function destroy($id)
    {
        $userObj = User::findOrFail($id);
        $userObj->delete();
        return response()->json('User has been  deleted');
    }


    protected function paginate($items, $perPage =5)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $items->slice(($currentPage - 1) * $perPage, $perPage);
        return new LengthAwarePaginator($currentPageItems, count($items), $perPage);
    }
}