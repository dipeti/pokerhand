<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Card;
use AppBundle\Entity\Croupier;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/{num}", name="homepage", defaults={"num" = 1}, requirements={"num": "\d+"})
     */
    public function indexAction($num)
    {
        $croupier = new Croupier($num);
        $croupier->deal();
        $hand = $croupier->getHand();
//        $hand->setCards($this->getMockCards());

        $cards = $hand->getCards();
        $result = $hand->getResult();
        return $this->render('default/index.html.twig', [
            'cards' => $cards,
            'result' => $result,
        ]);
    }

    private function getMockCards()
    {
        $cards = array();
        $cards[] = Card::getInstance("H5");
        $cards[] = Card::getInstance("H5");
        $cards[] = Card::getInstance("H8");
        $cards[] = Card::getInstance("H2");
        $cards[] = Card::getInstance("H2");
        return $cards;
    }
}
