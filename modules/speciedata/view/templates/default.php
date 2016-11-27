<div class="container module-highlighthome">
  <!-- Exibição com 3 destaques -->
  
  <h3>Nova Espécie</h3>
  <form class="form-inline module-nova-especie" action="/user/extras/" method="POST" enctype="multipart/form-data">

    <label>Nome: </label> <input class="form-control nome" maxlength="100" type="text" required />

    <button type="submit" class="btn btn-primary enviar-formulario" id="btn_save">
      <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">&nbsp;</span>Salvar
    </button>

    <a href="/user/profile/" class="btn btn-danger" role="button">
      <span class="glyphicon glyphicon-remove-circle cancelar" aria-hidden="true">&nbsp;</span>Cancelar
    </a>

  </form>

  <br><br><br>
  <h3>Espécies cadastradas</h3>
  <table class="table table-striped">

    <tbody>
      <tr>
        <th>Id</th>
        <th>Nome</th>
        <th>Ações</th>
      </tr>

      <tr>
        <td>1</td>
        <td>Cachorro</td>
        <td>
          <button type="submit" class="btn btn-primary" id="btn_alter">Alterar</button>
          <a href="/user/profile/" class="btn btn-danger" role="button">Excluir</a>
        </td>
      </tr>

      <tr>
        <td>2</td>
        <td>Gato</td>
        <td>
          <button type="submit" class="btn btn-primary" id="btn_alter">Alterar</button>
          <a href="/user/profile/" class="btn btn-danger" role="button">Excluir</a>
        </td>
      </tr>

    </tbody>
  </table>
</div>

