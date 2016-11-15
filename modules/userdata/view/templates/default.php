<div class="container module-highlighthome">
  <!-- Exibição com 3 destaques -->
  <h4><i>//pode ser assim e depois um botão pra editar, ou direto na edição com os dados carregados.. o que achei mais pratico até!</h4></i>
  <table class="table table-striped">

    <tbody>
      <tr>
        <td>
          Nome
        </td>
        <td>
          Teste da Silva
        </td>
      </tr>

      <tr>
        <td>
          E-mail
        </td>
        <td>
          teste@teste.com
        </td>
      </tr>

      <tr>
        <td>
          Telefone
        </td>
        <td>
          (51) 99920 8881
        </td>
      </tr>

      <tr>
        <td>
          Endereço completo
        </td>
        <td>
          Rua Abc, 134. Centro. Canoas RS
        </td>
      </tr>

    </tbody>
  </table>
  <!-- fecha Exibição de destaques -->

  <form class="form-inline" action="/user/extras/" method="post" enctype="multipart/form-data">

    <label>Nome</label>
    <p><input class="form-control" id="id_nome" maxlength="100" name="nome" type="text" required value="Teste da Silva" /></p>

    <label>E-mail</label>
    <p><input class="form-control" id="id_Email" maxlength="100" name="email" type="text" required value="teste@teste.com"/></p>


    <label>Telefone</label>
    <p><input class="form-control" id="id_Telefone" min="0" name="telefone" type="number" value="51999208882"/></p>


    <label>Endereço completo</label>
    <p><input class="form-control" id="id_Endereco" maxlength="255" name="endereco" type="text" value="Rua Abc, 134. Centro. Canoas RS" /></p>


    <label>Senha</label>
    <p><input class="form-control" id="id_senha" min="0" name="senha" type="password" /></p>

    <label>Confirmar senha</label>
    <p><input class="form-control" id="id_senha2" min="0" name="senha2" type="password"  /></p>    

    <button type="submit" class="btn btn-primary" id="btn_save">
      <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">&nbsp;</span>Salvar
    </button>

    <a href="/user/profile/" class="btn btn-danger" role="button">
      <span class="glyphicon glyphicon-remove-circle" aria-hidden="true">&nbsp;</span>Cancelar
    </a>

  </form>
</div>

