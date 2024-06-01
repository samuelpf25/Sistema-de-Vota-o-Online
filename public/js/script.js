function zerar() {
  const cpf = document.getElementById("cpf").value;
  fetch("zerarvoto.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ cpf }),
  });
}

document
  .getElementById("autenticacaoForm")
  .addEventListener("submit", function (e) {
    $("#spinnerAutentica").removeClass();
    $("#spinnerAutentica").addClass("spinner-border spinner-border-sm");

    $("#spinner").html(
      "<div class='spinner-border' role='status'><span class='visually-hidden'>buscando usuário...</span></div>"
    );
    e.preventDefault();
    const cpf = document.getElementById("cpf").value;
    fetch("autenticar.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ cpf }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          $("#cpf").removeClass("is-invalid");
          $("#cpf").addClass("is-valid");
          $("#spinner").empty();
          $("#spinnerAutentica").removeClass();
          $("#btnAutentica").attr("disabled", "");

          $("#alerta").removeClass();
          $("#alerta")
            .addClass("alert alert-success alert-dismissible fade show")
            .html(
              '<strong>Usuário encontrado...</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
            )
            .delay(1000)
            .fadeOut(500);

          document.getElementById("checkcpf").style.display = "block";
          document
            .getElementById("autenticacaoForm")
            .setAttribute("disabled", "");
          document.getElementById("lcodigo").innerHTML =
            "Insira o código enviado para o e-mail <strong>" +
            data.email +
            "</strong>";
          document.getElementById("verificacaoForm").style.display = "block";
        } else {
          //alert("Erro: " + data.message);
          $("#cpf").removeClass("is-valid");
          $("#cpf").addClass("is-invalid");
          $("#spinner").empty();
          $("#spinnerAutentica").removeClass();
          $("#btnAutentica").removeAttr("disabled");

          $("#alerta").removeClass();
          $("#alerta")
            .addClass("alert alert-danger alert-dismissible")
            .html(
              "<strong>Erro: " +
                data.message +
                '</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
            );
        }
      });
  });

document
  .getElementById("verificacaoForm")
  .addEventListener("submit", function (e) {
    $("#spinnerVerifica").removeClass();
    $("#spinnerVerifica").addClass("spinner-border spinner-border-sm");
    $("#spinner").html(
      "<div class='spinner-border' role='status'><span class='visually-hidden'>verificando código...</span></div>"
    );
    e.preventDefault();
    const cpf = document.getElementById("cpf").value;
    const codigo = document.getElementById("codigo").value;
    fetch("verificar_codigo.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ cpf, codigo }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          $("#codigo").removeClass("is-invalid");
          $("#codigo").addClass("is-valid");
          $("#spinner").empty();
          $("#spinnerVerifica").removeClass();
          $("#btnVerifica").attr("disabled", "");

          $("#alerta").removeClass();
          $("#alerta")
            .addClass("alert alert-success alert-dismissible fade show")
            .html(
              '<strong>Código verificado...</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
            )
            .delay(1000)
            .fadeOut(500);

          document.getElementById("checkcodigo").style.display = "block";
          //document.getElementById('verificacaoForm').style.display = 'none';
          document.getElementById("votacaoForm").style.display = "block";
        } else {
          //alert("Erro: " + data.message);
          $("#codigo").removeClass("is-valid");
          $("#codigo").addClass("is-invalid");
          $("#spinner").empty();
          $("#spinnerVerifica").removeClass();
          $("#btnVerifica").removeAttr("disabled");

          $("#alerta").removeClass();
          $("#alerta")
            .addClass("alert alert-danger alert-dismissible")
            .html(
              "<strong>Erro: " +
                data.message +
                '</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
            );
        }
      });
  });

document.getElementById("votacaoForm").addEventListener("submit", function (e) {
  $("#spinner").html(
    "<div class='spinner-border' role='status'><span class='visually-hidden'>Registrando voto...</span></div>"
  );
  $("#spinnerVoto").removeClass();
  $("#spinnerVoto").addClass("spinner-border spinner-border-sm");
  e.preventDefault();

  const cpf = document.getElementById("cpf").value;
  const voto = document.getElementById("voto").value;
  let ip = "vazio";

  try {
    ip = window.ipAddress || "vazio";
  } catch (error) {
    console.error("Erro ao obter o endereço IP:", error);
  }

  fetch("votar.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ cpf, voto, ip }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success && voto != "") {
        $("#voto").removeClass("is-invalid");
        $("#voto").addClass("is-valid");
        $("#spinner").empty();
        $("#spinnerVoto").removeClass();

        $("#alerta").removeClass();
        $("#alerta")
          .addClass("alert alert-success alert-dismissible fade show")
          .html(
            '<strong>Voto registrado, Obrigado!</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
          )
          .delay(5000)
          .fadeOut(500);

        document.getElementById("checkvoto").style.display = "block";
        const nome = encodeURIComponent(data.nome);
        window.location.href = `pagina_de_confirmacao.html?nome=${nome}`;
      } else {
        //alert("Erro: " + data.message);
        $("#voto").removeClass("is-valid");
        $("#voto").addClass("is-invalid");
        $("#spinner").empty();
        $("#spinnerVoto").removeClass();

        $("#alerta").removeClass();
        $("#alerta")
          .addClass("alert alert-danger alert-dismissible")
          .html(
            "<strong>Erro: " +
              data.message +
              '</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
          );
      }
    });
});

