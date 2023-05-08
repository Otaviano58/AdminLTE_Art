<!DOCTYPE html>
<html lang="pt">
<head>
  <title><?php echo $title; ?></title>
  <meta charset="utf-8">
  <meta name="app-url" content="<?php echo base_url('/') ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
 
 
<div class="container">
    <h2 class="text-center mt-5 mb-3"><?php echo $title; ?></h2>
    <div class="card">
        <div class="card-header" style="font-size: 0.8rem;">
            <button class="btn btn-outline-primary" onclick="createProject()"> 
                Adicionar novo agente
            </button>
        </div>
        <div class="card-body" style="font-size: 0.8rem;">
            <div id="alert-div">
             
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>CPF</th>
                        <th>RG</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="projects-table-body">
                     
                </tbody>
                 
            </table>
        </div>
    </div>
</div>
 
<!-- modal for creating and editing function
<div class="modal" tabindex="-1" role="dialog" id="form-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Project Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="modal-alert-div">
             
        </div>
        <form>
            <input type="hidden" name="update_id" id="update_id">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome">
            </div>
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea class="form-control" id="descricao" rows="3" name="descricao"></textarea>
            </div>
            <div class="form-group">
            <label for="sexo">Gênero:</label>
            <select name="sexo" id="sexo">
            <optgroup label="Gêneros">
                <option value="masculino">Masculino</option>
                <option value="feminino">Feminino</option>
            </optgroup>
            <optgroup label="Opcional">
                <option value="nao_informar">Prefiro não informar</option>
            </optgroup>
            </select>

            </div>
          
            <button type="submit" class="btn btn-outline-primary" id="save-project-btn">Save Project</button>
        </form>
      </div>
    </div>
  </div>
</div> -->
 
<!-- view record modal -->
<!-- <div class="modal" tabindex="-1" role="dialog" id="view-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agente - Informações</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <b>Nome:</b>
        <p id="nome-info"></p>
        <b>Description:</b>
        <p id="descricao-info"></p>
      </div>
    </div>
  </div>
</div> -->
 
