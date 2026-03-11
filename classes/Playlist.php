<?php

class Playlist
{
    private string $id;
    private string $name;
    private string $description;
    private string $creatorId;
    private DateTime $creationDate;
    private array $videos = [];

    public function __construct(string $id, string $name, string $description, string $creatorId)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setDescription($description);
        $this->setCreatorId($creatorId);
        $this->creationDate = new DateTime();
    }

    public function getId(): string { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function getCreatorId(): string { return $this->creatorId; }
    public function getCreationDate(): DateTime { return $this->creationDate; }
    public function getVideos(): array { return $this->videos; }

    public function setId(string $id): void
    {
        if (empty(trim($id))) {
            throw new InvalidArgumentException("L'ID de la playlist ne peut pas être vide.");
        }
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        if (empty(trim($name))) {
            throw new InvalidArgumentException("Le nom de la playlist ne peut pas être vide.");
        }
        $this->name = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setCreatorId(string $creatorId): void
    {
        if (empty(trim($creatorId))) {
            throw new InvalidArgumentException("L'ID du créateur ne peut pas être vide.");
        }
        $this->creatorId = $creatorId;
    }

    public function addVideo(Video $video): void
    {
        foreach ($this->videos as $v) {
            if ($v->getId() === $video->getId()) {
                throw new InvalidArgumentException(
                    "La vidéo '{$video->getTitle()}' est déjà dans la playlist."
                );
            }
        }
        $this->videos[] = $video;
    }

    public function removeVideo(string $videoId): bool
    {
        foreach ($this->videos as $key => $v) {
            if ($v->getId() === $videoId) {
                array_splice($this->videos, $key, 1);
                return true;
            }
        }
        return false;
    }

    public function getVideoCount(): int
    {
        return count($this->videos);
    }

    public function getTotalDuration(): int
    {
        return array_sum(array_map(fn(Video $v) => $v->getDuration(), $this->videos));
    }

    public function showDetails(): string
    {
        $lines = [
            "Playlist : {$this->name}",
            "   Description  : {$this->description}",
            "   Créée le     : " . $this->creationDate->format('d/m/Y'),
            "   Vidéos       : {$this->getVideoCount()} | Durée totale : " . $this->formatTotalDuration(),
        ];
        foreach ($this->videos as $v) {
            $lines[] = "   - [{$v->getType()}] {$v->getTitle()} ({$v->formatDuration()})";
        }
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
