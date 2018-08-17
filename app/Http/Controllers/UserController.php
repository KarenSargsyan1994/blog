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
            'max' => 'required|regex:/^[0-9]+$/',
            'min' => 'required|regex:/^[0-9]+$/'
        ]);
        if ($validator->fails()) {
            $errors_list = $validator->errors()->messages();
            if (!empty($errors_list['max']) && !empty($errors_list['min'])) {
                $max = 1;
                $min = 10;
            } elseif (!empty($errors_list['max'])) {
                $max = 1;
                $min = request()->min;

            } else {
                $min = 10;
                $max = request()->max;
            }

        } else {
            $min = request()->min;
            $max = request()->max;
        }

        if (request()->select == null) {
            $select = 'name';
        } else {
            $select = request()->select;
        }

        $search = request()->search;
        $sort = request()->sort;
        $searchArr = array('search' => $search, 'sort' => $sort, 'min' => $min, 'max' => $max, 'select' => $select);

        $query = User::with('projects')
            ->with('tasks')->where('users.name', 'LIKE', '%' . $search . '%')
            ->orWhere('users.email', 'LIKE', '%' . $search . '%')
            ->groupBy('users.id')->withCount('projects')
            ->having('projects_count', '>', $max)
            ->having('projects_count', '<', $min)
            ->orderBy($select, $sort)->get();
        $userArr = $this->paginate($query)->setPath('http://blog-test.loc/index');

        return view('users.index', [
            'userArr' => $userArr, 'searchArr' => $searchArr,
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
        $id = $_GET['id'];
        $userDate = User::findOrFail($id);
        return $userDate;

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