<script type="text/javascript">
 
     
    showAllProjects();
 
    /*
        This function will get all the project records
    */
    function showAllProjects()
    {
        let url = $('meta[name=app-url]').attr("content") + "project/show-all";
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                $("#projects-table-body").html("");
                let projects = response;
                for (var i = 0; i < projects.length; i++) 
                {
                    let showBtn =  '<button ' +
                                        ' class="btn btn-outline-info" ' +
                                        ' onclick="showProject(' + projects[i].id + ')">Show' +
                                    '</button> ';
                    let editBtn =  '<button ' +
                                        ' class="btn btn-outline-success" ' +
                                        ' onclick="editProject(' + projects[i].id + ')">Edit' +
                                    '</button> ';
                    let deleteBtn =  '<button ' +
                                        ' class="btn btn-outline-danger" ' +
                                        ' onclick="destroyProject(' + projects[i].id + ')">Delete' +
                                    '</button>';
 
                    let projectRow = '<tr>' +
                                        '<td>' + projects[i].nome + '</td>' +
                                        '<td>' + projects[i].descricao + '</td>' +
                                        '<td>' + projects[i].cpf + '</td>' +
                                        '<td>' + projects[i].rg + '</td>' +
                                
                                        '<td>' + showBtn + editBtn + deleteBtn + '</td>' +
                                    '</tr>';
                    $("#projects-table-body").append(projectRow);
                }
 
                 
            },
            error: function(response) {
                console.log(response)
            }
        });
    }
 
    /*
        check if form submitted is for creating or updating
    */
    $("#save-project-btn").click(function(event ){
        event.preventDefault();
        if($("#update_id").val() == null || $("#update_id").val() == "")
        {
            storeProject();
        } else {
            updateProject();
        }
    })
 
    /*
        show modal for creating a record and 
        empty the values of form and remove existing alerts
    */
    function createProject()
    {
        $("#alert-div").html("");
        $("#modal-alert-div").html("");
        $("#update_id").val("");
        $("#nome").val("");
        $("#descricao").val("");
        $("#sexo").val("");
        $("#cpf").val("");
        $("#rg").val("");
        $("#cep").val("");
        $("#estado").val("");
        $("#cidade").val("");
        $("#bairro").val("");
        $("#rua").val("");
        $("#numero").val("");
        $("#form-modal").modal('show'); 
    }
 
    /*
        submit the form and will be stored to the database
    */
    function storeProject()
    {   
        $("#save-project-btn").prop('disabled', true);
        let url = $('meta[name=app-url]').attr("content") + "project/store";
        let data = {
            nome: $("#nome").val(),
            descricao: $("#descricao").val(),
            sexo: $("#sexo").val(),
        };
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            success: function(response) {
 
                $("#save-project-btn").prop('disabled', false);
                let successHtml = '<div class="alert alert-success" role="alert"><b>Project Created Successfully</b></div>';
                $("#alert-div").html(successHtml);
                $("#nome").val("");
                $("#descricao").val("");
                sexo: $("#sexo").val(""),
                showAllProjects();
                $("#form-modal").modal('hide');
            },
            error: function(response) {
                $("#save-project-btn").prop('disabled', false);
            
                let responseData = JSON.parse(response.responseText);
                console.log(responseData.errors);
 
                if (typeof responseData.errors !== 'undefined') 
                {
                    let errorHtml = '<div class="alert alert-danger" role="alert">' +
                                        '<b>Validation Error!</b>' +
                                        responseData.errors +
                                    '</div>';
                    $("#modal-alert-div").html(errorHtml);      
                }
            }
        });
    }
 
 
    /*
        edit record function
        it will get the existing value and show the project form
    */
    function editProject(id)
    {
        let url = $('meta[name=app-url]').attr("content") + "project/edit/" + id ;
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                let project = response;
                $("#alert-div").html("");
                $("#modal-alert-div").html("");
                $("#update_id").val(project.id);
                $("#name").val(project.name);
                $("#description").val(project.description);
                $("#form-modal").modal('show'); 
            },
            error: function(response) {
                 
            }
        });
    }
 
    /*
        sumbit the form and will update a record
    */
    function updateProject()
    {
        $("#save-project-btn").prop('disabled', true);
        let url = $('meta[name=app-url]').attr("content") + "project/update/" + $("#update_id").val();
        let data = {
            id: $("#update_id").val(),
            name: $("#name").val(),
            description: $("#description").val(),
        };
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            success: function(response) {
                $("#save-project-btn").prop('disabled', false);
                let successHtml = '<div class="alert alert-success" role="alert"><b>Project Updated Successfully</b></div>';
                $("#alert-div").html(successHtml);
                $("#name").val("");
                $("#description").val("");
                showAllProjects();
                $("#form-modal").modal('hide');
            },
            error: function(response) {
                /*
                    show validation error
                */
                $("#save-project-btn").prop('disabled', false);
            
                let responseData = JSON.parse(response.responseText);
                console.log(responseData.errors);
 
                if (typeof responseData.errors !== 'undefined') 
                {
                    let errorHtml = '<div class="alert alert-danger" role="alert">' +
                                        '<b>Validation Error!</b>' +
                                        responseData.errors +
                                    '</div>';
                    $("#modal-alert-div").html(errorHtml);      
                }
            }
        });
    }
 
    /*
        get and display the record info on modal
    */
    function showProject(id)
    {
        $("#name-info").html("");
        $("#description-info").html("");
        let url = $('meta[name=app-url]').attr("content") + "project/show/" + id +"";
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                console.log(response);
                let project = response;
                $("#nome-info").html(project.nome);
                $("#descricao-info").html(project.descricao);
                $("#view-modal").modal('show'); 
                 
            },
            error: function(response) {
                console.log(response)
            }
        });
    }
 
    /*
        delete record function
    */
    function destroyProject(id)
    {
        let url = $('meta[name=app-url]').attr("content") + "project/delete/" + id;
        let data = {
            name: $("#nome").val(),
            description: $("#descricao").val(),
        };
        $.ajax({
            url: url,
            type: "DELETE",
            data: data,
            success: function(response) {
                let successHtml = '<div class="alert alert-success" role="alert"><b>Project Deleted Successfully</b></div>';
                $("#alert-div").html(successHtml);
                showAllProjects();
            },
            error: function(response) {
                console.log(response)
            }
        });
    }
 
</script>
</body>
</html>