<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EnvController extends Controller
{
    public function View(Request $request)
    {
        return view("Admin.AppSetting");
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
