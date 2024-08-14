<?php

namespace App\Helper;

trait FixturesTrait
{
    /**
     * @return string
     */
    public function getReminderTypes(): string
    {
        $types = ['DANGER', 'DARK', 'INFO', 'PRIMARY', 'SUCCESS', 'WARNING'];

        return $types[array_rand($types)];
    }

    /**
     * @return string[]
     */
    public function getTeams(): array
    {
        return [
            'SUPER ADMIN',
            'TEAM ATENCION AL CLIENTE / VENDEDOR',
            'TEAM MARKETING',
            'TEAM ANALYTICS',
            'TEAM CATALOGO',
            'TEAM OPERACIONES - WAREHOUSE',
            'TEAM FACTURACION',
            'TEAM COBRANZA',
            'TEAM LOGISTICA',
        ];
    }

    /**
     * @return string[]
     */
    private function getRoles(): array
    {
        return [
            'ROLE_ADMIN' => 'ADMINISTRADOR',
            'ROLE_EMPLOYEE' => 'EMPLEADO',
        ];
    }

    /**
     * @return string[]
     */
    private function getPermissions(): array
    {
        return [
            'create_user' => 'CREAR USUARIO',
            'create_employee' => 'CREAR EMPLEADO',
            'read_user' => 'VER USUARIO',
            'read_employee' => 'VER EMPLEADO',
            'update_user' => 'ACTUALIZAR USUARIO',
            'update_employee' => 'ACTUALIZAR EMPLEADO',
            'delete_user' => 'ELIMINAR USUARIO',
            'delete_employee' => 'ELIMINAR EMPLEADO',
        ];
    }

    /**
     * @return string
     */
    private function getFullName(): string
    {
        return $this->getNames().' '.$this->getLastNames();
    }

    /**
     * @return string
     */
    private function getNames(): string
    {
        $man = array(
            'Antonio',
            'José',
            'Manuel',
            'Francisco',
            'Juan',
            'David',
            'José Antonio',
            'José Luis',
            'Jesús',
            'Javier',
            'Francisco Javier',
            'Carlos',
            'Daniel',
            'Miguel',
            'Rafael',
            'Pedro',
            'José Manuel',
            'Ángel',
            'Alejandro',
            'Miguel Ángel',
            'José María',
            'Fernando',
            'Luis',
            'Sergio',
            'Pablo',
            'Jorge',
            'Alberto',
        );
        $woman = array(
            'María Carmen',
            'María',
            'Carmen',
            'Josefa',
            'Isabel',
            'Ana María',
            'María Dolores',
            'María Pilar',
            'María Teresa',
            'Ana',
            'Francisca',
            'Laura',
            'Antonia',
            'Dolores',
            'María Angeles',
            'Cristina',
            'Marta',
            'María José',
            'María Isabel',
            'Pilar',
            'María Luisa',
            'Concepción',
            'Lucía',
            'Mercedes',
            'Manuela',
            'Elena',
            'Rosa María',
        );

        return mt_rand() % 2
            ? $man[array_rand($man)]
            : $woman[array_rand(
                $woman
            )];
    }

    /**
     * @return string
     */
    private function getLastNames(): string
    {
        $lastNames = array(
            'García',
            'González',
            'Rodríguez',
            'Fernández',
            'López',
            'Martínez',
            'Sánchez',
            'Pérez',
            'Gómez',
            'Martín',
            'Jiménez',
            'Ruiz',
            'Hernández',
            'Díaz',
            'Moreno',
            'Álvarez',
            'Muñoz',
            'Romero',
            'Alonso',
            'Gutiérrez',
            'Navarro',
            'Torres',
            'Domínguez',
            'Vázquez',
            'Ramos',
            'Gil',
            'Ramírez',
            'Serrano',
            'Blanco',
            'Suárez',
            'Molina',
            'Morales',
            'Ortega',
            'Delgado',
            'Castro',
            'Ortíz',
            'Rubio',
            'Marín',
            'Sanz',
            'Iglesias',
            'Nuñez',
            'Medina',
            'Garrido',
        );

        return $lastNames[array_rand($lastNames)].' '.$lastNames[array_rand(
                $lastNames
            )];
    }
}