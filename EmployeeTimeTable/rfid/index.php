<?php
session_start();

//Caso o usuário não esteja autenticado, limpa os dados e redireciona
if (!isset($_SESSION['email']) and ! isset($_SESSION['password'])) {
    //Destrói
    session_destroy();

    //Limpa
    unset($_SESSION['email']);
    unset($_SESSION['password']);

    //Redireciona para a página de autenticação
    header('location:login.php');
}

$conn = mysqli_connect("127.0.0.1", "root", "12345", "teste");


if (isset($_GET['action'])) {
    session_destroy();
    header('location:index.php');
}

if (isset($_POST['action'])) {

    header('location:index.php');
}

if (isset($_POST['res'])) {

    header('location:index.php');
}
?>


<!DOCTYPE html>
<html lang = "en">
    <head> 

        <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script> 
        <script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
        <script>
            webshims.setOptions('forms-ext', {types: 'date'});
            webshims.polyfill('forms forms-ext');
            $.webshims.formcfg = {
                en: {
                    dFormat: '-',
                    dateSigns: '-',
                    patterns: {
                        d: "yy-mm-dd"
                    }
                }
            };
        </script>


        <meta charset = "utf-8">
        <meta http-equiv = "X-UA-Compatible" content = "IE=edge">
        <meta name = "viewport" content = "width=device-width, initial-scale=1">
        <!--The above 3 meta tags *must* come first in the head;
        any other head content must come *after* these tags -->
        <meta name = "description" content = "">
        <meta name = "author" content = "">
        <link rel = "icon" href = "../../favicon.ico">

        <title>Lavandaria A Ideal de Leixões</title>
        <link rel="shortcut icon" href="lav.ico" type="image/x-icon">
        <!--Bootstrap core CSS -->
        <link rel = "stylesheet" href = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity = "sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin = "anonymous">
        <!--IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href = "assets/css/ie10-viewport-bug-workaround.css" rel = "stylesheet">

        <!--Custom styles for this template -->
        <link href = "navbar-fixed-top.css" rel = "stylesheet">

        <!--Just for debugging purposes. Don't actually copy these 2 lines! -->
                <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="assets/js/ie-emulation-modes-warning.js"></script>
        <script src="../assets/js/ie-emulation-modes-warning.js"></script>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <!-- Fixed navbar -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand">Lavandaria A Ideal de Leixões</a> 
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php?action=logout">Sair</a></li>
                </ul>

            </div><!--/.nav-collapse -->
        </div>

    </nav>

    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <!--                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                    <h4 class="modal-title">Confirmação</h4>
                </div>
                <div class="modal-body">
                    <p>Insira password para remover registo!</p>

                </div>
                <div class="modal-footer">
                    <form name="remove_pw" method="POST">
                        <input type="password" name="pwToRemove" value="" />
                        <button name="submit_pw"type="submit" class="btn btn-primary">Confirmar</button>
                        <input type="button" onclick="location.href = 'index.php';"class="btn btn-primary" value="Cancelar"></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br><br>

    <?php
    if (isset($_GET['delete'])) {
        ?>

        <script type = "text/javascript">
            $(document).ready(function () {
                $("#myModal").appendTo('body').modal('show');
            });
        </script> 
        <?php
        if ($_POST['pwToRemove'] == 'qw12eridkfa') {
            $sql_query = mysqli_query($conn, "delete from registo where id=" . $_GET['delete'] . ";");
            ?> <script> alert('Registo removido com sucesso!')
                        window.location = 'index.php'</script> <?php
        }
    }

    $startDate = mysqli_real_escape_string($conn, $_POST['startDate']);
    $finishDate = mysqli_real_escape_string($conn, $_POST['finishDate']);
    $employeeName = mysqli_real_escape_string($conn, $_POST['employeeName']);

    if ($startDate == '' && $finishDate == '') {
        $startDate = date('Y-m-d');
        $finishDate = date('Y-m-d');
    } else if ($startDate != '' && $finishDate == '') {
        $finishDate = date('Y-m-d');
    }
    ?>
    <div align="center">
        <form  method="POST">
            Data Inicio <input type="date" size='15' value ='<?php echo $startDate; ?>' name="startDate">
            Data Fim <input type="date" size='15' value= '<?php echo $finishDate; ?>'  name="finishDate"></td>&nbsp &nbsp &nbsp;
            Nome <select name="employeeName" id="employeeName" value='<?php echo $_POST['employeeName'] ?>'>


                <?php
                $sql_query = mysqli_query($conn, "select nome from Funcionario;");
                echo "<option>Todos</option>";
                while ($row = mysqli_fetch_assoc($sql_query)) {
                    $name = $row['nome'];
                    echo "<option>$name</option>";
                }
                ?>
            </select>

            <button name = 'pq' type="submit" class="btn btn-default btn-lg">
                <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar
            </button>
        </form>


    </div>
    <br>
    <div class="container">
        <center>
            <form  method = "post">
                <input type = "submit" name = "create_pdf" class = "btn btn-danger" onclick="getData()" value = "Gerar PDF" />
                <?php
                echo '<input type="hidden" name="pdf_name" value="' . $employeeName . '">';
                echo '<input type="hidden" name="pdf_fd" value="' . $startDate . '">';
                echo '<input type="hidden" name="pdf_sd" value="' . $finishDate . '">';
                ?>
            </form>
        </center>
        <?php
        echo "<table><tr><th class='col-md-3'>Nome</th><th class='col-md-3'>Data</th><th class='col-md-2'>Registo Entrada</th><th class='col-md-2'>Registo Saida</th><th class='col-md-1'></th><th class='col-md-1'></th></tr>";


        if (!isset($_POST['pq']) && !isset($_GET['delete']) && !isset($_GET['edit'])) {
            $sql = mysqli_query($conn, "select r.id,e.nome, r.data,r.entrada,r.saida from registo r, Funcionario e where data=curdate() and e.id=r.Funcionario_id order by data, entrada;");


        while ($row = mysqli_fetch_assoc($sql)) {


                echo "<tr>";
                echo "<td class='col-md-3'>" . $row['nome'] . "</td>";
                echo '<td class="col-md-3">' . $row['data'] . "</td>";
                echo '<td bgcolor="#b3ff99" class="col-md-2">' . $row['entrada'] . "</td>";
                echo '<td bgcolor="#99b3ff" class="col-md-2">' . $row['saida'] . "</td>";
                echo "<td class='col-md-1'>";
                ?>
                <div class="edit">
                    <?php echo '<a href="index.php?edit=' . $row['id'] . '">'; ?>
                    <button type="button" class="btn btn-default btn-lg">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </button>
                </div> 
                <?php
                echo "</td>";
                echo "<td class='col-md-1'>"
                ?> 
                <div class="remove">
                    <?php echo '<a href="index.php?delete=' . $row['id'] . '">'; ?>
                    <button type="button" class="btn btn-default btn-lg">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                </div> 
                <?php
                echo "</td>";
                echo "</tr>";
                echo "</td>";
                ?>

                <?php
            }
        }





        $sql = mysqli_query($conn, "select r.id,e.nome, r.data,r.entrada,r.saida from registo r, Funcionario e where e.id=r.Funcionario_id order by r.data, r.entrada;");
        while ($row = mysqli_fetch_assoc($sql)) {

            if ($row['id'] == $_GET['edit']) {
                ?>
                <form action="edit.php" method="POST">

                    <?php
                    echo "<tr>";
                    echo "<td class='col-md-3'><input type='text' name='nome' size='10' value='" . $row['nome'] . "'></td>";
                    echo "<td class='col-md-3'><input type='date' name='data' size='13' value='" . $row['data'] . "'></td>";
                    echo "<td class='col-md-2'><input type='text' name='entrada' size='10' value='" . $row['entrada'] . "'></td>";
                    echo "<td class='col-md-3'><input type='text' name='saida' size='10' value='" . $row['saida'] . "'></td>";
                    echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                    echo '<td class="col-md-1"><button id="submit2">Confirmar</button></td>';
                    ?>
                </form>
                <?php
                echo '<form method="POST">';
                echo '<td class="col-md-1"><button id="res" name="res">Cancelar</button></td>';
             
            }
        }

        if ($employeeName == 'Todos') {

            $sql = mysqli_query($conn, "select r.id,e.nome, r.data,r.entrada,r.saida from registo r, Funcionario e where data>='$startDate' and data<='$finishDate' and e.id=r.Funcionario_id order by data, entrada;");

            while ($row = mysqli_fetch_assoc($sql)) {


                echo "<tr>";
                echo "<td class='col-md-3'>" . $row['nome'] . "</td>";
                echo '<td class="col-md-3">' . $row['data'] . "</td>";
                echo '<td bgcolor="#b3ff99" class="col-md-2">' . $row['entrada'] . "</td>";
                echo '<td bgcolor="#99b3ff" class="col-md-2">' . $row['saida'] . "</td>";
                echo "<td class='col-md-1'>";
                ?>
                <div class="edit">
                    <?php echo '<a href="index.php?edit=' . $row['id'] . '">'; ?>
                    <button type="button" class="btn btn-default btn-lg">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </button>
                </div> 
                <?php
                echo "</td>";
                echo "<td class='col-md-1'>"
                ?>


                <div class="remove">
                    <?php echo '<a href="index.php?delete=' . $row['id'] . '">'; ?>
                    <button type="button" class="btn btn-default btn-lg">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                </div> 




                <?php
                echo "</td>";
                echo "</tr>";
                echo "</td>";
                ?>

                <?php
            }
        } else {
            //echo "ajjajaaj";
            //$sql2 = "select e.nome, r.data,r.entrada,r.saida from registo r, Funcionario e where e.id=r.Funcionario_id and data>='$startDate' and data<='$finishDate'and e.nome='$employeeName' order by Funcionario_id;";
            //echo $sql2;
            $sql = mysqli_query($conn, "select r.id, e.nome, r.data,r.entrada,r.saida from registo r, Funcionario e where e.id=r.Funcionario_id and data>='$startDate' and data<='$finishDate'and e.nome='$employeeName' order by data, entrada;");

            while ($row = mysqli_fetch_assoc($sql)) {

                if ($row['id'] == $_GET['edit']) {
                    ?>
                    <form action="edit.php" method="POST">

                        <?php
                        echo "<tr>";
                        echo "<td class='col-md-3'><input type='text' name='nome' size='10' value='" . $row['nome'] . "'></td>";
                        echo "<td class='col-md-3'><input type='date' name='data' size='13' value='" . $row['data'] . "'></td>";
                        echo "<td class='col-md-2'><input type='text' name='entrada' size='10' value='" . $row['entrada'] . "'></td>";
                        echo "<td class='col-md-3'><input type='text' name='saida' size='10' value='" . $row['saida'] . "'></td>";
                        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                        echo '<td class="col-md-1"><button id="submit2">Confirmar</button></td>';
                        ?>
                    </form>
                    <?php
                    echo '<form method="POST">';
                    echo '<td class="col-md-1"><button id="res" name="res">Cancelar</button></td>';
                    echo '</form>';
                }
                echo "<tr>";
                echo "<td class='col-md-3'>" . $row['nome'] . "</td>";
                echo '<td class="col-md-3">' . $row['data'] . "</td>";
                echo '<td bgcolor="#b3ff99"<td class="col-md-2">' . $row['entrada'] . "</td>";
                echo '<td bgcolor="#99b3ff"class="col-md-2">' . $row['saida'] . "</td>";
                echo "<td class='col-md-1'>";
                ?>
                <div class="edit">
                    <?php echo '<a href="index.php?edit=' . $row['id'] . '">'; ?>
                    <button type="button" class="btn btn-default btn-lg">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </button>
                </div> 
                <?php
                echo "</td>";
                echo "<td class='col-md-1'>"
                ?> 

                <div class="remove">
                    <?php echo '<a href="index.php?delete=' . $row['id'] . '">'; ?>
                    <button type="button" class="btn btn-default btn-lg">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                </div> 
                <?php
            }
        }


        echo "</table>";
        echo "</br></br></br>";
        ?>

        <?php
        $pdf_name = $_POST['pdf_name'];
        $pdf_fd = $_POST['pdf_fd'];
        $pdf_sd = $_POST['pdf_sd'];
//echo $employeeName . $startDate . $finishDate;
        if (isset($_POST["create_pdf"])) {
            //echo $pdf_name .$pdf_fd .$pdf_sd;

            $out = 'enviarPdf.php?name=' . $pdf_name . '&fd=' . $pdf_fd . '&sd=' . $pdf_sd;
            ?>
            <script type ="text/javascript" language="Javascript">window.open('<?php echo $out; ?>');</script>
            <?php
        }


        mysqli_close($conn);
        ?>

        <script>
            $('#popover').popover({
                html: true,
                title: function () {
                    return $("#popover-head").html();
                },
                content: function () {
                    return $("#popover-content").html();
                }
            });
        </script>
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>



</body>
</html> 
