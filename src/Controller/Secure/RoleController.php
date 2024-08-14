<?php

namespace App\Controller\Secure;

use App\Entity\Role;
use App\Entity\User;
use App\Form\RoleType;
use App\Pagination\Pagination;
use App\Repository\RoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/role')]
#[IsGranted('ROLE_ADMIN')]
class RoleController extends AbstractController
{
    #[Route('/', name: 'app_role_index', methods: ['GET', 'POST'])]
    public function index(Request $request, RoleRepository $repository, Pagination $pagination): Response
    {
        if ($request->isMethod('post')) {
            return $this->json($pagination->paginate($request, $repository));
        }

        return $this->render('role/index.html.twig', ['active' => 'role']);
    }

    #[Route('/new', name: 'app_role_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RoleRepository $repository): Response
    {
        $entity = new Role();
        $form = $this->createForm(RoleType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($entity, true);

            $this->addFlash('notice', 'Acción realizada correctamente');

            return $this->redirectToRoute('app_role_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('role/new.html.twig', ['role' => $entity, 'form' => $form, 'active' => 'role']);
    }

    #[Route('/{id}/edit', name: 'app_role_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, RoleRepository $repository, Role $entity): Response
    {
        $form = $this->createForm(RoleType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($entity, true);

            $this->addFlash('notice', 'Acción realizada correctamente');

            return $this->redirectToRoute('app_role_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('role/edit.html.twig', ['role' => $entity, 'form' => $form, 'active' => 'role']);
    }

    #[Route('/{id}', name: 'app_role_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, RoleRepository $repository, Role $entity): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entity->getId(), $request->request->get('_token'))) {
            $repository->remove($entity, true);
        }

        $this->addFlash('notice', 'Acción realizada correctamente');

        return $this->redirectToRoute('app_role_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/delete-more', name: 'app_role_delete_more', methods: ['DELETE'])]
    public function deleteMore(Request $request, RoleRepository $repository): Response
    {

        $ids = explode(',', $request->get('ids', []));

        foreach ($ids as $id) {
            $entity = $repository->find($id);
            if ($entity && !$entity->isSecurityRole()) {
                $repository->remove($entity, true);
            }
        }

        $this->addFlash('notice', 'Acción realizada correctamente');

        return $this->json('OK');

    }
}
