<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
	Route::get('/',[Controller::class, 'home'])
		->name('home');

	#region TASKS
		Route::group(['as' => 'tasks.', 'prefix' => 'tasks'], function()
		{
			/**
			 * listar todas as tarefas
			 */
			Route::get('list',[TasksController::class, 'list'])
				->name('list');

			/**
			 * abrir uma tarefa
			 */
			Route::get('open/{id}',[TasksController::class, 'open'])
				->name('open');

			/**
			 * rota para a tela para criar uma tarefa
			 */
			Route::get('create',[TasksController::class, 'create'])
				->name('create');

			/**
			 * criar uma tarefa
			 */
			Route::post('create',[TasksController::class, 'createTask'])
				->name('create.task');

			/**
			 * editar uma tarefa
			 */
			Route::post('edit',[TasksController::class, 'editarTask'])
				->name('edit');

			/**
			 * marca que a tarefa esta feita
			 */
			Route::post('feito/{id}',[TasksController::class, 'marcarFeito'])
				->name('feito');

			/**
			 * excluir tarefa
			 */
			Route::delete('delete/{id}',[TasksController::class, 'excluirTarefa'])
				->name('delete');
		});
	#endregion