<?php include("includes/header.php") ?>

<!----------------------------------------Paso 3--------------------------------------------->
<?php
//insertar datos, si precionamos btn
if (isset($_POST['crearCategoria'])) {
    
    //Obtener valores
    $nombre = $_POST['nombre'];

    //validar si esta vacio
    if (empty($nombre)) {
        $error = 'Algunos campos vacios';
        header('location: crear_categoria.php?error='.$error);
    }else{
        //configuramos fehca de insercion
        $fecha_actual= date ("Y-m-d");

        //si entra por else es porque se puede ingresar un nuevo registro
        $query = "INSERT INTO categorias (nombre, fecha_creacion) VALUES (:nombre, :fecha_creacion)";
        $stmt = $conn ->prepare($query);

        //vincular parametro
        $stmt-> bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt-> bindParam(":fecha_creacion", $fecha_actual, PDO::PARAM_STR);

        $resultado = $stmt-> execute();

        //si hubo resultado
        if ($resultado) {
            $mensaje = "Categoria creada correctamente";
            header('Location: categorias.php?mensaje='.$mensaje);
            exit();
        }else {
            $error = 'Error, no se pudo crear el registro';
            header('location: categoria.php?error='.$error);
            exit();
        }

    }
}

?>

<!-----------------------------Paso13 Mensajes campos vacios-------------------------->
<div class="row">
    <div class="col-sm-12">
        <?php if(isset($_GET['error'])) :?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?php echo $_GET['error']; ?></strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif?>
    </div>    
</div>

<div class="row">
        <div class="col-sm-6">
            <h3>Crear una Nueva Categoría</h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre">               
            </div>          

            <button type="submit" name="crearCategoria" class="btn btn-primary w-100">Crear Nueva Categoría</button>
            </form>
        </div>
    </div>
<?php include("includes/footer.php") ?>
       