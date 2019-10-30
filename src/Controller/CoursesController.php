<?php

namespace App\Controller;

use App\Component\TextParser;
use App\Entity\Courses;
use App\Form\CoursesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/courses")
 */
class CoursesController extends AbstractController
{
    /**
     * @Route("/", name="courses_index", methods={"GET"})
     */
    public function index(): Response
    {
        $courses = $this->getDoctrine()
            ->getRepository(Courses::class)
            ->findAll();

        return $this->render('admin/courses/index.html.twig', [
            'courses' => $courses,
        ]);
    }

    /**
     * @Route("/new", name="courses_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $course = new Courses();
        $form = $this->createForm(CoursesType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $parser = new TextParser($course->getTextBody());
            $course->setParsedText($parser->parseForJs());
            $course->setWordsCount($parser->calculateWords());
            $course->setLetterCount($parser->calculateLetters());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($course);
            $entityManager->flush();

            return $this->redirectToRoute('courses_index');
        }

        return $this->render('admin/courses/new.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="courses_show", methods={"GET"})
     */
    public function show(Courses $course): Response
    {
        return $this->render('admin/courses/show.html.twig', [
            'course' => $course,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="courses_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Courses $course): Response
    {
        $form = $this->createForm(CoursesType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('courses_index');
        }

        return $this->render('admin/courses/edit.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="courses_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Courses $course): Response
    {
        if ($this->isCsrfTokenValid('delete'.$course->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($course);
            $entityManager->flush();
        }

        return $this->redirectToRoute('courses_index');
    }
}
