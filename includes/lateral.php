<?php require_once 'includes/ayudas.php'; ?>
<aside id="sidebar">

    <?php if (isset($_SESSION['usuario'])) : ?>
        <div id="usuario-logueado" class="bloque">
            <h3><?='Bienvenido, '.$_SESSION['usuario']['nombre'].' '.$_SESSION['usuario']['apellidos']; ?></h3>
            <!-- botones -->
            <a href="cerrarsesion.php" class="boton boton-verde">Crear entrada</a>
            <a href="cerrarsesion.php" class="boton boton-naranja">Editar datos</a>
            <a href="cerrarsesion.php" class="boton">Cerrar sesion</a>
        </div>
    <?php endif; ?>

    
    <div id="login" class="bloque">
        <h3>Identificate</h3>
        <?php if (isset($_SESSION['error_login'])) : ?>
            <div class="alerta alerta-error">
                <h3><?=$_SESSION['error_login']; ?></h3>
            </div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <label for="email">Email</label>
            <input type="email" name="email" />

            <label for="password">Contraseña</label>
            <input type="password" name="password" />

            <input type="submit" value="Entrar" />
        </form>
    </div>
    <div id="register" class="bloque">
        <h3>Registrate</h3>

        <!-- Mostrar errores -->
        <?php if(isset($_SESSION['sqlResultados'])):?>
            <div class="alerta alerta-exito">
                <?=$_SESSION['sqlResultados']?>
            </div>
        <?php elseif (isset($_SESSION['errores']['sql'])):?>
            <div class="alerta alerta-error">
                <?=$_SESSION['errores']['sql']?>
            </div>
        <?php endif;?>

        <!-- Formulario de registro de datos -->
        <form action="registro.php" method="POST">
            <label for="nombres">Nombres</label>
            <input type="text" name="nombres" />
            <?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'nombres') : '';?>

            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" />
            <?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'apellidos') : '';?>

            <label for="email">Email</label>
            <input type="email" name="email" />
            <?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'email') : '';?>

            <label for="password">Contraseña</label>
            <input type="password" name="password" />
            <?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'password') : '';?>

            <input type="submit" name="submit" value="Entrar" />
        </form>
        <?php borrarErrores();?>
    </div>
</aside>