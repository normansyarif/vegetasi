<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use File;

class PageController extends Controller
{
    // private $pythonBinary = 'C:\Users\User\AppData\Local\Programs\Python\Python36\python.exe';
    private $pythonBinary = '/usr/bin/python3';

    // private $pythonProjectPath = 'C:\xampp\htdocs\laravel\public\pyproject\'
    private $pythonProjectPath = '/opt/lampp/htdocs/laravel/public/pyproject/';


    public function show() {
        $acc = null;
        $table = null;
        $length = null;
        $class = null;

        if(file_exists( public_path() . '/pyproject/train.csv') && file_exists( public_path() . '/pyproject/full.csv')) {
            $process = new Process([$this->pythonBinary, $this->pythonProjectPath . 'full.py']);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $data = $process->getOutput();
            $data = json_decode($data);

            $acc = $data[0];
            $table = $data[1];
            $length = $data[2];
            $class = $data[3];
        }else if(file_exists( public_path() . '/pyproject/train.csv')){
            $process = new Process([$this->pythonBinary, $this->pythonProjectPath . 'train.py']);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $data = $process->getOutput();
            $data = json_decode($data);

            $acc = $data[0];
            $table = $data[1];
            $length = null;
            $class = null;
        }

        $clData = [];

        if($class != null) {
            $clArr = explode(",", $class);
            foreach($clArr as $cl) {
                $clItem = explode("=", $cl);

                $luasTotalInHa = $length*900/10000;

                $temp = [];
                $temp['class'] = $clItem[0];
                $temp['pixel'] = $clItem[1]; 
                $temp['luas_in_ha'] = $temp['pixel']*900/10000;
                $temp['luas_in_percent'] = round($temp['luas_in_ha']/$luasTotalInHa*100, 2);
                array_push($clData, $temp);
            }
        }

        return view('show')
        ->with('acc', $acc)
        ->with('table', $table)
        ->with('length', $length)
        ->with('clData', $clData);
    }

    public function uploadTrain(Request $req) {
        if($req->hasFile('ds-train')) {
            $ext = $req->file('ds-train')->getClientOriginalExtension();
            if(strtolower($ext) != 'csv') {
                return redirect()->back()->with('error', 'Format tidak didukung. Silahkan pilih dataset format .csv');
            }else{
                $filenameToStore = 'train.csv';
                $req->file('ds-train')->move(public_path('pyproject'), $filenameToStore);
                return redirect()->back()->with('success', 'Berhasil mengupload dataset train');
            }
        }else{
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }
    }

    public function uploadFull(Request $req) {
        if($req->hasFile('ds-full')) {
            $ext = $req->file('ds-full')->getClientOriginalExtension();
            if(strtolower($ext) != 'csv') {
                return redirect()->back()->with('error', 'Format tidak didukung. Silahkan pilih dataset format .csv');
            }else{
                $filenameToStore = 'full.csv';
                $req->file('ds-full')->move(public_path('pyproject'), $filenameToStore);
                return redirect()->back()->with('success', 'Berhasil mengupload dataset full');
            }
        }else{
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }
    }

    public function traindel() {
        File::delete('pyproject/train.csv');
        return redirect()->back()->with('success', 'Berhasil menghapus dataset train');

    }

    public function fulldel() {
        File::delete('pyproject/full.csv');
        return redirect()->back()->with('success', 'Berhasil menghapus dataset full');
    }


}
