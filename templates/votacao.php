<!DOCTYPE html>
<html lang="pt_br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>UEg - Lista de Candidatos</title>

    <!-- Bootstrap -->
    <link href="/templates/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

   <div class="container">
      <h1>Apuração de votos para ...</h1>
      <p class="text-right"><input type="button" class="btn btn-default" value="Voltar" onclick="window.location='/apuracao'"></p>

      <?php
        if(isset($votacao) && !empty($votacao)) { ?>

          <table class="table table-bordered">
            <tr>
              <th>Foto</th>
              <th>Número</th>
              <th>Nome</th>
              <th>Apelido</th>
              <th>Quantidade de Votos</th>
            </tr>

          <?php foreach ($votacao as $voto) { ?>
            <tr>
              <td align="center">
                <?php if(isset($voto['foto'])) { ?>
                  <img src="<?php echo $voto['foto']; ?>" width="120px" height="120px" class="img-circle">
                <?php } ?>
              </td>
              <td align="center">
                <?php echo (isset($voto['numero_candidato'])) ? $voto['numero_candidato'] : ''; ?>
              </td>
              <td>
                <?php echo (isset($voto['nome'])) ? $voto['nome'] : ''; ?>
              </td>
              <td>
                <?php echo (isset($voto['apelido'])) ? $voto['apelido'] : ''; ?>
              </td>
              <td>
                <?php echo (isset($voto['qtd_votos'])) ? $voto['qtd_votos'] : ''; ?>
              </td>
            </tr>
          <?php } ?>

          </table>

        <?php } else {  ?>

          <p class="text-center">Não há votos cadastrados.</p>

      <?php  } ?>
    </div>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/templates/bootstrap/js/jquery.v1.11.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/templates/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>