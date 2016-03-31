<?php
/**
 * Created by PhpStorm.
 * User: edgar
 * Date: 12/11/15
 * Time: 20:03
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Producto;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductoController extends Controller
{
    /**
     * @Route(
     *          path="/producto",
     *          name="app_producto_index"
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */


    public function indexAction()
    {
        $m = $this->getDoctrine()->getManager();

       /* $producto1 = new Producto();
        $producto1->setNombre('aceite');
        $producto1->setDescripcion('aceite de oliva');
        $producto1->setPrecio('2');
        $producto1->setDisponible('SI');


        $m->persist($producto1);

        $m->flush();


        $producto2 = new Producto();
        $producto2->setNombre('vinagre');
        $producto2->setDescripcion('vinagre de modena');
        $producto2->setPrecio('3');
        $producto2->setDisponible('SI');

        $m->persist($producto2);

        $m->flush();
*/

        $repository = $m->getRepository('AppBundle:Producto');

        $productos = $repository->findAll();

       return $this->render(':producto:index.html.twig', ['productos' => $productos]);


    }

    /**
     * @Route(
     *          path="/insertar",
     *         name="app_producto_insertar"
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function insertarAction()
    {
        return $this->render(':producto:insertar.html.twig');
    }

    /**
     * @Route(
     *         path="/do-insertar",
     *         name="app_producto_doInsertar"
     * )
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function doInsertarAction(Request $request)
    {
        $producto = new Producto();

        $producto->setNombre($request->request->get('nombre'));
        $producto->setDescripcion($request->request->get('descripcion'));
        $producto->setPrecio($request->request->get('precio'));
        $producto->setDisponible($request->request->get('disponible'));

        $m = $this->getDoctrine()->getManager();
        $m->persist($producto); //va a quedar en la base de datos
        $m->flush();

        $this->addFlash('messages', 'Nuevo producto creado');

        return $this->redirectToRoute('app_producto_index');
    }

    /**
     *
     * @Route(
     *          path="/actualizar/{id}",
     *          name="app_producto_actualizar")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function actualizarAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Producto');

        $producto = $repository->find($id);

        //var_dump($user);die; //mostar contenido de una variable

        return $this->render(':producto:actualizar.html.twig',
            [
                'producto' => $producto,
            ]);
    }

    /**
     * @Route(
     *          path="/do-actualizar",
     *          name="app_producto_doActualizar")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */

    public function doActualizarAction(Request $request)
    {
        $m          = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Producto');

        $id             = $request->request->get('id');
        $nombre         = $request->request->get('nombre');
        $descripcion    = $request->request->get('descripcion');
        $precio         = $request->request->get('precio');
        $disponible     = $request->request->get('disponible');


        $producto = $repository->find($id);

        $producto->setNombre($nombre);
        $producto->setDescripcion($descripcion);
        $producto->setPrecio($precio);
        $producto->setDisponible($disponible);


        $m->flush();

        $this->addFlash('messages', 'Nuevo producto actualizado');

        return $this->redirectToRoute('app_producto_index');
    }

    /**
     * @Route(
     *          path="/eliminar/{id}",
     *          name="app_producto_eliminar"
     * )
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */

    public function eliminarAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Producto');

        $producto = $repository->find($id);


        $m->remove($producto);
        $m->flush();

        $this->addFlash('messages', 'Producto ha sido eliminado');

        return $this->redirectToRoute('app_producto_index');

    }


}

