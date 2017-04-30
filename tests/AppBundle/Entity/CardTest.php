<?php


namespace Tests\AppBundle\Entity;


use AppBundle\Entity\Card;

class CardTest extends \PHPUnit_Framework_TestCase
{
    /** @test*/
    public function number_of_cards_in_deck()
    {
        $array = Card::getDeck(1);
        $array2 = Card::getDeck();
        $array3 = Card::getDeck(2);
        $this->assertCount(104, $array3);
        $this->assertCount(52, $array);
        $this->assertCount(52, $array2);
    }

    /** @test*/
    public function test_next_for_straight()
    {
        $card = Card::getInstance('DJ');
        $nextCard = Card::getInstance('DQ');
        $this->assertTrue($card->isNextForStraight($nextCard));
        $this->assertFalse($nextCard->isNextForStraight($card));
    }

    /** @test*/
    public function test_is_same_color()
    {
        $card1 = Card::getInstance('DJ');
        $card2 = Card::getInstance('DQ');
        $card3 = Card::getInstance('HQ');
        $this->assertTrue($card1->isSameColor($card2));
        $this->assertFalse($card1->isSameColor($card3));
    }
}