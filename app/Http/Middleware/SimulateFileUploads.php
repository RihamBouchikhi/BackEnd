<?php

namespace App\Http\Middleware;

use Closure;

class SimulateFileUploads
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Remplacer les chemins de fichier par des fichiers temporaires
        $requestData = $request->all();
        $requestData['CV'] = $this->createTempFile('cv.pdf');
        $requestData['demande-stage'] = $this->createTempFile('demande_stage.pdf');

        // Mettre à jour la requête avec les fichiers temporaires
        $request->replace($requestData);

        return $next($request);
    }

    /**
     * Créer un fichier temporaire avec des données de test.
     *
     * @param string $fileName
     * @return string Chemin du fichier temporaire
     */
    private function createTempFile($fileName)
    {
        // Créer un fichier temporaire avec des données de test
        $tempFilePath = storage_path('app/temp/' . $fileName);
        file_put_contents($tempFilePath, 'Contenu du fichier de test');

        return $tempFilePath;
    }
}
