<?php

namespace GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DataBundle\Document\Game;

class AbstractController extends Controller
{
    private function getODM()
    {
	return $this->container->get('doctrine.odm.mongodb.document_manager');
    }

    private function getRepository($repo, $document)
    {
	return $this->getODM()->getRepository(sprintf($repo.':'.$document));
    }

    public function getUser()
    {
	return $this->container->get('security.context')->getToken()->getUser();
    }

    protected function getMoves()
    {
	return array('Rock','Paper','Scissors','Lizard','Spock');
    }

    protected function autoMove()
    {
	$moves = $this->getMoves();
	return strtolower($moves[array_rand($moves,1)]);
    }

    protected function validateMove($player)
    {
	if(!$player || !in_array(ucfirst($player),$this->getMoves()))
	    return $this->autoMove();

	return strtolower($player);
    }

    protected function resolveThrow($player, $npc)
    {
	if($player === $npc)
            return 'Draw';

        switch(true)
        {
            case ($player === 'rock' && ($npc === 'scissors' || $npc === 'lizard')):
            case ($player === 'paper' && ($npc === 'rock' || $npc === 'spock')):
            case ($player === 'scissors' && ($npc === 'paper' || $npc === 'lizard')):
            case ($player === 'lizard' && ($npc === 'spock' || $npc === 'paper')):
            case ($player === 'spock' && ($npc === 'rock' || $npc === 'scissors')):
                return 'Win';
        }

	return 'Lose';
    }

    protected function saveGame($gameData)
    {
	$game = new Game();

	$game->setPlayer($gameData['player']);
	$game->setNpc($gameData['npc']);
	$game->setResult($gameData['result']);
	$game->setDate();
	
	$user = $this->getUser();

	if($user != 'anon.')
	{
	    $game->setUser($user);
	}

	$odm = $this->getODM();
        $odm->persist($game);
        $odm->flush();

	return $gameData;
    }

    protected function playerHistory($rev = false)
    {
	$repo = $this->getRepository('DataBundle', 'Game');
	$user = $this->getUser();
	$output = array();

	foreach($repo->findBy(array('user'=>$user)) as $history)
        {
            $output[] = array(
                'player' => $history->getPlayer(),
                'npc' => $history->getNpc(),
                'result' => $history->getResult()
            );
        }

	if($rev)
            return array_reverse($output);

	return $output;
    }

    protected function playerStats()
    {
	$repo = $this->getRepository('DataBundle', 'Game');
	$user = $this->getUser();

        return $output = array(
            'wins' => count($repo->findBy(array('user'=>$user,'result'=>'Win'))),
            'losses' => count($repo->findBy(array('user'=>$user,'result'=>'Lose'))),
            'draws' => count($repo->findBy(array('user'=>$user,'result'=>'Draw'))),
            'total' => count($repo->findBy(array('user'=>$user))),
        );
    }

    protected function globalStats()
    {
	$repo = $this->getRepository('DataBundle', 'Game');

	return $output = array(
            'wins' => count($repo->findBy(array('result'=>'Win'))),
            'losses' => count($repo->findBy(array('result'=>'Lose'))),
            'draws' => count($repo->findBy(array('result'=>'Draw'))),
            'total' => count($repo->findAll()),
        );
    }
}
