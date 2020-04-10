<?php

namespace App\Command;

use App\Traits\LoadWP;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use OP\Framework\Helpers\LanguageHelper;

class FakerCleanCommand extends Command
{
    use LoadWP;

    protected $commandName = 'faker:clean';
    protected $commandDescription = "Delete dummy posts";

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        LoadWP::load();

        global $wpdb;

        $generate   = \Tools\FakerPosts\Generate\Generate::getInstance();

        $output->writeln("\n<question>Delete FakerPost user.. 🔫</question>");

        /**
         * Delete user
         */
        $generate->deleteUser();

        /**
         * Clean trashed posts
         */
        $query = "SELECT ID FROM `{$wpdb->prefix}posts` WHERE post_status = 'trash'";
        $ids   = $wpdb->get_results($query, ARRAY_N);

        $ids = array_map(function ($e) {
            return (int) $e[0];
        }, $ids);

        if ($ids && count($ids)) {
            $output->writeln("\n<question>Clearing trashed posts.. 🧹</question>");

            $query = "DELETE FROM `{$wpdb->prefix}posts` WHERE id IN (". implode(", ", $ids) .")";
            $wpdb->get_results($query);
        }

        $output->writeln("\n<info>Cleaning complete ! 🍹</info>");
    }
}
