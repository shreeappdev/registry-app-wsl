<?php
    use App\Models\Domain;

    function getAnnex1($name,$id,$type)
    {
        return "{$name}_{$id}_{$type}_annex1.pdf";
    }

    function getAnnex2($name,$id,$type)
    {
        return "{$name}_{$id}_{$type}_annex2.pdf";
    }

   