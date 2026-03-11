<?php

class Episode
{
    private int $number;
    private string $title;
    private string $description;
    private int $duration;
    private DateTime $airDate;

    public function __construct(
        int $number,
        string $title,
        string $description,
        int $duration,
        DateTime $airDate
    ) {
        $this->setNumber($number);
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setDuration($duration);
        $this->airDate = $airDate;
    }

    public function getNumber(): int { return $this->number; }
    public function getTitle(): string { return $this->title; }
    public function getDescription(): string { return $this->description; }
    public function getDuration(): int { return $this->duration; }
    public function getAirDate(): DateTime { return $this->airDate; }

    public function setNumber(int $number): void
    {
        if ($number <= 0) {
            throw new InvalidArgumentException("Le numéro d'épisode doit être un entier positif.");
        }
        $this->number = $number;
    }

    public function setTitle(string $title): void
    {
        if (empty(trim($title))) {
            throw new InvalidArgumentException("Le titre de l'épisode ne peut pas être vide.");
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

    public function setAirDate(DateTime $date): void
    {
        $this->airDate = $date;
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

    public function showDetails(): string
    {
        return sprintf("Épisode %d: %s (%s)", $this->number, $this->title, $this->formatDuration());
    }
}
