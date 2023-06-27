import './bootstrap';
import '../sass/app.scss'
import jQuery from 'jquery';
window.$ = jQuery;

$(function ()
{
	var btn_open_tasks = $(".btn-open-task");
	var btn_new_tasks = $("#button-new-task");
	var updateTask = $("#updateTask");
	var taskFeita = $("#taskFeita");
	var deleteTask = $("#deleteTask");

	const methods =
	{
		/**
		 * Metodo que exibe o alert personalizado na view
		 * @param {string} text 
		 * @param {string} type 
		 */
		showAlert: (text, type) =>
		{
			let modalconfirm = new bootstrap.Modal(document.getElementById('modal-alert'));
			modalconfirm.toggle();
			console.log(text);
			console.log($("#message-alert"));
			$("#message-alert").html(text);
		},
		/**
		 * carregar lista de tarefas
		 * @returns 
		 */
		carregarTarefas: async () =>
		{
			return new Promise(function(resolve, reject)
			{
				$.ajax({
					url: route('tasks.list'),
					type: "GET",
					credentials: "same-origin",
					success: function(response)
					{
						var result = response;
						if (result.type === "success")
						{
							result.tasks.forEach(task =>
							{
								methods.displayTasks(task.id, task.titulo, task.descricao, task.prazo);
							});
	
							// atualiza
							
							btn_open_tasks = $(".btn-open-task");
							resolve(btn_open_tasks);
						}
					},
					error: function(error)
					{
						reject(error);
					}
				});
			});
		},
		/**
		 * exibe as tarefas em card
		 * @param {string} id 
		 * @param {string} titulo 
		 * @param {string} descricao 
		 * @param {string} data_prazo 
		 */
		displayTasks: (id, titulo, descricao, data_prazo) =>
		{
			// Criar os elementos do conteúdo
			var divCol = document.createElement("div");
			divCol.className = "col-12 col-sm-6 col-md-4";

			var divCard = document.createElement("div");
			divCard.className = "card my-3";

			var divCardBody = document.createElement("div");
			divCardBody.className = "card-body";

			var data = new Date(data_prazo);

			// Obter os componentes da data
			var dia = data.getDate();
			var mes = data.getMonth() + 1; // Os meses são baseados em zero, então adicionamos 1
			var ano = data.getFullYear();

			var pDate = document.createElement("p");
			pDate.className = "card-text text-muted text-end";
			pDate.textContent = dia + "/" + mes + "/" + ano;

			var h5 = document.createElement("h5");
			h5.className = "card-title";
			h5.textContent = titulo;

			var pDescription = document.createElement("p");
			pDescription.className = "card-text";
			pDescription.textContent = descricao;

			var button = document.createElement("button");
			button.type = "button";
			button.className = "btn btn-primary btn-open-task";
			button.setAttribute("data-bs-toggle", "modal");
			button.setAttribute("data-bs-target", "#tarefaModal");
			button.setAttribute("data-id", id);
			button.textContent = "Leia Mais";

			// Adicionar os elementos criados à div com o ID "list-task"
			var divListTask = document.getElementById("list-task");
			divCardBody.appendChild(pDate);
			divCardBody.appendChild(h5);
			divCardBody.appendChild(pDescription);
			divCardBody.appendChild(button);
			divCard.appendChild(divCardBody);
			divCol.appendChild(divCard);
			divListTask.appendChild(divCol);
		},
		/**
		 * pega a tarefa aberta e adiciona seus atributos nos campos necessarios
		 * @param {*} task 
		 */
		openTask: (task) =>
		{
			$("#id").val(task.id);
			$("#titulo").val(task.titulo);
			$("#descricao").val(task.descricao);
			$("#conteudo").val(task.conteudo);
			$("#deleteTask").attr("data-id",task.id);
			$("#taskFeita").attr("data-id",task.id);

			var datePrazo = new Date(task.prazo);
			// Obter os componentes da data
			var dia = datePrazo.getDate();
			var mes = (datePrazo.getMonth() + 1) < 9 ? '0'+(datePrazo.getMonth() + 1) : (datePrazo.getMonth() + 1);
			var ano = datePrazo.getFullYear();
			var hora = datePrazo.getHours();
			var min = datePrazo.getMinutes();
			$("#prazo").val(ano + "-" + mes + "-" + dia + "T"+ hora + ":" + min);
		},
	};

	methods.carregarTarefas().then((btn) =>
	{
		// carregar uma tarefa para mais detalhe
		btn?.on("click",function(event)
		{
			event.preventDefault(); // Evita o comportamento padrão do formulário

			$.ajax({
				url: route('tasks.open',{id: event.target.dataset.id}),
				type: "GET",
				credentials: "same-origin",
				headers: {
					'Content-Type': 'application/json',
					// adicionei uma excecao ao recuperar o get, como exemplo
				},
				success: function(response)
				{
					var result = response;
					if (result.type === "success")
					{
						methods.openTask(result.task);
					}
				},
				error: function(error)
				{
				}
			});
		});
	});

	// criar tarefa
	btn_new_tasks?.on("click", function(event)
	{
		event.preventDefault(); // Evita o comportamento padrão do formulário

		var formData = new FormData(document.querySelector("#form-new-task"));
		var data = {};
	
		for (var [key, value] of formData.entries())
		{
			data[key] = value;
		}
		var data = JSON.stringify(data);

		$.ajax({
			url: event.target.dataset.action,
			type: "POST",
			credentials: "same-origin",
			data: data,
			headers: {
				'Content-Type': 'application/json',
				"X-CSRF-Token": $("#form-new-task").data("token"),
			},
			success: function(response)
			{
				var result = response;
				if (result.type === "success")
				{
					methods.showAlert(result.message, result.type);
				}

				// tempo de leitura
				setTimeout(() => {
					window.location.href = result.redirect;
				}, 500);
			},
			error: function(error)
			{
				var result = error.responseJSON;
				if (result.type === "error")
				{
					methods.showAlert(result.message, result.type);
				}
				else
				{
					$.each(result.errors, function(field, errors)
					{
						methods.showAlert(errors.join(", "), "warning");
					});
				}
			}
		});
	});

	// atualizar tarefa
	updateTask?.on("click", function(event)
	{
		event.preventDefault(); // Evita o comportamento padrão do formulário

		var formData = new FormData(document.querySelector("#form-edit-task"));
		var data = {};
	
		for (var [key, value] of formData.entries())
		{
			data[key] = value;
		}
		var data = JSON.stringify(data);

		$.ajax({
			url: $("#form-edit-task").data("action"),
			type: "POST",
			credentials: "same-origin",
			data: data,
			headers: {
				'Content-Type': 'application/json',
				"X-CSRF-Token": $("#form-edit-task").data("token"),
			},
			success: function(response)
			{
				var result = response;
				if (result.type === "success")
				{
					methods.showAlert(result.message, result.type);
				}

				// tempo de leitura
				setTimeout(() => {
					window.location.href = result.redirect;
				}, 500);
			},
			error: function(error)
			{
				var result = error.responseJSON;
				if (result.type === "error")
				{
					methods.showAlert(result.message, result.type);
				}
				else
				{
					$.each(result.errors, function(field, errors)
					{
						methods.showAlert(errors.join(", "), "warning");
					});
				}
			}
		});
	});

	// marca feito
	taskFeita?.on("click", function(event)
	{
		event.preventDefault(); // Evita o comportamento padrão do formulário

		$.ajax({
			url: route('tasks.feito',{id: event.target.dataset.id}),
			type: "POST",
			credentials: "same-origin",
			headers: {
				'Content-Type': 'application/json',
				"X-CSRF-Token": $("#form-edit-task").data("token"),
			},
			success: function(response)
			{
				var result = response;
				if (result.type === "success")
				{
					methods.showAlert(result.message, result.type);
				}

				// tempo de leitura
				setTimeout(() => {
					window.location.href = result.redirect;
				}, 500);
			},
			error: function(error)
			{
				var result = error.responseJSON;
				if (result.type === "error")
				{
					methods.showAlert(result.message, result.type);
				}
				else
				{
					$.each(result.errors, function(field, errors)
					{
						methods.showAlert(errors.join(", "), "warning");
					});
				}
			}
		});
	});

	// excluir
	deleteTask?.on("click", function(event)
	{
		event.preventDefault(); // Evita o comportamento padrão do formulário

		$.ajax({
			url: route('tasks.delete',{id: event.target.dataset.id}),
			type: "DELETE",
			credentials: "same-origin",
			headers: {
				'Content-Type': 'application/json',
				"X-CSRF-Token": $("#form-edit-task").data("token"),
			},
			success: function(response)
			{
				var result = response;
				if (result.type === "success")
				{
					methods.showAlert(result.message, result.type);
				}

				// tempo de leitura
				setTimeout(() => {
					window.location.href = result.redirect;
				}, 500);
			},
			error: function(error)
			{
				var result = error.responseJSON;
				if (result.type === "error")
				{
					methods.showAlert(result.message, result.type);
				}
				else
				{
					$.each(result.errors, function(field, errors)
					{
						methods.showAlert(errors.join(", "), "warning");
					});
				}
			}
		});
	});
});