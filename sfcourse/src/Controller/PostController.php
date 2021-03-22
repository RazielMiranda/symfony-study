<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\debug;

/**
* @Route("/post", name="post.")
*/
class PostController extends AbstractController
{
    /**
     * @Route("/", name="list")
     */
    public function index(PostRepository $postRepository): Response
    {

        $posts = $postRepository->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {   
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        // $form->getErrors();
        // if ($form->isSubmitted() && $form->isValid()){
        if ($form->isSubmitted()){

            $em = $this->getDoctrine()->getManager();
            /** @var UploadedFile $file */

            $file = $request->files->get('post')['image'];

            if($file){
                $filename = md5(uniqid()) . '.' . $file->guessClientExtension();

                $file->move(
                     $this->getParameter('uploads_dir'),
                     $filename
                );

                $post->setImage($filename);

            }


            $post->setImage($filename);
            $em->persist($post);
            $em->flush();
        }

        return $this->render('post/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/show/{id?}", name="show")
     */
    public function show($id ,PostRepository $postRepository): Response
    {
        $post = $postRepository->find($id);
        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id ,PostRepository $postRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $postRepository->find($id);
        $em->remove($post);
        $em->flush();
        $this->addFlash('delete', 'Post was removed');
        return $this->redirect($this->generateUrl('post.list'));
    }


}
