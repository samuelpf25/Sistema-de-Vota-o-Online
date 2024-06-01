<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
  header('Location: login.php');
  exit();
}

require_once '../config.php';
require_once '../src/Usuario.php';

$usuarios = Usuario::obterUsuarios();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- Adicionando o CSS do Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />

  <script src="js/jquery.js"></script>
  <!-- Adicionando o JavaScript do Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/script.js"></script>
  <style>
    .is-invalid {
      border-color: red;
    }

    @keyframes blink {
      0% {
        background-color: yellow;
      }

      50% {
        background-color: red;
      }

      100% {
        background-color: yellow;
      }
    }

    .destaque {
      animation: blink 1s infinite;
    }
  </style>

  <title>Cadastro de Usuários</title>
</head>

<body>
  <div class="container mt-5">
    <h1>Cadastro de Usuários</h1>
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#cadastroModal">
      Cadastrar Novo Usuário
    </button>
    <table id="tbcadastro" class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>CPF</th>
          <th>Email</th>
          <th>Ação</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>


    <!-- Modal para Cadastro de Novo Usuário -->
    <div class="modal fade" id="cadastroModal" tabindex="-1" aria-labelledby="cadastroModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="cadastroModalLabel">Cadastrar Novo Usuário</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="cadastroForm">
              <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" required>
              </div>
              <div class="mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" class="form-control" id="cpf" required>
                <div class="invalid-feedback">
                  CPF deve ter pelo menos 11 caracteres e conter somente números.
                </div>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" required>
              </div>
              <button type="submit" class="btn btn-primary">Cadastrar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script defer>
      $(document).ready(function() {
        // Delegação de eventos para elementos dinâmicos
        $(document).on('input', 'input.altera', function() {
          console.log('função alterar classe destaque chamada!');
          $('.btn-atualizar').removeClass('destaque');
          $(this).closest('tr').find('.btn-atualizar').addClass('destaque');
        });

        $('#cpf').on('input', function() {
          const cpfInput = $(this);
          const cpfValue = cpfInput.val();

          // Verifica se o CPF contém apenas números e tem pelo menos 11 caracteres
          if (/^\d{11,}$/.test(cpfValue)) {
            cpfInput.removeClass('is-invalid');
          } else {
            cpfInput.addClass('is-invalid');
          }
        });

        $('#cadastroForm').on('submit', function(event) {
          const cpfInput = $('#cpf');
          const cpfValue = cpfInput.val();

          // Verifica se o CPF contém apenas números e tem pelo menos 11 caracteres
          if (!/^(?!0{11})\d{11,}$/.test(cpfValue)) {
            event.preventDefault();
            cpfInput.addClass('is-invalid');
          } else {

            cpfInput.removeClass('is-invalid');
            event.preventDefault();
            const nome = $('#nome').val();
            const cpf = $('#cpf').val();
            const email = $('#email').val();

            $.post('cadastrar_usuario.php', {
              nome: nome,
              cpf: cpf,
              email: email
            }, function(response) {
              $('#cadastroModal').modal('hide');
              alert('Usuário cadastrado com sucesso!');
              carregarTabela();
            }).fail(function() {
              alert('Erro ao cadastrar o usuário.');
            });
          }
        });
      });

      carregarTabela();
    </script>
</body>

</html>