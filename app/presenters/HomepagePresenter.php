<?php

namespace App\Presenters;

use App\Entity\Article;
use Kdyby\Doctrine\EntityManager;
use Nette;


class HomepagePresenter extends Nette\Application\UI\Presenter implements
{

	private $entityManager;

	public function __construct(EntityManager $entityManager)
	{
		parent::__construct();
		$this->entityManager = $entityManager;
	}

	public function renderDefault()
	{
		$article = new Article('article');
		$this->entityManager->persist($article);
		$this->entityManager->flush();

		$this->template->article = $this->entityManager->getRepository(Article::class)->findOneBy([]);
	}

}
