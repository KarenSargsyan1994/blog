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
            'moreThan' => 'required|regex:/^[0-9]+$/',
            'lessThan' => 'required|regex:/^[0-9]+$/'
        ]);
        if ($validator->fails()) {
            $errors_list = $validator->errors()->messages();
            if (!empty($errors_list['moreThan']) && !empty($errors_list['lessThan'])) {
                $moreThan = -1;
                $lessThan = 10;
            } elseif (!empty($errors_list['moreThan'])) {
                $moreThan = 1;
                $lessThan = request()->lessThan;

            } else {
                $moreThan = 10;
                $lessThan = request()->moreThan;
            }

        } else {
            $lessThan = request()->lessThan;
            $moreThan = request()->moreThan;
        }

        if (request()->select == null) {
            $selectName = 'name';
        } else {
            $selectName = request()->select;
        }

        $searchName = request()->search;
        $sort = request()->sort;
        $searchArr = array('search' => $searchName, 'sort' => $sort, 'lessThan' => $lessThan, 'moreThan' => $moreThan, 'select' => $selectName);

        $query = User::with('projects')
            ->with('tasks')->where('users.name', 'LIKE', '%' . $searchName . '%')
            ->orWhere('users.email', 'LIKE', '%' . $searchName . '%')
            ->groupBy('users.id')->withCount('projects')
            ->having('projects_count', '>', $moreThan)
            ->having('projects_count', '<', $lessThan)
            ->orderBy($selectName, $sort)->get();
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