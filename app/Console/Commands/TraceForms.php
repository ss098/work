<?php

namespace App\Console\Commands;

use App\Form;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TraceForms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trace:forms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '清理超过 14 天不曾更新的表单';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Form::where('updated_at', '<', now()->subDays(14))
            ->with('record.attachment')
            ->chunk(25, function ($forms) {
                foreach ($forms as $form) {
                    $records = $form->record;

                    foreach ($records as $record) {
                        foreach ($record->attachment as $attachment) {
                            echo 'delete attachment:' . $attachment->id . PHP_EOL;

                            if (Storage::exists($attachment->name)) {
                                Storage::delete($attachment->name);
                            }
                        }

                        $form->delete();
                    }
                }
            });
    }
}
