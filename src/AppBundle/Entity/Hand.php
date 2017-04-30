<?php

namespace AppBundle\Entity;


class Hand
{
    const ROYAL = 'royal';
    const FLUSH = 'flush';
    const STRAIGHT = 'straight';
    const SETS = 'sets';
    const POKER = 'poker';
    const FULL_HOUSE = 'full';
    const THREE_OF_A_KIND = 'three';
    const TWO_PAIR = 'two.pair';
    const ONE_PAIR = 'one.pair';
    const PAIR = 'pair';

    /** Output result associations*/
    static $ranks = array(
        1 => 'High',
        2 => 'One Pair',
        3 => 'Two Pair',
        4 => 'Three of a Kind',
        5 => 'Straight',
        6 => 'Flush',
        7 => 'Full House',
        8 => 'Poker',
        9 => 'Straight Flush',
        10 => 'Royal Flush',
    );


    /** @var array<Card> $cards*/
    private $cards;

    /** @var array $sets - used to store sets found among cards*/
    private $sets;

    /** @var array $outcomes - used to store ranks found among cards excluding sets*/
    private $outcomes;

    public function __construct()
    {
        $this->cards = array();
    }


    public function addCard(Card $card)
    {
        if (count($this->cards) < 5)
        {
            $this->cards[] = $card;
        }
    }

    /**
     * @return bool
     */
    public function checkForRoyal() : bool
    {
        if (isset($this->outcomes[self::ROYAL]))
        {
            return $this->outcomes[self::ROYAL];
        }
        $royal = ['10','J','Q','K','A'];

        $result = array();
        foreach ($this->cards as $item) {
            if(!in_array($item,$result) && in_array($item->getRank(),$royal))
            {
                $result[] = $item;
            }
        }
        return $this->outcomes[self::ROYAL] = 5 === count($result);
    }

    public function checkForStraight() : bool
    {
        if (isset($this->outcomes[self::STRAIGHT]))
        {
            return $this->outcomes[self::STRAIGHT];
        }
        elseif ($this->checkForRoyal())
        {
            return $this->outcomes[self::STRAIGHT] = true;
        }

        $result = $this->cards;
        usort($result,['AppBundle\Entity\Card','orderForStraight']);
        for ($i = 1; $i < count($result) ; $i++)
        {
            if(!$result[$i-1]->isNextForStraight($result[$i]))
            {
                return $this->outcomes[self::STRAIGHT] = false;
            }
        }
        return $this->outcomes[self::STRAIGHT] = true;
    }

    public function checkForFlush() : bool
    {
        if (isset($this->outcomes[self::FLUSH]))
        {
            return $this->outcomes[self::FLUSH];
        }

        for ($i = 1; $i < count($this->cards) ; $i++) {
            if (!$this->cards[$i - 1]->isSameColor($this->cards[$i]))
            {
                return $this->outcomes[self::FLUSH] = false;
            }
        }
        return $this->outcomes[self::FLUSH] = true;
    }

    /**
     * @return bool
     */
    public function checkForSets() : bool
    {
        $result = array();
        foreach ($this->cards as $item)
        {
            if (!isset($result[$item->getRank()]))
            {
                $result[$item->getRank()] = 0;
            }
            $result[$item->getRank()]++;
        }

        foreach ($result as $rank => $set)
        {
            if ($set == 4) {
                $this->sets[self::POKER] = $rank;
                break;
            } elseif ($set == 3) {
                $this->sets[self::THREE_OF_A_KIND] = $rank;
            } elseif ($set == 2) {
                $this->sets[self::PAIR][] = $rank;
            }
        }
        if (isset($this->sets[self::THREE_OF_A_KIND]) && isset($this->sets[self::PAIR]))
        {

            $this->sets[self::FULL_HOUSE][self::THREE_OF_A_KIND] = $this->sets[self::THREE_OF_A_KIND];
            $this->sets[self::FULL_HOUSE][self::PAIR] = $this->sets[self::PAIR];
        }
        elseif (isset($this->sets[self::PAIR]))
        {
            2 == count($this->sets[self::PAIR]) ? $this->sets[self::TWO_PAIR] = $this->sets[self::PAIR] :
                $this->sets[self::ONE_PAIR] = $this->sets[self::PAIR];
        }
        return !empty($this->sets);
    }


    /**
     * @return string
     */
    public function getResult() : string
    {
        if ($this->checkForRoyal() && $this->checkForFlush())
        {
            return self::$ranks[10];
        }
        else if($this->checkForStraight() && $this->checkForFlush())
        {
            return  self::$ranks[9];
        }
        else if($this->checkForSets())
        {
            if (!empty($this->sets[self::POKER]))
            {
                return self::$ranks[8].' of '.$this->sets[self::POKER];
            }
            else if (!empty($this->sets[self::FULL_HOUSE]))
            {
                return self::$ranks[7];
            }
            else if (!empty($this->sets[self::THREE_OF_A_KIND]))
            {
                return self::$ranks[4].' of '.$this->sets[self::THREE_OF_A_KIND];
            }
            else if (!empty($this->sets[self::TWO_PAIR]))
            {
                return self::$ranks[3].' of '.$this->sets[self::TWO_PAIR][0]. ' and ' .$this->sets[self::TWO_PAIR][1];
            }
            else if (!empty($this->sets[self::ONE_PAIR]))
            {
                return self::$ranks[2].' of '.$this->sets[self::ONE_PAIR][0];
            }
        }
        else if($this->checkForFlush())
        {
            return self::$ranks[6];
        }
        else if($this->checkForStraight())
        {
            return self::$ranks[5];
        }
        usort($this->cards,['AppBundle\Entity\Card','sort']);
        return self::$ranks[1]. ' with '. $this->cards[4];


    }

    /**
     * @return array
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * @param array $hand
     */
    public function setCards(array $cards)
    {
        $this->cards = $cards;
    }
}