<?php

namespace Tests\Feature;

use App\Filament\Pages\ImportDeliveryExcel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ImportExcelEkspedisiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_lincah(): void
    {

        $path = storage_path('dummy_file/rekon-lincah.xlsx');

        $file = new UploadedFile(
            $path,
            File::name($path)
        );


        ImportDeliveryExcel::importExcel($file);
        $this->assertTrue(true);
    }
}
