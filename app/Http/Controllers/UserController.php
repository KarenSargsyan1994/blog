<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/27/18
 * Time: 5:50 PM
 */

namespace App\Http\Controllers;

use App\Projects;
use App\Tasks;
use Illuminate\Http\Request;
use App\User;
use PHPUnit\Framework\Constraint\Count;

class UserController
{
    public function index()
    {
        $search = request('search');

        $userArr = User::where('users.name', 'LIKE', '%' . $search . '%')
            ->orWhere('users.email', 'LIKE', '%' . $search . '%')
            ->groupBy('users.id')
            ->with('projects')
            ->with('tasks')
            ->paginate(8);


        return view('users.index', [
            'userArr' => $userArr
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


    public function edit($id)
    {
        $userObj = User::findOrFail($id);
        return view('users.edit', compact('userObj', 'id'));

    }


    public function update(Request $request, $id)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email|regex:/(^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,3}$)/u',
        ]);
        User::findOrFail($id)->update($request->all());
        return redirect('index')->with('success', 'user updated');
    }

    public function editUser(Request $request)
    {

        $data = user::findOrFail ( $request->id );
        $data->name = $request->name;
        $data->email= $request->email;
        $data->save ();
        return response ()->json ( $data );

    }

    public function destroy($id)
    {
        $userObj = User::findOrFail($id);
        $userObj->delete();
        return redirect('users')->with('success', 'Product has been  deleted');
    }
}