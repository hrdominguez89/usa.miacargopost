<?php

namespace App\Controller\Secure;

use App\Entity\Team;
use App\Entity\User;
use App\Form\MemberFormType;
use App\Form\TeamType;
use App\Pagination\Pagination;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/team')]
#[IsGranted('ROLE_ADMIN')]
class TeamController extends AbstractController
{
    #[Route('/', name: 'app_team_index', methods: ['GET', 'POST'])]
    public function index(Request $request, TeamRepository $repository, Pagination $pagination): Response
    {
        if ($request->isMethod('post')) {
            return $this->json($pagination->paginate($request, $repository));
        }

        return $this->render('team/index.html.twig', ['active' => 'team']);
    }

    #[Route('/new', name: 'app_team_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TeamRepository $repository): Response
    {
        $entity = new Team();
        $form = $this->createForm(TeamType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($entity, true);

            $this->addFlash('notice', 'Acción realizada correctamente');

            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('team/new.html.twig', ['team' => $entity, 'form' => $form, 'active' => 'team']);
    }

    #[Route('/{id}/edit', name: 'app_team_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, TeamRepository $repository, Team $entity): Response
    {
        $form = $this->createForm(TeamType::class, $entity);
        $form->handleRequest($request);

        $formMember = $this->createForm(MemberFormType::class);
        $formMember->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($entity, true);

            $this->addFlash('notice', 'Acción realizada correctamente');

            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($formMember->isSubmitted() && $formMember->isValid()) {

            /** @var User $member */
            $member = $formMember->get('member')->getData();

            $member->setTeam($entity);

            $repository->save($entity, true);

            $this->addFlash(
                'notice',
                'Acción realizada correctamente'
            );

            return $this->redirectToRoute('app_team_edit', ['id' => $entity->getId()], Response::HTTP_SEE_OTHER);
        }

        $members = $repository->findAllMembersPaginated($entity->getId());

        return $this->render('team/edit.html.twig', [
            'members' => $members,
            'team' => $entity,
            'form' => $form,
            'formMember' => $formMember,
            'active' => 'team'
        ]);
    }

    #[Route('/delete-more', name: 'app_team_delete_more', methods: ['DELETE'])]
    public function deleteMore(Request $request, TeamRepository $repository): Response
    {

        $ids = explode(',', $request->get('ids', []));

        foreach ($ids as $id) {
            $entity = $repository->find($id);
            if ($entity) {
                $repository->remove($entity, true);
            }
        }

        $this->addFlash('notice', 'Acción realizada correctamente');

        return $this->json('OK');
    }
}
