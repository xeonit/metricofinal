<?php

namespace App\Jobs;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Models\Project; 
use Illuminate\Support\Facades\File;

class PlanUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $project_id;
    protected $path;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($project_id,$path)
    {
        // $this->request = $request;

        $this->project_id = $project_id;
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Use the provided project_id and path
    $project_id = $this->project_id;
    $path = $this->path;

    // Fetch the uploaded file using its path (assuming it's in the 'uploads/tmp' directory)
    $tmpdir = public_path("uploads/tmp");
    $hashname = $path; // The path you received
    $tmppath = $tmpdir.'/'.$hashname;

    // Perform the file upload logic with the provided data
    $totalPages = $this->getPDFTotalPages($tmppath);

    $document = Project::find($project_id)->document;
    if (!$document) {
        $directory = \generate_unique_dir();
        $isSuccess = Document::create([
            'project_id' => $project_id,
            'directory' => $directory
        ]);

        if (!$isSuccess) {
            return json_encode([
                'status' => 500
            ]);
        }
    } else {
        $directory = $document->directory;
    }

    $dirpath = public_path("uploads/projects/$directory/$path");
    File::ensureDirectoryExists($dirpath);

    for ($i = 1; $i <= $totalPages; $i++) {
        $filepath = $dirpath.str_replace('.pdf', "-$i.svg", $hashname);
        $cmd = 'pdftocairo -svg -f '.$i.' -l '.$i.'  "'.$tmppath.'"  "'.$filepath.'"';
        $code = \shell_exec($cmd);
    }
    @unlink($tmppath);

    return json_encode([
        'status' => 200,
    ]);
    }

    private function getPDFTotalPages($document)
    {
        // $cmd = "/path/to/pdfinfo";           // Linux
        $cmd = "LD_LIBRARY_PATH=".env('LIB64_PATH').'; pdfinfo';  // Windows

        // Parse entire output
        // Surround with double quotes if file name has spaces
        exec("$cmd \"$document\"", $output);

        // Iterate through lines
        $pagecount = 0;
        echo "$cmd \"$document\"";
        foreach ($output as $op) {
            // Extract the number
            if (preg_match("/Pages:\s*(\d+)/i", $op, $matches) === 1) {
                $pagecount = intval($matches[1]);
                break;
            }
        }


        return $pagecount;
    }
}
