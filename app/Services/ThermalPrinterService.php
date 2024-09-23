// app/Services/ThermalPrinterService.php

namespace App\Services;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

class ThermalPrinterService
{
    protected $printerPath;

    public function __construct($printerPath)
    {
        $this->printerPath = $printerPath;
    }

    public function printText($text)
    {
        $connector = new FilePrintConnector($this->printerPath);
        $printer = new Printer($connector);

        try {
            $printer->text($text);
            $printer->cut();
        } finally {
            $printer->close();
        }
    }
}