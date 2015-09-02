<!DOCTYPE html>
<html lang="pt_br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>UEg - Lista de Eleitores</title>

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
      <h1>Lista de Eleitores</h1>
      <p class="text-right"><input type="button" class="btn btn-default" value="Voltar" onclick="window.location='/'"></p>

      <?php
        if(isset($eleitores) && !empty($eleitores)) { ?>

          <table class="table table-bordered">
            <tr>
              <th class="col-md-2">Foto</th>
              <th class="col-md-2">Número Documento</th>
              <th class="col-md-6">Nome</th>
              <th class="col-md-2">UEV</th>
            </tr>

          <?php foreach ($eleitores as $eleitor) { ?>
            <tr>
              <td align="center">
                <img src="<?php echo $eleitor->foto; ?>" width="120px" height="120px" class="img-circle">
              </td>
              <td>
                <?php echo $eleitor->numero_doc; ?>
              </td>
              <td>
                <?php echo $eleitor->nome; ?>
              </td>
              <td>
                <?php echo $eleitor->uev; ?>
              </td>
            </tr>
          <?php } ?>

          </table>

        <?php } else {  ?>

          <p class="text-center">Não há eleitores cadastrados.</p>

      <?php  } ?>
    </div>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="templates/bootstrap/js/jquery.v1.11.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="templates/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>