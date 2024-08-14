<?php

namespace App\Controller\Secure;

use App\Entity\Reminder;
use App\Entity\User;
use App\Repository\ReminderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reminder')]
class ReminderController extends AbstractController
{
    #[Route('/index', name: 'app_reminder_index', methods: ['GET', 'POST'])]
    public function index(Request $request, ReminderRepository $repository): Response
    {
        if ($request->isMethod('post')) {

            [$start, $end] = $repository->parseDates($request);

            return $this->json($repository->findAllPaginated($this->getUser(), $start, $end));
        }

        return $this->render('reminder/index.html.twig', ['active' => 'reminder']);
    }

    /**
     * @throws \Exception
     */
    #[Route('/new', name: 'app_reminder_new', methods: ['POST'])]
    public function new(Request $request, ReminderRepository $repository): Response
    {

        [$user, $data] = [$this->getUser(), $request->get('newEvent')];

        $entity = new Reminder();

        [$timeStart, $timeEnd] = [$data['timeStart'], $data['timeEnd']];

        [$start, $end] = [new \DateTime($data['start'].' '.$timeStart), new \DateTime($data['end'].' '.$timeEnd)];

        $entity
            ->setUser($user instanceof User ? $user : null)
            ->setAllDay($data['allDay'])
            ->setTitle($data['title'])
            ->setDateStart($start)
            ->setDateEnd($end)
            ->setLocation($data['location'])
            ->setTypeReminder($data['className'])
            ->setDescription($data['description']);

        $repository->save($entity, true);

        return $this->json($entity->toArray());
    }
}
