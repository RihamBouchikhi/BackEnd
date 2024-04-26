<?php

namespace App\Http\Controllers;
use App\Models\Intern;
use App\Traits\Refactor;
use Barryvdh\DomPDF\Facade\Pdf;


class AttestationController 
{
  use Refactor;
      public function showView($id){
      return view('attestations.attestation');
    }
        public function generatAttestation($id){
          $profile = Intern::find($id)->profile;
          $intern = $this->refactorProfile($profile);
        view()->share('attestations.attestation',$intern);
        $pdf = Pdf::loadView('attestations.attestation', $intern);
        return $pdf->download('attestation.pdf');
    }

}
