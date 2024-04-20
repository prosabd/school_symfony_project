<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class RechercherVoiture
{
    /**
     * @Assert\LessThan(propertyPath="maxAnnee", message="doit etre plus petit que l'annee Max")
     */
    private $anneeMin;
    /**
     * @Assert\GreaterThan(propertyPath="minAnnee", message="doit etre plus grand que l'annee Min")
     */
    private $anneeMax;
    

    public function getAnneeMin(): ?int
    {
        return $this->anneeMin;
    }

    public function setAnneeMin(int $annee): self
    {
        $this->anneeMin = $annee;

        return $this;
    }

    public function getAnneeMax(): ?int
    {
        return $this->anneeMax;
    }

    public function setAnneeMax(int $annee): self
    {
        $this->anneeMax = $annee;

        return $this;
    }
}
