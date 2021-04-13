<?php

/**
 * PlayerController
 * 
 * @author
 * @version 
 */

namespace SourceCraft\Controller;

#require_once 'Zend/Controller/Action.php';
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

#require_once 'Player.php';
use SourceCraft\Model\Player;
use SourceCraft\Model\PlayerDbInterface;
use SourceCraft\Model\PlayerAliasDbInterface;

#require_once 'Race.php';
use SourceCraft\Model\Race;
use SourceCraft\Model\RaceDbInterface;

#require_once 'PlayerAlias.php';

#require_once 'Faction.php';

#require_once 'Upgrade.php';
use SourceCraft\Model\Upgrade;
use SourceCraft\Model\UpgradeDbInterface;

#class Sc_PlayerController extends Zend_Controller_Action
class PlayerController extends AbstractActionController
{
    /**
     * @var PlayerDbInterface
     */
    private $playerRepository;

    /**
     * @var RaceDbInterface
     */
    private $raceRepository;

    /**
     * @var UpgradeDbInterface
     */
    private $upgradeRepository;

    /**
     * @var PlayerAliasDbInterface
     */
    private $aliasRepository;

    public function __construct(PlayerDbInterface $playerRepository,
								RaceDbInterface $raceRepository,
	                            UpgradeDbInterface $upgradeRepository,
								PlayerAliasDbInterface $aliasRepository)
    {
        $this->playerRepository  = $playerRepository;
		$this->raceRepository    = $raceRepository;
		$this->upgradeRepository = $upgradeRepository;
        $this->aliasRepository   = $aliasRepository;
	}

	/**
	 * The default action - show the list of players
	 */
    public function indexAction()
    {
		// Grab the paginator from the Repository:
		$paginator = $this->playerRepository->fetchAll(true);

		// Set the current page to what has been passed in query string,
		// or to 1 if none is set, or the page is invalid:
		$page = (int) $this->params()->fromQuery('page', 1);
		$page = ($page < 1) ? 1 : $page;
		$paginator->setCurrentPageNumber($page);

		// Set the number of items per page to 20:
		$paginator->setItemCountPerPage(20);

		return new ViewModel(['paginator' => $paginator]);
    }	

