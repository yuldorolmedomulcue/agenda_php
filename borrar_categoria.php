<?php 
include("includes/header.php");
// include("includes/db_connect.php"); // Asegúrate de que este archivo tiene la conexión a la base de datos

// Verificar si se recibió un ID de categoría por la URL
if (isset($_GET['id'])) {
    $id_categoria = $_GET['id'];

    // Obtener los detalles de la categoría
    $query = "SELECT * FROM categorias WHERE id=:id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $id_categoria, PDO::PARAM_INT);
    $stmt->execute();

    // Volcamos registro
    $categoria = $stmt->fetch(PDO::FETCH_OBJ);
    
    // Validar si la categoría existe
    if (!$categoria) {
        $mensaje = "Categoría no encontrada";
        header("Location: categorias.php?mensaje=$mensaje");
        exit();
    }
    
} else {
    // Si no se recibió un ID válido, redirigir a la lista de categorías
    $mensaje = "ID de categoría no proporcionado";
    header("Location: categorias.php?mensaje=$mensaje");
    exit();
}

// Borrar datos, si presionamos el botón
if (isset($_POST['borrarCategoria'])) {

    // Ejecutar la consulta para borrar la categoría
    $query = "DELETE FROM categorias WHERE id=:id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $id_categoria, PDO::PARAM_INT);
    
    $resultado = $stmt->execute();

    // Si hubo resultado
    if ($resultado) {
        $mensaje = "Categoría borrada correctamente";
        header("Location: categorias.php?mensaje=$mensaje");
        exit();
    } else {
        $error = "Error, no se pudo borrar la categoría";
        header("Location: categorias.php?error=$error");
        exit();
    }
}
?>

<div class="row">
    <div class="col-sm-6">
        <h3>Borrar Categoría</h3>
    </div>            
</div>
<div class="row">
    <div class="col-sm-6 offset-3">
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id_categoria; ?>">
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría:</label>
                <input type="text" class="form-control" name="categoria" value="<?php echo $categoria->nombre; ?>" readonly>
            </div>
            
            <button type="submit" name="borrarCategoria" class="btn btn-danger w-100"><i class="bi bi-x-circle-fill"></i> Borrar Categoría</button>
        </form>
    </div>
</div>
<?php include("includes/footer.php") ?>
