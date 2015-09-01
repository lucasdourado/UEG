<!DOCTYPE html>
<html lang="pt_br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="templates/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <div class="container">
      <h1>Lista de Candidatos</h1>
      <p class="text-right"><input type="button" class="btn btn-default" value="Voltar" onclick="window.location='/'"></p>

      <?php
        if(!isset($candidatos) && !empty($candidatos)) { ?>

          <table class="table table-bordered">
            <tr>
              <th>Foto</th>
              <th>Número</th>
              <th>Nome</th>
              <th>Apelido</th>
              <th>Cargo</th>
            </tr>

          <?php foreach ($candidatos as $candidato) { ?>
            <tr>
              <td align="center">
                <img src="<?php echo $candidato->foto; ?>" width="120px" height="120px" class="img-circle">
              </td>
              <td align="center">
                <?php echo $candidato->numero; ?>
              </td>
              <td>
                <?php echo $candidato->nome; ?>
              </td>
              <td>
                <?php echo $candidato->apelido; ?>
              </td>
              <td>
                <?php echo $candidato->nome_cargo; ?>
              </td>
            </tr>
          <?php } ?>

          </table>

        <?php } else {  ?>

          <p class="text-center">Não há candidatos cadastrados.</p>

      <?php  } ?>
    </div>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="templates/bootstrap/js/jquery.v1.11.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="templates/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>