<?php

/**
 * RaceController
 * 
 * @author
 * @version 
 */

namespace SourceCraft\Controller;

#require_once 'Zend/Controller/Action.php';
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\AbstractActionController;

#require_once 'Race.php';
#use SourceCraft\Model\RaceTable;
use SourceCraft\Model\RaceRepositoryInterface;
#use SourceCraft\Form\RaceForm;
use SourceCraft\Model\Race;

#require_once 'Upgrade.php';
use SourceCraft\Model\Upgrade;


#class Sc_RaceController extends Zend_Controller_Action
class RaceController extends AbstractActionController
{
    /**
     * @var RaceRepositoryInterface
     */
    private $repository;

    /*
	public function __construct(Racerepository $table)
    {
        $this->repository = $table;
    }
	*/

    public function __construct(RaceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

	/**
	 * The default action - show the home page
	 *
	public function indexAction()
	{
		$this->_forward('list');
	}
	*
    public function indexAction()
    {
        // Grab the paginator from the RaceTable:
        $paginator = $this->repository->fetchAll(true);

        // Set the current page to what has been passed in query string,
        // or to 1 if none is set, or the page is invalid:
        $page = (int) $this->params()->fromQuery('page', 1);
        $page = ($page < 1) ? 1 : $page;
        $paginator->setCurrentPageNumber($page);

        // Set the number of items per page to 10:
        $paginator->setItemCountPerPage(10);

        return new ViewModel(['paginator' => $paginator]);
    }
	*/
    public function indexAction()
    {
		// Grab the paginator from the Repository:
		$paginator = $this->repository->fetchAll(true);

		// Set the current page to what has been passed in query string,
		// or to 1 if none is set, or the page is invalid:
		$page = (int) $this->params()->fromQuery('page', 1);
		$page = ($page < 1) ? 1 : $page;
		$paginator->setCurrentPageNumber($page);

		// Set the number of items per page to 10:
		$paginator->setItemCountPerPage(10);

		return new ViewModel(['paginator' => $paginator]);
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
    
	
	public function findAction()
	{
		if ($this->getRequest()->getMethod() == 'POST')
		{
			$race = $this->getRequest()->getParam('race');
			if ($race)
			{
				$this->_redirect('/sc/race/show/name/' . urlencode($race));
			}
			else
			{
				$faction = $this->getRequest()->getParam('faction');
				if ($faction)
				{
					$this->_redirect('/sc/faction/show/id/' . urlencode($faction));
				}
				else
				{
					$list_race = $this->getRequest()->getParam('list_race');
					if ($list_race)
					{
						$this->_redirect('/sc/race/list');
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
			// Not a POST request, show find race form
			$view = $this->initView();
			$this->render();
		}
	}

	public function showAction()
	{
		$ident = $this->getRequest()->getParam('ident');
		if ($ident)
		{
			$race_table = new Race();
			$view = $this->initView();
			$race = $race_table->getRaceForIdent($ident);
			if ($race)
			{
				$view->race = $race;
			}
			else
			{
				$view->error = 'Race Ident ' . $ident . ' was not found';
				$this->render();
				return;
			}
		}
		else
		{
			$name = $this->getRequest()->getParam('name');
			if ($name)
			{
				$race_table = new Race();
				$view = $this->initView();
				$race_rowset = $race_table->getRaceListForName($name, true);
				$race_count = count($race_rowset);
				if ($race_count == 1)
				{
					$race = $race_rowset->current();
					$ident = $race->race_ident;
					$view->race = $race;
				}
				else if ($race_count > 1)
				{
					$this->_forward('match', 'race', 'sc',
						array('name' => $name));
					return;
				}
				else
				{
					$view->error = 'Race ' . $name . ' was not found';
					$this->render();
					return;
				}
			}
		}

		if (isset($race) && $race)
		{
			$upgrade_table 	= new Upgrade();
			$view->upgrades = $upgrade_table->getUpgradeListForRace($ident, true);
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
   			$race_table = new Race();
			$rowset = $race_table->getRaceListForName($name, true);
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
				$this->_forward('show', 'race', 'sc',
						array('name' => $name));
			}
			else
			{
				$view = $this->initView();
				$view->error = 'No race matching ' . $name . ' was found';
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
		$view = $this->initView();
		$race_table = new Race();
		$paginator = Zend_Paginator::factory($race_table->getRaceList());
		$paginator->setItemCountPerPage(4);
		$paginator->setCurrentPageNumber($this->_getParam('page'));
		$paginator->setView($view);
		$this->view->paginator = $paginator;
		$this->render();
	}
 ***************************************************************************************/
}
?>
