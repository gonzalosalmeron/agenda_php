<?php 
    /**
     * Gonzalo José Salmerón Robles
     */

    
    // Recogemos el usuario de la sesión
    session_start();
    require_once("./libs/Token.php");
    require_once("./models/Usuario.php");
    require_once("./models/Contacto.php");
    
    // recogemos el usuario de la sesion
    $user = unserialize($_SESSION["usuario"]);

    if (!empty($_POST)):
        if (Token::check($_POST["_token"])):
            $contacto = new Contacto;
            
            if(empty($_POST["id"])): $contacto->save();
            else: $contacto->update();
            endif;

            header("location: ./main.php");
        endif;
    endif;

    $contacto = [];
    if (isset($_GET["edit"])):
        $idCon = intval($_GET["edit"]) ?? null;
        if (strlen($idCon) > 0):
            $contacto = Contacto::getById($idCon);
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
    <title>Crear contacto</title>
</head>
<body>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col justify-center px-6 py-8 m-auto md:h-screen lg:py-0 max-w-6xl">

            <a class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300
                inline-flex px-3 py-1 rounded-xl transition duration-300 cursor-pointer w-min whitespace-nowrap"
                href="./main.php"
            >
                <span>Ir atras</span>
            </a>

            <div class="px-6 py-5 rounded-3xl bg-white dark:bg-gray-800 mt-10">
                <div class="pb-8">
                    <h2 class="font-semibold text-2xl dark:text-white">Crear nuevo contacto</h2>
                    <p class="text-gray-500 text-sm">Añade un nuevo contacto a tu agenda</p>
                </div>

                <form method="POST">
                    <?= new Token  ?>
                    <input type="hidden" name="idUsu" value="<?= $user->id ?>">
                    <input type="hidden" name="id" value="<?= $contacto->id ?? null ?>">
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 mb-6 w-full group">
                            <input type="text" name="nombre" id="nombre" value="<?= $contacto->nombre ?? "" ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="nombre" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nombre</label>
                        </div>
                        <div class="relative z-0 mb-6 w-full group">
                            <input type="text" name="apellidos" id="apellidos" value="<?= $contacto->apellidos ?? "" ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="apellidos" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Apellidos</label>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 mb-6 w-full group">
                            <input type="tel" name="telefono" id="telefono" value="<?= $contacto->telefono ?? "" ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="telefono" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Teléfono</label>
                        </div>
                        <div class="relative z-0 mb-6 w-full group">
                            <input type="email" name="email" id="email" value="<?= $contacto->email ?? "" ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
                        </div>
                    </div>
                    <div class="relative z-0 mb-6 w-full group">
                        <input type="text" name="foto" id="foto" value="<?= $contacto->foto ?? "" ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                        <label for="foto" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Foto</label>
                    </div>
                    <div class="relative z-0 mb-6 w-full group">
                        <input type="text" name="observaciones" id="observaciones" value="<?= $contacto->observaciones ?? "" ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "/>
                        <label for="observaciones" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Observaciones</label>
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>