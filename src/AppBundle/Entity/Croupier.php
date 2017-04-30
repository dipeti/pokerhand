<?php
/**
 * Created by PhpStorm.
 * User: dipet
 * Date: 2017. 04. 26.
 * Time: 22:15
 */

namespace AppBundle\Entity;


class Croupier
{
    /**@var array<Card> $deck*/
    private $deck;

    /**@var Hand $hand*/
    private $hand;

    /**
     * Croupier constructor.
     */
    public function __construct($numberOfDecks)
    {
        $this->deck = Card::getDeck($numberOfDecks);
        $this->hand = new Hand();
    }

    /**
     * @return Hand
     */
    public function getHand(): Hand
    {
        return $this->hand;
    }

    public function deal()
    {
        if(shuffle($this->deck))
        {
            for ($i = 0; $i < 5; $i++)
            {
                $this->hand->addCard(array_pop($this->deck));
            }
        }
        else
        {
            throw new \RuntimeException('Shuffle failed.');
        }


    }



}