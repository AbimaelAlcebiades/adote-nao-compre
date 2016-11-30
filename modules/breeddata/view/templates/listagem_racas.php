<br><br><br>
  <h3>Raças cadastradas</h3>
  <table class="table table-striped">

    <tbody>
      <tr>
        <th>Id</th>
        <th>Nome</th>
        <th>Ações</th>
      </tr>
      <?php foreach ($racas as $raca) { ?>
      <tr>
        <td><?php echo $raca->getId(); ?></td>
        <td class="nome_raca_lista"><?php echo $raca->getNome(); ?></td>
        <td>
          <button type="submit" data-id="<?php echo $raca->getId(); ?>" class="btn btn-primary alterar-raca" id="btn_alter">Alterar</button>
          <a href="#" data-id="<?php echo $raca->getId(); ?>" class="btn btn-danger excluir-raca" role="button">Excluir</a>
        </td>
      </tr>
      <?php }?>
    </tbody>
</table>