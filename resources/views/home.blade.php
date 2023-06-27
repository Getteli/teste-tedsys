{{-- layout onde esse conteudo sera apresentado --}}
@extends('container')

{{-- conteudo --}}
@section('content')
	<div class="container mt-5">
		<div class="row" id="list-task">
		</div>

		<div class="modal fade" id="tarefaModal" tabindex="-1" aria-labelledby="tarefaModal" aria-hidden="true">
			<div class="modal-dialog">
				<form id="form-edit-task" data-action="{{ route('tasks.edit') }}" method="POST" data-token="{{ csrf_token() }}">
					<div class="modal-content">
						<div class="modal-header">
							<h1 class="modal-title fs-5">
								<input type="text" maxlength="45" name="titulo" required class="form-control" id="titulo">
							</h1>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body" id="conteudo-task">
							<input type="hidden" value="" id="id" name="id">
							<div class="mb-3 col-12 col-sm-6">
								<label for="descricao" class="form-label">Descrição</label>
								<input type="text" maxlength="200" name="descricao" class="form-control" id="descricao">
							</div>
							<div class="mb-3 col-12">
								<div class="form-floating">
									<textarea name="conteudo" id="conteudo" required maxlength="16777215" class="form-control" placeholder="descreva a tarefa com mais detalhes (opcional)" id="conteudo"></textarea>
									<label for="conteudo">Conteúdo</label>
								</div>
							</div>
							<div class="mb-3 col-12 col-sm-6">
								<label for="prazo" class="form-label">Prazo</label>
								<input type="datetime-local" name="prazo" class="form-control" id="prazo">
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" id="deleteTask" data-bs-dismiss="modal">excluir</button>
							<button type="button" class="btn btn-success" id="taskFeita">Feito</button>
							<button type="button" class="btn btn-primary" id="updateTask">Salvar mudanças</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('title')
	Teste TedSys - home
@endsection