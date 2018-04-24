<?php namespace Bantenprov\PassingGrade\Console\Commands;

use Illuminate\Console\Command;

/**
 * The PassingGradeCommand class.
 *
 * @package Bantenprov\PassingGrade
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class PassingGradeCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bantenprov:passing-grade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Demo command for Bantenprov\PassingGrade package';

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
        $this->info('Welcome to command for Bantenprov\PassingGrade package');
    }
}