	/**
	 * The show action - show a single player
	 */
	public function showAction()
	{
		$ident = $this->params()->fromRoute('id');
		if ($ident)
		{
			#$player_table = new Player();
			#$view = $this->initView();
			#$player = $player_table->getPlayerForIdent($ident);
			$player = $this->playerRepository->findPlayer($ident);
		}
		else
		{
			$name = $this->params()->fromRoute('name');
			if ($name)
			{
				$player = $this->playerRepository->findPlayerByName($name);
			}
		}

	    if (isset($player) && $player)
		{
			$races = $this->raceRepository->fetchRacesForPlayer($ident);
			$upgrades = $this->upgradeRepository->fetchUpgradesForPlayer($ident);
			$aliases = $this->aliasRepository->fetchAliasesForPlayer($ident);
			return new ViewModel(['player' => $player,
			                      'races' => $races,
								  'upgrades' => $upgrades,
								  'alises' => $aliases]);
		}
		else
			return new ViewModel(['error' => 'Player Ident ' . $ident . ' was not found',]);
	}

/***************************************************************************************
    public function __construct(PlayerDbInterface $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * @var Zend_Session_Namespace
     *
    protected $session = null;

    /**
     * Overriding the init method to also load the session from the registry
     *
     *
    public function init()
    {
        parent::init();
        $this->session = Zend_Registry::get('session');
    }

    public function initView()
    {
        $view = parent::initView();
        if (isset($this->session))
        {
        	$view->session = $this->session;        
        }
        return $view;
    }
    
    /**
     * The default action - show the home page
     *
    public function indexAction()
    {
	    $this->_forward('list');
    }

    public function findAction()
    {
	    if ($this->getRequest()->getMethod() == 'POST')
	    {
		    $name = $this->getRequest()->getParam('name');
		    if ($name)
		    {
			    $this->_redirect('/sc/player/match/name/' . urlencode($name));
		    }
		    else
		    {
			    $steamid = $this->getRequest()->getParam('steamid');
			    if ($steamid)
			    {
				    $this->_forward('show', 'player', 'sc',
						    array('steamid' => $steamid));
			    }
			    else
			    {
				    $list_player = $this->getRequest()->getParam('list_player');
				    if ($list_player)
				    {
					    $this->_redirect('/sc/player/list');
				    }
				    else
				    {
					    $this->showAction();
				    }
			    }
		    }
	    }
	    else
	    {
		    // Not a POST request, show find player form
		    $view = $this->initView();
		    $this->render();
	    }
    }

    public function showAction()
    {
	    $view = $this->initView();
	    $player_table = new Player();

	    $ident = $this->getRequest()->getParam('ident');
	    if ($ident)
	    {
		    $player = $player_table->getPlayerForIdent($ident);
		    if (!$player)
		    {
			    $view->error = 'Player # "' . $ident . ' was not found';
			    $this->render();
			    return;
		    }
	    }
	    else
	    {
		    $steamid = $this->getRequest()->getParam('steamid');
		    if ($steamid)
		    {
			    $player = $player_table->getPlayerForSteamid($steamid);
			    if ($player)
			    {
				    $ident  = $player->player_ident;
			    }
			    else
			    {
				    $view->error = 'No player with a steamid of ' . $steamid . ' was found';
				    $this->render();
				    return;
			    }
		    }
		    else
		    {
			    $user = $this->getRequest()->getParam('user');
			    if ($user)
			    {
				    $player = $player_table->getPlayerForUsername($user);
				    if ($player)
				    {
					    $ident  = $player->player_ident;
				    }
				    else
				    {
					    $this->_forward('show', 'player', 'sc',
						    array('name' => $user));
					    return;
				    }
			    }
			    else
			    {
				    $name = $this->getRequest()->getParam('name');
				    if ($name)
				    {
					    $player_table = new Player();
					    $player_rowset = $player_table->getPlayerForName($name);
					    $player_count = count($player_rowset);
					    if ($player_count == 1)
					    {
						    $player = $player_rowset->current();
						    $ident  = $player->player_ident;
					    }
					    else if ($player_count > 1)
					    {
						    $this->_forward('match', 'player', 'sc',
							    array('name' => $name));
					    }
					    else
					    {
						    $view->error = 'No player with a name of ' . $name . ' was found';
						    $this->render();
						    return;
					    }
				    }
			    }
		    }
	    }

	    if (isset($player) && $player)
	    {
		    $view->player 	= $player;

		    $alias_table 	= new PlayerAlias();
		    $view->alias 	= $alias_table->getAliasesForPlayer($player->player_ident);

		    $tech_table 	= new Faction();
		    $view->tech 	= $tech_table->getFactionListForPlayer($player->player_ident, true);

		    $player_table 	= new Player();
		    $view->players 	= $player_table->getPlayerListForPlayer($player->player_ident, true);

		    $upgrade_table 	= new Upgrade();
		    $view->upgrades	= $upgrade_table->getUpgradeListForPlayer($player->player_ident, true);
		    $this->render();
	    }
	    else
	    {
		    $this->_forward('list');
	    }
    }

    public function matchAction()
    {
	    $name = $this->getRequest()->getParam('name');
	    if ($name)
	    {
		    $player_table = new Player();
		    $rowset = $player_table->getPlayerListMatchingName($name, true);
		    $count = count($rowset);
		    if ($count > 1)
		    {
			    $view = $this->initView();
			    $paginator = Zend_Paginator::factory($rowset);
			    $paginator->setItemCountPerPage(50);
			    $paginator->setCurrentPageNumber($this->_getParam('page'));
			    $paginator->setView($view);
			    $this->view->paginator = $paginator;
			    $this->render();
		    }
		    elseif ($count == 1)
		    {
			    $this->_forward('show', 'player', 'sc',
				    array('name' => $name));
		    }
		    else
		    {
			    $view = $this->initView();
			    $view->error = 'No player matching ' . $name . ' was found';
			    $this->render();
		    }
	    }
	    else
	    {
		    $this->_forward('list');
	    }
    }

    public function listAction()
    {
	    $player_table = new Player();
	    $view = $this->initView();
	    $paginator = Zend_Paginator::factory($player_table->getPlayerList());
	    $paginator->setItemCountPerPage(50);
	    $paginator->setCurrentPageNumber($this->_getParam('page'));
	    $paginator->setView($view);
	    $this->view->paginator = $paginator;
	    $this->render();
    }
 ***************************************************************************************/
}
?>
