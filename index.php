<?php

require_once('Game.php');
session_start();

Game::clearLog();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['choose_pokemon'])) {
        Game::startGame($_POST['choose_pokemon']);
    } else if (isset($_POST['choose_attack'])) {
        Game::playerTurn($_POST['choose_attack']);
        Game::enemyTurn();
    } else if (isset($_POST['restart'])) {
        Game::reset();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jp</title>
    <style>
        :root {
            font: 16px/1.5 'Helvetica'
        }

        * {
            box-sizing: border-box;
        }

        body {
            padding: 0;
            margin: 0;
        }

        .flex {
            display: flex;
            justify-content: center;
            flex-flow: row wrap;
        }

        .card {
            overflow: hidden;
            border: 1px solid rgb(200, 200, 200);
            flex: 0 1 20%;
            margin: 1rem;
            min-width: 300px;
        }

        .cimg {
            height: 200px;
            background: #eee;
            padding: .5rem
        }

        .cbody {
            padding: 1rem;
        }

        .ctitle {
            font-size: 1.1rem;
            margin-bottom: .5rem;
        }

        .cimg img {
            object-fit: contain;
            height: 100%;
            width: 100%;
        }

        h1 {
            text-align: center;
            display: block;
        }

        .btn {
            border: 0;
            background: teal;
            color: white;
            padding: .5rem 1rem;
            display: block;
            margin-top: 1rem;
            cursor: pointer;
        }

        .bcontainer {
            display: flex;
            flex-flow: column nowrap;
            width: 1000px;
            height: 700px;
            background: #eee;
            flex-shrink: 0;
        }

        .battlefield {
            flex: 1 1 auto;
            position: relative;
            background: rgba(0, 0, 0, .3)
        }

        .battlefield::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            display: block;
            background-image: url('img/background.jpg');
            background-size: 100% 100%;
            background-repeat: no-repeat;
            opacity: .7;
            z-index: 0;
        }

        .menu {
            padding: 1rem 1rem;
            display: flex;
            flex-flow: row wrap;
            align-items: center;
        }

        .message {
            padding: .5rem 1rem;
            height: 95px;
            border-top: 3px solid #999;
            font-family: monospace;
        }

        .you {
            display: block;
            height: 130px;
            width: 130px;
            object-fit: contain;
            position: absolute;
            bottom: 15%;
            left: 20%;
        }

        .enemy {
            display: block;
            height: 90px;
            width: 90px;
            object-fit: contain;
            position: absolute;
            top: 32%;
            right: 27%;
        }

        .vcenter {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .pokestats {
            border: 1px solid black;
            width: 200px;
            margin: 0 1rem;
            padding: .2rem .5rem;
            font-size: .9rem;
            position: relative;
        }

        .hp,
        .mp {
            position: absolute;
            top: 0;
            left: 0;
            display: block;
            height: 100%;
            opacity: .5;
        }

        .hp {
            background: green;
        }

        .hp.enemy {
            background: red;
        }

        .enemy-menu {
            align-items: center;
            padding: .7rem;
            display: flex;
            justify-content: flex-end;
        }

        .mp {
            background: blue;
        }
    </style>
</head>

<body>
    <?php
    if (!Game::started()) {
    ?>
        <h1>Choose your Pokemon</h1>
        <div class="flex">
            <div class="card">
                <div class="cimg">
                    <img src="img/bulb.png" alt="">
                </div>
                <div class="cbody">
                    <div class="ctitle">
                        Bulbasaur
                    </div>
                    <div class="ctext">
                        A brilliant grass-type Pokémon that specializes in magic attacks and healing
                        <form action="" method="POST">
                            <input type="hidden" value="1" name="choose_pokemon">
                            <button class="btn">I CHOOSE YOU!</button>
                        </form>
                    </div>
                </div>

            </div>
            <div class="card">
                <div class="cimg">
                    <img src="img/charm.png" alt="">
                </div>
                <div class="cbody">
                    <div class="ctitle">
                        Charmander
                    </div>
                    <div class="ctext">
                        A violent fire-type Pokémon that boasts offensive power in its raw physical strength
                        <form action="" method="POST">
                            <input type="hidden" value="2" name="choose_pokemon">
                            <button class="btn">I CHOOSE YOU!</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="cimg">
                    <img src="img/squirt.png" alt="">
                </div>
                <div class="cbody">
                    <div class="ctitle">
                        Squirtle
                    </div>
                    <div class="ctext">
                        A versatile water-type Pokémon that quickly adapts to the battlefield and excels in all-around combat
                        <form action="" method="POST">
                            <input type="hidden" value="3" name="choose_pokemon">
                            <button class="btn">I CHOOSE YOU!</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="cimg">
                    <img src="img/pidgey.png" alt="">
                </div>
                <div class="cbody">
                    <div class="ctitle">
                        Pidgey
                    </div>
                    <div class="ctext">
                        A naive flying-type Pokémon that is notorious of turning the tides of battle using double-edged attacks
                        <form action="" method="POST">
                            <input type="hidden" value="4" name="choose_pokemon">
                            <button class="btn">I CHOOSE YOU!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else {

        Game::updateGameStatus();
        $player = Game::getPlayer();
        $enemy = Game::getEnemy();

    ?>
        <style>
            body {
                background: #333;
            }

            h1 {
                margin: 0;
                padding: .5rem;
                background: teal;
                color: white;
            }

            .move {
                margin-right: .5rem;
            }

            .overlay {
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                width: 100%;
                background: rgba(0, 0, 0, .7);

                color: white;
                text-align: center;
                padding-top: 200px;
                z-index: 1000;
            }

            .overlay h1 {
                font-size: 4rem;
                background: none;
                margin-bottom: 2rem;
            }

            .overlay button {
                background: white;
                color: black;
                padding: .7rem 1.5rem;
            }

            #actions {
                padding: .5rem 1rem;
            }
        </style>
        
        <div class="vcenter">

            <div class="bcontainer">
                <h1>Round <?php echo $_SESSION['round'] ?></h1>
                <div class="enemy-menu">
                    Enemy HP:
                    <div class="pokestats">
                        <?php echo $enemy->getHP() ?>
                        <div class="hp enemy" style="width: <?php echo 200 * ($enemy->getHP() / $enemy->getMaxHP()) ?>px"></div>
                    </div>
                    MP:
                    <div class="pokestats">
                        <?php echo $enemy->getMP() ?>
                        <div class="mp" style="width: <?php echo 200 * ($enemy->getMP() / $enemy->getMaxMP()) ?>px"></div>
                    </div>
                </div>
                <div class="battlefield">
                    <img src="<?php echo $player->getPlayerImage() ?>" alt="" class="you">
                    <img src="<?php echo $enemy->getEnemyImage() ?>" alt="" class="enemy">
                </div>

                <div class="menu">
                    Player HP:
                    <div class="pokestats">
                        <?php echo $player->getHP() ?>
                        <div class="hp" style="width: <?php echo 200 * ($player->getHP() / $player->getMaxHP()) ?>px"></div>
                    </div>

                    MP:
                    <div class="pokestats">
                        <?php echo $player->getMP() ?>
                        <div class="mp" style="width: <?php echo 200 * ($player->getMP() / $player->getMaxMP()) ?>px"></div>
                    </div>
                </div>
                <form action="" method="POST" id="actions">
                    <?php

                    foreach ($player->getMoves() as $key => $value) {
                        echo "<button class='move' value='$key' name='choose_attack' type='submit' ". ( $player->getMP() < $value->getCost() ? " disabled " : '') ."> " . $value->name . ": " . $value->getCost() . " MP</button>";
                    }

                    ?>
                </form>
                <div class="message">
                    <?php
                    foreach (Game::getLog() as $m) {
                        echo "$m<br>";
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php
    }

    if (Game::over()) {

    ?>
        <div class="overlay">
            <h1>Game Over</h1>
            Wins: <?php echo $_SESSION['wins'] ?>
            Losses: <?php echo $_SESSION['loss'] ?>
            <br><br><br>
            <form method="POST" action="">
                <button name="restart" type="submit" value="1">
                    Restart
                </button>
            </form>
        </div>
    <?php } ?>
</body>

</html>