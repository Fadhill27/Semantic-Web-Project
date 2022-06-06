<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dota heroes table</title>
    
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c3c1353c4c.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Connector untuk menghubungkan PHP dan SPARQL -->
    <?php
        require_once("sparqllib.php");
        $searchInput = "" ;
        $filter = "" ;
        
        if (isset($_POST['search'])) {
            $searchInput = $_POST['search'];
            $data = sparql_get(
            "http://localhost:3030/dota",
            "
            PREFIX id: <http://learningsparql.com/ns/addressbook#>
            PREFIX item: <http://learningsparql.com/ns/data#>

            SELECT ?heroName ?main ?str ?strmax ?agi ?agimax ?int ?intmax ?winRate ?pickRate ?kdaRate
            WHERE
            { 
                ?items
                    item:heroName       ?heroName ;
                    item:main			?main;
                    item:str            ?str;
                    item:strMax         ?strmax;
                    item:agi            ?agi;
                    item:agiMax         ?agimax;
                    item:int            ?int;
                    item:intMax         ?intmax;
                    item:winRate        ?winRate;
                    item:pickRate       ?pickRate;
                    item:kdaRate        ?kdaRate.
                    FILTER 
                        (regex (?heroName, '$searchInput', 'i')
                        || regex (?main, '$searchInput', 'i') 
                        || regex (?str, '$searchInput', 'i') 
                        || regex (?strmax, '$searchInput', 'i') 
                        || regex (?agi, '$searchInput', 'i') 
                        || regex (?agimax, '$searchInput', 'i') 
                        || regex (?int, '$searchInput', 'i') 
                        || regex (?intmax, '$searchInput', 'i') 
                        || regex (?winrate, '$searchInput', 'i') 
                        || regex (?pickrate, '$searchInput', 'i') 
                        || regex (?kdarate, '$searchInput', 'i'))
            }
            "
            );
        } else {
            $data = sparql_get(
            "http://localhost:3030/dota",
            "
            PREFIX id: <http://learningsparql.com/ns/addressbook#>
            PREFIX item: <http://learningsparql.com/ns/data#>
            
            SELECT ?heroName ?main ?str ?strmax ?agi ?agimax ?int ?intmax ?winRate ?pickRate ?kdaRate
            WHERE
            { 
                ?items
                    item:heroName       ?heroName ;
                    item:main			?main;
                    item:str            ?str;
                    item:strMax         ?strmax;
                    item:agi            ?agi;
                    item:agiMax         ?agimax;
                    item:int            ?int;
                    item:intMax         ?intmax;
                    item:winRate        ?winRate;
                    item:pickRate       ?pickRate;
                    item:kdaRate        ?kdaRate.
            }
            ORDER BY ASC(?heroName)
            "
            );
        }

        if (!isset($data)) {
            print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
        }
    ?>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-dark sticky-top">
        <div class="container container-fluid">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 h5">
                    <li class="nav-item px-2">
                        <a class="nav-link active text-white" aria-current="page" href="index.php">Home</a>
                    </li>
                </ul>
                <form class="d-flex" role="search" action="" method="post" id="search" name="search">
                    <input class="form-control me-2" type="search" placeholder="Ketik keyword disini" aria-label="Search" name="search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Body -->
    <div class="container container-fluid my-3">
        <?php
            if ($searchInput != NULL) {
                ?> 
                    <i class="fa-solid fa-magnifying-glass"></i><span>Menampilkan hasil pencarian untuk <b>"<?php echo $searchInput; ?>"</b></span> 
                <?php
            }
        ?>
        <h4>Data attribut hero pada game dota, beserta win rate, pick rate, kda ratio</h4>
        <table id="data" class="table table-bordered table-hover text-center table-responsive">
        <i>Kolom data dapat di click untuk sortir berdasarkan kolom yang diinginkan</i><br>
        <i>at 30 merupakan stat tersebut pada saat hero mencapai level max (30)</i>
            <thead class="table-dark align-middle">
                <tr>
                    <th onclick="sortTable(0)">Nama hero</th>
                    <th onclick="sortTable(1)">Atribut utama</th>
                    <th onclick="sortTable(2)">STR</th>
                    <th onclick="sortTable(3)" >STR at 30</th>
                    <th onclick="sortTable(4)" >AGI</th>
                    <th onclick="sortTable(5)" >AGI at 30</th>
                    <th onclick="sortTable(6)" >INT</th>
                    <th onclick="sortTable(7)" >INT at 30</th>
                    <th onclick="sortTable(8)" >Win Rate(%)</th>
                    <th onclick="sortTable(9)" >Pick Rate(%)</th>
                    <th onclick="sortTable(10)" >KDA Ratio</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                <?php $i = 0; ?>
                <?php foreach ($data as $data) : ?>
                    <td><?= $data['heroName'] ?></td>
                    <td><?= $data['main'] ?></td>
                    <td><?= $data['str'] ?></td>
                    <td><?= $data['strmax'] ?></td>
                    <td><?= $data['agi'] ?></td>
                    <td><?= $data['agimax'] ?></td>
                    <td><?= $data['int'] ?></td>
                    <td><?= $data['intmax'] ?></td>
                    <td><?= $data['winRate'] ?></td>
                    <td><?= $data['pickRate'] ?></td>
                    <td><?= $data['kdaRate'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    

<script>
    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("data");
        switching = true;
        dir = "asc";
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                if (dir == "asc") {
                    if (n < 2) { //n == 0 karena data berupa text, bukan angka
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                        }
                    }else if (Number(x.innerHTML) > Number(y.innerHTML)) {
                        shouldSwitch = true;
                        break;
                    } 
                } else if (dir == "desc") {
                    if (n < 2) {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        } 
                    }else if (Number(x.innerHTML) < Number(y.innerHTML)) {
                        shouldSwitch = true;
                        break;
                    } 
                    
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount ++;
            } else {
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
</script>
</body>

</html>