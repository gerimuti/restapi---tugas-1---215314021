<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $database = "tododb";
    $username = "root";
    $password = "";
    $hostname = "localhost";

    $conn = new mysqli($hostname, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed : " . $conn->connect_error);
    }

    if (isset($_POST['send'])) {
        $kegiatan = $_POST['nama'];
        $sql = "INSERT INTO todolist (kegiatan,status) VALUES ('$kegiatan','Aktif')";
        $query = mysqli_query($conn, $sql);
    }
    // $conn->close();

    if (isset($_GET['selesai'])) {
        $id = $_GET['selesai'];
        $sql = "UPDATE todolist SET status='selesai' WHERE idkegiatan=$id";
        if ($conn->query($sql) === TRUE) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
    if (isset($_GET['hapus'])) {
        $id = $_GET['hapus'];
        $sql = "DELETE FROM todolist WHERE idkegiatan=$id";
        if ($conn->query($sql) === TRUE) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
    ?>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="jumbotron text-center">
        <h3>APLIKASI TO-DO-LIST</h3>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <form action="todo.php" method='POST'>
                    <P>
                        <label for="nama">Nama kegiatan :</label>
                        <input name="nama" id="nomor" type="text"><input name="send" type="submit" value="Tambahkan">


                    </P>
                    <?php
                    $sql = "SELECT * FROM todolist";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        echo "<table class='table'>";
                        echo "<thead><tr>
    <th>ID</th>
    <th>Kegiatan</th>
    <th>Status</th>
    <th> </th>
    </tr></thead>";
                        echo "<tbody>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr><td>" . $row["idkegiatan"] . "</td><td>" . $row["kegiatan"] . "</td><td>" . $row["status"] . "</td><td>";
                            if ($row["status"] == "Aktif") {
                                echo "<a href='" . $_SERVER['PHP_SELF'] . "?selesai=" . $row["idkegiatan"] . "'>Selesai</a> ";
                            }
                            echo "<a href='" . $_SERVER['PHP_SELF'] . "?hapus=" . $row["idkegiatan"] . "'>Hapus</a>";
                            echo "</td></tr>";
                        }
                        echo "</tbody></table>";
                    }
                    ?>
                </form>
                <p>
                    Daftar Kegiatan :
                </p>
            </div>


            <div>


            </div>
</body>

</html>