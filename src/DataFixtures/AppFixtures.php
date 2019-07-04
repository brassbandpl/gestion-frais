<?php
namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$username, $password, $email, $roles]) {
            $user = new User();
            $user->setUsername($username);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setEmail($email);
            $user->setRoles($roles);

            $manager->persist($user);
            $this->addReference($username, $user);
        }

        foreach ($this->getEventData() as [$date, $type, $addressLabel, $address, $postalCode, $city ]) {
            $event = new Event();
            $event->setDate($date);
            $event->setType($type);
            $event->setAddressLabel($addressLabel);
            $event->setAddress($address);
            $event->setPostalCode($postalCode);
            $event->setCity($city);
            $event->setClosed(false);

            $manager->persist($event);
            $this->addReference($date->format('Ymd'), $event);
        }

        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            // $userData = [$username, $password, $email, $roles];
            ['toto_admin', 'pwd', 'toto_admin@bbpl.fr', ['ROLE_ADMIN']],
            ['tata_user', 'pwd', 'tata_user@symfony.com', ['ROLE_USER']],
        ];
    }

    private function getEventData(): array
    {
        return [
            // $userData = [$username, $password, $email, $roles];
            [new \DateTime('2018-03-12'), 'repetition', 'montjean', 'a', '44490', 'Montjean'],
            [new \DateTime('2018-03-19'), 'repetition', 'montjean', 'a', '44490', 'Montjean'],
            [new \DateTime('2018-03-26'), 'repetition', 'montjean', 'a', '44490', 'Montjean'],
            [new \DateTime('2018-04-02'), 'repetition', 'montjean', 'a', '44490', 'Montjean'],
            [new \DateTime('2018-04-09'), 'repetition', 'montjean', 'a', '44490', 'Montjean'],
            [new \DateTime('2018-08-27'), 'repetition', 'montjean', 'a', '44490', 'Montjean'],
            [new \DateTime('2018-09-03'), 'repetition', 'montjean', 'a', '44490', 'Montjean'],
        ];
    }


}