<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use AppBundle\Entity\user;
use AppBundle\Entity\job;
use AppBundle\Entity\Relation;
use AppBundle\Entity\fridge;
use AppBundle\Entity\recipe;
use AppBundle\Entity\ingredients;
use AppBundle\Entity\RecipeHasIng;

use AppBundle\Form\UserType;
use AppBundle\Form\login;
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
		$time = strtotime("now");
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

       
        $jobs = $this->getDoctrine()->getRepository('AppBundle:job')->findBy( array('idUser' => $user->getID(), 'flag'=> 0));
	
		$time= $session->get('mon');
		
        
        $day= $time->format('d');
        $month=$time->format('m');
		

        $days=array();

        for ($i=0; $i<8; $i++){

            if ($day<32) {
                array_push($days, $day.".".$month);
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
			$r = $meets[$i]->getTime()->format('G')*20+$meets[$i]->getTime()->format('m');
			array_push($a, array($meets[$i]->getTime()->format('d'),$meets[$i], $meets[$i]->getFlag() ,$meets[$i]->getTime()->format('m'), $r));

           
        }

	
		


        return $this->render('default/harmonogram.html.twig',array('user' => $user, 'days' => $days, 'jobs' => $jobs, 'meets'=>$meets, 'data'=> $a, 'test'=> $i));
    }


	/**
     * @Route("/harmonogram/logout", name="logout")
     */
    public function logOutAction(Request $request )
    {
		$request->getSession()->clear();
		
		return $this->redirectToRoute('homepage' );
		
	}
	
	
    /**
     * @Route("/add", name="add")
     */
    public function addAction(Request $request)
    {
		
			return $this->render('default/add_job.html.twig');
    }


	/**
     * @Route("/addRecipe", name="addRecipe")
     */
    public function addRecipeAction(Request $request)
    {
		
			return $this->render('default/addRecipe.html.twig');
    }
	
	/**
     * @Route("/recipe", name="recipe")
     */
    public function recipeAction(Request $request)
    {
		$session = $request->getSession();
        $user = $session->get('user');
		
		$file_get = $_FILES['foto']['name'];
		$temp = $_FILES['foto']['tmp_name'];
		
		$file_to_saved = "C:/fotoo/".$file_get; 
		move_uploaded_file($temp, $file_to_saved);

		$recipe = new recipe();
			$recipe->setName($_POST['name']);
			$recipe->setDuration($_POST['duration']);
			$recipe->setPerson($_POST['person']);
			$recipe->setFlag(0);
			$recipe->setFoto($file_to_saved);
			$recipe->setIdFridge($user->getidFridge());
		
		$em = $this->getDoctrine()->getManager();
        $em->persist($recipe);
        $em->flush();
		

		return $this->render('default/addIngrydients.html.twig',array('user' => $user,  'name' => $_POST['name']));
	}
	
	/**
     * @Route("/fetch", name="fetch")
     */
    public function fetchAction(Request $request)
    {
	
		$session = $request->getSession();
        $user = $session->get('user');
		
		
		$output = '';
			if(isset( $_POST["query"])) {
				$text = $_POST["query"];
				$output = $this->getDoctrine()->getRepository('AppBundle:ingredients')->createQueryBuilder('i')
					->where('i.name LIKE :name')
					->setParameter('name',"%".$text."%")
					->getQuery()->getResult();
			} else {
				$output = $this->getDoctrine()->getRepository('AppBundle:ingredients')
					->findAll();
			}
			
		return $this->render('default/Ingrydients.html.twig', array('Ingrydients' => $output));
	}
	
	/**
     * @Route("/inggg", name="ingg")
     */
    public function inggAction(Request $request)
    {
		$session = $request->getSession();
        $user = $session->get('user');
		
		
		
		return $this->render('default/addIngrydients.html.twig',array('user' => $user));
	}
	/**
     * @Route("/addingRecipe", name="addingRecipe")
     */
    public function addingRecipeAction(Request $request)
    {
			if(isset( $_POST["query"])) {
				$ing = explode(" ", $_POST["query"]);
				echo $_POST["query"];
				
				echo "pp";
					
				$rhi = new RecipeHasIng();
				
				
				$recipe = $this->getDoctrine()->getRepository('AppBundle:recipe')->findOneBy(array('name' => $ing[1]));
				
				$rhi->setIdRecipe($recipe->getId());
				echo $recipe->getId();
				
				
				
				$em = $this->getDoctrine()->getManager();
				$count = count($ing);
				
				for($i=2; $i<$count-1; $i=$i+2){
					

						$rhi->setIdIng($ing[$i]);
						$rhi->setAmount($ing[$i+1]);
						
					//	echo $ing[$i];
						
						$em->persist($rhi);
						$em->flush();
						$em->clear();
				}
				
				
				
			}
		
		
		
			return  $this->redirectToRoute('harmonogram');
	}
	
	 /**
     * @Route("/food", name="food")
     */
    public function foodAction(Request $request)
    {
		$session = $request->getSession();
        $user = $session->get('user');
		
		
		if ($user->getidFridge()==0)	return $this->render('default/food.html.twig');
		else {
			
				
				return $this->render('default/fridge.html.twig');
			
			
		}
    }

	
	
	/**
     * @Route("/newFridge", name="newFridge")
     */
    public function newFridge(Request $request)
    {
		$session = $request->getSession();
        $user = $session->get('user');
		
		$user = $this->getDoctrine()->getRepository('AppBundle:user')->findOneBy(array('id' => $user->getID()));
		 
		
		$fridge = new fridge();
		$fridge->setIdOwner($user->getID());
		
		  $em = $this->getDoctrine()->getManager();
          $em->persist($fridge);
          $em->flush();
		  
		  $f = $this->getDoctrine()->getRepository('AppBundle:fridge')->findOneBy(array('idOwner' => $user->getID()));
		 
		  
		$user->setidFridge($f->getId());
		
		 $em->persist($user);
         $em->flush();
		 
		 
		$session->set('user',$user);
		
		if ($user->getidFridge()==0)	return $this->render('default/food.html.twig');
		else return $this->redirectToRoute('harmonogram');
    }

	
	
	
	 /**
     * @Route("/harm/{week}", name="harm")
     */
    public function harmAction(Request $request, $week)
    {
		$session = $request->getSession();
        $user = $session->get('user');


		$time= $session->get('mon');
		
		$time->modify(" {$week} day");
		
		$session->set('mon', $time);
		
		
        $day= $time->format('d');
        $month=$time->format('m');
		

        $days=array();

        for ($i=0; $i<8; $i++){

            if ($day<31) {
                array_push($days, $day.".".$month);
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
			$r = $meets[$i]->getTime()->format('G')*20+$meets[$i]->getTime()->format('m');
			array_push($a, array($meets[$i]->getTime()->format('d'),$meets[$i], $meets[$i]->getFlag() ,$meets[$i]->getTime()->format('m'), $r));

           
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
		
		
		$day_array = explode(".",$x);
		
			$data = new \DateTime();
			$data->setDate($year,$day_array[1],$day_array[0]);
			$data->setTime($y/20,0);
			
			$job->setTime($data);
			
			$time2 = new \DateTime($job->getTime3());
            $time2->modify("+ {$job->getDuration()} hour");

            $job->setTime2($time2);
			
			$job->setFlag(2);	
		
		
		
			$em = $this->getDoctrine()->getManager();
			$id = $em->persist($job);
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
     * @Route("/findFriend", name="findFriend")
     */
    public function findFriendAction(Request $request)
    {

       if(isset($_POST['name'])){
           $userFriend = new user();
           $session = $request->getSession();
           $user = $session->get('user');

		   $userFriendName = $_POST['name'];
		   
           $friend = $this->getDoctrine()->getRepository('AppBundle:user')->findBy(array('login' => $userFriendName));
	   }
	   
	   
       $session = $request->getSession();
       $user = $session->get('user');
	   
	   //$friend = $this->getDoctrine()->getRepository('AppBundle:user')->findAll();
        
       return $this->render('default/friendFind.html.twig',array('user' => $user, 'friend' =>$friend));


    }
	
	
	/**
     * @Route("/findedFriend", name="findedFriend")
     */
    public function findedFriendAction(Request $request)
    {

       if(isset($_POST['name'])){
           $userFriend = new user();
           $session = $request->getSession();
           $user = $session->get('user');

		   $userFriendName = $_POST['name'];
		   
           $friend = $this->getDoctrine()->getRepository('AppBundle:user')->findBy(array('login' => $userFriendName));
	   }
        return $this->redirectToRoute('friend');


    }

	/**
     * @Route("/addFriend/{login}", name="addFriend")
     */
    public function addFriendAction(Request $request, $login)
    {

			$relation = new relation();
          
           $session = $request->getSession();
           $user = $session->get('user');

			$em = $this->getDoctrine()->getManager();
		   
           $friend = $this->getDoctrine()->getRepository('AppBundle:user')->findOneBy(array('login' => $login));
		   $relation->setIdUser2($friend->getID());
		   $relation->setIdUser($user->getID());
		   $relation->setAccept(0);
		   
					$em->persist($relation);
					$em->flush();
					$em->clear();
	   
        return $this->redirectToRoute('friend');


    }

	
	
	/**
     * @Route("/acceptFriend/{id}", name="acceptFriend")
     */
    public function acceptFriend(Request $request, $id)
    {

		
          
           $session = $request->getSession();
           $user = $session->get('user');
			$myID= $user->getID();
			$em = $this->getDoctrine()->getManager();
		   
           $query =$em->createQuery(
			'SELECT r
			FROM AppBundle:User user
			JOIN AppBundle:Relation r
			WHERE r.idUser = :DD AND r.idUser2 = :my
			AND r.idUser2=user.id 
			OR r.idUser2 = :DD AND r.idUser = :my
			AND r.idUser=user.id '
			)->setParameter('DD', $id)->setParameter('my', $myID);
			
			$relation = $query->getSingleResult();
	   
			
		  
		   $relation->setAccept(1);
		   
					$em->persist($relation);
					$em->flush();
					$em->clear();
	   
        return $this->redirectToRoute('friend');


    }

	
    /**
     * @Route("/addmeet", name="addmeet")
     */
    public function addmeetAction(Request $request)
    {
       
        
        return $this->render('default/addMeet.html.twig');
    }

	 /**
     * @Route("/friend", name="friend")
     */
    public function friendAction(Request $request)
    {
       $session = $request->getSession();
       $user = $session->get('user');
	   
	  // $friends = $this->getDoctrine()->getRepository('AppBundle:Relation')->findBy(array('idUser' => $user->getId(),'idUser2' => $user->getId()));
       
	   
	   $em = $this->getDoctrine()->getManager();
	   $query =$em->createQuery(
			'SELECT user.login, user.id, r.accept
			FROM AppBundle:User user
			JOIN AppBundle:Relation r
			WHERE r.idUser = :DD
			AND r.idUser2=user.id 
			OR r.idUser2 = :DD
			AND r.idUser=user.id '
			)->setParameter('DD', $user->getId());
	   
	   $friends = $query->getResult();
	   
	   
       return $this->render('default/friend.html.twig',array('user' => $user, 'friends' => $friends));
    }
	
	 /**
     * @Route("/findTask", name="findTask")
     */
    public function findTaskAction(Request $request)
    {
		$session = $request->getSession();
        $user = $session->get('user');

   
        $jobs = $this->getDoctrine()->getRepository('AppBundle:job')->findBy( array('idUser' => $user->getID(), 'flag'=> 0));
		return $this->render('default/Task.html.twig',array('user' => $user, 'jobs' => $jobs));
		
	}
	
	
	 /**
     * @Route("/send/{fID}/{jID}", name="send")
     */
    public function sendAction($fID, $jID, Request $request)
    {
		$session = $request->getSession();
        $user = $session->get('user');
		$rr = $_POST['description'];
		
        $job = $this->getDoctrine()->getRepository('AppBundle:job')->findOneBy( array('idUser' => $user->getID(), 'id'=> $jID));
		$job->setIdUser($fID);
		
		$em = $this->getDoctrine()->getManager();
		
					$em->persist($job);
					$em->flush();
					$em->clear();
		
		return $this->render('default/Task.html.twig',array('user' => $user, 'jobs' => $job));
		
	}
	
	
	/**
     * @Route("/showAccept/{id}", name="showA")
     */
    public function showAction($id, Request $request)
    {
		
		$job = $this->getDoctrine()->getRepository('AppBundle:job')->find($id);
      
		$data = $job->getTime()->format('Y-m-d H:i:s');
		
		return $this->render('default/show.html.twig',array('name' => $job->getName(),'description'=>$job->getDescription(), 'duration'=>$job->getDuration(), 'data' => $data , 'id' => $id));
    
	}
    /**
     * @Route("/show/{id}", name="show")
     */
    public function showAcceptAction($id, Request $request)
    {
		$job = $this->getDoctrine()->getRepository('AppBundle:job')->find($id);
      
        if(isset($_POST['name'])){
           
           $session = $request->getSession();
           $user = $session->get('user');

           $s= $_POST['deadline'];
           $data = new \DateTime($s);
		   $job->setName($_POST['name']);
			$job->setDescription($_POST['description']);
			
			$em = $this->getDoctrine()->getManager();
			
			$job->setTime($data);
			$job->setDuration(intval($_POST['duration']));
			$job->setTime2($job->getTime());
		
			
				$em->persist($job);
				$em->flush();
				$em->clear();
			
					
				
		}
				
				

           echo "sie".$_POST['deadline'];
           return $this->redirectToRoute('harmonogram');
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
