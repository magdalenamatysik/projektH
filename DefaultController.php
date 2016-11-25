<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\UserType;
use AppBundle\Form\login;
use AppBundle\Entity\user;
use AppBundle\Entity\job;
use AppBundle\Form\add_job;
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $user = new user();
        $form = $this->createForm(login::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $userp = $this->getDoctrine()->getRepository('AppBundle:user')
                ->findOneBy( array('login' => $user->getLogin()));


               if( password_verify($user->getPassword(),$userp->getPassword())){

                   return $this->render('default/harmonogram.html.twig', array('user'=>$userp));
               }

                else return $this->render('default/index.html.twig', array('user'=>$userp, 'user2' =>$user));




        }


        return $this->render('default/login.html.twig',  array('form' => $form->createView()));


        // replace this example code with whatever you need
   //     return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/harmonogram", name="harmonogram")
     */
    public function harmonogramAction( $user )
    {

        return $this->render('default/harmonogram.html.twig',array('user' =>$user));


    }


    /**
     * @Route("/add/{id}", name="add")
     */
    public function addAction($id ,Request $request)
    {
        $job = new job();
        $form = $this->createForm(add_job::class, $job);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $job->setIdUser($id);
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            //$user = $em->getRepository(user::class)->find($id);
            //return  $this->render('default/harmonogram.html.twig',array('user' =>$user));


        }
        return $this->render('default/add_job.html.twig',array('form' => $form->createView()));
    }





    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        $user = new user();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();


            return $this->render('default/sukcess.html.twig');
        }

        return $this->render(
            'default/register.html.twig',
            array('form' => $form->createView())
        );

        // replace this example code with whatever you need

    }


}
