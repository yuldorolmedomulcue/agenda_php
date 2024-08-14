<?php include("includes/header.php") ?>

<!----------------------------------------Paso 4--------------------------------------------->
<?php 
//validar si recibimos id de la categoria por URl2
if (isset($_GET['id'])) {
    $id_categoria = $_GET['id'];
}

//Obtener categoria actual3
$query = "SELECT * FROM categorias WHERE id=:id";

$stmt = $conn->prepare($query);

//parametros pociosionales4
$stmt->bindParam(":id", $id_categoria, PDO::PARAM_INT);
$stmt->execute();

$categoria = $stmt->fetch(PDO::FETCH_OBJ);

//<!-------------------------------------codigo reciclado de crearcateg---------------------------------------->
//Editamos datos
if (isset($_POST['editarCategoria'])) {
    
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
        $query = "UPDATE categorias set nombre = :nombre WHERE id= :id";
        $stmt = $conn->prepare($query);

        //vincular parametro
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id_categoria, PDO::PARAM_INT);

        $resultado = $stmt-> execute();

        //si hubo resultado
        if ($resultado) {
            $mensaje = "Categoria editada correctamente";
            header('Location: categorias.php?mensaje='.$mensaje);
            exit();
        }else {
            $error = 'Error, no se pudo editar el registro';
            header('location: categoria.php?error='.$error);
            exit();
        }

    }
}

?>

<!-----------------------------Paso14 Mensajes campos vacios-------------------------->
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
            <h3>Editar Categoría</h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre" value="<?php if($categoria) echo $categoria->nombre; ?>"> <!--valuar5-->              
            </div>          

            <button type="submit" name="editarCategoria" class="btn btn-primary w-100">Editar Categoría</button>
            </form>
        </div>
    </div>
<?php include("includes/footer.php") ?>
       