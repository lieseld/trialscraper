<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

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
    public string $stage = 'input';

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

        foreach ($this->files as $file)
        {
            dd($file->store('files'));
        }
    }
}
