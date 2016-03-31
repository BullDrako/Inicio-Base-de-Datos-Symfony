<?php
/**
 * Created by PhpStorm.
 * User: edgar
 * Date: 10/11/15
 * Time: 17:33
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class UserController extends Controller
{

    /**
     *
     * @Route(
     *          path="/user",
     *          name="app_user_index"
     * )
     *
     * @return mixed
     */
    public function indexAction()
    {

        //crear usuario

       $m =  $this->getDoctrine()->getManager();



        $user1 = new User();
        $user1->setEmail('user1@email.com');
        $user1->setPassword('1234');

        $m->persist($user1);// persist esto va a ir a la base de datos

        $m->flush();


        $user2 = new User();
        $user2->setEmail('user2@email.com');
        $user2->setPassword('1234');

        $m->persist($user2);// persist esto va a ir a la base de datos

        $m->flush();



        //recuperar usuario de la base de datos

       $repository = $m->getRepository('AppBundle:User');

        /**
         * @var User $user
         */

       // $user = $repository->findOneByUsername('user2');


        //modificar usuario

      //  $user->setEmail('nuevo@email.com'); // persist no hace falta porque ya viene de la base de datos


        //borrar usuario

       //$m->remove($user1);


      // $m->flush();


        // recuperar varios usuarios

       $users = $repository->findAll();

        //$m->flush();


       return $this->render(':user:index.html.twig', ['users' => $users]);

        //return $this->render('');
    }

    /**
     * updateAction
     *
     * @Route( path="/update/{id}",
     *          name="app_user_update"
     * )
     */

    public function updateAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:User');

        $user = $repository->find($id);

        //var_dump($user);die; //mostar contenido de una variable

        return $this->render(':user:update.html.twig',
            [
                'user' => $user,
            ]);
    }

    /**
     * @Route(
     *          path="/do-update",
     *          name="app_user_doUpdate"
     * )
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function doUpdateAction(Request $request)
    {
        $m          = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:User');

        $id         = $request->request->get('id');
        $email      = $request->request->get('email');
        $password   = $request->request->get('password');


        $user = $repository->find($id);

        $user->setEmail($email);
        $user->setPassword($password);

        $m->flush();

        $this->addFlash('messages', 'New user updated');

        return $this->redirectToRoute('app_user_index');
    }

    /**
     * @Route(
     *      path="/insert",
     *      name="app_user_insert"
     * )
     */
    public function insertAction()
    {
        return $this->render(':user:insert.html.twig');
    }

    /**
     * @Route(
     *         path="/do-insert",
     *         name="app_user_doInsert"
     * )
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function doInsertAction(Request $request)
    {
        $user = new User();

        $user->setEmail($request->request->get('email'));
        $user->setPassword($request->request->get('password'));

        $m = $this->getDoctrine()->getManager();
        $m->persist($user); //va a quedar en la base de datos
        $m->flush();

        $this->addFlash('messages', 'New user created');

        return $this->redirectToRoute('app_user_index');
    }

    /**
     * @Route(
     *      path="/remove/{id}",
     *      name="app_user_remove"
     * )
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:User');

        $user = $repository->find($id);


        $m->remove($user);
        $m->flush();

        $this->addFlash('messages', 'User has been removed');

        return $this->redirectToRoute('app_user_index');

    }
}
//producto entidad

//id nombre descripcion precio si esta disponible o no fechac reacion fecha modificacion