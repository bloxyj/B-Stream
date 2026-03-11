<?php

declare(strict_types=1);

require_once __DIR__ . '/autoload.php';



$catalog = new Catalog();

$film1 = new Film(
    'f1', 'A Silent Voice', 'Un ancien harceleur cherche à se racheter auprès de la fille sourde qu\'il a blessée par le passé.',
    130, 2016, 'Naoko Yamada', 'Animation', 4.7,
    'https://upload.wikimedia.org/wikipedia/en/1/17/A_Silent_Voice_film_poster.png',
    8_000_000, 30_800_000, 'Japonais'
);

$film2 = new Film(
    'f2', 'Interstellar', 'Des astronautes voyagent à travers un trou de ver pour trouver une nouvelle demeure pour l\'humanité.',
    169, 2014, 'Christopher Nolan', 'Science-Fiction', 4.8,
    'https://upload.wikimedia.org/wikipedia/en/b/bc/Interstellar_film_poster.jpg',
    165_000_000, 773_800_000, 'Anglais'
);

$series1 = new Series(
    's1', 'Jujutsu Kaisen', 'Un lycéen devient l\'hôte d\'un puissant esprit maudit et intègre l\'école des sorciers jujutsu.',
    24, 2020, 'Gege Akutami', 'Animation', 4.9,
    'https://upload.wikimedia.org/wikipedia/en/2/2e/Jujutsu_Kaisen_Key_Visual_1.jpg',
    3, 'En cours'
);

$series1->addEpisode(new Episode(1, 'Ryomen Sukuna', 'Yuji Itadori avale un doigt de l\'Esprit Maudit Sukuna.', 24, new DateTime('2020-10-03')));
$series1->addEpisode(new Episode(2, 'Pour moi-même', 'Yuji est condamné à mort par la société des sorciers.', 24, new DateTime('2020-10-10')));
$series1->addEpisode(new Episode(3, 'La fille batisseuse', 'Yuji rencontre Nobara Kugisaki lors d\'une mission.', 24, new DateTime('2020-10-17')));

$series2 = new Series(
    's2', 'Bocchi the Rock!', 'Une guitariste introvertie rejoint un groupe et tente de surmonter son anxiété sociale.',
    24, 2022, 'Aki Hamazi', 'Animation', 5.0,
    'https://upload.wikimedia.org/wikipedia/en/6/61/Bocchi_the_Rock%21_volume_1_cover.jpg',
    1, 'En cours'
);

$series2->addEpisode(new Episode(1, 'Rolling Bocchi', 'Hitori Gotō rencontre Nijika et intègre le groupe Kessoku Band.', 24, new DateTime('2022-10-09')));
$series2->addEpisode(new Episode(2, 'A demain', 'Le groupe se prépare pour sa première performance live.', 24, new DateTime('2022-10-16')));
$series2->addEpisode(new Episode(3, 'Arrivee en fanfare', 'Hitori joue pour la première fois devant un public.', 24, new DateTime('2022-10-23')));

$catalog->addVideo($film1);
$catalog->addVideo($film2);
$catalog->addVideo($series1);
$catalog->addVideo($series2);

echo $catalog->showCatalog() . "<br>";

echo "<br> Details Film : <br>";
echo $film1->showDetails() . "<br>";

echo "<br> Details Serrie : <br>";
echo $series1->showDetails() . "<br>";

echo "<br>Episodes : <br>";
echo $series1->listEpisodes() . "<br>";

$user = new User('u1', 'Alice Dupont', 'alice@example.com');

$user->addToHistory($film1);
$user->addToHistory($series1);
$user->addToHistory($film1);

echo $user->showProfile() . "<br>";
echo $user->showHistory() . "<br>";

$playlist = $user->createPlaylist('Mes incontournables');
$playlist->setDescription('Les meilleurs films et séries.');
$playlist->addVideo($film1);
$playlist->addVideo($film2);
$playlist->addVideo($series1);
$playlist->addVideo($series2);

echo $playlist->showDetails() . "<br><br>";

echo "<br> Recherche par genre = Animation :<br>";
foreach ($catalog->searchByGenre('Animation') as $v) {
    echo "  [{$v->getType()}] {$v->getTitle()} <br>";
}

echo "<br>Tri par notation :<br>";
foreach ($catalog->sortByRating() as $v) {
    echo "  {$v->getTitle()} - {$v->getRating()}/5 <br>";
}

echo "<br> Rentabilite de Interstellar :<br>";
printf("  %+.1f%%", $film2->calculateProfitability());

echo "<img src='{$film2->getPosterUrl()}' alt='Interstellar' style='width:200px;margin:10px;'>";