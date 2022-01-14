<?php

namespace Uniqoders\Game\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Uniqoders\Game\Console\CustomRepository;

class GameCommand extends Command
{
   
    private $customRepository;

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('game')
            ->setDescription('New game: you vs computer')
            ->addArgument('name', InputArgument::OPTIONAL, 'what is your name?', 'Player 1');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write(PHP_EOL . 'Made with ♥ by Uniqoders.' . PHP_EOL . PHP_EOL);

        $player_name = $input->getArgument('name');

        $players = [
            'player' => [
                'name' => $player_name,
                'stats' => [
                    'draw' => 0,
                    'victory' => 0,
                    'defeat' => 0,
                ]
            ],
            'computer' => [
                'name' => 'Computer',
                'stats' => [
                    'draw' => 0,
                    'victory' => 0,
                    'defeat' => 0,
                ]
            ]
        ];
        $this->customRepository = new CustomRepository(); 
        
        $bing_bang = $this->customRepository->BigBang();


        // Weapons available
        $weapons = $this->customRepository->Weapons($bing_bang);

        // Rules to win
        $rules = $this->customRepository->Rules($bing_bang);     

        $round = 0;
        $max_round = $this->customRepository->ChangeRounds();

        $ask = $this->getHelper('question');

        print_r("Recuerda que ganarás con el 60% de los juegos ganados \n");

        $flag = 0;
        do {
            
            // User selection
            $question = new ChoiceQuestion('Porfavor seleccione su arma ', array_values($weapons), 1);
            $question->setErrorMessage('Weapon %s is invalid.');

            $user_weapon = $ask->ask($input, $output, $question);
            $output->writeln('Tu haz seleccionado: ' . $user_weapon);
            $user_weapon = array_search($user_weapon, $weapons);

            // Computer selection
            $computer_weapon = array_rand($weapons);
            $output->writeln('La computadora ha seleccionado: ' . $weapons[$computer_weapon]);

            if ($rules[$user_weapon] === $computer_weapon) {
                $players['player']['stats']['victory']++;
                $players['computer']['stats']['defeat']++;

                $output->writeln($player_name . ' win!');

                $flag++;

            } else if ($rules[$computer_weapon] === $user_weapon) {
                $players['player']['stats']['defeat']++;
                $players['computer']['stats']['victory']++;

                $output->writeln('Gana la computadora!');
            } else {
                $players['player']['stats']['draw']++;
                $players['computer']['stats']['draw']++;

                $output->writeln('Draw!');
            }
            
            $round++;
            
            if (($flag/$max_round) >= 0.6) {
                $round = $max_round;
            }

        } while ($round < $max_round);

        // Display stats
        $stats = $players;

        $stats = array_map(function ($player) {
            return [$player['name'], $player['stats']['victory'], $player['stats']['draw'], $player['stats']['defeat']];
        }, $stats);

        $table = new Table($output);
        $table
            ->setHeaders(['Player', 'Victory', 'Draw', 'Defeat'])
            ->setRows($stats);

        $table->render();

        return 0;
    }
}
