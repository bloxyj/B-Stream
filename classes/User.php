<?php

class User
{
    private string $id;
    private string $name;
    private string $email;
    private DateTime $registrationDate;
    private bool $activeSubscription;
    private array $history   = [];
    private array $playlists = [];

    public function __construct(string $id, string $name, string $email, bool $activeSubscription = true)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setEmail($email);
        $this->activeSubscription = $activeSubscription;
        $this->registrationDate = new DateTime();
    }

    public function getId(): string { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public function getRegistrationDate(): DateTime { return $this->registrationDate; }
    public function isSubscriptionActive(): bool { return $this->activeSubscription; }
    public function getHistory(): array { return $this->history; }
    public function getPlaylists(): array { return $this->playlists; }

    public function setId(string $id): void
    {
        if (empty(trim($id))) {
            throw new InvalidArgumentException("L'ID utilisateur ne peut pas être vide.");
        }
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        if (empty(trim($name))) {
            throw new InvalidArgumentException("Le nom ne peut pas être vide.");
        }
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("L'adresse email '{$email}' est invalide.");
        }
        $this->email = $email;
    }

    public function setSubscriptionActive(bool $active): void
    {
        $this->activeSubscription = $active;
    }

    public function addToHistory(Video $video): void
    {
        foreach ($this->history as $v) {
            if ($v->getId() === $video->getId()) {
                return;
            }
        }
        $this->history[] = $video;
    }

    public function createPlaylist(string $name): Playlist
    {
        $playlist = new Playlist(uniqid('pl_'), $name, '', $this->id);
        $this->playlists[] = $playlist;
        return $playlist;
    }

    public function showProfile(): string
    {
        $status = $this->activeSubscription ? 'Actif' : 'Inactif';
        return sprintf(
            "Profil : %s\n   Email        : %s\n   Inscrit le   : %s\n   Abonnement   : %s\n   Videos vues  : %d | Playlists : %d",
            $this->name,
            $this->email,
            $this->registrationDate->format('d/m/Y'),
            $status,
            count($this->history),
            count($this->playlists)
        );
    }

    public function showHistory(int $limit = 10): string
    {
        if (empty($this->history)) {
            return "Aucune vidéo dans l'historique.";
        }
        $recent = array_slice(array_reverse($this->history), 0, $limit);
        $lines = ["Historique de {$this->name} :"];
        foreach ($recent as $v) {
            $lines[] = "   - [{$v->getType()}] {$v->getTitle()} ({$v->formatDuration()})";
        }
        return implode("\n", $lines);
    }
}
