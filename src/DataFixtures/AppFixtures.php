<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Period;
use App\Entity\RefundConfiguration;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager) : void
    {
        foreach ($this->getUserData() as [$username, $password, $email, $dateBegin, $roles]) {
            $user = new User();
            $user->setUsername($username);
            $user->setPassword($this->passwordEncoder->hashPassword($user, $password));
            $user->setEmail($email);
            $user->setDateBegin($dateBegin);
            $user->setRoles($roles);

            $manager->persist($user);
            $this->addReference($username, $user);
        }

        foreach ($this->getEventData($manager) as [$date, $type, $addressLabel, $address, $postalCode, $city, $period]) {
            $event = new Event();
            $event->setDateTimeStart($date);
            $event->setType($type);
            $event->setAddressLabel($addressLabel);
            $event->setAddress($address);
            $event->setPostalCode($postalCode);
            $event->setCity($city);
            $event->setClosed(false);
            $event->setPeriod($period);

            $manager->persist($event);
            $this->addReference($date->format('Ymd'), $event);
        }

        foreach ($this->getRefundConfiguration($manager) as [$date, $nbKmNotRefund, $euroPerKm, $isTollGoRefunded, $isTollReturnRefunded]) {
            $refundConfiguration = new RefundConfiguration();
            $refundConfiguration->setDateStart($date);
            $refundConfiguration->setNbKmNotRefund($nbKmNotRefund);
            $refundConfiguration->setEuroPerKm($euroPerKm);
            $refundConfiguration->setIsTollGoRefunded($isTollGoRefunded);
            $refundConfiguration->setIsTollReturnRefunded($isTollReturnRefunded);

            $manager->persist($refundConfiguration);
            $this->addReference($date->format('Ymd'), $refundConfiguration);
        }

        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            // $userData = [$username, $password, $email, $roles];
            ['toto_admin', 'pwd', 'toto_admin@bbpl.fr', new \DateTime('2018-01-01'), ['ROLE_ADMIN']],
            ['tata_user', 'pwd', 'tata_user@symfony.com', new \DateTime('2018-08-01'), ['ROLE_USER']],
        ];
    }

    private function getEventData(ObjectManager $manager): array
    {
        $period1 = new Period();
        $period1->setDateStart(new \DateTime('2018-01-01'));
        $period1->setDateEnd(new \DateTime('2018-05-31'));
        $manager->persist($period1);

        $period2 = new Period();
        $period2->setDateStart(new \DateTime('2018-06-01'));
        $period2->setDateEnd(new \DateTime('2019-03-31'));
        $manager->persist($period2);

        return [
            // $userData = [$username, $password, $email, $roles];
            [new \DateTime('2018-03-12'), 'repetition', 'montjean', 'a', '44490', 'Montjean', $period1],
            [new \DateTime('2018-03-19'), 'repetition', 'montjean', 'a', '44490', 'Montjean', $period1],
            [new \DateTime('2018-03-26'), 'repetition', 'montjean', 'a', '44490', 'Montjean', $period1],
            [new \DateTime('2018-04-02'), 'repetition', 'montjean', 'a', '44490', 'Montjean', $period1],
            [new \DateTime('2018-04-09'), 'repetition', 'montjean', 'a', '44490', 'Montjean', $period1],
            [new \DateTime('2018-08-27'), 'repetition', 'montjean', 'a', '44490', 'Montjean', $period2],
            [new \DateTime('2018-09-03'), 'repetition', 'montjean', 'a', '44490', 'Montjean', $period2],
        ];
    }

    private function getRefundConfiguration(): iterable
    {
        yield [
            new \DateTimeImmutable('2000-01-01'), 25, 0.10, true, false,
        ];

        yield [
            new \DateTimeImmutable('2018-05-01'), 25, 0.15, true, false,
        ];
    }
}
