<?php require_once '../template/topoLogin.php'; ?>

    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/rodape.css">

    <div class="container">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" id="formLogin">
                <span id="reauth-email" class="reauth-email"></span>
                <p id="textoInvalido" class="hidden text-danger">Usuário/senha inválidos...</p>
                <input type="text" id="login" name="login" class="form-control" placeholder="Login" required autofocus>
                <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required>
                <button id="btnLogin" class="btn btn-lg btn-primary btn-block btn-signin" data-loading-text="Carregando..." type="submit">Login</button>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        $( document ).ready(function() {

            $('#formLogin').submit(function(event) {
                event.preventDefault();
                var btn = $('#btnLogin').button('loading'),
                    formLogin = $(this).serialize();

                $.ajax({
                    url: '../controller/usuario.php',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {action: 'login', campo: formLogin},
                }).done(function(r) {
                    console.log(r);
                    if (r.login=='accepted') {
                        location.href = "home.php";
                    }else if(r.login=='denied'){
                        btn.button('reset');
                        $('#textoInvalido').removeClass('hidden').hide(2000);
                    };
                });

            });

        });
    </script>
<?php require_once '../template/rodapeLogin.php'; ?>