<?php

class Catalog
{
    private array $videos = [];

    public function addVideo(Video $video): void
    {
        foreach ($this->videos as $v) {
            if ($v->getId() === $video->getId()) {
                throw new InvalidArgumentException(
                    "La vidéo '{$video->getTitle()}' est déjà dans le catalogue."
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

    public function searchByTitle(string $title): array
    {
        return array_values(
            array_filter($this->videos, fn(Video $v) => stripos($v->getTitle(), $title) !== false)
        );
    }

    public function searchByGenre(string $genre): array
    {
        return array_values(
            array_filter($this->videos, fn(Video $v) => $v->getGenre() === $genre)
        );
    }

    public function searchByType(string $type): array
    {
        return array_values(
            array_filter($this->videos, fn(Video $v) => $v->getType() === $type)
        );
    }

    public function sortByRating(): array
    {
        $videos = $this->videos;
        usort($videos, fn(Video $a, Video $b) => $b->getRating() <=> $a->getRating());
        return $videos;
    }

    public function sortByYear(bool $descending = true): array
    {
        $videos = $this->videos;
        usort($videos, fn(Video $a, Video $b) => $descending
            ? $b->getReleaseYear() <=> $a->getReleaseYear()
            : $a->getReleaseYear() <=> $b->getReleaseYear()
        );
        return $videos;
    }

    public function getVideoCount(): int
    {
        return count($this->videos);
    }

    public function getVideos(): array
    {
        return $this->videos;
    }

    public function showCatalog(): string
    {
        if (empty($this->videos)) {
            return "Le catalogue est vide.";
        }
        $lines = ["Catalogue ({$this->getVideoCount()} video(s)) :"];
        foreach ($this->videos as $v) {
            $lines[] = sprintf(
                "  [%s] %s (%d) - %.1f/5 - %s",
                $v->getType(),
                $v->getTitle(),
                $v->getReleaseYear(),
                $v->getRating(),
                $v->formatDuration()
            );
        }
        return implode("\n", $lines);
    }
}
