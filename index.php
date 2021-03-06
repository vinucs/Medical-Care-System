<!DOCTYPE html>
<html>
    <head>
        <title>EzMed</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <!-- Styles CSS -->
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class="container">
            <div class="login-box">
                <h1>Bem-vindo!</h1>
                <p>Entre para usar os recursos da plataforma!</p>
                <form action="back-end/login.php" method="POST" id="login-form">
                    <input type="email" placeholder="Nome de usuário" name="email">
                    <input type="password" placeholder="Senha" name="senha">
                    <button type="submit" form="login-form" class="default-button">Entrar</button>
                </form>
            </div>
        </div>
    </body>
    <footer>
        <p>Feito por Nathan Garcia e Vinicius Sartorio. O código é livre, podendo ser utilizado por qualquer indivíduo.</p>
    </footer>
</html>

