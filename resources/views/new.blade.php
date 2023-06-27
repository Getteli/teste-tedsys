{{-- layout onde esse conteudo sera apresentado --}}
@extends('container')

{{-- conteudo --}}
@section('content')
	<div class="container mt-5">
		<form method="POST" id="form-new-task" data-action="{{ route('tasks.create.task') }}" data-token="{{ csrf_token() }}">
			<div class="row">
				<div class="mb-3 col-12 col-sm-6">
					<label for="titulo" class="form-label">Titulo</label>
					<input type="text" maxlength="45" name="titulo" required class="form-control" id="titulo">
				</div>
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
				<div class="col-12 col-sm-6">
					<button type="button" id="button-new-task" class="btn btn-primary mt-button">{{ __('view.create_tasks')}}</button>
				</div>
			</div>
		</form>
	</div>
@endsection

@section('title')
	Teste TedSys - Criar nova tarefa
@endsection