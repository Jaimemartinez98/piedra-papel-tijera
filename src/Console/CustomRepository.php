<?php

namespace Uniqoders\Game\Console;

class CustomRepository
{
  
    public function ChangeRounds()
    {  

        $question_total_rounds = readline("¿Desea aumentar la cantidad de rondas predeterminadas?: si/no: ");
        $input_total_rounds = 0;

        if ($question_total_rounds != 'si' && $question_total_rounds != 'no') {
            echo "Porfavor seleccione una respuesta correcta";
            exit;            
        }else{

            switch ($question_total_rounds) {
                case 'si':
                    $input_total_rounds = readline('¿Cantidad de rondas?: ');
                    break;
                
                 case 'no':
                    $input_total_rounds = 5;
                    break;
            }
            
        }

        return $input_total_rounds;

    }

    public function BigBang()
    {  

        $question_big_bang = readline("¿Desea jugar con las reglas de The Big Bang Theory?: si/no: ");
        $input_bing_bang = 0;

        if ($question_big_bang != 'si' && $question_big_bang != 'no') {
            echo "Porfavor seleccione una respuesta correcta";
            exit;            
        }else{

            switch ($question_big_bang) {
                case 'si':
                    $input_bing_bang = 1;
                    break;
                
                 case 'no':
                    $input_bing_bang = 0;
                    break;
            }
            
        }

        return $input_bing_bang;

    }


    public function Weapons($bing_bang)
    {  
        if ($bing_bang==1) {

            $weapons = [
                0 => 'Tijeras',
                1 => 'Piedra',
                2 => 'Papel',
                3 => 'Lagarto',
                4 => 'Spock'
            ];
    
        } else {
           
            $weapons = [
                0 => 'Tijeras',
                1 => 'Piedra',
                2 => 'Papel'
            ];

        }
        
       
        return $weapons;
    }

    public function Rules($bing_bang)
    {  

        if ($bing_bang==1) {
           
            $rules = [
                0 => 2 ,
                0 => 3 ,
                1 => 0 ,
                1 => 3 ,
                2 => 1 ,
                2 => 4 ,
                3 => 2 ,
                3 => 4 ,
                4 => 0 ,
                4 => 1 
            ];

        } else {
           
            $rules = [
                0 => 2,
                1 => 0,
                2 => 1
            ];

        }

        
        
        return $rules;
       
    }



  
}