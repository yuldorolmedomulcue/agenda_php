<?php include("includes/header.php") ?>

<!----------------------------------------Paso 10--------------------------------------------->
<?php 
//validar si recibimos id de contacto por URl2
if (isset($_GET['id'])) {
    $id_contacto = $_GET['id'];
}

//Obtener categoria actual3
$query = "SELECT * FROM contactos WHERE id=:id";

$stmt = $conn->prepare($query);

//parametros pociosionales4
$stmt->bindParam(":id", $id_contacto, PDO::PARAM_INT);
$stmt->execute();

//volcamos registro
$contacto = $stmt->fetch(PDO::FETCH_OBJ);

//validar si recibimos id de contacto por URl2
if (isset($_GET['idCategoria'])) {
    $idCategoria = $_GET['idCategoria'];
}

//parametros lista de categorias
$query = "SELECT * FROM categorias";
$stmt = $conn->prepare($query);

//ejecutamos paso2
$stmt->execute();
$categorias = $stmt->fetchALL(PDO::FETCH_OBJ);

/*------------------------Codigo reciclado de crearcontacto.php---------------------------*/
//Borrar datos, si precionamos btn
if (isset($_POST['borrarContacto'])) {

        //si entra por else es porque se puede ingresar un nuevo registro | : son parametros pocisionales
        $query = "DELETE FROM contactos WHERE id=:id ";
        $stmt = $conn ->prepare($query);

        //vincular parametro
        $stmt-> bindParam(":id", $id_contacto, PDO::PARAM_INT);

        //execute= ejecutamos consulta
        $resultado = $stmt-> execute();

        //si hubo resultado
        if ($resultado) {
            $mensaje = "Contacto borrado correctamente";
            header('Location: contactos.php?mensaje='.$mensaje);
            exit();
        }else {
            $error = 'Error, no se pudo borrar el contacto';
            header('location: borrar_contacto.php?error='.$error);
            exit();
        }
    }
?>


<div class="row">
        <div class="col-sm-6">
            <h3>Borrar Contacto</h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre" value="<?php if($contacto) echo $contacto->nombre; ?>" readonly> <!--Paso3 value-->               
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" name="apellido" id="apellidos" placeholder="Ingresa los apellidos" value="<?php if($contacto) echo $contacto->apellido; ?>" readonly>               
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="number" class="form-control" name="telefono" id="telefono" placeholder="Ingresa el teléfono" value="<?php if($contacto) echo $contacto->telefono; ?>" readonly>               
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Ingresa el email" value="<?php if($contacto) echo $contacto->email; ?>" readonly>               
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Nn:</label>
                <select class="form-select" aria-label="Default select example" name="categoria">
                    <option value="">--Nn--</option>
                    <!--Datos que apareceran en la seccion categorias en editarcontacto.php-->
                    <?php foreach($categorias as $fila) : ?> <!--paso3 foreach-->
                        <option value="<?php echo $fila->id; ?>" <?php if($idCategoria == $fila->id) echo "selected"; ?>><?php echo $fila->nombre; ?></option> <!--paso4 -->
                    <?php endforeach; ?>             
                </select>
            </div>
            
            <br />
            <button type="submit" name="borrarContacto" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Borrar Contacto</button>
            </form>
        </div>
    </div>
<?php include("includes/footer.php") ?>
       