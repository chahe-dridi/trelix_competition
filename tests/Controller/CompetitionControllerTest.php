<?php

namespace App\Test\Controller;

use App\Entity\Competition;
use App\Repository\CompetitionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompetitionControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CompetitionRepository $repository;
    private string $path = '/competitions/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Competition::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Competition index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'competition[nom]' => 'Testing',
            'competition[description]' => 'Testing',
            'competition[datedebut]' => 'Testing',
            'competition[datefin]' => 'Testing',
            'competition[image]' => 'Testing',
        ]);

        self::assertResponseRedirects('/competitions/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Competition();
        $fixture->setNom('My Title');
        $fixture->setDescription('My Title');
        $fixture->setDatedebut('My Title');
        $fixture->setDatefin('My Title');
        $fixture->setImage('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Competition');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Competition();
        $fixture->setNom('My Title');
        $fixture->setDescription('My Title');
        $fixture->setDatedebut('My Title');
        $fixture->setDatefin('My Title');
        $fixture->setImage('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'competition[nom]' => 'Something New',
            'competition[description]' => 'Something New',
            'competition[datedebut]' => 'Something New',
            'competition[datefin]' => 'Something New',
            'competition[image]' => 'Something New',
        ]);

        self::assertResponseRedirects('/competitions/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getDatedebut());
        self::assertSame('Something New', $fixture[0]->getDatefin());
        self::assertSame('Something New', $fixture[0]->getImage());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Competition();
        $fixture->setNom('My Title');
        $fixture->setDescription('My Title');
        $fixture->setDatedebut('My Title');
        $fixture->setDatefin('My Title');
        $fixture->setImage('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/competitions/');
    }
}
