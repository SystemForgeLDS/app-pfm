<?php

namespace App\Http\Controllers;

use App\Constants\UserRoles;
use App\Http\Requests\TaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create($id) 
    {
        $project = Project::findOrFail($id);
        $consultants = User::where("type", 1)->get();
        return view('task.create', compact('project'), compact('consultants'));
    }

    public function store(TaskRequest $request)
    {
        $task = new Task();

        $task->title = $request->title;
        $task->description = $request->description;
        $task->value = $request->value;
        $task->predicted_hour = $request->predicted_hour;
        $task->project_id = $request->project_id;

        //validando consultor
        
        $user = User::findOrFail($request->user_id);

        if ($user->type == UserRoles::CONSULTANT) {
            $task->user_id = $request->user_id;
        }
        else {
            return redirect()->back()->withErrors(['error' => 'Selecione um consultor válido']);
        }

        //****

        $task->save();

        return redirect(route('project.show', $task->project_id))->with('msg', 'Atividade "' . $task->title . '" adicionada com sucesso');
    }

    public function edit($id) 
    {
        $task = Task::findOrFail($id);

        $consultants = User::where("type", 1)->get();

        return view('task.edit', compact('task'), compact('consultants'));
    }

    public function update(TaskRequest $request) 
    {
        $data = $request->all();

        //validando consultor

        $user = User::findOrFail($request->user_id);

        if ($user->type != UserRoles::CONSULTANT)
            return redirect()->back()->withErrors(['error' => 'Selecione um consultor válido']);

        //****

        $task = Task::findOrFail($request->id);

        $task->update($data);

        if ($task->completed) {
            $msg = 'Atividade "' . $task->title . '" finalizada com sucesso';
        }
        else {
            $msg = 'Atividade "' . $task->title . '" atualizada com sucesso';
        }

        return redirect(route('project.show', $task->project_id))->with('msg', $msg);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        $task->delete();

        return redirect(route('project.show', $task->project_id))->with('msg', 'Atividade "' . $task->title . '" excluída com sucesso');
    }

    public function show($id)
    {
        $task = Task::findOrFail($id);

        return view('task.show', compact('task'));
    }
}
