<br><br><br>
  <h3>Espécies cadastradas</h3>
  <table class="table table-striped">

    <tbody>
      <tr>
        <th>Id</th>
        <th>Nome</th>
        <th>Ações</th>
      </tr>
      <?php foreach ($especies as $especie) { ?>
      <tr>
        <td><?php echo $especie->getId(); ?></td>
        <td><?php echo $especie->getNome(); ?></td>
        <td>
          <button type="submit" class="btn btn-primary" id="btn_alter">Alterar</button>
          <a href="#" data-id="<?php echo $especie->getId(); ?>" class="btn btn-danger excluir-especie" role="button">Excluir</a>
        </td>
      </tr>
      <?php }?>
    </tbody>
</table>
