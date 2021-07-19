<!DOCTYPE html>
<html lang="en pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <!-- PHP -->
  <?php
  // Conexão com o arquivo do banco de dados
  require_once 'db_connect.php';

  // Sessão
  session_start();

  // Botão enviar
  if (isset($_POST['btn-entrar'])) :
    $erros = array();
    $login = mysqli_escape_string($connect, $_POST['login']);
    $senha = mysqli_escape_string($connect, $_POST['senha']);

    if (empty($login) or empty($senha)) :
      $erros[] = "<li>O campo login/senha precisa ser preenchido.</li>";
    else :
      $sql = "SELECT login FROM usuarios WHERE login = '$login' ";
      $resultado = mysqli_query($connect, $sql);

      if (mysqli_num_rows($resultado) > 0) :
        $senha = md5($senha); //criptografando senha
        $sql = "SELECT * FROM usuarios WHERE login = '$login' AND senha = '$senha'";
        $resultado = mysqli_query($connect, $sql);
        if (mysqli_num_rows($resultado) == 1) :
          $dados = mysqli_fetch_array($resultado); //essa função vai converter o resultado em um array e atribuir na variável dados
          mysqli_close($connect);
          $_SESSION['logado'] = true;
          $_SESSION['id_usuario'] = $dados['id'];
          header('Location: home.php'); //função para direcionar para uma pag restrita
        else :
          $erros[] = "O usuário ou senha não existem.";
        endif;
      else :
        $erros[] = "Usuário inexistente";
      endif;
    endif;
  endif;
  ?>
  <!-- /PHP -->

  <!-- Formulário -->
  <div id="login-container">
    <h1>Login</h1>

    <!-- Atribuindo mensagem de erro caso algum campo não seja preenchido -->
    <?php
    if (!empty($erros)) :
      foreach ($erros as $erro) :
        echo $erro;
      endforeach;
    endif;
    ?>
    <!-- /Mensagem de erro-->

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <label for="email">Login</label>
      <input type="text" name="login" id="email" placeholder="Digite seu login" autocomplete="off">
      <label for="password">Senha</label>
      <input type="password" name="senha" id="password" placeholder="Digite sua senha">
      <a href="#" id="forgot-pass">Esqueceu a senha?</a>
      <!--Link p caso de redefinição de senha!-->
      <button type="input" name="btn-entrar">Login</button>
      <!--<input type="submit" value="Login">-->
      <!-- Faz o envio de info para o sevidor!-->
    </form> <!-- /Formulário -->

    <!-- Infos -->
    <div id="social-container">
      <p>Ou conecte-se através de suas redes sociais</p>
      <i class="fa fa-facebook-f"></i>
      <i class="fa fa-linkedin"></i>
    </div>
    <div id="register-container">
      <p>Ainda não tem uma conta?</p>
      <a href="#">Registrar</a>
    </div>
  </div>
</body>

</html>