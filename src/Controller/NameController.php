<?php

namespace App\Controller;

use App\Entity\Name;
use App\Form\NameType;
use App\Repository\NameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/name')]
class NameController extends AbstractController
{
    #[Route('/', name: 'app_name_index', methods: ['GET'])]
    public function index(NameRepository $nameRepository): Response
    {
        return $this->render('name/index.html.twig', [
            'names' => $nameRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_name_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $name = new Name();
        $form = $this->createForm(NameType::class, $name);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($name);
            $entityManager->flush();

            return $this->redirectToRoute('app_name_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('name/new.html.twig', [
            'name' => $name,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_name_show', methods: ['GET'])]
    public function show(Name $name): Response
    {
        return $this->render('name/show.html.twig', [
            'name' => $name,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_name_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Name $name, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NameType::class, $name);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_name_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('name/edit.html.twig', [
            'name' => $name,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_name_delete', methods: ['POST'])]
    public function delete(Request $request, Name $name, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$name->getId(), $request->request->get('_token'))) {
            $entityManager->remove($name);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_name_index', [], Response::HTTP_SEE_OTHER);
    }
}
