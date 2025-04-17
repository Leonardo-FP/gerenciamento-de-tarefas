<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function showTasks()
    {
        $tarefas = Tasks::where('user_id', auth()->user()->id)->get();
 
        return view('tasks.show', compact('tarefas'));
    }

    public function createTask()
    {
        return view('tasks.create');
    }

    public function storeTask(Request $request)
    {
        $validated = $request->validate([
            'user_id'     => 'required',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'status'      => 'required|bool',
        ]);
        
        $task = Tasks::create($validated);

        return redirect()
            ->route('tasks.show')
            ->with('success', 'Tarefa #'.$task->id.' criada com sucesso!');
    }

    public function updateTask(Request $request)
    {
        $validated = $request->validate([
            'id'          => 'required|exists:tasks,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $task = Tasks::find($validated['id']);

        $task->update([
            'title'       => $validated['title'],
            'description' => $validated['description'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tarefa atualizada com sucesso!',
            'task' => [
                'id'          => $task->id,
                'title'       => $task->title,
                'description' => $task->description,
                'status'      => $task->status,
                'created_at'  => $task->created_at->format('d/m/Y'),
            ],
        ]);
    }

    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'id'          => 'required|exists:tasks,id',
        ]);

        $task = Tasks::find($validated['id']);

        $task->update([
            'status'       => !$task->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tarefa atualizada com sucesso!',
            'task' => [
                'id'          => $task->id,
                'title'       => $task->title,
                'description' => $task->description,
                'status'      => $task->status,
                'created_at'  => $task->created_at->format('d/m/Y'),
            ],
        ]);
    }
}
