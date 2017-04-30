<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Card;
use AppBundle\Entity\Hand;

class HandTest extends \PHPUnit_Framework_TestCase
{
    /** @test*/
    public function hand_contains_not_more_than_5_cards(){
        $hand = new Hand();
        for ($i = 0; $i < 10 ; $i++)
        {
            $hand->addCard(Card::getInstance('H10'));
        }

        $this->assertCount(5,$hand->getCards());
    }
    /** @test*/
    public function finds_royal()
    {
        $hand = new Hand();
        $hand->addCard(Card::getInstance('H10'));
        $hand->addCard(Card::getInstance('HA'));
        $hand->addCard(Card::getInstance('HK'));
        $hand->addCard(Card::getInstance('HJ'));
        $hand->addCard(Card::getInstance('HQ'));
        $this->assertTrue($hand->checkForRoyal());
    }
    /** @test*/
    public function finds_flush()
    {
        $hand = new Hand();
        $hand->addCard(Card::getInstance('H10'));
        $hand->addCard(Card::getInstance('HA'));
        $hand->addCard(Card::getInstance('HK'));
        $hand->addCard(Card::getInstance('HJ'));
        $hand->addCard(Card::getInstance('HQ'));
        $this->assertTrue($hand->checkForFlush());
    }

    /** @test*/
    public function finds_straight()
    {
        $hand = new Hand();
        $hand->addCard(Card::getInstance('H10'));
        $hand->addCard(Card::getInstance('HA'));
        $hand->addCard(Card::getInstance('HK'));
        $hand->addCard(Card::getInstance('HJ'));
        $hand->addCard(Card::getInstance('HQ'));
        $this->assertTrue($hand->checkForStraight());
    }
    /** @test*/
    public function finds_sets()
    {
        $hand = new Hand();
        $hand->addCard(Card::getInstance('H10'));
        $hand->addCard(Card::getInstance('HA'));
        $hand->addCard(Card::getInstance('HK'));
        $hand->addCard(Card::getInstance('HJ'));
        $hand->addCard(Card::getInstance('HJ'));
        $this->assertTrue($hand->checkForSets());
    }

    /** @test*/
    public function finds_result_royal_flush()
    {
        $hand = new Hand();
        $hand->addCard(Card::getInstance('H10'));
        $hand->addCard(Card::getInstance('HA'));
        $hand->addCard(Card::getInstance('HK'));
        $hand->addCard(Card::getInstance('HJ'));
        $hand->addCard(Card::getInstance('HQ'));
        $this->assertEquals('Royal Flush',$hand->getResult());
    }
    /** @test*/
    public function finds_result_flush()
    {
        $hand = new Hand();
        $hand->addCard(Card::getInstance('H10'));
        $hand->addCard(Card::getInstance('H2'));
        $hand->addCard(Card::getInstance('HK'));
        $hand->addCard(Card::getInstance('HJ'));
        $hand->addCard(Card::getInstance('HQ'));
        $this->assertEquals('Flush',$hand->getResult());
    }
    /** @test*/
    public function finds_result_straight_flush()
    {
        $hand = new Hand();
        $hand->addCard(Card::getInstance('H5'));
        $hand->addCard(Card::getInstance('H6'));
        $hand->addCard(Card::getInstance('H7'));
        $hand->addCard(Card::getInstance('H8'));
        $hand->addCard(Card::getInstance('H9'));
        $this->assertEquals('Straight Flush',$hand->getResult());
    }

    /** @test*/
    public function finds_result_poker()
    {
        $hand = new Hand();
        $hand->addCard(Card::getInstance('P8'));
        $hand->addCard(Card::getInstance('D6'));
        $hand->addCard(Card::getInstance('H8'));
        $hand->addCard(Card::getInstance('C8'));
        $hand->addCard(Card::getInstance('D8'));
        $this->assertEquals('Poker of 8',$hand->getResult());
    }

