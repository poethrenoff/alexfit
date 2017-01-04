<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use AppBundle\Lib\Transliterator;

class UploadController extends Controller
{
    /**
     * @Route("/admin/upload", name="upload")
     */
    public function indexAction(Request $request)
    {
        $CKEditorFuncNum = $request->query->get('CKEditorFuncNum');
        
        $file = $request->files->get('upload');
        if (!$file) {
            return $this->render('AppBundle:Admin:upload.html.twig', array(
                'CKEditorFuncNum' => $CKEditorFuncNum,
                'errorMessage' => 'Отсутствует файл для закачки!'
            ));
        }
        
        $uploadDirectory = $this->container->getParameter('upload_directory');
        $uploadAlias = $this->container->getParameter('upload_alias');
        
        $fileName = Transliterator::transliterate($file->getClientOriginalName());
        
        try {
            $file->move($uploadDirectory, $fileName);
        } catch (FileException $e) {
            return $this->render('AppBundle:Admin:upload.html.twig', array(
                'CKEditorFuncNum' => $CKEditorFuncNum,
                'errorMessage' => 'Ошибка при загрузке файла!'
            ));
        }
        
        return $this->render('AppBundle:Admin:upload.html.twig', array(
            'CKEditorFuncNum' => $CKEditorFuncNum,
            'filePath' => $uploadAlias . $fileName
        ));
    }
}
