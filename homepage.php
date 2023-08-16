<?php
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] !== true) {
    header("Location: login.html"); // Redireciona para a página de login
    exit();
}

$hostname = "127.0.0.1";
$port = "3306";
$username = "root";
$password = "";
$dbname = "trafego";

$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

$sql = "SELECT * FROM tenis_web";
$result = mysqli_query($conn, $sql);



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_id']) && is_numeric($_POST['delete_id'])) {
        $delete_id = $_POST['delete_id'];

        // Prepara a consulta SQL para excluir o registro
        $sql = "DELETE FROM tenis_web WHERE id = $delete_id";

        if (mysqli_query($conn, $sql)) {
            // Registro excluído com sucesso
            $exito = "Registro excluído com sucesso.";
        } else {
            // Ocorreu um erro ao excluir o registro
            $erro = "Erro ao excluir o registro: " . mysqli_error($conn);
        }
    }
}


?>

<!DOCTYPE html>
<html lang="UTF-8">

<head>

    <link rel="shortcut icon" type="image/png" href="img/bola_t.png" />

    <!-- Link para o arquivo CSS -->
    <link rel="stylesheet" type="text/css" href="styles.css">
    <!-- Link para o arquivo JS -->
    <script src="script.js"></script>

    <!-- links do DATATABLE -->
    <link href="DataTables/datatables.min.css" rel="stylesheet">
    <script src="DataTables/datatables.min.js"></script>
    <!-- Fim dos links do DATATABLE -->

    <!-- links do BootsTrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- Fim dos links do BootsTrap -->
    <title>Homepage</title>


    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="arquivos/DataTables/datatables.css">
    <link rel="stylesheet" href="arquivos/DataTables/datatables.min.css">


</head>

<body>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> -->

    <script src="arquivos/DataTables/jQuery-3.7.0/jquery-3.7.0.min.js"></script>
    <script src="arquivos/DataTables/jQuery-3.7.0/jquery-3.7.0.js"></script>

    <script src="arquivos/DataTables/datatables.min.js"></script>
    <script src="arquivos/DataTables/datatables.js"></script>

    <!-- <script src="datatable/jquery-3.6.0.min.js"></script>
<script src="datatable/datatables.min.js"></script> -->

    <script>
        $(document).ready(function() {
            $('#example').DataTable({ 
                // responsive: true,    
                "order": [
                    [0, "desc"]
                ] // Ordena a primeira coluna (índice 0) em ordem ascendente
            });
        });


        <?php
        if (isset($exito)) {
            echo "alert('$exito');";
        }
        if (isset($erro)) {
            echo "alert('$erro');";
        }
        ?>

    </script>

    <h1>Tabela de Dados</h1>

    <!-- Botão de Logout -->
    <form action="logout.php" method="post">
        <button type="submit" name="logout">Logout</button>
    </form>

    <table id="example" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Login</th>
                <th>Senha</th>
                <th>Nivel_Seg</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['login']; ?></td>
                    <td><?php echo $row['senha']; ?></td>
                    <td><?php echo $row['nivel_seg']; ?></td>
                    <td id="botao">
                        <form method="post" action="">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="button" onclick="return confirm('Tem certeza que deseja excluir este registro?')">
                                <span class="button__text">Delete</span>
                                <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="512" viewBox="0 0 512 512" height="512" class="svg">
                                        <title></title>
                                        <path style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px" d="M112,112l20,320c.95,18.49,14.4,32,32,32H348c17.67,0,30.87-13.51,32-32l20-320"></path>
                                        <line y2="112" y1="112" x2="432" x1="80" style="stroke:#fff;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px"></line>
                                        <path style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px" d="M192,112V72h0a23.93,23.93,0,0,1,24-24h80a23.93,23.93,0,0,1,24,24h0v40"></path>
                                        <line y2="400" y1="176" x2="256" x1="256" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></line>
                                        <line y2="400" y1="176" x2="192" x1="184" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></line>
                                        <line y2="400" y1="176" x2="320" x1="328" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></line>
                                    </svg></span>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <style>

    </style>

</body>

</html>



<?php
mysqli_close($conn);
?>