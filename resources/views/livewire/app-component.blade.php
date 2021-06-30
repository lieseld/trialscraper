<div class="flex flex-col">
    <div class="text-5xl dark:text-white"><span class="text-blue-300">trial</span>scraper</div>
    @if ($stage = 'input')
        <form wire:submit.prevent="uploadFiles">
            <div class="my-4 flex flex-col space-y-2">
                <label class="text-lg dark:text-gray-300">
                    Upload ANZCTR clinical trial file(s) in xml format
                </label>
                <input wire:model="files" type="file" class="dark:text-white border dark:border-gray-600 p-3 rounded" multiple name="" id="">
            </div>
            @error('files.*')
            <div class="my-4 dark:text-white">
                There was an error exporting this file. Check it is of the right format.
            </div>
            @enderror
            <div class="dark:text-white" wire:loading wire:target="files">Uploading...</div>
            @if (count($files) > 0)
            <div wire:loading.remove class="my-4 flex flex-col space-y-2">
                <button type="submit" class="dark:bg-green-500 hover:bg-green-600 focus:bg-green-800 transition text-left p-3 px-5 text-white font-bold rounded">Export</button>
            </div>
            @endif
        </form>
    @endif
</div>
