<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function showTasks()
    {
        $tarefas = Tasks::where('user_id', auth()->user()->id)->where('active', 1)->get();
 
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

        if (!$task) {
            return response()->json(['error' => 'Erro ao criar tarefa.'], 404);
        }

        // Armazenando a mensagem de sucesso na sessão para ser usada na próxima requisição
        session()->flash('toast_message', 'Tarefa criada com sucesso!');
        session()->flash('toast_type', 'primary'); 

        return response()->json([
            'success' => true,
            'message' => 'Tarefa criada com sucesso!',
        ]);
    }

    public function updateTask(Request $request)
    {
        $validated = $request->validate([
            'id'          => 'required|exists:tasks,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $task = Tasks::find($validated['id']);

        if (!$task) {
            return response()->json(['error' => 'Tarefa não encontrada.'], 404);
        }

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

        if (!$task) {
            return response()->json(['error' => 'Tarefa não encontrada.'], 404);
        }

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

    public function deleteTask(Request $request)
    {
        $task = Tasks::find($request->id);

        if (!$task) {
            return response()->json(['error' => 'Tarefa não encontrada.'], 404);
        }

        $task->active = 0;
        $task->save();

        return response()->json(['success' => true]);
    }

    public function filter(Request $request)
    {
        $query = Tasks::where('user_id', auth()->user()->id)->where('active', 1);

        if ($request->has('status') && in_array($request->status, ['0', '1'])) {
            $query->where('status', $request->status);
        }

        $tarefas = $query->get();

        // Retorna só o HTML do tbody
        return view('partials.tasks-tbody', compact('tarefas'))->render();
    }
}
