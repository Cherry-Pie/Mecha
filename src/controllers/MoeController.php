<?php 

namespace Yaro\Mecha;


class MoeController extends \Controller
{

    private fucntion checkAuth() 
    {
        $isAllowed = \Config::get('mecha::auth_check');
        if (\Config::get('mecha::is_auth_by_credentials') && !$isAllowed()) {
            throw new \RuntimeException('Permission denied');
        }
    } // end checkAuth

    public function getFileContents()
    {
        $this->checkAuth();
		
        $file = file_get_contents(base_path() . \Input::get('path'));

        return \Response::json(array(
            'status'  => true,
            'content' => $file,
            'filehash' => md5_file(base_path() . \Input::get('path')),
        ));     
    } // end getFileContents

    public function doSaveFileContents()
    {
        $this->checkAuth();
		
        if (md5_file(base_path() . \Input::get('path')) != \Input::get('filehash')) {
            return \Response::json(array(
                'status' => false,
            ));
        }

        file_put_contents(base_path() . \Input::get('path'), \Input::get('content'));

        return \Response::json(array(
            'status'  => true,
            'filehash' => md5_file(base_path() . \Input::get('path')),
        ));     
    } // end getFileContents

    public function getTreeContents()
    {
        $this->checkAuth();
		
        $root = base_path();
        $post = \Input::all();
        $post['dir'] = urldecode($post['dir']);

        $response = '';
        if (file_exists($root . $post['dir'])) {
            $files = scandir($root . $post['dir']);
            natcasesort($files);

            if (count($files) > 2) { // The 2 accounts for . and .. 
                $response .= "<ul class=\"jqueryFileTree\" style=\"display: none;\">";

                // All dirs
                foreach ($files as $file) {
                    if ($this->isDir($file, $root, $post)) {
                        $response .= "<li class=\"directory collapsed\"><a class='moe-dir-context' href=\"#\" rel=\"" . htmlentities($post['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
                    }
                }

                // All files
                foreach ($files as $file) {
                    if ($this->isFile($file, $root, $post)) {
                        $ext = preg_replace('/^.*\./', '', $file);
                        $response .= "<li class=\"file ext_$ext\"><a class='moe-file-context' href=\"#\" data-type='".$this->getFileTypeByExtension($ext)."' rel=\"" . htmlentities($post['dir'] . $file) . "\">" . htmlentities($file) . "</a></li>";
                    }
                }

                $response .= "</ul>";   
            }
        }

        return $response;
    } // end getTreeContents

    private function isDir($file, $root, $post)
    {
        return $this->hasDirAccess($root, $post['dir'], $file)
                && file_exists($root . $post['dir'] . $file) 
                && $file != '.' 
                && $file != '..' 
                && is_dir($root . $post['dir'] . $file);
    } // end isDir

    private function hasDirAccess($root, $dir, $file)
    {
        $checkDir = \Config::get('mecha::dir_access');

        return $checkDir($root, $dir, $file);
    } // end hasDirAccess

    private function isFile($file, $root, $post)
    {
        return $this->hasFileAccess($root, $post['dir'], $file)
                && file_exists($root . $post['dir'] . $file) 
                && $file != '.' 
                && $file != '..' 
                && !is_dir($root . $post['dir'] . $file);
    } // end isFile

    private function hasFileAccess($root, $dir, $file)
    {
        $checkFile = \Config::get('mecha::file_access');

        return $checkFile($root, $dir, $file);
    } // end hasFileAccess

    private function getFileTypeByExtension($extension)
    {
        return 'php';
    } // end getFileTypeByExtension

    public function doAuthenticate()
    {
        $callback = \Config::get('mecha::auth_callback');

        $data = array(
            'status' => false
        );
        if ($callback(\Input::get('login'), \Input::get('pass'))) {
            $data['status'] = true;
            $data['editor'] = \View::make('mecha::mecha')->render();
        }

        return \Response::json($data);
    } // end doAuth

    public function doMoveFiles()
    {
        $this->checkAuth();

        $root = base_path() . \Input::get('to');
        foreach (\Input::get('files', array()) as $file) {
            $dirs = array_filter(explode('/', $file));
            $name = end($dirs);
            // TODO: errors catching
            rename(base_path() . $file, $root . $name);
        }

        return \Response::json(array(
            'status' => true
        ));
    } // end doMoveFiles

    public function doCopyFiles()
    {
        $this->checkAuth();

        $root = base_path() . \Input::get('to');
        foreach (\Input::get('files', array()) as $file) {
            $dirs = array_filter(explode('/', $file));
            $name = end($dirs);
            // TODO: errors catching
            xcopy(base_path() . $file, $root . $name);
        }

        return \Response::json(array(
            'status' => true
        ));
    } // end doCopyFiles

    public function doRemoveFile()
    {
        $this->checkAuth();
        
        $path = base_path() . \Input::get('path');
        if (is_dir($path)) {
            $root = base_path();
            if (!$this->hasDirAccess($root, \Input::get('path'), false)) {
                throw new RuntimeException("Permission denied");
            }
            $this->doRemoveDirectory($path);
        } else {
            $root = base_path();
            if (!$this->hasFileAccess($root, \Input::get('path'), false)) {
                throw new RuntimeException("Permission denied");
            }
            unlink($path);
        }

        return \Response::json(array(
            'status' => true
        ));
    } // end doRemoveFile

    private function doRemoveDirectory($dir)
    {
        $it = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }

        rmdir($dir);
    } // end doRemoveDirectory
    
    public function doCreateFile() 
    {
        $this->checkAuth();
        
        $root = base_path();
        if (!$this->hasFileAccess($root, \Input::get('to'), \Input::get('file'))) {
            throw new RuntimeException("Permission denied");
        }

    	file_put_contents($root . \Input::get('to') . \Input::get('file'), '');
    	
    	return \Response::json(array(
            'status' => true
        ));
    } // end doCreateFile
    
    public function doCreateDir()
    {
        $this->checkAuth();

        $root = base_path();
        if (!$this->hasDirAccess($root, \Input::get('to'), \Input::get('dir'))) {
            throw new RuntimeException("Permission denied");
        }
        
    	\File::makeDirectory($root . \Input::get('to') . \Input::get('dir'), 0775);
    	
    	return \Response::json(array(
            'status' => true
        ));
    } // end doCreateDir

}
