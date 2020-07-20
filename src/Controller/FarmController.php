<?php

namespace App\Controller;

use App\Entity\Farm;
use App\Form\FarmType;
use App\Repository\FarmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/farm")
 */
class FarmController extends AbstractController
{
    /**
     * @Route("/", name="farm_index", methods={"GET"})
     */
    public function index(FarmRepository $farmRepository): Response
    {
        return $this->render('farm/index.html.twig', [
            'farms' => $farmRepository->findAllFarm(),
        ]);
    }

    /**
     * @Route("/new", name="farm_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $farm = new Farm();
        $form = $this->createForm(FarmType::class, $farm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($farm);
            $entityManager->flush();

            return $this->redirectToRoute('farm_index');
        }

        return $this->render('farm/new.html.twig', [
            'farm' => $farm,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="farm_show", methods={"GET"})
     */
    public function show(Farm $farm): Response
    {
        return $this->render('farm/show.html.twig', [
            'farm' => $farm,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="farm_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Farm $farm): Response
    {
        $form = $this->createForm(FarmType::class, $farm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('farm_index');
        }

        return $this->render('farm/edit.html.twig', [
            'farm' => $farm,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="farm_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Farm $farm): Response
    {
        if ($this->isCsrfTokenValid('delete'.$farm->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($farm);
            $entityManager->flush();
        }

        return $this->redirectToRoute('farm_index');
    }
}
