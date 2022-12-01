<?php
    //
    require_once("./libs/Token.php");

    session_start();
    if (!empty($_SESSION["usuario"])) header("location: ./main.php");

    if (!empty($_POST) && Token::check($_POST["_token"])):
        //
        require_once("./libs/Database.php");
        $db = Database::getDatabase();
        $datos = $db->escape($_POST);

        $email = $datos["email"];
        $password = md5($datos["password"]);

        //
        require_once("./models/Usuario.php");

        //
        $db->query("SELECT * FROM usuario WHERE email = '${email}' AND password = '${password}'");
        $usuario = $db->getData("Usuario");

        if (empty($usuario)):
            $error = "Email o contraseña incorrectos.";
        else:
            $_SESSION["inicio"] = time();
            $_SESSION["usuario"] = serialize($usuario);

            header("location: main.php");

        endif;

    endif;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./assets/style.css">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3112/3112968.png" type="image/x-icon">
    <title>Iniciar sesión</title>
</head>
<body>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center gap-3 mb-6 text-3xl font-semibold text-gray-900 dark:text-white">
                <img src="https://cdn-icons-png.flaticon.com/512/3112/3112968.png" alt="Agenda" class="w-8">
                <span>AgenDaw</span>  
            </a>
            <div class="w-full bg-white rounded-3xl shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-700 md:text-xl dark:text-white">
                        Inicia sesión
                    </h1>
                    <form class="space-y-4 md:space-y-6" method="POST">
                        <?= new Token ?>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="email@email.com" required="" value="gonzxlosalmeron@gmail.com">
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="" value="1234">
                            
                            <!-- lanza un error cuando no se ha encontrado el usuario -->
                            <?php if (isset($error)): ?>
                                <p class="text-red-500 text-sm pt-2">Email o contraseña incorrectos</p>
                            <?php endif ?>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                  <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                                </div>
                                <div class="ml-3 text-sm">
                                  <label for="remember" class="text-gray-500 dark:text-gray-300">Recuérdame</label>
                                </div>
                            </div>
                            <a href="#" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">¿Has olvidado la contraseña?</a>
                        </div>
                        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Iniciar sesión</button>
                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                            ¿Aún no tienes cuenta? <a href="#" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Regístrate</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>