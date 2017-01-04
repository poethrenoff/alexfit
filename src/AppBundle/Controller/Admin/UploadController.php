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
            return $this->getResponse($CKEditorFuncNum, '', 'Отсутствует файл для закачки!');
        }
        
        $uploadDirectory = $this->container->getParameter('upload_directory');
        $uploadAlias = $this->container->getParameter('upload_alias');
        
        $newFileName = Transliterator::transliterate($file->getClientOriginalName());
        
        try {
            $file->move($uploadDirectory, $newFileName);
        } catch (FileException $e) {
            return $this->getResponse($CKEditorFuncNum, '', 'Ошибка при загрузке файла!');
        }
        
        return $this->getResponse($CKEditorFuncNum, $uploadAlias . $newFileName);
    }
    
    public function getResponse($CKEditorFuncNum, $filePath = '', $errorMessage = '')
    {
        return new Response(<<<HTML
<script type='text/javascript'>
     window.parent.CKEDITOR.tools.callFunction('{$CKEditorFuncNum}', '{$filePath}', '{$errorMessage}');
</script>
HTML
        );
    }
}
