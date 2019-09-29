<?php

namespace App\Entity;

class MigrationVersions
{
    private $version;

    private $executedAt;

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function getExecutedAt(): ?\DateTimeImmutable
    {
        return $this->executedAt;
    }

    public function setExecutedAt(\DateTimeImmutable $executedAt): self
    {
        $this->executedAt = $executedAt;

        return $this;
    }
}
