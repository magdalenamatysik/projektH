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
use AppBundle\Form\addMeet;
use AppBundle\Form\show;


use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $user = new user();
        $form = $this->createForm(login::class, $user);

        $session = new Session();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $userp = $this->getDoctrine()->getRepository('AppBundle:user')
                ->findOneBy( array('login' => $user->getLogin()));
            $session->set('user',  $userp);

               if( password_verify($user->getPassword(),$userp->getPassword())){

                   return $this->redirectToRoute('harmonogram' );
               }

                else return $this->render('default/index.html.twig', array('user'=>$userp, 'user2' =>$user));

        }


        return $this->render('default/login.html.twig',  array('form' => $form->createView()));


        // replace this example code with whatever you need
        // return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/harmonogram", name="harmonogram")
     */
    public function harmonogramAction(Request $request )
    {
        $session = $request->getSession();
        $user = $session->get('user');

        //spradz czy task spradzanie id i flagi (0- task)
        $jobs = $this->getDoctrine()->getRepository('AppBundle:job')->findBy( array('idUser' => $user->getID(), 'flag'=> 0));




        $time = strtotime("last Monday");

        $day=date("d", $time);
        $month=date("m", $time);
        $year =date("Y", $time);
        $data =new \DateTime();


        $days=array();

        for ($i=0; $i<8; $i++){

           if ($day<32) {
               array_push($days, $day,$month);
               $day++;
           }else{
               $day=1;
               $month++;
           }
        }




        $meets = $this->getDoctrine()->getRepository('AppBundle:job')->findBy(array('idUser' => $user->getID(), 'flag'=> 1));

        $mon=array();
        $tue=array();
        $wed=array();
        $thu=array();
        $fri=array();
        $sat=array();
        $sun=array();

      for($i=0; $i<sizeof($meets);$i++){

          if ($meets[$i]->getTimeDay() == $days[0] && $meets[$i]->getTimeMonth() == $days[1]) array_push($mon, $meets[$i]);
          if ($meets[$i]->getTimeDay() == $days[2] && $meets[$i]->getTimeMonth() == $days[3]) array_push($tue, $meets[$i]);
          if ($meets[$i]->getTimeDay() == $days[4] && $meets[$i]->getTimeMonth() == $days[5]) array_push($wed, $meets[$i]);
          if ($meets[$i]->getTimeDay() == $days[6] && $meets[$i]->getTimeMonth() == $days[7]) array_push($thu, $meets[$i]);
          if ($meets[$i]->getTimeDay() == $days[8] && $meets[$i]->getTimeMonth() == $days[9]) array_push($fri, $meets[$i]);
          if ($meets[$i]->getTimeDay() == $days[10] && $meets[$i]->getTimeMonth() == $days[11]) array_push($sat, $meets[$i]);
          if ($meets[$i]->getTimeDay() == $days[12] && $meets[$i]->getTimeMonth() == $days[13]) array_push($sun, $meets[$i]);
    }

        return $this->render('default/harmonogram.html.twig',array('user' => $user, 'days' => $days, 'jobs' => $jobs, 'mon'=>$mon, 'tue'=>$tue, 'wed'=>$wed, 'thu'=>$thu, 'fri'=>$fri, 'sat'=>$sat, 'sun'=>$sun));
    }


    /**
     * @Route("/add", name="add")
     */
    public function addAction(Request $request)
    {
        $job = new job();
        $form = $this->createForm(add_job::class, $job);



        $session = $request->getSession();
        $user = $session->get('user');



        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $job->setIdUser($user->getId());
            $job->setTime2($job->getTime());
            $job->setFlag(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();


             return $this->redirectToRoute('harmonogram');

        }
        return $this->render('default/add_job.html.twig',array('form' => $form->createView(),'user' => $user));
    }


    /**
     * @Route("/addmeet", name="addmeet")
     */
    public function addmeetAction(Request $request)
    {
        $job = new job();
        $form2 = $this->createForm(addMeet::class, $job);



        $session = $request->getSession();
        $user = $session->get('user');


        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {

            $job->setIdUser($user->getId());
            $job->setFlag(1);

            $time2 = new \DateTime($job->getTime3());
            $time2->modify("+ {$job->getDuration()} hour");

            $job->setTime2($time2);

            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();


            return $this->redirectToRoute('harmonogram');

        }
        return $this->render('default/addMeet.html.twig',array('form2' => $form2->createView(),'user' => $user));
    }


    /**
     * @Route("/show/{id}", name="show")
     */
    public function showAction($id, Request $request)
    {
        $job = $this->getDoctrine()->getRepository('AppBundle:job')->find($id);
        $form = $this->createForm(show::class, $job);

        $session = $request->getSession();
        $user = $session->get('user');

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();


            return $this->redirectToRoute('harmonogram');

        }
        return $this->render('default/show.html.twig',array('form' => $form->createView(),'user' => $user , 'jobID' => $job->getID()));
    }


    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteAction($id, Request $request)
    {
        $job = $this->getDoctrine()->getRepository('AppBundle:job')->find($id);

            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($job);
            $em->flush();
            return $this->redirectToRoute('harmonogram');


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


            return $this->redirectToRoute('homepage');
        }

        return $this->render(
            'default/register.html.twig',
            array('form' => $form->createView())
        );

        // replace this example code with whatever you need

    }


}
