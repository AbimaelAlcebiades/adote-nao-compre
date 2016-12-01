 <div class="container">
      <div>
        <h1>Meus Cães</h1>
      </div>

      <div class="container">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Cão</th>
              <th>Ação</th>
            </tr>
          </thead>

          <tbody>
              <?php foreach ($animalList as $animal) { ?>
              
            <tr>
              <td>
                <?php echo $animal->getNome(); ?>
              </td>
              <td>
                <a href="../templates/edicao_animal.php?animal=<?php echo $animal->getId(); ?>" class="btn btn-info" role="button">
                  <span class="glyphicon glyphicon-pencil" aria-hidden="true">&nbsp;</span>Editar
                </a>

                <a class="btn btn-danger" role="button" name="delete" data-id="<?php echo $animal->getId(); ?>">
                  <span class="glyphicon glyphicon-remove-circle" aria-hidden="true">&nbsp;</span>Excluir
                </a>
              </td>
            </tr>
             <?php } ?>
          </tbody>
        </table>

        <a href="../templates/edicao_animal.php" id="id_add_dog" class="btn btn-success" role="button">
          <span class="glyphicon glyphicon-plus" aria-hidden="true">&nbsp;</span>Adicionar Cão
        </a>

      </div>

      <hr>
    </div> 