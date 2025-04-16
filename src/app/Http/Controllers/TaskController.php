<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function showTasks()
    {
        $tarefas = Tasks::all();
        return view('tasks.show', compact('tarefas'));
    }

    public function createTask()
    {
        return view('tasks.create');
    }

    public function storeTask(Request $request)
    {
        dd($request);
    }
}
