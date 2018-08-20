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

        $validator = \Validator::make(request()->all(), [
            'more_Than' => 'required|regex:/^[0-9]+$/',
            'less_Than' => 'required|regex:/^[0-9]+$/'
        ]);

        $query = User::with('projects')
            ->with('tasks')->where('users.name', 'LIKE', '%' . request()->get('searchName') . '%')
            ->orWhere('users.email', 'LIKE', '%' . request()->get('searchName') . '%')
            ->groupBy('users.id')->withCount('projects');

        if (request()->filled('more_Than')) {
            $query->having('projects_count', '>', request()->get('more_Than'));
        }
        if (request()->filled('less_Than')) {
            $query->having('projects_count', '<', request()->get('less_Than'));
        }
        $query=$query->orderBy(request()->input('select', 'name'), request()->get('sortBy'))->get();
        $userArr = $this->paginate($query);

        return view('users.index', [
            'userArr' => $userArr,

        ]);


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

    public function edit()
    {
        $id = request()->get('id');

        $userObj = User::findOrFail($id);
        return $userObj;

    }

    public function update(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|regex:/(^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,3}$)/u',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {

            User::findOrFail($request->user_id)->update($request->all());
            return response()->json(['success' => 'User is successfully updated']);
        }


    }

    public function destroy($id)
    {
        $userObj = User::findOrFail($id);
        $userObj->delete();
        return redirect('users')->with('success', 'User has been  deleted');
    }


    protected function paginate($items, $perPage = 7)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $items->slice(($currentPage - 1) * $perPage, $perPage);
        return new LengthAwarePaginator($currentPageItems, count($items), $perPage);
    }
}