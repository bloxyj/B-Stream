<?php

abstract class Video
{
    public const GENRES = [
        'Action', 'Comédie', 'Drame', 'Horreur', 'Science-Fiction',
        'Romance', 'Thriller', 'Animation', 'Documentaire', 'Fantasy'
    ];

    protected string $id;
    protected string $title;
    protected string $description;
    protected int $duration;
    protected int $releaseYear;
    protected string $director;
    protected string $genre;
    protected float $rating;
    protected string $posterUrl;
    protected DateTime $dateAdded;

    public function __construct(
        string $id,
        string $title,
        string $description,
        int $duration,
        int $releaseYear,
        string $director,
        string $genre,
        float $rating,
        string $posterUrl
    ) {
        $this->setId($id);
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setDuration($duration);
        $this->setReleaseYear($releaseYear);
        $this->setDirector($director);
        $this->setGenre($genre);
        $this->setRating($rating);
        $this->setPosterUrl($posterUrl);
        $this->dateAdded = new DateTime();
    }

    abstract public function showDetails(): string;
    abstract public function getType(): string;

    public function getId(): string { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getDescription(): string { return $this->description; }
    public function getDuration(): int { return $this->duration; }
    public function getReleaseYear(): int { return $this->releaseYear; }
    public function getDirector(): string { return $this->director; }
    public function getGenre(): string { return $this->genre; }
    public function getRating(): float { return $this->rating; }
    public function getPosterUrl(): string { return $this->posterUrl; }
    public function getDateAdded(): DateTime { return $this->dateAdded; }

    public function setId(string $id): void
    {
        if (empty(trim($id))) {
            throw new InvalidArgumentException("L'ID ne peut pas être vide.");
        }
        $this->id = $id;
    }

    public function setTitle(string $title): void
    {
        if (empty(trim($title))) {
            throw new InvalidArgumentException("Le titre ne peut pas être vide.");
        }
        $this->title = $title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setDuration(int $duration): void
    {
        if ($duration <= 0) {
            throw new InvalidArgumentException("La durée doit être supérieure à 0.");
        }
        $this->duration = $duration;
    }

    public function setReleaseYear(int $year): void
    {
        $currentYear = (int) date('Y');
        if ($year < 1888 || $year > $currentYear + 5) {
            throw new InvalidArgumentException("L'année de publication '$year' n'est pas valide.");
        }
        $this->releaseYear = $year;
    }

    public function setDirector(string $director): void
    {
        if (empty(trim($director))) {
            throw new InvalidArgumentException("Le réalisateur ne peut pas être vide.");
        }
        $this->director = $director;
    }

    public function setGenre(string $genre): void
    {
        if (!in_array($genre, self::GENRES)) {
            throw new InvalidArgumentException(
                "Genre invalide. Genres autorisés : " . implode(', ', self::GENRES)
            );
        }
        $this->genre = $genre;
    }

    public function setRating(float $rating): void
    {
        if ($rating < 0 || $rating > 5) {
            throw new InvalidArgumentException("La notation doit être comprise entre 0 et 5.");
        }
        $this->rating = $rating;
    }

    public function setPosterUrl(string $url): void
    {
        $this->posterUrl = $url;
    }

    public function formatDuration(): string
    {
        if ($this->duration < 60) {
            return $this->duration . "min";
        }
        $hours   = intdiv($this->duration, 60);
        $minutes = $this->duration % 60;
        return $minutes > 0 ? "{$hours}h{$minutes}" : "{$hours}h";
    }
}
