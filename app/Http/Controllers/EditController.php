<?php

namespace App\Http\Controllers;

use App\Projects;
use App\User;
use Illuminate\Http\Request;

class EditController extends Controller
{

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




    public function editProj()
    {

        $id = $_GET['id'];
        $ProjectDate = Projects::findOrFail($id);
        return $ProjectDate;
    }

    public function updateProj(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $projectObj = Projects::findOrFail($request->get('project_id'));
            $projectObj->update($request->only([
                'name', 'description'
            ]));
            dd($projectObj->toArray());
            return response()->json(['success' => ' is successfully updated']);
        }


    }

}