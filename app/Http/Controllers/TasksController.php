<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestTask;
use App\Models\Tasks;
use Illuminate\Http\Request;

class TasksController extends Controller
{

	/**
	 * Controller que leva à página inicial a lista de tarefas existentes, ativas
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 **/
	public function list()
	{
		$response = [
			'type' => 'success',
			'tasks' => (new Tasks())->getAllTasks(),
		];
		return response()->json($response);
	}

	/**
	 * Controller para levar a tela de criação de tarefa
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 **/
	public function create()
	{
		return view('new');
	}

	/**
	 * Controller para levar os dados do formulario para o model
	 *
	 * @param RequestTask $request request com os dados do formulario
	 * @return Mixed
	 **/
	public function createTask(RequestTask $request)
	{
		try
		{
			$result = (new Tasks())->createTask($request);

			if ($result == true)
			{
				$response = [
					'type' => 'success',
					'message' => "tarefa criada com sucesso",
					'redirect' => route('home')
				];
			}
			else
			{
				throw new \Exception($result);
			}
		}
		catch (\Throwable $th)
		{
			$response = [
				'type' => 'error',
				'message' => $th->getMessage(),
			];
		}

		return response()->json($response);
	}

	/**
	 * Controller para abrir e pegar mais detalhes de uma tarefa
	 * 
	 * @param int $id
	 * @return Mixed
	 **/
	public function open(int $id)
	{
		$response = [
			'type' => 'success',
			'task' => (new Tasks())->find($id),
		];
		return response()->json($response);
	}

	/**
	 * Controller para editar a tarefa
	 *
	 * @param RequestTask $request
	 * @return Mixed
	 **/
	public function editarTask(RequestTask $request)
	{
		try
		{
			$result = (new Tasks())->editTask($request);

			if ($result == true)
			{
				$response = [
					'type' => 'success',
					'message' => "tarefa editada com sucesso",
					'redirect' => route('home')
				];
			}
			else
			{
				throw new \Exception($result);
			}
		}
		catch (\Throwable $th)
		{
			$response = [
				'type' => 'error',
				'message' => $th->getMessage(),
			];
		}

		return response()->json($response);
	}

	/**
	 * Controller para marcar que uma tarefa foi feita
	 * 
	 * @param int $id
	 * @return Mixed
	 **/
	public function marcarFeito(int $id)
	{
		try
		{
			$result = (new Tasks())->done($id);

			if ($result == true)
			{
				$response = [
					'type' => 'success',
					'message' => "tarefa feita com sucesso",
					'redirect' => route('home')
				];
			}
			else
			{
				throw new \Exception($result);
			}
		}
		catch (\Throwable $th)
		{
			$response = [
				'type' => 'error',
				'message' => $th->getMessage(),
			];
		}

		return response()->json($response);
	}

	/**
	 * Controller para excluir uma tarefa
	 *
	 * @param int $id
	 * @return Mixed
	 **/
	public function excluirTarefa(int $id)
	{
		try
		{
			$result = (new Tasks())->deletarTarefa($id);

			if ($result == true)
			{
				$response = [
					'type' => 'success',
					'message' => "tarefa excluida com sucesso",
					'redirect' => route('home')
				];
			}
			else
			{
				throw new \Exception($result);
			}
		}
		catch (\Throwable $th)
		{
			$response = [
				'type' => 'error',
				'message' => $th->getMessage(),
			];
		}

		return response()->json($response);
	}
}