function carregarTabela() {
  $.get("carrega_tabela.php", function (data) {
    const usuarios = JSON.parse(data).usuarios;
    const tbody = $("#tbcadastro tbody");
    tbody.empty();
    usuarios.forEach((usuario) => {
      tbody.append(`
                        <tr>
                            <td>${usuario.id}</td>
                            <td><input type="text" value="${usuario.nome}" class="form-control altera" id="nome-${usuario.id}"></td>
                            <td><input type="text" value="${usuario.cpf}" class="form-control cpf-input altera" id="cpf-${usuario.id}"></td>
                            <td><input type="text" value="${usuario.email}" class="form-control altera" id="email-${usuario.id}"></td>
                            <td>
                            <button class="btn btn-primary btn-atualizar" onclick="atualizarUsuario(${usuario.id})">Atualizar</button>
                            <button class="btn btn-danger" onclick="excluirUsuario(${usuario.id})">Excluir</button>
                            </td>
                        </tr>
                    `);
    });
    addCpfValidation();
  });
}

// Função para validar CPF
function validateCpf(cpf) {
  const cpfRegex = /^(?!0{11})\d{11}$/;
  return cpfRegex.test(cpf);
}

function addCpfValidation() {
  $("input.cpf-input")
    .each(function () {
      const cpfInput = $(this);
      const cpfValue = cpfInput.val();
      const isValid = validateCpf(cpfValue);

      if (isValid) {
        cpfInput.removeClass("is-invalid");
        cpfInput.tooltip("dispose");
      } else {
        cpfInput.addClass("is-invalid");
        cpfInput
          .tooltip({
            title: "CPF deve ter 11 dígitos e conter somente números.",
            placement: "right",
            trigger: "manual",
          })
          .tooltip("show");
      }
    })
    .on("input", function () {
      const cpfInput = $(this);
      const cpfValue = cpfInput.val();
      const isValid = validateCpf(cpfValue);

      if (isValid) {
        cpfInput.removeClass("is-invalid");
        cpfInput.tooltip("dispose");
      } else {
        cpfInput.addClass("is-invalid");
        cpfInput
          .tooltip({
            title: "CPF deve ter 11 dígitos e conter somente números.",
            placement: "right",
            trigger: "manual",
          })
          .tooltip("show");
      }
    });
}

function atualizarUsuario(id) {
  const nome = $(`#nome-${id}`).val();
  const cpf = $(`#cpf-${id}`).val();
  const email = $(`#email-${id}`).val();

  $.post(
    "atualizar_usuario.php",
    {
      id: id,
      nome: nome,
      cpf: cpf,
      email: email,
    },
    function (response) {
      $("#btnatualiza").removeClass("destaque");
      alert("Usuário atualizado com sucesso!");
      carregarTabela();
    }
  ).fail(function () {
    alert("Erro ao atualizar o usuário.");
  });
}

function excluirUsuario(id) {
  if (confirm("Tem certeza que deseja excluir este usuário?")) {
    $.post("excluir_usuario.php", { id: id }, function (response) {
      alert("Usuário excluído com sucesso!");
      carregarTabela();
    }).fail(function () {
      alert("Erro ao excluir o usuário.");
    });
  }
}


function Votos() {
  $.get("carrega_tabela.php", function (data) {
    const usuarios = JSON.parse(data).usuarios;
    let cont=0;
    let chapa1=0;
    let nulo=0;
    usuarios.forEach((usuario) => {
        if (usuario.voto_registrado!=null && usuario.codigo_verificacao!=null){
          cont+=1;
          if (usuario.voto_registrado=='Chapa 1'){
            chapa1+=1;
          }else if(usuario.voto_registrado=='Nulo' || usuario.voto_registrado==""){
            nulo+=1;
          }
        }
    });

    $('#votos_computados').text('Total de Votos Registrados: ' + cont)
    $('#chapa1').text('Total de Votos Chapa 1: ' + chapa1 + ' - ' + ((chapa1/cont)*100).toFixed(0) + '%')
    $('#nulo').text('Total de Votos Nulos: ' + nulo+ ' - ' + ((nulo/cont)*100).toFixed(0) + '%')
    
  });
}
