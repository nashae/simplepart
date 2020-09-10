<?php

namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;

class PaginatorService
{
    private $entityClass;
    private $limit = 5;
    private $currentPage = 1;
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    
    public function getPages()
    {
        $repo = $this->manager->getRepository($this->entityClass);
        $total = count($repo->findAll());
        $pages = ceil($total / $this->limit);
        return $pages;
    }

    public function getData()
    {
        $offset = $this->currentPage * $this->limit - $this->limit;
        $repo = $this->manager->getRepository($this->entityClass);
        $data = $repo->findBy([],['createdAt' => 'DESC'],$this->limit, $offset);
        return $data;

    }

    public function getDataByCategory($category)
    {
        $offset = $this->currentPage * $this->limit - $this->limit;
        $repo = $this->manager->getRepository($this->entityClass);
        $dataBycategory = $repo->findBy(['category' => $category],['createdAt' => 'DESC'],$this->limit, $offset);
        return $dataBycategory;
    }

    public function getDataByAuthor($user)
    {
        $offset = $this->currentPage * $this->limit - $this->limit;
        $repo = $this->manager->getRepository($this->entityClass);
        $dataByAuthor = $repo->findBy(['author' => $user],['createdAt' => 'DESC'],$this->limit, $offset);
        return $dataByAuthor;
    }

    public function getDataByUser()
    {
        $offset = $this->currentPage * $this->limit - $this->limit;
        $repo = $this->manager->getRepository($this->entityClass);
        $data = $repo->findBy([],['id' => 'DESC'],$this->limit, $offset);
        return $data;

    }

    /**
     * Get the value of entityClass
     */ 
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    /**
     * Get the value of limit
     */ 
    public function getLimit()
    {
        return $this->limit;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Get the value of currentPage
     */ 
    public function getPage()
    {
        return $this->currentPage;
    }

    
    public function setPage($currentPage)
    {
        $this->currentPage = $currentPage;

        return $this;
    }
}