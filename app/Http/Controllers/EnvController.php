<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EnvController extends Controller
{
    public function View(Request $request)
    {
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);

        $envArray = [];
        foreach (explode("\n", $envContent) as $line) {
            // Skip empty lines and comments
            if (trim($line) === '' || str_starts_with(trim($line), '#')) {
                continue;
            }
        
            // Split the line into key and value
            $parts = explode('=', $line, 2);
            if (count($parts) === 2) {
                $key = trim($parts[0]);
                // Remove quotes (single or double) from the value
                $value = trim($parts[1], " \t\n\r\0\x0B'\"");
        
                $envArray[$key] = $value;
            }
        }
        return view("Admin.AppSetting",compact('envArray'));
    }
    public function update(Request $request)
    {
        $data = $request->except('_token');
        $path = base_path('.env');

        if (file_exists($path)) {
            $env = file_get_contents($path);

            foreach ($data as $key => $value) {
                $pattern = "/^{$key}=.*/m";
                $replacement = "{$key}='{$value}'";

                if (preg_match($pattern, $env)) {
                    $env = preg_replace($pattern, $replacement, $env);
                } else {
                    $env .= "\n{$key}={$value}";
                }
            }

            file_put_contents($path, $env);
        }
        alert()->success('Success','Data App Setting berhasil disimpan.');
        return redirect('appsetting');
    }
}
