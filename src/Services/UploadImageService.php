<?php 

namespace App\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;

class UploadImageService {

    public function __construct(
        private Filesystem $fs,
        private string $profilFolder,
        private string $profilFolderPublic
        )
    {
        
    }

    public function uploadProfileImage($picture, $oldPicture = null)
    {
        $ext = $picture->guessExtension() ?? 'bin';
        $filename = bin2hex(random_bytes(10)) . "." . $ext;
        $picture->move($this->profilFolder, $filename);
        if($oldPicture) {
            $this->fs->remove($this->profilFolder . "/" . pathinfo($oldPicture, PATHINFO_BASENAME));
        }

        return $this->profilFolderPublic . "." . $filename;

    }
}

?>