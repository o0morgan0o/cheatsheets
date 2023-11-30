<?php
namespace App\Tests\Integration\Repository;

use App\Entity\LockDown;
use App\Repository\LockDownRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class LockDownRepositoryTest extends KernelTestCase
{
    /* composer require zenstruck/foundry --dev */
    use ResetDatabase, Factories;
    public function testIsInLockDownReturnsFalseWithNoRows()
    {
        self::bootKernel();
        $this->assertFalse($this->getLockDownRepository()->isInLockDown());
    }
    public function testIsInLockDownReturnsTrueIfMostRecentLockDownIsActive()
    {
        self::bootKernel();
        // aussi possible d'ubiliser la factory pour créer les éléments de la db
        $post = PostFactory::createOne(['title' => 'My First Post']);
        $realPost = $post->object();
        $post->sedTitle('new title');
        $post->getTitle();
        $post->save(); // save to db
        $post->refresh(); // refresh db
        $post->remove();
        $post->repository();
        //
        $lockDown = new LockDown();
        $lockDown->setReason('Dinos have organized their own lunch break');
        $lockDown->setCreatedAt(new \DateTimeImmutable('-1 day'));
        $entityManager = self::getContainer()->get(EntityManagerInterface::class);
        assert($entityManager instanceof EntityManagerInterface);
        $entityManager->persist($lockDown);
        $entityManager->flush();
        $this->assertTrue($this->getLockDownRepository()->isInLockDown());
    }
    private function getLockDownRepository(): LockDownRepository
    {
        return self::getContainer()->get(LockDownRepository::class);
    }
}