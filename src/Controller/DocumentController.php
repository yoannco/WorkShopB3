<?php

namespace App\Controller;

use App\Entity\Document;
use App\Form\DocumentType;
use App\Repository\DocumentRepository;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/document")
 */
class DocumentController extends AbstractController
{
    /**
     * @Route("/", name="document_index", methods={"GET"})
     */
    public function index(DocumentRepository $documentRepository, UserRepository $userRepository): Response
    {
        $userDocument = [];

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $identifier = $user->getUserIdentifier();
        $thisUser = $userRepository->findOneBy(array('email' => $identifier));
        if (count( explode(' ',trim($thisUser->getBinome()))) == 2){
            $binomeUser = $userRepository->findOneBy(array('name' => explode(' ',trim($thisUser->getBinome()))[0], 'firstName' => explode(' ',trim($thisUser->getBinome()))[1]));
            $userDocument = $documentRepository->findAllUserDocument($thisUser->getId(), $binomeUser->getId());
        }
        return $this->render('document/index.html.twig', [
            'documents' => $userDocument,
        ]);
    }

    /**
     * @Route("/new", name="document_new")
     */
    public function new(Request $request): Response
    {
        $document = new Document();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $document->setUserId( $user);
        $form = $this->createForm(DocumentType::class,$document);
       
        if ($request->isMethod('POST')) { 
            $form->handleRequest($request); 
            if ($form->isSubmitted() && $form->isValid()) {

                    // $string = "upload";
                    // $file = $document->getLink();
                    $file = $form->get('link')->getData();
                    $fichier = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move(
                    $this->getParameter("upload_document"),$fichier);
                    $document->setLink($fichier);

                $em = $this->getDoctrine()->getManager();
                $em->persist($document);
                $em->flush();
                $this->addFlash('notice', 'Document inséré');
            }
            // return $this->redirectToRoute('new');
        } 
        return $this->render('document/new.html.twig', [
        'form'=>$form->createView()
        ]);
    }

    // /**
    //  * @Route("/new", name="document_new", methods={"GET","POST"})
    //  */
    // public function new(Request $request): Response
    // {
    //     // $document = new Document();
    //     // $form = $this->createForm(DocumentType::class, $document);
    //     // // $form->handleRequest($request);

    //     // if ($form->isSubmitted() && $form->isValid()) {
    //     //     $entityManager = $this->getDoctrine()->getManager();
    //     //     $entityManager->persist($document);
    //     //     $entityManager->flush();

    //     //     return $this->redirectToRoute('document_index', [], Response::HTTP_SEE_OTHER);
    //     // }

    //     // return $this->renderForm('document/new.html.twig', [
    //     //     'document' => $document,
    //     //     'form' => $form,
    //     // ]);
        
    //     $document = new Document();
    //     $form = $this->createForm(DocumentType::class,$document);
       
    //     if ($request->isMethod('POST')) { 
    //         $form->handleRequest($request); 
    //         // $document->setEtatDocument(0);
    //         if ($form->isSubmitted() && $form->isValid()) {
    //                 $file = $form->get('link')->getData();
    //                 // $file = $document->getLink();
    //                 $link = md5(uniqid()).'.'.$file->guessExtension();
    //                 $file->move(
    //                 $this->getParameter(),$link);
    //                 $document->setLink($link);

    //             $em = $this->getDoctrine()->getManager();
    //             $em->persist($document);
    //             $em->flush();
    //             $this->addFlash('notice', 'Document inséré');
    //         }
    //         // return $this->redirectToRoute('document/new');
    //         return $this->renderForm('document/new.html.twig', [
    //                  'document' => $document,
    //                  'form' => $form,
    //              ]);
    //     } 
    //     return $this->render('document/new.html.twig', [
    //     'form'=>$form->createView()
    //     ]);
    // }

    /**
     * @Route("/{id}", name="document_show", methods={"GET"})
     */
    public function show(Document $document): Response
    {
        return $this->render('document/show.html.twig', [
            'document' => $document,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="document_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Document $document): Response
    {
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('document/edit.html.twig', [
            'document' => $document,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="document_delete", methods={"POST"})
     */
    public function delete(Request $request, Document $document): Response
    {
        if ($this->isCsrfTokenValid('delete'.$document->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($document);
            $entityManager->flush();
        }

        return $this->redirectToRoute('document_index', [], Response::HTTP_SEE_OTHER);
    }
}
