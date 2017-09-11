<?php

namespace GameBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SymFony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GameBundle\Controller\AbstractController;

/**
 * @Route("/game")
 */
class GameController extends AbstractController
{
    /**
     * @Route("/throw", name="game_throw")
     */
    public function throwAction(Request $request)
    {
	$player = $this->validateMove($request->get('throw'));
	$npc = $this->autoMove();
	$result = $this->resolveThrow($player, $npc);

	$output = $this->saveGame(array(
	    'player' => ucfirst($player), 
	    'npc' => ucfirst($npc), 
	    'result' => $result
	));

	return new Response(json_encode($output));

    }

    /**
     * @Route("/moves", name="game_actions")
     */
    public function moveAction()
    {
	return new Response(json_encode($this->getMoves()));
    }

    /**
     * @Route("/history/global", name="global_history")
     */
    public function globalHistoryAction()
    {
	$output['stats'] = $this->globalStats();

	return new Response(json_encode($output));
    }

    /**
     * @Route("/history/player", name="player_history")
     */
    public function playerHistoryAction()
    {
        $output = array(
            'stats' => $this->playerStats(),
            'history' => $this->playerHistory(true)
        );

        return new Response(json_encode($output));
    }
}
