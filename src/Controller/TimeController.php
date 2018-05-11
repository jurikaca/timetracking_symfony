<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Time;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TimeController extends Controller
{
    /**
     * function to store time logged information on db
     *
     * @param Request $request, request data
     * @return json
     */
    public function log_time(Request $request, ValidatorInterface $validator)
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: createAction(EntityManagerInterface $em)
        $em = $this->getDoctrine()->getManager();

        $time = new Time();
        $time->setUserId(1);
        $time->setDateFinished(\DateTime::createFromFormat('Y-m-d H:i:s',$request->get('date_finished')));
        $time->setTimeTracked($request->get('seconds'));
        $time->setTimeTrackedFormatted(\DateTime::createFromFormat('H:i:s', $request->get('time_tracked_formatted')));
        $time->setDescription($request->get('description'));

        $errors = $validator->validate($time); // validate inputs

        if (count($errors) > 0) { // if validation is not valid
            $response = new Response($errors);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }

        $em->persist($time);// tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->flush();// actually executes the queries (i.e. the INSERT query)

        $response = new Response(json_encode([
            'success'   =>  true,
            'msg'       =>  'Time was successfully logged.'
        ]));
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * function to filter time logged records
     *
     * @return json
     */
    public function get_time(Request $request)
    {
        $response = new Response(json_encode([
            "data"          => $this->getDoctrine()->getRepository(Time::class)->filter($request),
            "items_length"  => $this->getDoctrine()->getRepository(Time::class)->filter($request, true)
        ]));
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
}