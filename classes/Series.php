<?php

class Series extends Video
{
    private const VALID_STATUSES = ['En cours', 'Terminée', 'Annulée'];

    private int $numberOfSeasons;
    private string $status;
    private array $episodes = [];

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
        int $numberOfSeasons,
        string $status
    ) {
        parent::__construct($id, $title, $description, $duration, $releaseYear, $director, $genre, $rating, $posterUrl);
        $this->setNumberOfSeasons($numberOfSeasons);
        $this->setStatus($status);
    }

    public function getNumberOfSeasons(): int { return $this->numberOfSeasons; }
    public function getStatus(): string { return $this->status; }
    public function getEpisodes(): array { return $this->episodes; }

    public function setNumberOfSeasons(int $n): void
    {
        if ($n <= 0) {
            throw new InvalidArgumentException("Le nombre de saisons doit être un entier positif.");
        }
        $this->numberOfSeasons = $n;
    }

    public function setStatus(string $status): void
    {
        if (!in_array($status, self::VALID_STATUSES)) {
            throw new InvalidArgumentException(
                "Statut invalide. Valeurs acceptées : " . implode(', ', self::VALID_STATUSES)
            );
        }
        $this->status = $status;
    }

    public function getType(): string
    {
        return "Série";
    }

    public function showDetails(): string
    {
        return sprintf(
            "[Série] %s (%d) - %s\n" .
            "Réalisateur : %s | Durée moy./ép. : %s | Notation : %.1f/5\n" .
            "Saisons : %d | Statut : %s | Épisodes : %d | Durée totale : %s\n" .
            "%s",
            $this->title,
            $this->releaseYear,
            $this->genre,
            $this->director,
            $this->formatDuration(),
            $this->rating,
            $this->numberOfSeasons,
            $this->status,
            $this->getEpisodeCount(),
            $this->formatTotalDuration(),
            $this->description
        );
    }

    public function addEpisode(Episode $episode): void
    {
        foreach ($this->episodes as $ep) {
            if ($ep->getNumber() === $episode->getNumber()) {
                throw new InvalidArgumentException(
                    "Un épisode avec le numéro {$episode->getNumber()} existe déjà."
                );
            }
        }
        $this->episodes[] = $episode;
    }

    public function removeEpisode(int $number): bool
    {
        foreach ($this->episodes as $key => $ep) {
            if ($ep->getNumber() === $number) {
                array_splice($this->episodes, $key, 1);
                return true;
            }
        }
        return false;
    }

    public function getEpisodeCount(): int
    {
        return count($this->episodes);
    }

    public function getTotalDuration(): int
    {
        return array_sum(array_map(fn(Episode $ep) => $ep->getDuration(), $this->episodes));
    }

    public function listEpisodes(): string
    {
        if (empty($this->episodes)) {
            return "Aucun épisode disponible.";
        }
        $lines = array_map(fn(Episode $ep) => "  - " . $ep->showDetails(), $this->episodes);
        return implode("\n", $lines);
    }

    private function formatTotalDuration(): string
    {
        $total = $this->getTotalDuration();
        if ($total < 60) {
            return $total . "min";
        }
        $hours   = intdiv($total, 60);
        $minutes = $total % 60;
        return $minutes > 0 ? "{$hours}h{$minutes}" : "{$hours}h";
    }
}
