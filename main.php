<?php 
    session_start();

    // Recogemos el usuario de la sesión
    if (!isset($_SESSION["usuario"])) die(header("location: login.php"));

    //Guardamos el user en una variable
    require_once("./models/Usuario.php");
    $user = unserialize($_SESSION["usuario"]);

    //
    require_once("./models/Contacto.php");

    if (isset($_GET["delete"])):
        $deleteId = intval($_GET["delete"]) ?? null;

        if (strlen($deleteId) > 0):
            $contacto = Contacto::getById($deleteId);
            if (!is_null($contacto)):
                $contacto->delete();
            endif;
        endif;

        header('location: ./main.php');
    endif;

    // Regemos todos los contactos del usuario
    $contactos = Contacto::getAllByUser($user->id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="./assets/toggleTheme.js"></script>
    <link rel="stylesheet" href="./assets/style.css">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3112/3112968.png" type="image/x-icon">
    <title>Contactos</title>
</head>
<body>
    <section class="bg-gray-50 dark:bg-gray-900">
        <button onclick="switchMode" id="switchMode" class="absolute top-20 right-20"></button>

        <div class="w-full py-2 bg-black dark:bg-gray-800 text-white">
            <div class="max-w-7xl w-full mx-auto text-center text-sm">
                <p>!Bienvenido a la <b>AgenDaw</b>! Un proyecto para la clase de DAW 😁</p>
            </div>
        </div>
        <div class="flex flex-col px-6 py-8 mx-auto md:min-h-screen lg:py-0 max-w-6xl">
            <div class="flex justify-between items-end">
                <div class="pt-20">
                    <h2 class="text-gray-500 text-2xl font-bold">Hola,<br/><span class="text-3xl text-gray-800 dark:text-white"><?= $user->nombre ?></span> 👋</h2>
                    <p class="text-gray-400 font-medium">Esta es tu lista de contactos</p>
                </div>

                <div class="flex gap-2 justify-end pt-20">
                    <div class="bg-red-100 text-red-500 px-3 py-1 rounded-xl self-end"><?= sizeof($contactos) ?> contactos</div>
                    <a href="./credit.php" class="bg-blue-100 dark:bg-blue-700 text-blue-500 dark:text-blue-100 px-3 py-1 rounded-xl self-end">Nuevo contacto</a>
                    <a href="./logout.php" class="bg-gray-200 text-gray-800 px-3 py-1 rounded-xl self-end">Cerrar sesión</a>
                </div>
            </div>
            <div class="overflow-x-auto relative shadow-md sm:rounded-2xl my-10">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                Nombre
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Telefono
                            </th>
                            <th scope="col" class="py-3 px-6">
                                
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($contactos as $contacto): ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="flex items-center py-4 px-6 text-gray-900 whitespace-nowrap dark:text-white">
                                    <img class="w-10 h-10 rounded-full" src="<?= $contacto->foto ?>" alt="Jese image">
                                    <div class="pl-3">
                                        <div class="text-base font-semibold"><?= $contacto->nombre ?></div>
                                        <div class="font-normal text-gray-500"><?= $contacto->email ?></div>
                                    </div>
                                </th>
                                <td class="py-4 px-6">
                                    <?= $contacto->telefono ?>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <div class="h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></div> <?= $contacto->observaciones ?>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex gap-3">
                                        <a href="./credit.php?edit=<?= $contacto->id ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                        <a href="./main.php?delete=<?= $contacto->id ?>" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>