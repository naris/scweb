<?php

/**
 * FactionController
 * 
 * @author
 * @version 
 */

namespace SourceCraft\Controller;

#require_once 'Zend/Controller/Action.php';
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

#require_once 'Faction.php';
use SourceCraft\Model\Faction;
use SourceCraft\Model\FactionRepositoryInterface;

#require_once 'Race.php';
use SourceCraft\Model\Race;
use SourceCraft\Model\RaceRepositoryInterface;

#require_once 'Upgrade.php';

#class Sc_FactionController extends Zend_Controller_Action
class FactionController extends AbstractActionController
{
    /**
     * @var FactionRepositoryInterface
     */
    private $factionRepository;

    /**
     * @var RaceRepositoryInterface
     */
    private $raceRepository;

    public function __construct(FactionRepositoryInterface $factionRepository,
	                            RaceRepositoryInterface $raceRepository)
    {
        $this->factionRepository = $factionRepository;
        $this->raceRepository = $raceRepository;
    }

	/**
	 * The default action - show the list of factions
	 */
	public function indexAction()
	{
		// Grab the paginator from the Repository:
		$paginator = $this->factionRepository->fetchAll(true);

		// Set the current page to what has been passed in query string,
		// or to 1 if none is set, or the page is invalid:
		$page = (int) $this->params()->fromQuery('page', 1);
		$page = ($page < 1) ? 1 : $page;
		$paginator->setCurrentPageNumber($page);

		// Set the number of items per page to 4:
		$paginator->setItemCountPerPage(4);

		return new ViewModel(['paginator' => $paginator]);
	}
	
	public function showAction()
	{
		$ident = $this->params()->fromRoute('id');
		if ($ident)
		{
			$faction = $this->factionRepository->findFaction($ident);
			if ($faction)
			{
				$races = $this->raceRepository->fetchRacesForFaction($ident);
				return new ViewModel(['faction' => $faction, 'races' => $races]);
			}
			else
				return new ViewModel(['error' => 'Faction Ident ' . $ident . ' was not found',]);

			/*
			$faction_table = new Faction();
			$view = $this->initView();
			$faction = $faction_table->getFaction($ident);
			if ($faction)
			{
				$view->faction 	= $faction;

				$race_table 	= new Race();
				$view->races 	= $race_table->getRaceListForFaction($ident, true);

				$upgrade_table 	= new Upgrade();
				$view->upgrades = $upgrade_table->getUpgradeListForFaction($ident, true);
			}
			else
			{
				$view->error = 'Faction ' . $ident . ' was not found';
			}
			$this->render();
			*/
		}
		else
		{
			/*
			$this->_forward('list');
			*/
		}
	}

/***************************************************************************************
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
		$this->showAction();
	}
	
	public function showAction()
	{
		$factionId = $this->getRequest()->getParam('id');
		if ($factionId)
		{
			$faction_table = new Faction();
			$view = $this->initView();
			$faction = $faction_table->getFaction($factionId);
			if ($faction)
			{
				$view->faction 	= $faction;

				$race_table 	= new Race();
				$view->races 	= $race_table->getRaceListForFaction($factionId, true);

				$upgrade_table 	= new Upgrade();
				$view->upgrades = $upgrade_table->getUpgradeListForFaction($factionId, true);
			}
			else
			{
				$view->error = 'Faction ' . $factionId . ' was not found';
			}
			$this->render();
		}
		else
		{
			$this->_forward('list');
		}
	}
	
	public function listAction()
	{
		$view = $this->initView();
		$faction_table = new Faction();
		$has_races = $this->getRequest()->getParam('has_races');
		$paginator = Zend_Paginator::factory($faction_table->getFactionList($has_races));
		$paginator->setItemCountPerPage(4);
		$paginator->setCurrentPageNumber($this->_getParam('page'));
		$paginator->setView($view);
		$this->view->paginator = $paginator;
		$this->render();
	}
	***************************************************************************************/
}
?>

