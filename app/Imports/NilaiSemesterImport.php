<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
class NilaiSemesterImport implements ToCollection
{
   public function collection(Collection $rows)
   {
   }

}
