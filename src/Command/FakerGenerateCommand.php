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

class FakerGenerateCommand extends Command
{
    use LoadWP;

    protected $commandName = 'faker:generate';
    protected $commandDescription = "Generate posts.";

    protected $commandArgumentName = "number";
    protected $commandArgumentDescription = "How many post should we generate?";

    // protected $commandOptionName = "cap"; // should be specified like "app:greet John --cap"
    // protected $commandOptionDescription = 'If set, it will greet in uppercase letters';

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription)
            ->addArgument(
                $this->commandArgumentName,
                InputArgument::OPTIONAL,
                $this->commandArgumentDescription
            )
            // ->addOption(
            //     $this->commandOptionName,
            //     null,
            //     InputOption::VALUE_NONE,
            //     $this->commandOptionDescription
            // )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        LoadWP::load();

        $number     = intval($input->getArgument($this->commandArgumentName)) ?: 5;
        $generate   = \Tools\FakerPosts\Generate\Generate::getInstance();

        $post_types = [
            'page',
            'post',
        ];

        $pages_templates = [
            'template-acfTemplate.php',
            'template-freeSectionTemplate.php',
        ];

        if (empty($post_types)) {
            $output->writeln("\n<error>No post types specified..</error>");
            return;
        }
        
        $output->writeln("\n<question>Generating post types : ". implode(', ', $post_types) . "</question>");

        $progressBar = new ProgressBar($output, $number);
        $progressBar->start();

        for ($i = 0; $i < $number; $i++) {
            foreach ($post_types as $p_type) {
                // Generate one post per lang
                $p_fr = $generate->post($p_type)->setLang('fr');
                $p_en = $generate->post($p_type)->setLang('en');

                // Sync posts together
                LanguageHelper::syncPosts([
                    'fr' => $p_fr->id,
                    'en' => $p_en->id,
                ]);

                // Set a template at random from a list if p_type is page
                if ($p_type == 'page') {
                    $k = array_rand($pages_templates);

                    $p_fr->setMeta('_wp_page_template', $pages_templates[$k]);
                    $p_en->setMeta('_wp_page_template', $pages_templates[$k]);
                }

                unset($p_fr);
                unset($p_en);
            }

            $progressBar->advance();
        }

        $progressBar->finish();

        $output->writeln("\n<info>Post were generated ! Happy Lorem Ipsum 👌🏻</info>");
    }
}
