<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Filter\UserFilterType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="app_user_index", methods={"GET", "POST"})
     */
    public function index(UserRepository $userRepository, Request $request,
                          PaginatorInterface $paginator): Response
    {
        $users = $userRepository->findAll();

        $form = $this->createForm(UserFilterType::class);
        $search = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $users = $userRepository->filter(
                $search->get('roleUser')->getData(),
                $search->get('ordreNom')->getData(),
                $search->get('ordrePrenom')->getData()
            );
        }

        $usersTotal = $users;

        $users = $paginator->paginate(
            $users,
            $request->query->getInt('page',1),
            20
        );

        return $this->render('user/index.html.twig', [
            'users' => $users,
            'totalUsers' => $usersTotal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="app_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request,
                        UserPasswordHasherInterface $userPasswordHasher,
                        EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('password')->getData() != null){
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
            }

            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'SuccessUser',
                'L\'utilisateur a été enregistré !'
            );

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user,
                         UserPasswordHasherInterface $userPasswordHasher,
                         EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user,['password_required' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('password')->getData() != null){
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
            }

            $entityManager->flush();
            $this->addFlash(
                'SuccessUser',
                'L\'utilisateur a été modifié !'
            );

            return $this->redirectToRoute('app_user_edit', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delete_view", name="app_user_delete_view", methods={"GET","POST"})
     */
    public function delete_view(User $user): Response
    {
        return $this->render('user/delete_view.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}", name="app_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash(
                'SuccessDeleteUser',
                'Votre fait a été supprimé !'
            );
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
