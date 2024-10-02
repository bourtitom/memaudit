<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Attribute\AsCommand;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Theme;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Psr\Log\LoggerInterface;
use App\Entity\Card;

#[AsCommand(
    name: 'app:create-theme',
    description: 'Creates a new theme.',
    hidden: false,
    aliases: ['app:add-theme']
)]
class CreateTheme extends Command
{
    private $themeManager;
    private $client;
    private $logger;

    public function __construct(EntityManagerInterface $themeManager, HttpClientInterface $client, LoggerInterface $logger, EntityManagerInterface $cardManager)
    {
        parent::__construct();
        $this->themeManager = $themeManager;
        $this->cardManager = $cardManager;
        $this->client = $client; 
        $this->logger = $logger;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Theme Creator',
            '============',
        ]);
        $this->logger->info('I just got the logger');
        $helper = $this->getHelper('question');

        $question = new Question('Quel type de jeu voulez-vous (Visuel [0], Cognitif [1]) ? ', 'Visuel');
        $gameType = $helper->ask($input, $output, $question);
        
        if (strtolower($gameType) === 'visuel' || $gameType === '0') {
            $gameType = 0;
        } elseif (strtolower($gameType) === 'cognitif' || $gameType === '1') {
            $gameType = 1;
        } else {
            $output->writeln('Type de jeu invalide. Utilisez "Visuel [0]" ou "Cognitif [1]".');
            return Command::FAILURE;
        }
        
        $question = new Question('Quelle est le nom du theme ? ');
        $gameName = $helper->ask($input, $output, $question);
        
        $theme = new Theme();
        $theme->setName($gameName);
        $theme->setType($gameType);
        
        $this->themeManager->persist($theme);
        $this->themeManager->flush();
        
        $output->writeln('Saved new theme with name '.$theme->getName());

        $apiKey = '46287815-e172dfd89b16d682bd9d2e137';
        $query = urlencode($gameName);
        $url = "https://pixabay.com/api/?key=$apiKey&q=$query&image_type=photo";


        try {
            $response = $this->client->request('GET', $url);
            $statusCode = $response->getStatusCode();
            $contentType = $response->getHeaders()['content-type'][0];
            $content = $response->getContent();
            $data = $response->toArray();

            if (isset($data['hits']) && count($data['hits']) > 0) {
                $output->writeln('Found the following results:');
                foreach ($data['hits'] as $hit) {
                    if ($gameType === 0) {
                        $output->writeln($hit['webformatURL']);
                        $card = new Card();
                        $card->setImgPath($hit['webformatURL']);
                        $card->setType($gameType);
                        $card->setIdTheme($theme->getId());
                        
                        $this->cardManager->persist($card);
                    } else {    
                        $output->writeln($hit['pageURL']);
                    }
                }
                $this->cardManager->flush();

            } else {
                $output->writeln('No results found for the theme.');
            }

        } catch (\Exception $e) {
            $output->writeln('Error fetching data from Pixabay: ' . $e->getMessage());
        }


        return Command::SUCCESS;
    }
}