    /** @test*/
    public function finds_result_full_house()
    {
        $hand = new Hand();
        $hand->addCard(Card::getInstance('P8'));
        $hand->addCard(Card::getInstance('D6'));
        $hand->addCard(Card::getInstance('H8'));
        $hand->addCard(Card::getInstance('C6'));
        $hand->addCard(Card::getInstance('D8'));
        $this->assertEquals('Full House',$hand->getResult());
    }
    /** @test*/
    public function finds_result_straight()
    {
        $hand = new Hand();
        $hand->addCard(Card::getInstance('P3'));
        $hand->addCard(Card::getInstance('D6'));
        $hand->addCard(Card::getInstance('H4'));
        $hand->addCard(Card::getInstance('C5'));
        $hand->addCard(Card::getInstance('D7'));
        $this->assertEquals('Straight',$hand->getResult());
    }

    /** @test*/
    public function finds_result_three_of_a_kind()
    {
        $hand = new Hand();
        $hand->addCard(Card::getInstance('P8'));
        $hand->addCard(Card::getInstance('D6'));
        $hand->addCard(Card::getInstance('H8'));
        $hand->addCard(Card::getInstance('C5'));
        $hand->addCard(Card::getInstance('D8'));
        $this->assertEquals('Three of a Kind of 8',$hand->getResult());
    }

    /** @test*/
    public function finds_result_two_pair()
    {
        $hand = new Hand();
        $hand->addCard(Card::getInstance('PA'));
        $hand->addCard(Card::getInstance('D6'));
        $hand->addCard(Card::getInstance('H8'));
        $hand->addCard(Card::getInstance('CA'));
        $hand->addCard(Card::getInstance('D8'));
        $this->assertEquals('Two Pair of A and 8',$hand->getResult());
    }

    /** @test*/
    public function finds_result_one_pair()
    {
        $hand = new Hand();
        $hand->addCard(Card::getInstance('PA'));
        $hand->addCard(Card::getInstance('D6'));
        $hand->addCard(Card::getInstance('H7'));
        $hand->addCard(Card::getInstance('CA'));
        $hand->addCard(Card::getInstance('D4'));
        $this->assertEquals('One Pair of A',$hand->getResult());
    }

    /** @test*/
    public function finds_result_high_card()
    {
        $hand = new Hand();
        $hand->addCard(Card::getInstance('PA'));
        $hand->addCard(Card::getInstance('D6'));
        $hand->addCard(Card::getInstance('H7'));
        $hand->addCard(Card::getInstance('C8'));
        $hand->addCard(Card::getInstance('D4'));
        $this->assertEquals('High with A-P',$hand->getResult());
    }

    /** @test*/
    public function order_hand_for_straight()
    {
        $hand = new Hand();
        $hand->addCard(Card::getInstance('PA'));
        $hand->addCard(Card::getInstance('D6'));
        $hand->addCard(Card::getInstance('H7'));
        $hand->addCard(Card::getInstance('C8'));
        $hand->addCard(Card::getInstance('D4'));
        $cards = $hand->getCards();
        usort($cards,['AppBundle\Entity\Card','orderForStraight']);
        $this->assertEquals(Card::getInstance('PA'),$cards[0]);
        $this->assertEquals(Card::getInstance('D4'),$cards[1]);
        $this->assertEquals(Card::getInstance('D6'),$cards[2]);
        $this->assertEquals(Card::getInstance('H7'),$cards[3]);
        $this->assertEquals(Card::getInstance('C8'),$cards[4]);
    }

    /** @test*/
    public function sort_hand_by_value()
    {
        $hand = new Hand();
        $hand->addCard(Card::getInstance('PA'));
        $hand->addCard(Card::getInstance('D6'));
        $hand->addCard(Card::getInstance('H7'));
        $hand->addCard(Card::getInstance('C8'));
        $hand->addCard(Card::getInstance('D4'));
        $cards = $hand->getCards();
        usort($cards,['AppBundle\Entity\Card','sort']);
        $this->assertEquals(Card::getInstance('D4'),$cards[0]);
        $this->assertEquals(Card::getInstance('D6'),$cards[1]);
        $this->assertEquals(Card::getInstance('H7'),$cards[2]);
        $this->assertEquals(Card::getInstance('C8'),$cards[3]);
        $this->assertEquals(Card::getInstance('PA'),$cards[4]);
    }



}