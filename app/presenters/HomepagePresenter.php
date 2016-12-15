<?php

namespace App\Presenters;

use App\Entity\Article;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Kdyby\Doctrine\EntityManager;
use Nette;


class HomepagePresenter extends Nette\Application\UI\Presenter implements EventSubscriber
{

	private $entityManager;

	private $postLoadCalled = false;

	public function __construct(EntityManager $entityManager)
	{
		parent::__construct();
		$entityManager->getEventManager()->addEventSubscriber($this);
		$this->entityManager = $entityManager;
	}

	public function renderDefault()
	{
		$article = new Article('article');
		$this->entityManager->persist($article);
		$this->entityManager->flush();

		$this->template->article = $this->entityManager->getRepository(Article::class)->findOneBy([]);
		$this->template->postLoadCalled = $this->postLoadCalled;
	}

	public function getSubscribedEvents()
	{
		return [Events::postLoad];
	}

	public function postLoad(LifecycleEventArgs $args)
	{
		$this->postLoadCalled = true;
	}

}
