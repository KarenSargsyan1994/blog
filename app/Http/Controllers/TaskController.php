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

class TaskController
{

    public function projectTasks($id)
    {
        $taskArr = Tasks::where('tasks.project_id', '=', $id)->paginate(5);


        return view('tasks/task', ['taskArr' => $taskArr]);
    }

    public function userTasks($id)
    {
        $taskArr = Tasks::where('tasks.user_id', '=', $id)->paginate(5);

        return view('tasks/task', ['taskArr' => $taskArr]);
    }

    public function edit()
    {

        $id = request()->id;
        $taskObj = Tasks::findOrFail($id);
        return $taskObj;}

    public function update(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $taskObj = Tasks::findOrFail($request->get('task_id'));

            $taskObj->update($request->only([
                'name', 'description'
            ]));

            return response()->json(['success' => ' is successfully updated']);
        }


    }
}