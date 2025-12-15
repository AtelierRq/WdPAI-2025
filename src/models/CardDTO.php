<?php

class CardDTO
{
    public string $title;
    public string $description;
    public string $image;

    public function __construct(Card $card)
    {
        $this->title = $card->getTitle();
        $this->description = $card->getDescription();
        $this->image = $card->getImage();
    }
}