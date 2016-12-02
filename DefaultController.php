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
		$time = strtotime("last Monday");
		$time2 = new \DateTime (date("Y-m-d",$time));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $userp = $this->getDoctrine()->getRepository('AppBundle:user')
                ->findOneBy( array('login' => $user->getLogin()));
            $session->set('user',  $userp);
			$session->set('mon', $time2);

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


		$time= $session->get('mon');
		
        
        $day= $time->format('d');
        $month=$time->format('m');
		//$day = 7;
		

        $days=array();

        for ($i=0; $i<8; $i++){

            if ($day<31) {
                array_push($days, $day,$month);
                $day++;
            }else{
                $day=1;
                $month++;
            }
        }


        $a=array();

        $meets = $this->getDoctrine()->getRepository('AppBundle:job')->findBy(array('idUser' => $user->getID(), 'flag'=> array(1 , 2)));

        usort($meets, function($a, $b) {
            return strtotime($a->getTime()->format('Y-m-d G:i') ) < strtotime($b->getTime()->format('Y-m-d G:i'));
        });



        for ($i=0; $i<sizeof($meets)-1; $i++){
			$job = new job();
			array_push($a, array($meets[$i]->getTime()->format('d'),$meets[$i], $meets[$i]->getFlag() ,$meets[$i]->getTime()->format('m')));

               if($meets[$i]->getTime()->format('d')==$meets[$i+1]->getTime()->format('d')) {
				   
					$r =$meets[$i]->getTime()->format('G')-$meets[$i+1]->getTime2()->format('G');
					
					$job->setDuration($r);
					
					array_push($a, array($meets[$i]->getTime()->format('d'),$job, -1,$meets[$i]->getTime()->format('m')));
			   }
            else{
					$r =$meets[$i]->getTime()->format('G');
					
					$job->setDuration($r);
					array_push($a, array($meets[$i]->getTime()->format('d'),$job, -1 , $meets[$i]->getTime()->format('m')));
            }

           
        }

	
		


        return $this->render('default/harmonogram.html.twig',array('user' => $user, 'days' => $days, 'jobs' => $jobs, 'meets'=>$meets, 'data'=> $a, 'test'=> $i));
    }


    /**
     * @Route("/add", name="add")
     */
    public function addAction(Request $request)
    {
		
			return $this->render('default/add_job.html.twig');
    }

	
	
	 /**
     * @Route("/harm/{week}", name="harm")
     */
    public function harmAction(Request $request, $week)
    {
		$session = $request->getSession();
        $user = $session->get('user');


		$time= $session->get('mon');
		
		$time->modify(" {$week} week");
		
		$session->set('mon', $time);
		
		
        $day= $time->format('d');
        $month=$time->format('m');
		

        $days=array();

        for ($i=0; $i<8; $i++){

            if ($day<31) {
                array_push($days, $day, $month);
                $day++;
            }else{
                $day=1;
                $month++;
            }
        }


        $a=array();

       $meets = $this->getDoctrine()->getRepository('AppBundle:job')->findBy(array('idUser' => $user->getID(), 'flag'=> array(1 , 2)));

        usort($meets, function($a, $b) {
            return strtotime($a->getTime()->format('Y-m-d G:i') ) < strtotime($b->getTime()->format('Y-m-d G:i'));
        });



        for ($i=0; $i<sizeof($meets)-1; $i++){
			$job = new job();
			array_push($a, array($meets[$i]->getTime()->format('d'),$meets[$i], $meets[$i]->getFlag() ,$meets[$i]->getTime()->format('m')));

               if($meets[$i]->getTime()->format('d')==$meets[$i+1]->getTime()->format('d')) {
				   
					$r =$meets[$i]->getTime()->format('G')-$meets[$i+1]->getTime2()->format('G');
					
					$job->setDuration($r);
					
					array_push($a, array($meets[$i]->getTime()->format('d'),$job, -1,$meets[$i]->getTime()->format('m')));
			   }
            else{
					$r =$meets[$i]->getTime()->format('G');
					
					$job->setDuration($r);
					array_push($a, array($meets[$i]->getTime()->format('d'),$job, -1 , $meets[$i]->getTime()->format('m')));
            }
           
        }


        return $this->render('default/days.html.twig',array('user' => $user, 'days' => $days,   'data'=> $a));
    
		
		
        
    }
	
	/**
     * @Route("/return/{id}", name="return")
     */
    public function returnAction(Request $request,  $id)
    {
		$session = $request->getSession();
        $user = $session->get('user');
		
		$job = $this->getDoctrine()->getRepository('AppBundle:job')->findOneBy( array('idUser' => $user->getID(), 'id'=> $id));
		$job->setFlag(0);
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($job);
		$em->flush();
		
		//$jobs = $this->getDoctrine()->getRepository('AppBundle:job')->findBy( array('idUser' => $user->getID(), 'flag'=> 0));

		 return $this->redirectToRoute('harmonogram');

			
		//return $this->render('default/jobList.html.twig',array('user' => $user, 'jobs' => $jobs));
  
		
	}
	/**
     * @Route("/test/{y}/{x}/{id}", name="test")
     */
    public function testAction(Request $request, $y, $x, $id)
    {
		$session = $request->getSession();
        $user = $session->get('user');
		
		$job = $this->getDoctrine()->getRepository('AppBundle:job')->findOneBy( array('idUser' => $user->getID(), 'id'=> $id));

		
		$time= $session->get('mon');

        $day= $time->format('d');
        $month=$time->format('m');
		$year =$time->format('Y');
		
		
		if ($x>70 && $x<250){
			$data = new \DateTime();
			$data->setDate($year,$month,$day);
			$data->setTime($y/20,0);
			$job->setTime($data);
			$time2 = new \DateTime($job->getTime3());
            $time2->modify("+ {$job->getDuration()} hour");

            $job->setTime2($time2);
			
			$job->setFlag(2);	
		}
		if ($x>255 && $x<435){
			$data = new \DateTime();
			$data->setDate($year,$month,$day+1);
			$data->setTime($y/20,0);
			$job->setTime($data);
			
			$time2 = new \DateTime($job->getTime3());
            $time2->modify("+ {$job->getDuration()} hour");

            $job->setTime2($time2);
		
			$job->setFlag(2);	
		}
		
		if ($x>440 && $x<620){
			$data = new \DateTime();
			$data->setDate($year,$month,$day+2);
			$data->setTime($y/20,0);
			$job->setTime($data);
			
			$time2 = new \DateTime($job->getTime3());
            $time2->modify("+ {$job->getDuration()} hour");

            $job->setTime2($time2);
		
			$job->setFlag(2);	
		}
		
		if ($x>625 && $x<805){
			$data = new \DateTime();
			$data->setDate($year,$month,$day+3);
			$data->setTime($y/20,0);
			$job->setTime($data);
			
			$time2 = new \DateTime($job->getTime3());
            $time2->modify("+ {$job->getDuration()} hour");

            $job->setTime2($time2);
		
			$job->setFlag(2);	
		}
		if ($x>810 && $x<990){
			$data = new \DateTime();
			$data->setDate($year,$month,$day+4);
			$data->setTime($y/20,0);
			$job->setTime($data);
			
			$time2 = new \DateTime($job->getTime3());
            $time2->modify("+ {$job->getDuration()} hour");

            $job->setTime2($time2);
		
			$job->setFlag(2);	
		}
		
		if ($x>995 && $x<1175){
			$data = new \DateTime();
			$data->setDate($year,$month,$day+5);
			$data->setTime($y/20,0);
			$job->setTime($data);
			
			$time2 = new \DateTime($job->getTime3());
            $time2->modify("+ {$job->getDuration()} hour");

            $job->setTime2($time2);
		
			$job->setFlag(2);	
		}
		
		if ($x>1175 && $x<1360){
			$data = new \DateTime();
			$data->setDate($year,$month,$day+6);
			$data->setTime($y/20,0);
			$job->setTime($data);
			
			$time2 = new \DateTime($job->getTime3());
            $time2->modify("+ {$job->getDuration()} hour");

            $job->setTime2($time2);
		
			$job->setFlag(2);	
		}
		
			$em = $this->getDoctrine()->getManager();
			$em->persist($job);
			$em->flush();
		return $this->redirectToRoute('harmonogram');
			
    }

	
	
    /**
     * @Route("/addAccept", name="addAccept")
     */
    public function addAcceptAction(Request $request)
    {

       if(isset($_POST['name'])){
           $job = new job();
           $session = $request->getSession();
           $user = $session->get('user');

           $job->setIdUser($user->getId());

           $s= $_POST['deadline'];
           $data = new \DateTime($s);

           $job->setTime($data);
           $job->setDescription($_POST['description']);
           $job->setName($_POST['name']);
           $job->setDuration(intval($_POST['duration']));

           $job->setTime2($job->getTime());
           $job->setFlag(0);

           $em = $this->getDoctrine()->getManager();
           $em->persist($job);
           $em->flush();

           echo "sie".$_POST['deadline'];
           return $this->redirectToRoute('harmonogram');
       }

        return $this->redirectToRoute('harmonogram');


    }

  /**
     * @Route("/addAcceptMeet", name="addAcceptMeet")
     */
    public function addAcceptMeetAction(Request $request)
    {

       if(isset($_POST['name'])){
           $job = new job();
           $session = $request->getSession();
           $user = $session->get('user');

           $job->setIdUser($user->getId());
		   
           $s= $_POST['deadline'];
           $data = new \DateTime($s);
			$job->setName($_POST['name']);
			$job->setDescription($_POST['description']);
			$job->setFlag(1);
			$em = $this->getDoctrine()->getManager();
			
			$job->setTime($data);
			$job->setDuration(intval($_POST['duration']));
			$job->setTime2($job->getTime());
			
			$em->persist($job);
			$em->flush();
			$em->clear();
			$r='s';
			if (isset($_POST['regular'])) $r=$_POST['regular'];
		  
		   if ($r == 'reg'){
			   for ($i=0; $i <5 ; $i++){
				   
				   $job2= new job();
				   $job2= $job;
				   
					$data->modify("+ 1 week");
					$job2->setTime($data);
					$job2->setTime2($job2->getTime());
					
					
					$em->persist($job2);
					$em->flush();
					$em->clear();
				   
			   }
			   
		   }		
					
				

				
				

           echo "sie".$_POST['deadline'];
           return $this->redirectToRoute('harmonogram');
       }

        return $this->redirectToRoute('harmonogram');


    }

	
    /**
     * @Route("/addmeet", name="addmeet")
     */
    public function addmeetAction(Request $request)
    {
       
        
        return $this->render('default/addMeet.html.twig');
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
            if($job->getFlag()==1){
                $time2 = new \DateTime($job->getTime3());
                $time2->modify("+ {$job->getDuration()} hour");

                $job->setTime2($time2);
            }
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
