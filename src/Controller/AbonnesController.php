<?php

namespace App\Controller;

use App\Entity\Abonnes;
use App\Form\AbonnesType;
use App\Repository\AbonnesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/abonnes")
 */
class AbonnesController extends AbstractController
{
    /**
     * @Route("/", name="abonnes_index", methods={"GET"})
     */
    public function index(AbonnesRepository $abonnesRepository): Response
    {
        return $this->render('abonnes/index.html.twig', [
            'abonnes' => $abonnesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="abonnes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $abonne = new Abonnes();
        $form = $this->createForm(AbonnesType::class, $abonne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($abonne);
            $entityManager->flush();

            return $this->redirectToRoute('abonnes_index');
        }

        return $this->render('abonnes/new.html.twig', [
            'abonne' => $abonne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="abonnes_show", methods={"GET"})
     */
    public function show(Abonnes $abonne): Response
    {
        return $this->render('abonnes/show.html.twig', [
            'abonne' => $abonne,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="abonnes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Abonnes $abonne): Response
    {
        $form = $this->createForm(AbonnesType::class, $abonne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('abonnes_index');
        }

        return $this->render('abonnes/edit.html.twig', [
            'abonne' => $abonne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="abonnes_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Abonnes $abonne): Response
    {
        if ($this->isCsrfTokenValid('delete'.$abonne->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($abonne);
            $entityManager->flush();
        }

        return $this->redirectToRoute('abonnes_index');
    }
}
