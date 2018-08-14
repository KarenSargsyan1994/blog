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

        return view('projects.projects', ['projectArr' => $projectArr]);
    }
    public function update(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
       Projects::findOrFail($request->project_id)->update($request->all());
        return back();

    }


}