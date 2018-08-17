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
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;

class ProjectController
{

    public function projects($id)
    {
        $projectArr = Projects::where('projects.user_id', '=', $id)->with('tasks')->paginate(5);

        return view('projects/projects', ['projectArr' => $projectArr]);
    }

    public function edit()
    {

        $id = request()->id;
        $projectObj = Projects::findOrFail($id);
        return $projectObj;
    }

    public function update(Request $request)
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

            return response()->json(['success' => ' is successfully updated']);
        }


    }

}