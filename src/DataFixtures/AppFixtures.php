<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\Permission;
use App\Entity\Role;
use App\Entity\Team;
use App\Entity\User;
use App\Helper\FixturesTrait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    use FixturesTrait;

    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
        private readonly ManagerRegistry $registry
    ) {
    }


    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {

        // ROLES & PERMISSIONS

        foreach ($this->getRoles() as $key => $name) {
            $role = new Role();

            $role->setRoleKey($key)->setName($name);

            $manager->persist($role);
        }

        foreach ($this->getPermissions() as $key => $name) {
            $permission = new Permission();

            $permission->setPermissionKey($key)->setName($name);

            $manager->persist($permission);
        }

        $manager->flush();

        $roles = $this->registry->getRepository(Role::class)->findAll();
        $permissions = $this->registry->getRepository(Permission::class)->findAll();

        foreach ($roles as $role) {
            foreach ($permissions as $permission) {
                $role->addPermission($permission);
            }

            $manager->persist($role);
        }

        $manager->flush();

        // TEAMS

        for ($i = 0; $i < 5; $i++) {

            $team = new Team();
            $team->setName('WorkTeam '.$i);

            $manager->persist($team);

        }

        $manager->flush();

        // USERS

        for ($i = 0; $i < 11; $i++) {

            $user = new User();

            $user
                ->setName($this->getNames())
                ->setEmail('user'.$i.'@mailinator.com')
                ->setPassword($this->hasher->hashPassword($user, $_ENV['USERPASSWORD']))
                ->setRole($roles[$i % 2 ? 0 : 1]);

            $manager->persist($user);

        }

        $manager->flush();

        // CUSTOMERS

        for ($i = 0; $i < 11; $i++) {

            $customer = new Customer();

            $customer
                ->setApiId('59'.$i)
                ->setName($this->getNames())
                ->setLastName($this->getLastNames())
                ->setEmail('customer'.$i.'@mailinator.com')
                ->setGender(rand(2, 10) % 2 ? 'M' : 'F')
                ->setCustomerType('Persona')
                ->setStatus(1)
                ->setIdentityType('DNI')
                ->setIdentityNumber('34987273')
                ->setPhoneCode('54')
                ->setPhone('1234567890')
                ->setCellPhone('1234567890');

            $manager->persist($customer);

            $order = new Order();

            $dateCreated = new \DateTime();

            $order
                ->setCustomer($customer)
                ->setOrderId($i.($i + 1))
                ->setOrderDC($dateCreated->format('d-m-Y-H-i-s'))
                ->setWareHouseId($i.($i + 1))
                ->setStatusOrder(1)
                ->setShippingInternational($i.($i + 1))
                ->setPaymentFiles([])
                ->setPaymentsReceivedFile([])
                ->setPaymentsTransactionCodes([])
                ->setDebitCreditNotesFile([])
                ->setShippingName($customer->getName());

            $manager->persist($order);

        }

        $manager->flush();

    }
}
