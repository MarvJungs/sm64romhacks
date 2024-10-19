<?php

namespace App;

class Player
{
    protected $player;
    public function __construct(array $player)
    {
        $this->player = $player;
    }

    public function getType(): PlayerType
    {
        return $this->player['rel'] == 'user' ? PlayerType::User : PlayerType::Guest;
    }

    public function getWebLink(): string
    {
        return $this->player['weblink'] ?? '#';
    }

    public function getName(): string
    {
        return $this->getType() == PlayerType::User ? $this->player['names']['international'] : $this->player['name'];
    }
}
