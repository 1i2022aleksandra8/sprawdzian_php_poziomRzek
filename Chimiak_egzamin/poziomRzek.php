<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Poziomy rzek</title>
</head>
<body>
    <header>
        <banner id="baner1">
            <img src="obraz1.png" alt="Mapa Polski">
        </banner>
        <banner id="baner2">
            <h1 id="rzekih">Rzeki w województwie dolnośląskim</h1>
        </banner>
        <form action="poziomRzek.php" method="POST" id="menu">
            <input type="radio" name="wszystkie" class="formularz_radio"> Wszystkie
            <input type="radio" name="ostrzegawczy" class="formularz_radio"> Ponad stan ostrzegawczy
            <input type="radio" name="alarmowy" class="formularz_radio"> Ponad stan alarmowy

            <input type="submit" name="pokaz" value="Pokaż" id="btn">
        </form>
    </header>
    <main>
        <aside class="lewy">
            <h3>Stany na dzień 2022-05-05</h3>
            <table>
                <tr><th>Wodomierz</th><th>Rzeka</th><th>Ostrzegawczy</th><th>Alarmowy</th><th>Aktualny</th></tr>
                <?php

                $host = 'localhost';
                $uzytkownik = 'root';
                $haslo = '';
                $baza = 'rzeki';
                $polaczenie = mysqli_connect($host, $uzytkownik, $haslo, $baza);

                $_SERVER['REQUEST_METHOD'] === 'POST';

                $wszytskie = $_POST['wszystkie'];
                $ostrzegawczy = $_POST['ostrzegawczy'];
                $alarmowy = $_POST['alarmowy'];

                if(isset($_POST['wszystkie'])){
                $zapytanie1 = '
                SELECT	
                    wodowskazy.nazwa,
                    wodowskazy.rzeka,
                    wodowskazy.stanOstrzegawczy,
                    wodowskazy.stanAlarmowy,
                    pomiary.stanWody
                FROM wodowskazy
                INNER JOIN pomiary ON pomiary.wodowskazy_id = wodowskazy.id
                WHERE pomiary.dataPomiaru = "2022-05-05"
                ';

                $wywolanie1 = mysqli_query($polaczenie, $zapytanie1);
                while($wynik1 = mysqli_fetch_assoc($wywolanie1)){
                    echo "<tr><td>" . $wynik1['nazwa'] ."</td><td>" . $wynik1['rzeka'] ."</td><td>" . $wynik1['stanOstrzegawczy'] ."</td><td>" . $wynik1['stanAlarmowy'] ."</td><td>" . $wynik1['stanWody'] ."</td></tr>";
                }
                }

                if(isset($_POST['ostrzegawczy'])){
                $zapytanie2 = '
                SELECT	
                    wodowskazy.nazwa,
                    wodowskazy.rzeka,
                    wodowskazy.stanOstrzegawczy,
                    wodowskazy.stanAlarmowy,
                    pomiary.stanWody
                FROM wodowskazy
                INNER JOIN pomiary ON pomiary.wodowskazy_id = wodowskazy.id
                WHERE pomiary.dataPomiaru = "2022-05-05" AND wodowskazy.stanOstrzegawczy < pomiary.stanWody 
                ';

                $wywolanie2 = mysqli_query($polaczenie, $zapytanie2);
                while($wynik2 = mysqli_fetch_assoc($wywolanie2)){
                    echo "<tr><td>" . $wynik2['nazwa'] ."</td><td>" . $wynik2['rzeka'] ."</td><td>" . $wynik2['stanOstrzegawczy'] ."</td><td>" . $wynik2['stanAlarmowy'] ."</td><td>" . $wynik2['stanWody'] ."</td></tr>";
                }
                }

                if(isset($_POST['alarmowy'])){
                $zapytanie3 = '
                SELECT	
                    wodowskazy.nazwa,
                    wodowskazy.rzeka,
                    wodowskazy.stanOstrzegawczy,
                    wodowskazy.stanAlarmowy,
                    pomiary.stanWody
                FROM wodowskazy
                INNER JOIN pomiary ON pomiary.wodowskazy_id = wodowskazy.id
                WHERE pomiary.dataPomiaru = "2022-05-05" AND wodowskazy.stanAlarmowy < pomiary.stanWody 
                ';

                $wywolanie3 = mysqli_query($polaczenie, $zapytanie3);
                while($wynik3 = mysqli_fetch_assoc($wywolanie3)){
                    echo "<tr><td>" . $wynik3['nazwa'] ."</td><td>" . $wynik3['rzeka'] ."</td><td>" . $wynik3['stanOstrzegawczy'] ."</td><td>" . $wynik3['stanAlarmowy'] ."</td><td>" . $wynik3['stanWody'] ."</td></tr>";
                }
                }

                mysqli_close($polaczenie);

                ?>
            </table>
        </aside>

        <aside class="prawy">
            <h3>Informacje</h3>
            <ul>
                <li>Brak ostrzeżeń o burzach z gradem</li>
                <li>Smog w mieście Wrocław</li>
                <li>Silny wiatr w Karkonoszach</li>
            </ul>
            <h3>Średnie stany wód</h3>
            <?php
                $host = 'localhost';
                $uzytkownik = 'root';
                $haslo = '';
                $baza = 'rzeki';
                $polaczenie = mysqli_connect($host, $uzytkownik, $haslo, $baza);

                $_SERVER['REQUEST_METHOD'] === 'POST';

                $wszytskie = $_POST['wszystkie'];
                $ostrzegawczy = $_POST['ostrzegawczy'];
                $alarmowy = $_POST['alarmowy'];

                if(isset($_POST['alarmowy'])){
                $zapytanie4 = '
                SELECT
                    pomiary.dataPomiaru,
                    AVG(pomiary.stanWody) AS "srednia",
                FROM pomiary
                GROUP BY pomiary.dataPomiaru
                ';

                $wywolanie4 = mysqli_query($polaczenie, $zapytanie4);
                while($wynik4 = mysqli_fetch_assoc($wywolanie4)){
                    echo "<tr><td> Data:" . $wynik4['dataPomiaru'] ."</td><td> Średnia:" . $wynik4['srednia'] ."</td></tr>";
                }
                }



                mysqli_close($polaczenie);
            ?>
            <a href="https://komunikaty.pl">Dowiedz się więcej</a>
            <img src="obraz2.jpg" alt="rzeka" id="obraz2">
        </aside>
    </main>
    
    <footer>
        <p>Stronę wykonał: Aleksandra Chimiak</p>
    </footer>
    
</body>
</html>