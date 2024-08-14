<?php

namespace App\Controller\Secure;

use App\Entity\User;
use App\Form\UserType;
use App\Pagination\Pagination;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/user')]
#[IsGranted('ROLE_ADMIN')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET', 'POST'])]
    public function index(Request $request, UserRepository $repository, Pagination $pagination): Response
    {
        if ($request->isMethod('post')) {
            return $this->json($pagination->paginate($request, $repository));
        }

        return $this->render('user/index.html.twig', ['active' => 'user']);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        UserRepository $repository,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $entity = new User();
        $form = $this->createForm(UserType::class, $entity, ['password_required' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $repository->upgradePassword($entity, $passwordHasher->hashPassword($entity, $entity->getPassword()));

            $this->addFlash('notice', 'Acción realizada correctamente');

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', ['user' => $entity, 'form' => $form, 'active' => 'user']);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        UserRepository $repository,
        User $entity,
    ): Response {
        $hashedPassword = $entity->getPassword();

        $form = $this->createForm(UserType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($entity->getPassword()) {
                $hashedPassword = $passwordHasher->hashPassword($entity, $entity->getPassword());
            }

            $repository->upgradePassword($entity, $hashedPassword);

            $this->addFlash('notice', 'Acción realizada correctamente');

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', ['user' => $entity, 'form' => $form, 'active' => 'user']);
    }

    #[Route('/{id}', name: 'app_user_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, UserRepository $repository, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $repository->remove($user, true);

            $this->addFlash('notice', 'Acción realizada correctamente');
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/delete-more', name: 'app_user_delete_more', methods: ['DELETE'])]
    public function deleteMore(Request $request, UserRepository $repository): Response {

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
