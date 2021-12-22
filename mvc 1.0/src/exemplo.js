var APP = {
  init: function () {
    var btnEnviar = document.querySelector('#btnEnviar')
    var btnsExcluir = document.querySelectorAll('table .delete')

    if (btnEnviar) {
      btnEnviar.addEventListener('click', function () {
        APP.enviarPessoa()
      })
    }

    if (btnsExcluir) {
      for (btn of btnsExcluir) {
        btn.addEventListener('click', function (e) {
          var id = e.currentTarget.getAttribute('data-id')
          if (
            id &&
            confirm('Tem certeza que deseja excluir o registro ID ' + id + '?')
          ) {
            APP.excluirPessoa(id)
          }
        })
      }
    }
  },

  enviarPessoa: function () {
    var form = document.querySelector('form')

    if (form.reportValidity()) {
      var id = document.querySelector('#id').value
      var nome = document.querySelector('#nome').value
      var email = document.querySelector('#email').value
      var datanascimento = document.querySelector('#datanascimento').value
      var telefone = document.querySelector('#telefone').value

      var formdata = new FormData()
      formdata.append('id', id)
      formdata.append('nome', nome)
      formdata.append('email', email)
      formdata.append('datanascimento', datanascimento)
      formdata.append('telefone', telefone)

      var requestOptions = {
        method: 'POST',
        body: formdata,
        redirect: 'follow'
      }

      var codigoHttp = null
      var operacao = 'insert'
      var rota = 'MVC/action/AddPessoa.php'

      if (id && id > 0) {
        operacao = 'update'
        rota = 'MVC/action/AlterarPessoa.php'
      }

      fetch(rota, requestOptions)
        .then(response => {
          codigoHttp = response.status
          return response.text()
        })
        .then(message => {
          if (codigoHttp == 200) {
            if (operacao == 'insert') {
              alert('Pessoa foi cadastrada com o código ' + message)
            } else {
              alert('Dados da pessoa foram atualizados')
            }
          } else if (codigoHttp == 422) {
            alert(
              'Dados inválidos! Verifique se os campos estão preenchidos corretamente e tente novamente.'
            )
          } else if (codigoHttp == 500) {
            alert('Erro: ' + message)
          } else {
            alert('Erro ' + message)
          }
        })
    }
  },

  excluirPessoa: function (id) {
    var codigoHttp = null
    var formdata = new FormData()
    formdata.append('id', id)

    var requestOptions = {
      method: 'POST',
      body: formdata,
      redirect: 'follow'
    }

    fetch('MVC/action/ExcluirPessoa.php', requestOptions)
      .then(response => {
        codigoHttp = response.status
        return response.text()
      })
      .then(message => {
        if (codigoHttp == 200) {
          window.location.reload()
        } else {
          alert('Erro ' + message)
        }
      })
      .catch(message => {
        alert('Erro ' + message)
      })
  }
}

APP.init()
