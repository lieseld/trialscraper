<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

/**
 * Livewire component to process upload and export of clinical trial data.
 *
 * @package App\Http\Livewire
 */
class AppComponent extends Component
{
    use WithFileUploads;

    /**
     * Stage of the upload/export wizard.
     *
     * Input = file upload input
     * Processing = upload/processing/exporting
     * Result = download
     *
     * @var string
     */
    public $stage = "input";

    /**
     * Uploaded files
     *
     * @var array
     */
    public $files = [];

    /**
     * Render the view.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.app-component');
    }


    public function processAndInterpretFiles(array $files)
    {
        //create array of XML
        $trials = [];
        foreach ($files as $file) {
            $trials[] = xml_decode(file_get_contents($file));
        }

        //Start CSV creation
        $csvCols = [
            'registration_number', 'title', 'scientific_title', 'trial_acronym', 'condition_code', 'phase', 'primary_sponsor_name', 'recruitment_status'
        ];

        $filename = Storage::path('output') . Str::random(40) . '.csv';

        $csvFile = fopen($filename, 'w');
        fputcsv($csvFile, $csvCols);

        foreach ($trials as $trial) {
            $row = array();
            $row['registration_number'] = $trial['actrnumber'];
            $row['title'] = $trial['trial_identification']['studytitle'];
            $row['scientific_title'] = $trial['trial_identification']['scientifictitle'];
            $row['trial_acronym'] = $trial['trial_identification']['trial_acroynm'] ?? 'None';
           // $row['condition_code'] = $trial['conditions']['conditioncode'][0]['conditioncode1'] ?? 'N/A' . '-' . $trial['conditions']['conditioncode'][0]['conditioncode2'] ?? 'N/A';
            $row['phase'] = $trial['stage'];
            $row['primary_sponsor_name'] = $trial['sponsorship']['primarysponsorname'];
            $row['recruitment_status'] = $trial['recruitment']['phase'];
            fputcsv($csvFile, $row);
        }

        fclose($csvFile);

        return $filename;
    }

    /**
     * Upload files method.
     */
    public function uploadFiles()
    {
        /**
         * Validate the input to be a maximum of 1MB per file and xml type.
         */
        $this->validate([
            'files.*' => 'required|max:1024|mimes:xml',
            'files.mimes' => 'The file must be of the .xml format.'
        ]);

        //Store file paths so it's easier
        $filePaths = [];

        //Set sub directory name
        $subDir = Str::random(40);

        //Upload each file, and give the file path
        foreach ($this->files as $file)
        {
            $filePaths[] = Storage::path($file->store('files/' . $subDir));
        }

        $this->stage = "processing";
        $file = $this->processAndInterpretFiles($filePaths);
        return response()->file($file);
    }
}
