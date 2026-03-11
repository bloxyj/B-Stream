<?php

class Film extends Video
{
    private float $budget;
    private float $boxOffice;
    private string $originalLanguage;

    public function __construct(
        string $id,
        string $title,
        string $description,
        int $duration,
        int $releaseYear,
        string $director,
        string $genre,
        float $rating,
        string $posterUrl,
        float $budget,
        float $boxOffice,
        string $originalLanguage
    ) {
        parent::__construct($id, $title, $description, $duration, $releaseYear, $director, $genre, $rating, $posterUrl);
        $this->setBudget($budget);
        $this->setBoxOffice($boxOffice);
        $this->setOriginalLanguage($originalLanguage);
    }

    public function getBudget(): float { return $this->budget; }
    public function getBoxOffice(): float { return $this->boxOffice; }
    public function getOriginalLanguage(): string { return $this->originalLanguage; }

    public function setBudget(float $budget): void
    {
        if ($budget < 0) {
            throw new InvalidArgumentException("Le budget ne peut pas être négatif.");
        }
        $this->budget = $budget;
    }

    public function setBoxOffice(float $boxOffice): void
    {
        if ($boxOffice < 0) {
            throw new InvalidArgumentException("Le box-office ne peut pas être négatif.");
        }
        $this->boxOffice = $boxOffice;
    }

    public function setOriginalLanguage(string $language): void
    {
        if (empty(trim($language))) {
            throw new InvalidArgumentException("La langue originale ne peut pas être vide.");
        }
        $this->originalLanguage = $language;
    }

    public function getType(): string
    {
        return "Film";
    }

    public function showDetails(): string
    {
        return sprintf(
            "[Film] %s (%d) - %s\n" .
            "Réalisateur : %s | Durée : %s | Notation : %.1f/5\n" .
            "Langue : %s | Budget : %s € | Box-office : %s € | Rentabilité : %+.1f%%\n" .
            "%s",
            $this->title,
            $this->releaseYear,
            $this->genre,
            $this->director,
            $this->formatDuration(),
            $this->rating,
            $this->originalLanguage,
            number_format($this->budget, 0, ',', ' '),
            number_format($this->boxOffice, 0, ',', ' '),
            $this->calculateProfitability(),
            $this->description
        );
    }

    public function calculateProfitability(): float
    {
        if ($this->budget == 0) {
            return 0.0;
        }
        return (($this->boxOffice - $this->budget) / $this->budget) * 100;
    }
}
