<?php

namespace App\Models;

use App\Enum\Status;
use App\Http\Requests\RequestTask;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

	protected $table = "tasks";

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var string[]
	 */
	protected $fillable = [
		'titulo',
        'descricao',
        'conteudo',
        'feito',
		'status'
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array
	 */
	protected $hidden = [
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array
	 */
	protected $casts = [
        'prazo' => 'datetime',
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
	];

	#region RELATIONSHIPS
        // gosto de separar por regions os metodos, metodos de get/set e as classes para as relacoes
    #endregion

	#region METHODS

		/**
		 * Metodo para pegar todas as tarefas
		 *
		 * @return Tasks[]
		 **/
		public function getAllTasks()
		{
			try {
				return $this->where('status',Status::Ativo)->where('feito',Status::NaoFeito)->get();
			} catch (\Throwable $th) {
				return [];
			}
		}

		/**
		 * Metodo para criar tarefa
		 *
		 * @param RequestTask $request
		 * @return Mixed
		 **/
		public function createTask(RequestTask $request)
		{
			try
			{
				$task = new $this;
				$task->titulo = $request->titulo;
				$task->descricao = $request->descricao;
				$task->conteudo = $request->conteudo;
				$task->status = Status::Ativo;
				$task->prazo = $request->prazo;
				$task->save();

				return true;
			}
			catch (\Throwable $th)
			{
				// normalmente aqui eu crio uma logica para registrar alem de um log proprio, enviar um email com o erro direto para o email do projeto focado nisto
				// e retornando um erro padrao para o usuario
				return "erro ao realizar criacao de tarefa";
			}
		}

		/**
		 * Metodo para editar tarefa
		 *
		 * @param RequestTask $request
		 * @return Mixed
		 **/
		public function editTask(RequestTask $request)
		{
			try
			{
				$task = $this->find($request->id);
				$task->titulo = $request->titulo;
				$task->descricao = $request->descricao;
				$task->conteudo = $request->conteudo;
				$task->status = Status::Ativo;
				$task->prazo = $request->prazo;
				$task->save();

				return true;
			}
			catch (\Throwable $th)
			{
				return "erro ao editar tarefa";
			}
		}

		/**
		 * Metodo para marcar como feita a tarefa
		 *
		 * @param int $id
		 * @return Mixed
		 **/
		public function done(int $id)
		{
			try
			{
				$task = $this->find($id);
				$task->feito = Status::Feito;
				$task->save();

				return true;
			}
			catch (\Throwable $th)
			{
				return "erro ao marcar tarefa como feita";
			}
		}

		/**
		 * Metodo para marcar como inativo a tarefa
		 *
		 * @param int $id
		 * @return Mixed
		 **/
		public function deletarTarefa(int $id)
		{
			try
			{
				$task = $this->find($id);
				$task->status = Status::Inativo;
				$task->save();

				return true;
			}
			catch (\Throwable $th)
			{
				return "erro ao marcar tarefa como feita";
			}
		}
    #endregion
}