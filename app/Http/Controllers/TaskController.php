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

    public function projtask($id)
    {
        $taskArr = Tasks::where('tasks.project_id', '=', $id)->paginate(5);


        return view('tasks.task', ['taskArr' => $taskArr]);
    }

    public function tasks($id)
    {
        $taskArr = Tasks::where('tasks.user_id', '=', $id)->paginate(5);

        return view('tasks.task', ['taskArr' => $taskArr]);
    }


}