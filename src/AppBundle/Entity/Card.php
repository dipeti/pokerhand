<?php


namespace AppBundle\Entity;


class Card
{
    /**
     * This is the order of cards used for checking if the hand is straight. Aces may as well be the last
     * but that case is examined in Hand::checkForRoyal;
     */
    static $orderForStraight = [
        'A' => 1,'2' => 2,'3' => 3,'4' => 4,'5' => 5,'6' => 6,'7' => 7,'8' => 8,'9' => 9,'10' => 10,'J' => 11,'Q' => 12 ,'K' => 13,
    ];
    /**
     * This is the order of cards according to rank.
     */
    static $ranks = [
        '2' => 2,'3' => 3,'4' => 4,'5' => 5,'6' => 6,'7' => 7,'8' => 8,'9' => 9,'10' => 10,'J' => 11,'Q' => 12 ,'K' => 13,'A' => 14,
    ];
    static $suits = [
        'S',// spades
        'H',// hearts
        'C',// clubs
        'D',// diamonds
    ];

    private $rank;

    private $suit;

    /**@var int $number - used to get the order when checking for high-card.*/
    private $value;

    /**@var int $number - used to get the order when checking for straight.*/
    private $number;

    static function getDeck($numberOfDecks = 1) : array
    {
        $deck = array();
        $ranks = array_flip(self::$ranks);
        for ($i = 0; $i < $numberOfDecks ; $i++)
        {
            foreach (self::$suits as $suit)
            {
                foreach ($ranks as $rank)
                {
                    $deck[] = self::getInstance($suit.$rank);
                }
            }
        }
        return $deck;
    }

    static function getInstance(string $text) : Card
    {
            $card = new self();
            $card->suit = $text[0]; // Spades, Clubs, Hearts, Diamonds
            $card->rank = substr($text,1); //A, K, 10
            $card->value = self::$ranks[$card->rank]; // A=14, K=13
            $card->number = self::$orderForStraight[$card->rank];
            return $card;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param mixed $rank
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }

    /**
     * @return mixed
     */
    public function getSuit()
    {
        return $this->suit;
    }

    /**
     * @param mixed $suit
     */
    public function setSuit($suit)
    {
        $this->suit = $suit;
    }



    public static function orderForStraight(Card $card1, Card $card2) : int
    {

        if ($card1->number > $card2->number)
        {
            return 1;
        }
        elseif ($card1->number === $card2->number)
        {
            return 0;
        }
        return -1;
    }


    public static function sort(Card $card1, Card $card2) : int
    {

        if ($card1->value > $card2->value)
        {
            return 1;
        }
        elseif ($card1->value === $card2->value)
        {
            return 0;
        }
        return -1;
    }

    public function isNextForStraight(Card $card) : bool
    {
       return $this->number + 1 === $card->number;
    }
    public function isSameColor(Card $card) : bool
    {
        return $this->suit === $card->getSuit();
    }
    public function isSameRank(Card $card) : bool
    {
        return $this->rank === $card->getRank();
    }

    private function __construct()
    {
    }

    function __toString()
    {
        return $this->rank."-".$this->suit;
    }

}